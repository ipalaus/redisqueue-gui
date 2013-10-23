<!doctype html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800">

		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine or request Chrome Frame -->
		<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">

		<title>RedisQueue GUI</title>

		<link href="/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<nav class="navbar navbar-default" role="navigation">
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<a class="navbar-brand" href="/">RedisQueue GUI</a>
			</div><!-- /.navbar-collapse -->
		</nav>

		<div class="container">
		@section('heading')
		@show
		@yield('content')
		</div>

		@section('js')
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="/js/jquery-2.0.3.min.js"><\/script>')</script>
		<script src="/js/app.js"></script>
		@show
	</body>
</html>