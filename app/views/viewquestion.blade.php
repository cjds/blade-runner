@extends('layouts.master')

@section('content')
<script>
  $(document).ready(function(){
$('aside').height($('.main').height());
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
      var thisCopy=$(this);
			$.ajax({
  				type: "POST",
  				url: "{{url('add/addVote')}}",
  				data: { type: $(this).attr('data-vote'), post_id: $(this).attr('data-post-id') },
          dataType:"json"
  			}).done(function(json){
            
          if(json.status=='pass'){
            //alert(a+" " + $(this).attr('data-vote'));
            if(thisCopy.attr('data-vote')==-1)
              thisCopy.attr('src','{{URL::asset("img/downvote-pep.png")}}');
            else
              thisCopy.attr('src','{{URL::asset("img/upvote-pep.png")}}');
            var copy=$('.voteno[data-post-id='+thisCopy.attr('data-post-id')+']');
            voteCount=parseInt(copy.html())+parseInt(thisCopy.attr('data-vote'));
            $('.voteno[data-post-id='+thisCopy.attr('data-post-id')+']').html(voteCount);
          }
          else{
            alert(json.message);
          }
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

  <div class="main large-8 box-top box-sides box-bottom large-offset-1 small-12 columns ">
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
            <div class='voteno' data-post-id='{{$question->post_id}}' style='text-align:center;font-size:1.7em;width:56px'>{{$question->post->votes()->sum('voteType')+0;}} </div>
            @if(!$question->post->votes()->where('user_id',$user_id)->where('voteType',-1)->exists())
              {{HTML::image('img/downvote-bland.png', 'downvote', array('style'=>'width:40px;height:30px;margin-left:8px','class'=>'votebtn','data-post-id'=>$question->post_id,'data-vote'=>-1));}}
            @else
              {{HTML::image('img/downvote-pep.png', 'downvote', array('style'=>'width:40px;height:30px;margin-left:8px'));}}
            @endif
		  </div>
      <div class="large-11 small-12  columns">
        <div class='post-div row'>{{ $question->question_body}}
        
        @if($university_question!=null)
        <?php 
          $dates=array();
          $subject=$university_question->subject;
          foreach ($university_question->universityquestiondates as $key => $value){
            $dates[]['name']=$value->month_year;
          }
        ?>
        <br>
        <span style='font-size:0.8em'>
        {{HTML::link('univquestions/view?sid='.$subject->subject_id, $subject->subject_name);}} ({{$university_question->question_marks}}m) <br>
        asked in 
        @foreach($dates as $date)
          {{HTML::link('univquestions/view/paper/'.urlencode($date['name'])."?sid=".$subject->subject_id, $date['name']);}} 
        @endforeach
        </span>
        @endif
        </div><br>
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
          @include("layouts.userprofile",array('user'=>$question->post->creator,'add'=>''))
          @if($question->post->editor!=null)
            @include("layouts.userprofile",array('user'=>$question->post->creator,'add'=>'(editor)'))
          @endif
          
        </div>

        <div class="row link-div" style='font-size:0.8em'>
      		
          @if(Auth::user())
          	<a href='{{URL::to('edit/question?qid='.$question->post_id)}}'> <i class="fa-pencil fa" style="margin:2px"></i>edit</a>

            <a href="#" class="flagbtn" data-post-id="{{$question->post_id}}"><i class='fa-flag fa' style='margin:2px'></i>flag</a>

            @if(Auth::user()->privelege_level>=15)
            <a href='{{URL::to('delete/question?qid='.$question->post_id)}}'> <i class="fa-trash-o fa" style="margin:2px"></i>delete</a>
            @endif
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
        		<div class='voteno' data-post-id='{{$answer->post->post_id}}' style='text-align:center;font-size:1.7em;width:56px'>{{$answer->post->votes()->sum('voteType')+0;}} </div>
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
            @include("layouts.userprofile",array('user'=>$answer->post->creator,'add'=>''))
            @if($answer->post->editor!=null)
              @include("layouts.userprofile",array('user'=>$answer->post->editor,'add'=>'(editor)'))
            @endif
            </div>
            
	        	<div class="link-div row" style='font-size:0.8em;'>
                @if(Auth::user())
      		        	<a href='{{URL::to('edit/answer?aid='.$answer->post_id)}}'> <i class="fa-pencil fa" style="margin:2px"></i>edit</a>

                    <a href="#" class="flagbtn" data-post-id="{{$answer->post_id}}"><i class='fa-flag fa' style='margin:2px'></i>flag</a>

      					<!--@TODO File dialog fix-->
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

@if(Auth::user())
	{{Form::open(array('url'=>'add/answer'))}}
	{{Form::hidden('question_id', $question->post_id);}}
	<label>Think you can answer this question</label>

    @include("layouts.markdownmanager",array('data'=>''))
		{{Form::submit('Add Answer', array('class'=>'button'));}}
		{{Form::close();}}
@else

  <div class='columns'>  Please {{HTML::link('/register','register')}} or {{HTML::link('/login','login')}} to answer this question</div>


@endif

    </div>
      </div>
  </div>
</div>
  <aside class="large-2 hide-for-small columns box-top box-sides"  data-equalizer-watch>
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
      <div class='row related-questions-div' style='font-size:0.8em' id='related-questions-div'>

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