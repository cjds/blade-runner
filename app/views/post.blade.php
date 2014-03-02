@extends('layouts.postlayout')

@if($type=="edit")
<?php $tagArray=array();?>
@foreach ($question->tags as $tag) 
	<?php $tagArray[]=$tag->tag_name;?>
@endforeach
@endif


@section('form')
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
		<br>
@stop
@section('aside')

			<h5 class='box-solid-bottom' >Rules for posting</h5>
			<style>
				.skip-list > li{
					margin-top: 10px;
				
				}

				.skip-list i{
					color:#008cba;
				}
			</style>
			<table class="no-bullet skip-list" >

				<tr><td colspan=2><b>How to ask</b></td></tr>
				<tr><td><i class='fa fa-book'></td><td></i> Questions should be based on the Mumbai University Engineering Syllabus</td></tr>
				<tr><td><i class='fa fa-comment'></i></td><td> Provide details in the questions</td></tr>
				<br>
				<tr><td colspan=2><b>Formatting Tips</b></td></tr>
				<tr><td><i class='fa fa-edit'></i></td><td> We use <a href="http://daringfireball.net/projects/markdown/syntax">markdown</a> for formatting. Take a look. </tr>
				<tr><td><i class='fa fa-outdent'></i></td><td> Bold letters are written <strong>**bold**</strong> and italics like <i style='color:#000'>__italics__</i></td></tr>
				<tr><td><i class='fa fa-link'></i></td><td> Links are written as this: [link_text](link_address) </td></tr>
				<tr><td><i class='fa fa-book'></i></td><td>For mathematics we use MathJax. Here are some <a href="http://cdn.mathjax.org/mathjax/latest/test/examples.html">examples</a></i></td></tr>
				<tr><td><i class='fa fa-code'></i></td><td> All math must be included between two &lt;math&gt; and &lt;/math&gt; tags</a></i></td></tr>
				<tr><td><i class='fa fa-circle-o'></i></td><td> $\alpha$ is \alpha, $x^2$ is x^2, $\sqrt2$ is \sqrt2</a></i></tr>
				<tr><td><i class='fa fa-book'></i></td><td> $\int_1^n$ is \int_1^n, $\lim_{x\to 0}$ is \lim_{x\to 0}, $\hat i$ is \hat i</a></td></tr>


			</table>

@include('layouts/dialogs')
@stop