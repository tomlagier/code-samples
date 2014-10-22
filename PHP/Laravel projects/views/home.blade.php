@extends('desktop.layouts.main')
{{-- Desktop home page template --}}

@section('page-tags')

@stop

@section('page-styles')
<link href="/stylesheets/desktop/home.css" rel="stylesheet">
<link href="/stylesheets/vendor/slider.css" rel="stylesheet">
@stop

@section('page-header')

{{-- Secondary nav for homepage --}}

@include('desktop.home.chunks.nav');

@stop

@section('page-content')

	<div id="loader">
		<div id="progress-bar"></div>
	</div>
	
	{{-- Content separated into chunks for ease of rearrangement --}}
	<div id="main-container">
		@include('desktop.home.chunks.start')
		@include('desktop.home.chunks.about')
		@include('desktop.home.chunks.slider')
		@include('desktop.home.chunks.image')
		@include('desktop.home.chunks.stats')
	</div>

@stop

@section('page-overlays')

@stop

@section('page-footer')

@stop

@section('page-scripts')
<script src="/js/home.js"></script>
<script src="/js/slider.js"></script>
@stop