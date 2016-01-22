
<!doctype html>
<html class="no-js" lang="en" ng-app="@yield('module')">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Pragmanila | Exam</title>
<link rel="stylesheet" type="text/css" href="{{ asset('foundation-icons/foundation-icons.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/base.css') }}">
</head>
<body> 

	<header id="header">
		<div class="top-bar">
		  <div class="top-bar-left">
		    <ul class="dropdown menu" data-dropdown-menu>
		      <li class="menu-text"><a href="{{ route('web.finder') }}">Pragmanila (Reposearch)</a></li>
		    </ul>
		  </div>
		  <div class="top-bar-right">
		  	<ul class="menu">
		  		<li class="has-submenu">
		        	<a target="_blank" href="http://portfolio.unlimitedwebworks.guru">
			        	<small>portfolio.unlimitedwebworks.guru</small>
			        </a>
		      	</li>
		  	</ul>
		  </div>
		</div>
	</header>
	<!--#header ends-->

	<div id="content">
		@yield('content')
	</div>
	<!--#content ends-->

	<footer id="footer" class="text-center">
		<small>Copyright 2016 Jur Erick S. Porras - Fullstack Web Developer</small>
	</footer>
	<!--#footer ends-->

	<script type="text/javascript" src="{{ asset('js/base.js') }}"></script>
	<script type="text/javascript">
		$(document).foundation();
	</script>
</body>
</html>
