@extends('layouts.master')

@section('content')

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
	  					$('#original').html('<h4>'+json.original_title+'</h4><br>'+json.original_body+'<br>'+json.original_tags);
	  					$('#new').html('<h4>'+json.new_title+'</h4><br>'+json.new_body+'<br>'+json.new_tags); 
	  				}
	  				else{
						$('#original').html(json.original_body);
	  					$('#new').html(json.new_body);   					
	  				}
	  			}
	  			else if(json.status=='fail'){
	  				suggested_edits_id=-1;
	  				if(json.type=='no_review_left'){
	  					$('#original').html('<h2>No More Reviews Left</h2>');
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

<div class="row">
	<div class="span8 offset1">
		<h3>Original</h3>	
		<div id='original'></div>
	</div>
	<br><br>
	<div class="span8 offset1">
		<h3>New</h3>	
		<div id='new'></div>
	</div>
	<div id='explanation' class="span8 offset1">
	</div>
	<div class="span8 offset1">
		<input type='button' class='review-btn button' data-type='approve' value='Approve'/>
		<input type='button' class='review-btn button' data-type='skip' value='Skip'/>
		<input type='button' class='review-btn button' data-type='reject' value='Reject'/>
			
	</div>
</div>
@stop