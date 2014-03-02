@extends('layouts.master')

@section('content')
<div class='columns large-12'> 
<div class="row" style='min-height:400px'  data-equalizer-watch>
	<div class="large-8 large-offset-2 box-top box-sides text small-12 columns">
	<h3 class='text-center'>Branches</h3>
	<ul>
		@foreach ($branches as $branch) 
			<li class='subheader'>
				<a href="{{url('univquestions/view/branch')}}?bid={{$branch->branch_id}}"> {{$branch->branch_name}} </a>
			</li>
		@endforeach
	</div>
</div>
</div>

@stop