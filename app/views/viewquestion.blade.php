@extends('layouts.master')
{{HTML::style('css/markdown.css');}}
{{HTML::script('js/markdown/Markdown.Converter.js');}}
{{HTML::script('js/markdown/Markdown.Sanitizer.js');}}
{{HTML::script('js/markdown/Markdown.Editor.js');}}

  
<script type="text/x-mathjax-config">
  MathJax.Hub.Config({
    jax: ["input/TeX","output/HTML-CSS"],
    tex2jax: {inlineMath: [["$","$"],["\\(","\\)"]], displayMath: [ ["$$","$$"] ],mathsize: "90%",
    processEscapes: true},
    "HTML-CSS":{linebreaks:{automatic:true}},
     TeX: { noUndefined: { attributes: 
{ mathcolor: "red", mathbackground: "#FFEEEE", mathsize: "90%" } } }, 

  });
</script>


{{HTML::script('http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML');}}
{{HTML::script('../../MathJax.js?config=TeX-AMS-MML_HTMLorMML');}}
@section('content')
<style>
.votebtn:hover{
	cursor: pointer;
}

</style>
<script type="text/javascript">
var Preview = {
  delay: 150,  
converter :null,
  preview: null,
  buffer: null, 

  timeout: null,
  mjRunning: false,
  oldText: null,   
  init: function () {
    this.preview = document.getElementById("wmd-preview");
    this.buffer = document.getElementById("wmd-input");
    this.converter= new Markdown.Converter();
  },

  Update: function () {
    if (this.timeout) {clearTimeout(this.timeout)}
    this.timeout = setTimeout(this.callback,this.delay);
  },

  CreatePreview: function () {
    
    Preview.timeout = null;
    if (this.mjRunning) return;
    var text = this.buffer.value;
    //console.log(text);
    if (text === this.oldtext) return;
    this.oldtext = text;
    text=this.converter.makeHtml(text);
    text=text.replace(/[\$]/gi,'\ \\$');
    text = text.replace(/<\/math>/gi,'$$');
    text = text.replace(/<math>/gi,'$$');
    this.preview.innerHTML=text;
    //console.log(text);
    this.mjRunning = true;
    MathJax.Hub.Queue(
      ["Typeset",MathJax.Hub,this.preview],
      ["PreviewDone",this]
    );
  },

  PreviewDone: function () {
    this.mjRunning = false;
   
  }

};
</script>

