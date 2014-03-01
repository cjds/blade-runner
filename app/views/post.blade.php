@extends('layouts.master')

@if($type=="edit")
<?php $tagArray=array();?>
@foreach ($question->tags as $tag) 
	<?php $tagArray[]=$tag->tag_name;?>
@endforeach
@endif


@section('content')

	<div class="large-5 large-offset-2 box-top box-sides small-12 medium-8 columns main">
		@if($type=="new")
			<h3>Add a question</h3>
			{{Form::open(array('url' => 'add/question' ))}}
		@elseif($type=="edit")
			<h3>Edit question</h3>
			{{Form::open(array('url' => 'edit/question' ))}}
			{{Form::hidden('question_id', $question->post_id);}}
		@endif
		
		@if($errors->any())
			<div class='errors'>
				{{implode('',$errors->all('<div data-alert class="alert-box warning">:message <a href="#" class="close">&times;</a></div>'))}}
			</div>
		@endif
		<br><br>
		{{Form::label('title', 'Title')}}<br>
		{{Form::text('title',($type=='edit')?$question->question_title:Input::old('title'), array())}}
		{{Form::label('question', 'Body')}}<br>

      @include('layouts.markdownmanager',array('data'=>($type=='edit')?$question->question_body:Input::old('question')))
		<br>
		{{Form::label('tags', 'Tags')}}<br>

		{{Form::text('tags',($type=='edit')?implode(',', $tagArray):Input::old('tags'),array())}}
		{{Form::submit(($type=='edit')?'Edit Question':'Add Question',array('class'=>'button'))}}
	</div>
	<aside class="large-3 hide-for-small push-right medium-3 box-top box-sides  columns">
		<div class='row'>
			<h5 class='box-solid-bottom'>Rules for posting</h5>
			<ul class="no-bullet">
				<li>Be on-topic</li>
				<li>Be specific</li>
				<li>Make it relevant to others</li>
				<li>Keep an open mind</li>
			</ul>
		</aside>
	
	</div>
</div>
@include('layouts/dialogs')
@stop