@extends('layouts.master')

@section('content')

<div class='columns large-6 box-top box-sides box-bottom small-12 large-offset-3'>
	<div class='row'>
		<h2> {{$head}}</h2>
	</div>
	<div class='row'>
		<p> {{$body}}</p>
	</div>	
</div>
@stop