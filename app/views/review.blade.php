@extends('layouts.master')

@section('content')
{{HTML::style('css/markdown.css');}}
{{HTML::script('http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML');}}
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




<script type="text/javascript">
	$(document).ready(function(){
		var suggested_edits_id=-1;

		jsonReview();

		function jsonReview(){
			$.getJSON( "{{url('json/moderator/newreview')}}", function( json ) {
				if(json.status=='success'){
					$('#explanation').html(json.edit_explanation);
					suggested_edits_id=json.suggested_edits_id;
					if(json.type=='question'){
						$('#about').html('<h3>Edit of a question</h3>');
	  					$('#original').html('<h4>'+json.original_title+'</h4><br>'+json.original_body+'<br>'+json.original_tags);
	  					$('#new').html('<h4>'+json.new_title+'</h4><br>'+json.new_body+'<br>'+json.new_tags); 
	  				}
	  				else{
	  					$('#about').html('<h3>Edit of an Answer</h3><h4>'+json.question_title+'</h4><br>'+json.question_body+'<br><br><span style="font-size:0.8em">Tags: '+json.question_tags+"</span><br><br>")
						$('#original').html(json.original_body);
	  					$('#new').html(json.new_body);   					
	  				}
	  			}
	  			else if(json.status=='fail'){
	  				suggested_edits_id=-1;
	  				if(json.type=='no_review_left'){

	  					$('#about').html('<h2>No More Reviews Left</h2>');
	  					$('#original').html('');
	  					$('#new').html("");
	  				}
	  			}
	  			
	 		});
		}
		
		$('input.review-btn').click(function(e){
			e.preventDefault();
			$.ajax ({ 
				type:"POST",
				url:"{{url('json/moderator/newreview')}}",
				dataType:'json',
				data: { type:$(this).attr('data-type'), suggested_edits_id : suggested_edits_id}
			})
			.done(function( json ) {
    			jsonReview();
  			});

		});
	});
  
</script>





<div class='columns' style='min-height:400px' data-equalizer-watch>
<div class='row'>
<div id="about"></div>
</div>
<div class='row'>

	<div class="large-6 columns box-sides box-top  box-bottom small-12">
		<h3>Original</h3>	
		<div id='original'></div>
	</div>
	
	<div class=" large-6 columns small-12 box-sides box-top box-bottom">
		<h3>New</h3>	
		<div id='new'></div>
	</div>

</div>

<div class='row'>
	<div id='explanation' class="columns ">
	</div>
</div>	
<br><br>
<div class='row'>
	<div class="columns ">
		<input type='button' class='review-btn button small' data-type='approve' value='Approve'/>
		<input type='button' class='review-btn button small' data-type='skip' value='Skip'/>
		<input type='button' class='review-btn button small' data-type='reject' value='Reject'/>
			
	</div>
</div>
</div>
@stop