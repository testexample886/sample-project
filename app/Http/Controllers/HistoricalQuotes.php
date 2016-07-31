<?php

namespace SampleProject\Http\Controllers;

use Illuminate\Http\Request;

use SampleProject\Http\Requests;

use SampleProject\Http\Requests\HistoricalQuotesRequest;

use Cache;

use Carbon ;

class HistoricalQuotes extends Controller
{


    private function downloadCsvToArray($file_source,$delimiter = "," ,$column_to_compare = -1, $start_date = "" , $end_date = "")
    {

        $data = array();
        $header=array();

        try{
            $handle = fopen($file_source, 'rb');
            if (!$handle) {
                return false;
            }
            $start_date = intval(str_replace('-', '', $start_date));
            $end_date = intval(str_replace('-', '', $end_date));
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                    if ( count($header)==0)
                        $header = array_map('strtolower', $row);
                    else
                    {
                        if($column_to_compare === -1)
                        {
                            $data[] = array_combine($header, $row);
                        }
                        elseif( count($row) >  $column_to_compare )
                        {
                                $row_date = intval( str_replace('-', '', $row[$column_to_compare]) );
                                if($start_date <=  $row_date  and $row_date <=  $end_date )
                                    $data[] = array_combine($header, $row);
                        }
                        else
                            return false;
                    }
            }
            flush();
            fclose($handle);
            } catch (\Exception $e) {

                    \Log::error('downloadCsvToArray: error' . $e);

            }
        return $data;
    }


    private function getDatesFromRange($start, $end, $format = 'Y-m-d')
    {
        $array = array();
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        foreach($period as $date) {
            $array[] = $date->format($format);
        }

        return $array;
    }

    /**
     * Display the specified resource.
     *
     * @return String
     */
    private function getCompanyDetails($mode="symbol")
    {
        $companySymbolAndName = array();
        $url ="http://www.nasdaq.com/screening/companies-by-name.aspx?&render=download";
        if (Cache::has('companySymbolAndName'))
        {
                    $companySymbolAndName = Cache::get('companySymbolAndName');
        }
        else
        {
                $companyDetails =  $this->downloadCsvToArray($url);

                foreach ($companyDetails as  $company) {
                        $companySymbolAndName[ $company["symbol"] ] = $company["name"];
                }
                $expiresAt = Carbon::now()->addDays(1);
                Cache::put('companySymbolAndName', $companySymbolAndName, $expiresAt);

        }
        if($mode === "array")
            return $companySymbolAndName;
        list($symbol,$name ) = array_divide($companySymbolAndName);
        if($mode=="symbol")
            return $symbol;
        return $name;
    }

    /**
     * Display the specified resource.
     *
     * @return Array
     */
    private function getCurrentQuotes($comapnySymbol = "",$start_date = "", $end_date = "")
    {
        $cacheKey = '$comapnySymbol$start_date$end_date';
        $currentQuotes = array();
        if (Cache::has($cacheKey))
        {
                    $currentQuotes = Cache::get($cacheKey);
        }
        else
        {

                $current_quotes_url = "http://ichart.finance.yahoo.com/table.csv?s=$comapnySymbol";
                $currentQuotes = $this->downloadCsvToArray($current_quotes_url,",",0,$start_date,$end_date);
                $expiresAt = Carbon::now()->addMinutes(1);
                Cache::put($cacheKey , $currentQuotes, $expiresAt);

        }
        return $currentQuotes;
    }




     /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

        return view('historical.quotes.show' )->with('company_symbol', implode(',',$this->getCompanyDetails()) );
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {

        $end_date = $request->get('end_date');
        $company_symbol = implode(',',$this->getCompanyDetails());
        $this->validate($request, [
            'company_symbol' => 'required|in:'.$company_symbol,
            'email' => 'required|email|max:128',
            'start_date' => 'required|date_format:"Y-m-d"|before:'.$end_date,
            'end_date' => 'required|date_format:"Y-m-d"',
            ]);

        $email = $request->get('email');
        $current_symbol  = $request->get('company_symbol');
        $companyDetails = $this->getCompanyDetails($mode="array");
        $companyName = "";
        if(array_key_exists($current_symbol,$companyDetails))
            $companyName = $companyDetails[$current_symbol];
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        \Mail::send('emails.quotes',
                array(
                    'from_date' => $start_date,
                    'to_date' => $end_date
            ),
            function($message) use ($email, $companyName)
            {
                    $message->to($email, 'Client')->subject($companyName);
            });

        $currentQuotes = $this->getCurrentQuotes($current_symbol,$start_date,$end_date);
        $openPrice = array();
        $closePrice = array();
        $dates = array();
        $column_names = array();
        $message = "";
        if(count($currentQuotes) > 0)
        {

            list($column_names, ) = array_divide($currentQuotes[0]);
            list(, $quotes) = array_divide($currentQuotes);
            foreach ( $quotes as $quote) {
                foreach ($quote as $key => $value) {
                        if($key === "open")
                        {
                             $openPrice[] = $value;
                        }
                        elseif ($key === "close")
                        {
                             $closePrice[] = $value;
                        }elseif ($key === "date")
                        {
                              $dates[] = $value;
                        }
                }
            }
        }else{
            $message = "Error retrieving information from server please try again with the same or different companys' symbol";
        }
        return view('historical.quotes.show' ,array(
                                                                                'company_symbol' => $company_symbol,
                                                                                'column_names' => $column_names,
                                                                                 'quotes'  =>  $currentQuotes,
                                                                                 'start_date' => $start_date,
                                                                                 'end_date' => $end_date,
                                                                                 'companyName' => $companyName,
                                                                                 'open_price' => implode(',',$openPrice),
                                                                                 'close_price' => implode(',',$closePrice),
                                                                                 'dates' => implode(',',$dates),
                                                                                 'message' => $message
                                                                                )
                                                                        );
    }


}
