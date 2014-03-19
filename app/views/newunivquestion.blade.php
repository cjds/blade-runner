@extends('layouts.postlayout')

@section('form')

<script type="text/javascript">

$(document).ready(function(){

	var count={{($data==null)?0:count($data->universityquestiondates)}};
	var modules=<?php echo json_encode($modules) ?>;

	@if($data==null)
		addDate();
	@endif

	populateModules();
	$('#addmorebtn').on('click', function(){
		addDate();
	});

	$('.delete').on('click',function(e){
		e.preventDefault();
		$(this).parent().parent().remove();
	});

	function addDate(){
		var k =$('#magic').html().replace(/\[\d\]/gi,"["+count+"]");
		$('#field_set').append(k);
		count++;
	}
	$('#subject').change(function(){
		populateModules();		
	});


	
	function populateModules(){
		var data=modules[$('#subject').val()];
		var k="";
		for (index = 0; index < data.length; ++index) {
    		k+="<option value='"+data[index]['id']+"' "+data[index]['selected']+">"+data[index]['name']+"</option>";
		}
		$('#module').html(k);
	}
});
		   

	
</script>
	<h3>Add University Question</h3>
	
	{{Form::open(array('url'=>(($data==null)?'add':'edit').'/univquestion', 'id'=>'formab'))}}
	{{Form::label('title', 'Question Title')}} 
	{{Form::text('title', ($data==null)?'':$data->question->question_title, array('class'=>'large-8','id'=>'inputtext','autocomplete'=>'off'))}}
	<ul id="titledrop" class="large f-dropdown" style='display:none;left:0px;margin-top:-2px;' >
	</ul>
	 <br>
	{{Form::label('question', 'Question Body')}} 
	@include("layouts.markdownmanager",array('data'=>(($data==null)?'':$data->question->question_body)))
	<!--{{Form::textarea('question','', array('class' => 'large-8','cols'=>'50','rows'=>'10'))}}<br> -->

	@if($data!=null)
		{{Form::hidden('postid',$data->post_id);}}
	@endif
	<table id="field_set">
	@if($data!=null)
	<?php $i=0;?>
	@foreach ($data->universityquestiondates as $key => $value) 
		<?php $dates=explode(' ' ,$value->month_year)?>
	
		<tr >
			<td>
				{{Form::label('ques_no['.$i.']', 'Question Number')}} 
				{{Form::text('ques_no['.$i.']', $value->question_number, array('style' => 'width:40px'))}} 		
			</td>
			
			<td>
				<input name="month[{{$i}}]" type="radio" value="May" {{(trim($dates[0])=='May')?'checked':''}}> May/June
			</td>
			<td>
				<input name="month[{{$i}}]" type="radio" value="December" {{($dates[0]=='December')?'checked':''}}> December
			</td>
			<td>
				{{Form::selectRange('year['.$i.']', $dates[1], 2014, 2007)}}<br>			
			</td>
			<td>
			<a href='#' class='delete' data-delete='{{$i}}'>delete</a>
			</td>   
		</tr>
		<?php $i++;?>
	@endforeach
	@endif
	</table>
	<input type="button" value="Add more" class='button small' id='addmorebtn'/>
	{{Form::label('marks', 'Marks')}} 
	{{Form::text('marks', ($data==null)?'':$data->question_marks, array('style' => 'width:400px'))}} <br>
	{{Form::label('subject', 'Subject')}} 
	<select name="subject" id='subject'> 
	@foreach ($subjects as $key=>$subject) 
	
		<option value="{{$key}}"  {{$subject['selected']}}>{{$subject['name']}}</option>
	@endforeach
	</select>
	<br>
	{{Form::label('module', 'Module')}} 
	{{Form::select('module', array())}}<br>
	{{Form::label('tags', 'Tags')}}
	@if($data!=null)
	@foreach ($data->question->tags as $key => $value) 
		<?php $tags[]=$value->tag_name;?>
	@endforeach
	@endif
	{{Form::text('tags',($data==null)?'':implode(',',$tags), array('style' => 'width:400px','id'=>'taginput','autocomplete'=>'off'))}}
	<ul id="tagdrop" class="small f-dropdown" style='display:none;left:0px;margin-top:-2px;' >
	</ul>
			 <br>
	{{Form::submit('Add Question',array('class'=>'button'))}}
	{{Form::close()}}

<style type="text/css">
	#magic > tr > td{
		padding:0px
	}

</style>
		<table id='magic' style='display:none;'>
		<tr >
			<td>
				{{Form::label('ques_no', 'Question Number')}} 
				{{Form::text('ques_no[0]', '', array('style' => 'width:40px'))}} 		
			</td>
			
			<td>
				<br />
				<input name="month[0]" type="radio" value="May"> May/June
			</td>
			<td>
				<br />
				<input name="month[0]" type="radio" value="December"> December
			</td>
			<td>
				<br />
				{{Form::selectRange('year[0]', 2000, 2014, 2007)}}<br>			
			</td>
 
			<td>
			<a href='#' class='delete' data-delete='[0]'>delete</a>
			</td>   
		</tr>
		</table>
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



<script type="text/javascript">

	$(document).ready(function(){

		function split( val ) {
    	  return val.split( /,\s*/ );
    	}
    	function extractLast( term ) {
      		return split( term ).pop();
    	}

    	$("#taginput").blur(function() {
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