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
		console.log('data-delete');
		$(this).parent().parent().remove();
	});

	function addDate(){
		var k =$('#magic').html().replace(/\[\d\]/gi,"["+count+"]");
		console.log(k);
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
	{{Form::text('title', ($data==null)?'':$data->question->question_title, array('class'=>'large-8'))}} <br>
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
	{{Form::text('tags',($data==null)?'':implode(',',$tags), array('style' => 'width:400px'))}} <br>
	{{Form::submit('Add Question',array('class'=>'button'))}}
	{{Form::close()}}


		<table id='magic' style='display:none'>
		<tr >
			<td>
				{{Form::label('ques_no', 'Question Number')}} 
				{{Form::text('ques_no[0]', '', array('style' => 'width:40px'))}} 		
			</td>
			
			<td>
				<input name="month[0]" type="radio" value="May"> May/June
			</td>
			<td>
				<input name="month[0]" type="radio" value="December"> December
			</td>
			<td>
				{{Form::selectRange('year[0]', 2000, 2014, 2007)}}<br>			
			</td>   
			<td>
			<a href='#' class='delete' data-delete='[0]'>delete</a>
			</td>   
		</tr>
		</table>
@stop


@section('aside')

@stop