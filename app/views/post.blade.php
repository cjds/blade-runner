@extends('layouts.postlayout')

<?php $tagArray=array();?>
@if(substr($type,0,4)=="edit")
@foreach (($type=="editquestion")?$question->tags:$question->question->tags as $tag) 
	<?php $tagArray[]=$tag->tag_name;?>
@endforeach
@endif



@section('form')
		@if($type=="new")
			<h3>Add a question</h3>
			{{Form::open(array('url' => 'add/question' ))}}
		@elseif(substr($type,0,4)=="edit")
			<h3>Edit {{($type=='editanswer')?'answer':'question'}}</h3>
			@if($type=='editanswer')
				{{Form::open(array('url' => 'edit/answer'))}}
			@else
				{{Form::open(array('url' => 'edit/question'))}}
			@endif
			{{Form::hidden('question_id', $question->post_id);}}
		@endif
		
		@if($errors->any())
			<div class='errors'>
				{{implode('',$errors->all('<div data-alert class="alert-box warning">:message <a href="#" class="close">&times;</a></div>'))}}
			</div>
		@endif
		<br><br>
		
		@if($type=='editquestion' || $type=='new')
			{{Form::label('title', 'Title')}}<br>

			{{Form::text('title',($type=='editquestion')?$question->question_title:Input::old('title'), array('id'=>'inputtext','autocomplete'=>'off',))}}
			<ul id="titledrop" class="large f-dropdown" style='display:none;left:0px;margin-top:-2px;' >
			</ul>

			{{Form::label('question', 'Body')}}<br>
			@include('layouts.markdownmanager',array('data'=>($type=='editquestion')?$question->question_body:Input::old('question')))
			<br>
			{{Form::label('tags', 'Tags')}}<br>
			  
			{{Form::text('tags',($type=='editquestion')?implode(',', $tagArray):Input::old('tags'),array('id'=>'taginput','autocomplete'=>'off'))}}
			<ul id="tagdrop" class="small f-dropdown" style='display:none;left:0px;margin-top:-2px;' >
			</ul>
			
		
		@else
		    Title <br>
		    {{$question->question->question_title}}
		    <br><br>
		    Body<br>
			{{$question->question->question_body}}
			<br><br>
			Tags<br>
			@foreach($tagArray as $tag)
				<span class='tag'>
					{{HTML::link('search/questions/tag/'.urlencode($tag), $tag);}}
				</span>
			@endforeach
			<br><br>
			@include('layouts.markdownmanager',array('data'=>($type=='editanswer')?$question->answer_body:Input::old('question')))
		@endif


		{{Form::submit((substr($type,0,4)=='edit')?'Edit':'Add Question',array('class'=>'button'))}}
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
				<tr><td><i class='fa fa-book'></i></td><td>For mathematics we use MathJax. Here are some <a href="http://meta.math.stackexchange.com/questions/5020/mathjax-basic-tutorial-and-quick-reference">examples</a></i></td></tr>
				<tr><td><i class='fa fa-code'></i></td><td> All math must be included between two &lt;math&gt; and &lt;/math&gt; tags</a></i></td></tr>
				<tr><td><i class='fa fa-circle-o'></i></td><td> $\alpha$ is \alpha, $x^2$ is x^2, $\sqrt2$ is \sqrt2</a></i></tr>
				<tr><td><i class='fa fa-book'></i></td><td> $\int_1^n$ is \int_1^n, $\lim_{x\to 0}$ is \lim_{x\to 0}, $\hat i$ is \hat i</a></td></tr>


			</table>

@include('layouts/dialogs')
<script type="text/javascript">

	$(document).ready(function(){

		function split( val ) {
    	  return val.split( /,\s*/ );
    	}
    	function extractLast( term ) {
      		return split( term ).pop();
    	}

    	$("#tagdrop").blur(function() {
    		if(!$('#tagdrop').is(':active'))
  				$('#tagdrop').css('display','none');
		});

		$("#taginput").bind('input',function(e){
			if(($(this).val()).length>1){
				$.ajax({
	  				url: "{{URL::to('json/search/tag')}}",
	  				dataType :"json",
	  				data:{
	  					'term':extractLast($(this).val()),
	  					'count':'5'
	  				}
				}).done(function(data) {

	  				$('#tagdrop').html('');
	  				if(data.length>0)
	  					$('#tagdrop').css('display','block');
	  				else
	  					$('#tagdrop').css('display','none');
	  				for(var i=0;i<data.length;i++){
	  					$('#tagdrop').append("<li><a href='#' class='taglink' data-label='"+data[i].label+"'>"+data[i].label+"</a> </li>")	
	  				
	  				}
	  				
				});
			}
	     });

		$('#tagdrop').on('click','.taglink',function(e){
			e.preventDefault();
			var terms = split($('#taginput').val());
          	terms.pop();
          	terms.push( $(this).data('label') );
         	terms.push( "" );
          	$("#taginput").val(terms.join( ", " ));
          	$('#tagdrop').css('display','none');
          	$('#taginput').focus();
			
		});

		$("#inputtext").bind('input',function(){ 
			var query=$(this).val();
			if(query.length>4){
				$.ajax({
	  				url: "{{URL::to('json/relatedquestions')}}",
	  				dataType :"json",
	  				data:{
	  					'query':query,
	  					'count':'5'
	  				}
				}).done(function(data) {
	  				$('#titledrop').html('<li><a href="#"><strong>Your Question might have been asked</strong></a></li>');
	  				if(data.length>0)
	  					$('#titledrop').css('display','block');
	  				else
	  					$('#titledrop').css('display','none');
	  				for(var i=0;i<data.length;i++){
	  					$('#titledrop').append("<li><a href='{{URL::to('view/question')}}?qid="+data[i].post_id+"' class='taglink'>"+data[i].question_title+"</a> </li>");
	  				}
				});
			}
		});

		$("#inputtext").blur(function() {
			if(!$('#titledrop').is(':active'))
  				$('#titledrop').css('display','none');
		});	
	});
</script>
@stop

