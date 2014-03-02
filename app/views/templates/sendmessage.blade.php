@extends('layouts.master')

<?php $title=$head?>
@section('content')

<div class='columns large-6 box-top box-sides box-bottom small-12 large-offset-3' style='min-height:400px'>
	<div class='row'>
		<h2> {{$head}}</h2>
	</div>
	<div class='row'>
		<p> {{$body}}</p>
	</div>	
</div>
@stop