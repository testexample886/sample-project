<html>
    <head>
	<script src="{{URL::asset('assets/js/jquery-3.1.0.slim.min.js')}}"></script>
	<script src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
	<link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('assets/css/quotes.css') }}" rel="stylesheet">
      <link href="{{ URL::asset('assets/css/jquery-ui.css') }}" rel="stylesheet">
  	<script src="{{URL::asset('assets/js/jquery-1.12.4.js')}}"></script>
  	<script src="{{URL::asset('assets/js/jquery-ui.js')}}"></script>
    </head>
    <body>
  <h1>Example Project - Historical Quotes</h1>

    @yield('content')
    </body>
    <footer>
    @yield('footer')
    </footer>
</html>
