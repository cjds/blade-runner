@extends('layouts.master')

@section('content')

<div class="row">
	<div class="large-4 small-12 columns">
		@foreach($branches as $branch)
			<h3>{{$branch->branch_name}}</h3>
			<ul>
			@foreach($branch->subjects as $subject)
				<li>{{HTML::link('univquestions/view?sid='.$subject->subject_id, $subject->subject_name);}}</li>
			@endforeach
			</ul>
		@endforeach
	</div>
</div>

@stop