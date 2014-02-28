@extends('layouts.master')

@section('content')

<script type='text/javascript'>
	$(document).ready(function(){
		$("[name = 'modules']").click(function(){
			var modules = $(this).data('subject');
			var content = "<table>";
			$.each(modules, function(){
				var module_id = (this).module_id;
				content += "<tr><td><a href={{url('univquestions/view')}}?mid=" + module_id +">";
				content += (this).module_name;
				content += "</a></td></tr>";
			});
			content += "</table>";
			$(this).html(content);
		});

		$("[name = 'papers']").click(function(){
			var content = "<table>";
			var year = (new Date).getFullYear();
			var month = (new Date).getMonth()+1;
			var subject_id = $(this).data('subjectid');
				if (month >= 6) {
					content += "<tr><td><a href={{url('univquestions/view/paper', 'May" + year + "')}}?sid=" + subject_id + ">";
					content += "May/June" + year
					content += "</td>";
				}
				if (month == 12) {
					content += "<td><a href={{url('univquestions/view/paper', 'December" + year + "')}}?sid=" + subject_id + ">";
					content += "December " + year;
					content += "</td>";
				}
				content += "</tr>";
			for (var i = year-1; i >= 2010; i--) {
				content += "<tr><td>";
				content += "<tr><td><a href={{url('univquestions/view/paper', 'May" + i + "')}}?sid=" + subject_id + ">";
				content += "May/June " + i;
				content += "</td><td><a href={{url('univquestions/view/paper', 'December" + i + "')}}?sid=" + subject_id + ">";
				content += "December " + i;
				content += "</td></tr>";
				
			};
			content += "</table>";
			$(this).html(content);
		})
	});
</script>

<div class="row">
	<div class="large-8 large-offset-2 small-12 columns box-top box-sides box-bottom">
	@for ($i=3; $i <= 8; $i++)
		<h3>	Semester {{$i}} </h3>
		<table>
		@foreach ($subjects as $subject) 
			@if($subject->subject_sem == $i)
				<tr>
				<td><h5>{{HTML::link('univquestions/view?sid='.$subject->subject_id, $subject->subject_name);}}</h5></td>
				<td><h5 name="modules" data-subject='{{$subject->modules}}'><button>Modules</button></h5></td>
				<td><h5 name="papers" data-subjectid='{{$subject->subject_id}}'><button>Papers</button></h5></td>
				</tr>
			@endif
		@endforeach
		</table>
	@endfor
	</div>
</div>

@stop