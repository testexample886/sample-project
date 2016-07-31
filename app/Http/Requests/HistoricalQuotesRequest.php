<?php

namespace SampleProject\Http\Requests;

use SampleProject\Http\Requests\Request;

class HistoricalQuotesRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
    	// any visitor is able to use this form
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       	return [
    		'company_symbol' => 'required|max:5',
    		'email' => 'required|email|max:128',
    		'start_date' => 'required|date_format:"Y-m-d"',
    		'end_date' => 'required|date_format:"Y-m-d"',
  ];
    }
}
