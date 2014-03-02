@extends('layouts.simple')

<?php $header="Moderator Home"?>
@section('simpledata')


	<div class="columns large-10 large-offset-1">
	<div class="row">
		<ul >
		<li><i class="fa fa-question-circle"></i>{{HTML::link('moderator/review?type=question', 'Moderate Questions');}}</li>
		
		<li><i class="fa fa-check-circle"></i>{{HTML::link('moderator/review?type=answer', 'Moderate Anwers');}}</li>
		<li><i class="fa fa-flag"></i>{{HTML::link('moderator/flags', 'Moderate Flags');}}</li>
		<li><i class="fa fa-plus-circle"></i>{{HTML::link('add/univquestion', 'Add University Questions');}}</li>
	</div>
</div>
@stop