<script type='text/javascript'>
  $(document).ready(function(){
          
    Preview.init();
    Preview.callback = MathJax.Callback(["CreatePreview",Preview]);
    Preview.callback.autoReset = true;  // make sure it can run more than once

    $('#wmd-bold').click(function(e){
        $('#wmd-input').val(setUpmarkDownChar('**',$('#wmd-input'),'bold',true));
    });

    $('#wmd-italics').click(function(e){
        $('#wmd-input').val(setUpmarkDownChar('_',$('#wmd-input'),'italics',true));
    });

    $("#wmd-blockquote").click(function(e){
        text=blockMarkdownPara($('#wmd-input'),'>');
        $('#wmd-input').val(text);
    });

    $("#wmd-code").click(function(e){
        text=blockMarkdownPara($('#wmd-input'),'    ');
        $('#wmd-input').val(text);
    });

    $('#wmd-image').click(function(e){
        $('#imagedialog').foundation('reveal', 'open');
    });

    $('#wmd-ol').click(function(e){
        text=blockMarkdownPara($('#wmd-input'),'1. ');
        $('#wmd-input').val(text);
    });

    $('#wmd-ul').click(function(e){
        text=blockMarkdownPara($('#wmd-input'),'* ');
        $('#wmd-input').val(text);
    });

    $('#wmd-function').click(function(e){
        $('#functiondialog').foundation('reveal','open')
    });

    $( "#wmd-link" ).click(function(e) {
      e.preventDefault();
      var selectionStart=$("#wmd-input")[0].selectionStart;
      var selectionEnd=$("#wmd-input")[0].selectionEnd;
      if(selectionStart!=selectionEnd){
        var text=$('#wmd-input').val().substring(selectionStart,selectionEnd);
        $('#markdown_add_link input[name=link-description]').val(text);
      }
      $('#linkdialog').foundation('reveal', 'open');
    });    

    $('button.addeqnbtn').click(function(){
      $('#wmd-input').val(markdownAddChar('',$('#wmd-input')[0].selectionStart,$('#wmd-input')[0].selectionStart,$('#wmd-input').val(),'<math> '+$(this).attr('data-eqn')+'</math>',false));
      $('#functiondialog').foundation('reveal','close');
    })

    function blockMarkdownPara(inputElement,addingString){
        var text=inputElement.val();
        console.log(text);
        var selectionStart=inputElement[0].selectionStart;
        var selectionEnd=inputElement[0].selectionEnd;
        var position=text.substring(0,selectionStart).lastIndexOf('\n');
        if(selectionStart!=selectionEnd){
          para=text.substring(position,selectionEnd).replace(/[\n]/g,'\n'+addingString+' ');
          para=para.replace('\r','\r'+addingString+' ');
          text=text.substring(0,position)+'\n'+addingString+' '+para+text.substring(selectionEnd);
        } 
        else{
          position=text.substring(0,selectionStart).lastIndexOf('\n');
          text=text.substring(0,position)+'\n'+addingString+' '+text.substring(position);
        }  
        return text;
    }

    $('#addLinkBtn').click(function(e) {
       //[This link](http://example.net/) 
       //markdown_add_link
       var link=$('#markdown_add_link input[name=link-href]').val();
       var text=$('#markdown_add_link input[name=link-description]').val();

       $('#markdown_add_link input[name=link-href]').val(''); //reset value to blank
       $('#markdown_add_link input[name=link-description]').val(''); //reset value to blank
         
       $('#wmd-input').val(markdownAddChar('',$('#wmd-input')[0].selectionStart,$('#wmd-input')[0].selectionStart,$('#wmd-input').val(),'['+text+']'+'('+link+')',false));

       $('#linkdialog').foundation('reveal', 'close');
    });

    $('#addImageBtn').click(function(e){
        //var link
        var link=$('#markdown_add_image input[name=image-href]').val();
       var text=$('#markdown_add_image input[name=image-description]').val();

       $('#markdown_add_image input[name=image-href]').val(''); //reset value to blank
       $('#markdown_add_image input[name=image-description]').val(''); //reset value to blank
         
       $('#wmd-input').val(markdownAddChar('',$('#wmd-input')[0].selectionStart,$('#wmd-input')[0].selectionStart,$('#wmd-input').val(),'['+text+']'+'('+link+')',false));

       $('#linkdialog').foundation('reveal', 'close');
    });

    function setUpmarkDownChar(addingString,inputElement,middlePart,isSymmetric){
        return markdownAddChar(addingString,inputElement[0].selectionStart,inputElement[0].selectionEnd,inputElement.val(),middlePart,isSymmetric);
    }

    function markdownAddChar(addingString,selectionStart,selectionEnd,text,middlePart,isSymmetric){
      var start=text.substring(0,selectionStart);
      var selection=text.substring(selectionStart,selectionEnd);
      var end=text.substring(selectionEnd);
      if(selectionStart!=selectionEnd){
        middlePart=selection;
      }

      if(isSymmetric){
        return (start+' '+addingString+middlePart+addingString+' '+end);
      }
      else
        return (start+' '+addingString+middlePart+' '+end);
      
    }


    $('#wmd-input').on('keyup paste change',function(e){
        //$('.wmd-preview').html(converter.makeHtml($(this).val()));
        
        Preview.Update();
        //mathjaxediting();
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
      $('#flagdialog').foundation('reveal', 'close');
    });
	});

</script>

<section role="main">
<div class="row">
  <div class="large-10 medium-10 small-12 columns" >
    <div class="row">

    	<h4>{{ $question->question_title }}</h4>
    	<hr>
    </div>
    
    <div class="row">
      <div class="large-1 hide-for-small hide-for-medium columns" style='margin-bottom:15px'>
            @if( !$question->post->votes()->where('user_id',$user_id)->where('voteType',1)->exists())
              {{HTML::image('img/upvote-bland.png', 'upvote', array('style'=>'width:40px;height:30px;margin-left:8px','class'=>'votebtn','data-post-id'=>$question->post_id,'data-vote'=>1));}}
            @else
              {{HTML::image('img/upvote-pep.png', 'upvote', array('style'=>'width:40px;height:30px;margin-left:8px'));}}
            @endif
            <div style='text-align:center;font-size:1.7em'>{{$question->post->votes()->sum('voteType')+0;}} </div>
            @if(!$question->post->votes()->where('user_id',$user_id)->where('voteType',-1)->exists())
              {{HTML::image('img/downvote-bland.png', 'downvote', array('style'=>'width:40px;height:30px;margin-left:8px','class'=>'votebtn','data-post-id'=>$question->post_id,'data-vote'=>-1));}}
            @else
              {{HTML::image('img/downvote-pep.png', 'downvote', array('style'=>'width:40px;height:30px;margin-left:8px'));}}
            @endif
		</div>
      <div class="large-11 small-12  columns">
        <div class='post-div row'>
			{{ $question->question_body}}
        </div>
        <br>
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
        
        <div class='row user-div' style='font-size:0.8em'>
          {{ "by ".$question->post->creator->user_username}}
          <img src="http://www.gravatar.com/avatar/{{md5($question->post->creator->user_email)}}?s=30&d=identicon" alt=""> <br> <br>
        </div>

        <div class="row link-div" style='font-size:0.8em'>
			
		
		@if($question->post->editor!=null)
		{{ "Edited by ".$question->post->editor->user_username}}
		@endif
					{{HTML::link('#', 'share')}}
      @if(Auth::user())
    			{{HTML::link('edit/question?qid='.$question->post_id, 'edit')}}
    				<a href="#" class="flagbtn" data-post-id="{{$question->post_id}}">flag</a>
    			@if(Auth::user()->privelege_level>=15)
    				{{HTML::link('edit/question?qid='.$question->post_id, 'close')}}
          @endif
          @if(Auth::user()->privelege_level>=15 || Auth::user()==$question->post->creator)  
    				{{HTML::link('edit/question?qid='.$question->post_id, 'delete')}}
    			@endif
      @endif
        </div>
      </div>
    </div>
    </div>
    <aside class="large-2 hide-for-small columns">
    	<div class="row">
  			<h5>Tags</h5>
    		<hr>
    	</div>
    	<div class="tag-div row">
	    	@foreach($question->tags as $tag)
				<span class='tag'>{{HTML::link('search/questions/tag/'.urlencode($tag->tag_name), $tag->tag_name);}}</span>
			@endforeach
    	</div>
    	<div class='row'>
    		<h5>Related Questions</h5>
    		<hr>
  		</div>
  		<div class='row related-questions-div'>
  		</div>
  	</aside>
  </div>
