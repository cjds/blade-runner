@extends('layouts.master')

@section('content')

<div class="row">
	<div class="large-8 large-offset-1 small-12 columns">
	<h3>Branches</h3>
		@foreach ($branches as $branch) 
			<h3>
				<a href="{{url('univquestions/view/branch')}}?bid={{$branch->branch_id}}"> {{$branch->branch_name}} </a>
			</h3>
		@endforeach
	</div>
</div>

@stop