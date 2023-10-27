<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	@if (!empty($meta_title))
		<title>{{ $meta_title }}</title>
	@else
		<title>Ukrainian Shop</title>
	@endif
	@if (!empty($meta_description))
		<meta name="description" content="{{ $meta_description }}">
	@else
		<meta name="description" content="This is test E-commerce Website">
	@endif
	@if (!empty($meta_keywords))
		<meta name="keywords" content="{{ $meta_keywords }}">
	@else
		<meta name="keywords" content="selling ukrainian clothes online, sell ukrainian clothes, sell ukrainian dresses online, how to sell ukrainian clothes online">
	@endif
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<meta name="author" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	
	<!-- Front style -->
	<link id="callCss" rel="stylesheet" href="{{ url('css/front_css/front.min.css') }}" media="screen"/>
	<link href="{{ url('css/front_css/base.css') }}" rel="stylesheet" media="screen"/>
	<!-- Front style responsive -->
	<link href="{{ url('css/front_css/front-responsive.min.css') }}" rel="stylesheet"/>
	<link href="{{ url('css/front_css/font-awesome.css') }}" rel="stylesheet" type="text/css">
	<!-- Google-code-prettify -->
	<link href="{{ url('js/front_js/google-code-prettify/prettify.css') }}" rel="stylesheet"/>
	<!-- summernote -->
	<link href="{{ url('plugins/summernote/summernote-bs4.min.css') }}" rel="stylesheet"/>
	<!-- fav and touch icons -->
	<link rel="shortcut icon" href="{{ url('images/front_images/ico/favicon.ico') }}">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ url('images/front_images/ico/apple-touch-icon-144-precomposed.png') }}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ url('images/front_images/ico/apple-touch-icon-114-precomposed.png') }}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ url('images/front_images/ico/apple-touch-icon-72-precomposed.png') }}">
	<link rel="apple-touch-icon-precomposed" href="{{ url('images/front_images/ico/apple-touch-icon-57-precomposed.png') }}">
	<style type="text/css" id="enject"></style>
	<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=64d3a6615112d300191669fb&product=sop' async='async'></script>
</head>
<body>
@include('layouts.front_layouts.front_header')
<!-- Header End====================================================================== -->

@include('front.banners.home_page_banners')

<div id="mainBody">
	<div class="container">
		<div class="row">
			<!-- Sidebar ================================================== -->
			@include('layouts.front_layouts.front_sidebar')
			<!-- Sidebar end=============================================== -->
			@yield('content')
		</div>
	</div>
</div>
<!-- Footer ================================================================== -->
@include('layouts.front_layouts.front_footer')
<!-- Placed at the end of the document so the pages load faster ============================================= -->
<script src="{{ url('js/front_js/jquery.js') }}" type="text/javascript"></script>
<!-- Validate -->
<script src="{{ url('js/front_js/jquery.validate.js') }}" type="text/javascript"></script>
<script src="{{ url('js/front_js/front.min.js') }}" type="text/javascript"></script>
<script src="{{ url('js/front_js/google-code-prettify/prettify.js') }}"></script>

<script src="{{ url('js/front_js/front.js') }}"></script>
<script src="{{ url('js/front_js/front_script.js') }}"></script>
<script src="{{ url('js/front_js/jquery.lightbox-0.5.js') }}"></script>
<!-- Summernote -->
<script src="{{ url('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- Page specific script -->
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>
</body>
</html>