<br>
  <div class="large-10 medium-10 small-12 columns">
    
    <div class='row'>
    	<h3>Answers</h3><hr>
    </div>
	
	@foreach ($question->answers as $answer)
		<div class='row' style='margin-bottom:60px'>

      		<div class="large-1 hide-for-small hide-for-medium columns">
        		@if(!$answer->post->votes()->where('user_id',$user_id)->where('voteType',1)->exists())
              {{HTML::image('img/upvote-bland.png', 'upvote', array('style'=>'width:40px;height:30px;margin-left:8px','class'=>'votebtn','data-post-id'=>$answer->post_id,'data-vote'=>1));}}
            @else
              {{HTML::image('img/upvote-pep.png', 'upvote', array('style'=>'width:40px;height:30px;margin-left:8px'));}}
            @endif
        		<div style='text-align:center;font-size:1.7em'>{{$answer->post->votes()->sum('voteType')+0;}} </div>
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
	        	
            <div class='row user-div' style='font-size:0.8em'>
              {{ "by ".$answer->post->creator->user_username}}
              <img src="http://www.gravatar.com/avatar/{{md5($answer->post->creator->user_email)}}?s=30&d=identicon" alt=""> <br> <br>
            </div>
            
	        	<div class="link-div row" style='font-size:0.8em;'>
	          		{{HTML::link('#', 'share')}}
                @if(Auth::user())
      		        	{{HTML::link('edit/question?qid='.$answer->post_id, 'edit')}}
      					<!--@TODO File dialog fix-->
          					<a href="#" class="flagbtn" data-post-id="{{$answer->post_id}}">flag</a>
          					@if(Auth::user()->privelege_level>=15 )
          						{{HTML::link('edit/question?qid='.$answer->post_id, 'close')}}
                    @endif
                    @if(Auth::user()->privelege_level>=15 || Auth::user()==$question->post->creator)
          						{{HTML::link('edit/question?qid='.$answer->post_id, 'delete')}}
                    @endif
    					  @endif
				</div>
				
			</div>
		</div>
    @endforeach

	<div class='row' style='margin-bottom:60px'>
	@if($errors->any())
		<div class="alert alert-error">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			{{implode('',$errors->all('<li class="error">:message</li>'))}}
		</div>
	@endif

	{{Form::open(array('url'=>'add/answer'))}}
	{{Form::hidden('question_id', $question->post_id);}}
	<label>Think you can answer this question</label>
                
                <div class="wmd-panel">
            <div id="wmd-button-bar" class='wmd-button-row '>
              <div class='wmd-buttons'>
                  <span id='wmd-bold'></span>
                  <span id='wmd-italics'></span>
                  <span id='wmd-link'></span>
                  <span id='wmd-blockquote'></span>
                  <span id='wmd-code'></span>
                  <span id='wmd-image'></span>
                  <span id='wmd-ol'></span>
                  <span id='wmd-ul'></span>
                  <span id='wmd-function'></span>
              </div>
              
            </div>
            <textarea class="wmd-input" id="wmd-input"></textarea>
        </div>
        <div id="wmd-preview" class="wmd-panel wmd-preview"></div>


      <br>
		{{Form::submit('Add Answer', array('class'=>'button'));}}
		{{Form::close();}}
    </div>
    <aside class="large-2 hide-for-small columns">
    </aside>
  </div>
  </div>
</div>


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




</section>

@stop