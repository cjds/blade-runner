@extends('layouts.master')

@section('content')
<style>
.simpledata  ul{
	list-style:none;
}

.simpledata i{
	margin:6px;
}
</style>
<div class='columns large-12'> 
<div class="row" style='min-height:400px'  data-equalizer-watch>
	<div class="large-8 large-offset-2 box-top box-sides text small-12 columns">
	<h3 class='text-center'>{{$header}}</h3>
	<div class='row simpledata'>
	@yield('simpledata')	
	</div>
</div>
</div>
</div>
@stop