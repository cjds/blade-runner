@extends('layouts.postlayout')

@section('form')

<script type="text/javascript">
var count=1;
$(document).ready(function(){

	$('#addmorebtn').on('click', function(){
		
		var k = "<tr>"+$('#magic').html().replace(/\[\d\]/gi,"["+count+"]")+"</tr>";
		$('#field_set').append(k);
		count++;


	});

});
		   

	
</script>
	<h3>Add University Question</h3>
	
	{{Form::open(array('url'=>'add/univquestion', 'id'=>'formab'))}}
	{{Form::label('title', 'Question Title')}} 
	{{Form::text('title', '', array('class'=>'large-8'))}} <br>
	{{Form::label('question', 'Question Body')}} 
	@include("layouts.markdownmanager",array('data'=>""))
	<!--{{Form::textarea('question','', array('class' => 'large-8','cols'=>'50','rows'=>'10'))}}<br> -->
	<table id="field_set">

		<tr id="magic">
			<td>
				{{Form::label('ques_no', 'Question Number')}} 
				{{Form::text('ques_no[]', '', array('style' => 'width:40px'))}} <br>			
			</td>
			
			<td>
				<input name="month[0]" type="radio" value="May"> May/June
			</td>
			<td>
				<input name="month[0]" type="radio" value="December"> December
			</td>
			<td>
				{{Form::selectRange('year[]', 2000, 2014, 2007)}}<br>			
			</td>   
		</tr>

	</table>
	<input type="button" value="Add more" class='button small' id='addmorebtn'/>
	{{Form::label('marks', 'Marks')}} 
	{{Form::text('marks', '', array('style' => 'width:400px'))}} <br>
	{{Form::label('subject', 'Subject')}} 
	{{Form::select('subject', $subjects)}}<br>
	{{Form::label('module', 'Module')}} 
	{{Form::select('module', $modules)}}<br>
	{{Form::label('tags', 'Tags')}}
	{{Form::text('tags','', array('style' => 'width:400px'))}} <br>
	{{Form::submit('Add Question',array('class'=>'button'))}}
	{{Form::close()}}

@stop


@section('aside')

@stop