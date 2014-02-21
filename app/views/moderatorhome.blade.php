@extends('layouts.master')


@section('content')

<div class="row">
	<div class="span4 offset1">
		<h3>{{HTML::link('moderator/review?type=question', 'Moderate Questions');}}</h3>
		<br>
		<h3>{{HTML::link('moderator/review?type=answer', 'Moderate Anwers');}}</h3>
		<br>
		<h3>{{HTML::link('moderator/flags', 'Moderate Flags');}}</h3>
	</div>
</div>
@stop