<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $shop->shop_name }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/summernote-bs4.css') }}" rel="stylesheet">
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top p-0 shadow">
		<a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ url('/admin/dashboard') }}">{{ $shop->shop_name }}</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

	  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav flex-grow-1 px-3">
		      	<li class="nav-item text-nowrap">
		        	<a class="nav-link" href="/admin/dashboard">Dashboard</a>
		      	</li>
		      	<li class="nav-item text-nowrap">
		        	<a class="nav-link" href="/admin/orders">Orders</a>
		      	</li>
		      	<li class="nav-item text-nowrap dropdown">
		        	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          		Dropdown
		        	</a>
		        	<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          		<a class="dropdown-item" href="/admin/settings">Settings</a>
		          		<div class="dropdown-divider"></div>
		          		<a class="dropdown-item" href="/admin/categories">Categories</a>
		          		<a class="dropdown-item" href="/admin/products">Products</a>
		        	</div>
		      	</li>
		      	<li class="nav-item text-nowrap ml-auto">
		      		<a class="nav-link" href="/" target="_blank">View Shop</a>
		      	</li>
		      	<li class="nav-item text-nowrap">
		      		<a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
		      		<form id="logout-form" action="{{ route('shop.logout') }}" method="POST" style="display: none;">
                    	@csrf
                    </form>
		      	</li>
		    </ul>
		</div>
	</nav>

	<div class="container-fluid bg-light" style="height: 800px;">
		<div class="row">
			<nav class="col-md-2 d-none d-md-block bg-light sidebar">
				<div class="sidebar-sticky">
					<ul class="nav flex-column">
						<li class="nav-item">
							<a class="nav-link" href="/admin/dashboard"><i data-feather="home"></i>Dashboard</a>
						</li>
						<li class="nav-item">
				        	<a class="nav-link" href="/admin/orders"><i data-feather="shopping-cart"></i>Orders</a>
				      	</li>
				      	<li class="nav-item">
				        	<a class="nav-link" href="/admin/settings"><i data-feather="settings"></i>Settings</a>
				      	</li>
				      	<li class="nav-item">
				        	<a class="nav-link" href="/admin/categories"><i data-feather="folder"></i>Categories</a>
				      	</li>
				      	<li class="nav-item">
				        	<a class="nav-link" href="/admin/products"><i data-feather="file"></i>Products</a>
				      	</li>
					</ul>
				</div>
			</nav>

			<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
				@include('inc.messages')
				<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
					<h1 class="h2">@yield('main-title')</h1>
        			<div class="btn-toolbar mb-2 mb-md-0">
        				@yield('main-button-group')
          				<!-- <div class="btn-group mr-2">
            				<button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            				<button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          				</div>

          				<button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle"></button> -->
        			</div>
      			</div>
				@yield('main-content')
			</main>
		</div>
	</div>

	<!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/summernote-bs4.min.js') }}"></script>
    <script>
    	$(document).ready(function() {
		  	$('#summernote').summernote({
				toolbar: [
			    	// [groupName, [list of button]]
				    ['style', ['bold', 'italic', 'underline', 'clear']],
				    // ['font', ['strikethrough', 'superscript', 'subscript']],
				    ['fontsize', ['fontsize']],
				    ['color', ['color']],
				    ['para', ['ul', 'ol', 'paragraph']],
				    // ['height', ['height']]
			  	]
			});
		});
    </script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
  		feather.replace();
	</script>
</body>
</html>