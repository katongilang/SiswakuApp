<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/icon.png">
	<title>Siswaku</title>
	{{-- Memanggil Bootstrap --}}
	<link rel="stylesheet" type="text/css" href="{{asset('bootstrap_3_3_6/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/style.css') }}">
</head>
<body>
	<div class="container">
		@include('navbar')
		@yield('main')
	</div>
	@yield('footer')
	<script type="text/javascript" src="{{asset('js/jquery_2_2_1.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('bootstrap_3_3_6/js/bootstrap.min.js')}}"></script>
</body>
</html>