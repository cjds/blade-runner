@extends('layouts.master')

@section('content')

<div class="row">
	<div class="large-4 small-12 columns">
		<h3>Add New Subject</h3>
		{{Form::open(array('url'=>'admin/add/subjects'))}}
		{{Form::label('subject_name', 'Subject Name')}} 
		{{Form::text('subject_name', '', array('style' => 'width:400px'))}} <br>
		{{Form::label('subject_shortname', 'Subject Shortname')}} 
		{{Form::text('subject_shortname', '', array('style' => 'width:400px'))}} <br>
		{{Form::label('subject_sem', 'Semester')}} 
		{{Form::selectRange('subject_sem', 1, 8)}} <br>
		{{Form::label('subject_branch', 'Branch')}}
		{{Form::select('subject_branch', $branches)}}
		{{Form::submit('Add Subject', array('class'=>'button'))}}
		{{Form::close()}}
		<br>
	</div>
</div>
		

		<div class="row">
			<div class="large-8 small-12 columns">
				<h3>All Subjects</h3>
					<table class="table">
			  			<thead>
							<tr>
								<th>Subject Name</th>
								<th>Short Name</th>
								<th>Sem</th>
								<th>Branch</th>
							</tr>
						</thead> 
						<tbody>
							@foreach($subjects as $subject)
								<tr style='align:left'>
									<td>{{$subject->subject_name}} </td>
									<td>{{$subject->subject_shortname}} </td>
									<td>{{$subject->subject_sem}}</td>
									<td>{{$subject->branch->branch_name}}</td>	
								</tr>
							@endforeach
						</tbody>
					</table>
			</div>
		</div>
@stop