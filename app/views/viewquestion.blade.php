@extends('layouts.master')

@section('content')
<script>
  $(document).ready(function(){

    //Call the related questions
    $.ajax({
      url: '{{URL::to("json/relatedquestionstags")}}',
      type: 'POST',
      data: {num: 5,qid:{{$question->post_id}} },
      dataType: 'json'
    })
    .done(function(json) {
      $.each(json, function() {
        $('#related-questions-div')
            .append('<span class="related-questions"><a href="{{URL::to('view/question?qid=')}}'+this.post_id+'">'+this.question_title+'</a></span>');
      });
    });

    $('*.votebtn').click(function(e){
    
			e.preventDefault();
			$.ajax({
  				type: "POST",
  				url: "{{url('add/addVote')}}",
  				data: { type: $(this).attr('data-vote'), post_id: $(this).attr('data-post-id') }
  			});
		});

		$('#json_add_flag').submit(function(e){
			e.preventDefault();
			$(this).ajaxSubmit(function(){
				$('#flagdialog').foundation('reveal', 'close');
			});
		});

		$( "a.flagbtn" ).click(function(e) {
      e.preventDefault();
			$('#flag_post_id').attr('value',$(this).attr('data-post-id'));
      $('#flagdialog').foundation('reveal', 'open');
		});

    $('.modalclose').click(function(e){
      e.preventDefault();
      $('.reveal-modal').foundation('reveal', 'close');
    });
	});

</script>


  <div class="main large-8 box-top box-sides box-bottom large-offset-1 small-12 columns " >
    <div class="row">
        <h4 style='margin:15px' class='box-solid-bottom'>{{ $question->question_title }}</h4>
    </div>
    
    <div class="row">
      <div class="large-1 hide-for-small hide-for-medium columns" style='margin-bottom:15px'>
            @if( !$question->post->votes()->where('user_id',$user_id)->where('voteType',1)->exists())
              {{HTML::image('img/upvote-bland.png', 'upvote', array('style'=>'width:40px;height:30px;margin-left:8px','class'=>'votebtn','data-post-id'=>$question->post_id,'data-vote'=>1));}}
            @else
              {{HTML::image('img/upvote-pep.png', 'upvote', array('style'=>'width:40px;height:30px;margin-left:8px'));}}
            @endif
            <div style='text-align:center;font-size:1.7em;width:56px'>{{$question->post->votes()->sum('voteType')+0;}} </div>
            @if(!$question->post->votes()->where('user_id',$user_id)->where('voteType',-1)->exists())
              {{HTML::image('img/downvote-bland.png', 'downvote', array('style'=>'width:40px;height:30px;margin-left:8px','class'=>'votebtn','data-post-id'=>$question->post_id,'data-vote'=>-1));}}
            @else
              {{HTML::image('img/downvote-pep.png', 'downvote', array('style'=>'width:40px;height:30px;margin-left:8px'));}}
            @endif
		  </div>
      <div class="large-11 small-12  columns">
        <div class='post-div row'>{{ $question->question_body}}</div><br>
        <div class="row small-12 small-push hide-for-large columns">
          <a href='#' class='votebtn'>upvote</a>
          <a href='#' class='votebtn'>downvote</a>
        </div>
        <br>
        <div class='row tag-div'>
          @foreach($question->tags as $tag)
			       <span class='tag'>{{HTML::link('search/questions/tag/'.urlencode($tag->tag_name), $tag->tag_name);}}</span>
		      @endforeach
        </div>
        <br>
        <div class='row'>
          <div class='user-div'>
              <img src="http://www.gravatar.com/avatar/{{md5($question->post->creator->user_email)}}?s=30&d=identicon" alt=""> 
              {{$question->post->creator->user_username}}
          </div>
              @if($question->post->editor!=null)
            <div class='user-div'>
              <img src="http://www.gravatar.com/avatar/{{md5($question->post->creator->user_email)}}?s=30&d=identicon" alt=""> 
              {{$question->post->editor->user_username}} (editor)
          </div>
          @endif
          
        </div>

        <div class="row link-div" style='font-size:0.8em'>
      		
          @if(Auth::user())
          	{{HTML::link('edit/question?qid='.$question->post_id, 'edit')}}
            <a href="#" class="flagbtn" data-post-id="{{$question->post_id}}">flag</a>
          	<!--@if(Auth::user()->privelege_level>=15)
          			{{HTML::link('edit/question?qid='.$question->post_id, 'close')}}
            @endif
            @if(Auth::user()->privelege_level>=15 || Auth::user()==$question->post->creator)  
          			{{HTML::link('edit/question?qid='.$question->post_id, 'delete')}}
          	@endif-->
          @endif
        </div>
      </div>
    </div>
    
    <div class='row'>
    	<h3 style='margin-top:15px;margin-left:15px;margin-right:15px' class='box-solid-bottom'>Answers</h3>
    </div>
	<br>
	@foreach ($question->answers as $answer)
		<div class='row' style='margin-bottom:60px'>

      		<div class="large-1 hide-for-small hide-for-medium columns">
        		@if(!$answer->post->votes()->where('user_id',$user_id)->where('voteType',1)->exists())
              {{HTML::image('img/upvote-bland.png', 'upvote', array('style'=>'width:40px;height:30px;margin-left:8px','class'=>'votebtn','data-post-id'=>$answer->post_id,'data-vote'=>1));}}
            @else
              {{HTML::image('img/upvote-pep.png', 'upvote', array('style'=>'width:40px;height:30px;margin-left:8px'));}}
            @endif
        		<div style='text-align:center;font-size:1.7em;width:56px'>{{$answer->post->votes()->sum('voteType')+0;}} </div>
            @if(!$answer->post->votes()->where('user_id',$user_id)->where('voteType',-1)->exists())
        		  {{HTML::image('img/downvote-bland.png', 'downvote', array('style'=>'width:40px;height:30px;margin-left:8px','class'=>'votebtn','data-post-id'=>$answer->post_id,'data-vote'=>-1));}}
            @else
              {{HTML::image('img/downvote-pep.png', 'downvote', array('style'=>'width:40px;height:30px;margin-left:8px'));}}
            @endif
      		</div>
      
      		<div class="large-11 small-12  columns" >
        		<div class='post-div row' ><br>{{$answer->answer_body}} <br></div>
            
            <div class="small-12 hide-for-large row" style='margin-bottom:20px'>
          			<a href='#'>upvote</a>
        			<a href='#'>downvote</a>
        		</div>
	        	
            <div class='row'>
            <div class='user-div'>
            
              <img src="http://www.gravatar.com/avatar/{{md5($answer->post->creator->user_email)}}?s=30&d=identicon" alt="">
              {{$answer->post->creator->user_username}}
            </div>
            </div>
            
	        	<div class="link-div row" style='font-size:0.8em;'>
                @if(Auth::user())
      		        	{{HTML::link('edit/question?qid='.$answer->post_id, 'edit')}}
      					<!--@TODO File dialog fix-->
          					<a href="#" class="flagbtn" data-post-id="{{$answer->post_id}}">flag</a>
          					<!--@if(Auth::user()->privelege_level>=15 )
          						{{HTML::link('edit/question?qid='.$answer->post_id, 'close')}}
                    @endif
                    @if(Auth::user()->privelege_level>=15 || Auth::user()==$question->post->creator)
          						{{HTML::link('edit/question?qid='.$answer->post_id, 'delete')}}
                    @endif-->
    					  @endif
				</div>
				
			</div>
		</div>
    @endforeach

	<div class='row' style='margin-bottom:60px'>
    @if($errors->any())
      <div class='errors large-6 small-12' >        
        {{implode('',$errors->all('<div data-alert class="alert-box warning">:message <a href="#" class="close">&times;</a></div>'))}}
      </div>
    @endif


	{{Form::open(array('url'=>'add/answer'))}}
	{{Form::hidden('question_id', $question->post_id);}}
	<label>Think you can answer this question</label>
    @include("layouts.markdownmanager",array('data'=>''));
		{{Form::submit('Add Answer', array('class'=>'button'));}}
		{{Form::close();}}
    </div>
      </div>
  </div>
