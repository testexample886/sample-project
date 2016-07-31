@extends('layout')

@section('content')

<div class="container">
    <div class="row centered-form">
        <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
        	<div class="panel panel-default">
	        		<div class="panel-heading">
		    		<h3 class="panel-title">Please give us the below details</h3>
		 			</div>
		 			<div class="panel-body">
		    		<form id="search_quotes" role="form" method="post" action="{{action('HistoricalQuotes@search')}}">
			    			<div class="form-group">
			                	<input type="text" name="company_symbol" id="company_symbol" class="form-control input-sm required" placeholder="Company Symbol">
			    				<span id="company_symbol" class="h4 text-danger"></span>
			    			</div>

			    			<div class="form-group">
			    				<input  type="email" name="email" id="email" class="form-control input-sm required" placeholder="Your Email Address">
			    				<span id="email" class="h4 text-danger"></span>
			    			</div>

			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input  name="start_date" id="start_date" class="form-control input-sm datepicker required date" placeholder="Start Date">
			    						<span id="start_date" class="h4 text-danger"></span>
			    					</div>
			    				</div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input  name="end_date" id="end_date" class="form-control input-sm datepicker required date" placeholder="End Date">
			    						<span id="end_date" class="h4 text-danger"></span>
			    					</div>
			    				</div>
			    			</div>
			    			{{ csrf_field() }}
			    			<input type="submit" value="Search" class="btn btn-info btn-block">
		     		</form>

		    		@if(isset($message)  and $message)
    				<div id="info-message" class="alert alert-info">
      				{{$message}}
    				</div>
                      <script>
                                      $("#info-message").fadeTo(10000, 500).slideUp(500);
                      </script>
		  	      @endif
                      @if (count($errors) > 0)
    					<div id="error-message" class="alert alert-danger">
    					 		@foreach($errors->all(':message') as $message )
  									{{ $message }}
  									</br>
    							@endforeach
    					</div>
                              <script>
                                      $("#error-message").fadeTo(10000, 500).slideUp(500);
                              </script>
    				@endif
		    	</div>

    		</div>
   		</div>

   	</div>
    @if( isset($column_names)  and $column_names)
    <div class="row">
      <div class="panel panel-default scroll-wrapper">
      <h2>Results for the company: {{$companyName}}</h2>
      <h4>From:  {{$start_date}}   to:  {{$end_date}} </h>
      <table class="table table-striped">
        <thead>
        <tr>
          @foreach($column_names as $name)
          <th>{{ $name }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
          @foreach($quotes as $quote)
            <tr>
                @foreach($quote as $key => $value)
                    <td>{{ $value }}</td>
                @endforeach
            </tr>
            @endforeach
      </tbody>
    </table>
    </div>
  </div>

  <div class="row">

    <div class="panel panel-default">
    <canvas id="myChart" width="400" height="400"></canvas>
    </div>

  </div>


  @endif
</div>

@stop


@section('footer')

      @if( isset($column_names)  and $column_names)
        <script src="{{URL::asset('assets/js/Chart.bundle.min.js')}}"></script>
        <script>

var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: "{{$dates}}".split(","),
        datasets: [{
            label: 'Open price',
            data: "{{$open_price}}".split(","),
            backgroundColor: [
                'rgba(55, 199, 32, 0.2)'
            ],
            borderColor: [
                'rgba(55,199,32,1)'
            ],
            borderWidth: 1
        },{
            label: 'Close price',
            data: "{{$close_price}}".split(","),
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
      @endif

      <script>
      var companySymbol = "{{$company_symbol}}".split(",");

      $( function() {
            var availableTags = companySymbol;
            $( "#company_symbol" ).autocomplete({
                    source: availableTags
            });
      } );

      </script>
	<script src="{{URL::asset('assets/js/quotes.form.validation.js')}}"></script>
      <style type="text/css">

        .scroll-wrapper { height: 500px; overflow: scroll; }

      </style>
@stop