</div>
    <aside class="large-2 hide-for-small columns box-top" >
      <div class="row" style=" margin-top:17px">
        <h5 class='box-solid-bottom' style='padding:2px'>Tags</h5>
        
      </div>
      <div class="tag-div row">
        @foreach($question->tags as $tag)
        <span class='tag'>{{HTML::link('search/questions/tag/'.urlencode($tag->tag_name), $tag->tag_name);}}</span>
      @endforeach
      </div>
      <div class='row'>
        <h5 class='box-solid-bottom' style=''>Related Questions</h5>
      </div>
      <div class='row related-questions-div' id='related-questions-div'>

      </div>
    </aside>

<!-- Modal -->
<div id="flagdialog" class="reveal-modal" data-reveal>
    <div class='row'>
        <h2 id="myModalLabel">Flag this post</h2>
    </div>
    <div class='row'>
        {{Form::open(array('url'=>'json/add/flag','id' =>'json_add_flag'))}}
            {{Form::hidden('post_id', $question->post_id,array('id' => 'flag_post_id' ));}}

            {{Form::radio('flag-reason', 'This post contains inappropriate or spam content', true)}}
            This post contains inappropriate or spam content
            <br><br>
            {{Form::radio('flag-reason', 'The post is to broad or generalized', true)}}
            The post is to broad or generalized
            <br><br>
            {{Form::radio('flag-reason', 'The post is incomplete.', true)}}
            The post is incomplete.
            <br><br>
            {{Form::radio('flag-reason', 'Other', true)}}
            Other
            <br><br>
              {{Form::textarea('custom-reason', '',array('cols'=>'100','rows'=>'2','resize'=>'none'));}}
      </div>
      <div class="row">
          <button style='background-color:#cc3333' class=" modalclose">Close</button>
          {{Form::submit('Add Flag', array('class'=>'button'));}}
        {{Form::close()}}
    </div>
</div>

@stop