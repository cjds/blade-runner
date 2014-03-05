@extends('layouts.master')

@section('content')

<div class="row">
	<div class="large-4 small-12 columns">
		<h3>Edit Subject</h3>
		{{Form::open(array('url'=>'admin/subjects/edit'))}}
		{{Form::hidden('subject_id', $subject->subject_id);}}
		{{Form::label('subject_name', 'Subject Name')}} 
		{{Form::text('subject_name', $subject->subject_name, array('style' => 'width:400px'))}} <br>
		{{Form::label('subject_shortname', 'Subject Shortname')}} 
		{{Form::text('subject_shortname', $subject->subject_shortname, array('style' => 'width:400px'))}} <br>
		{{Form::label('subject_sem', 'Semester')}} 
		{{Form::selectRange('subject_sem', 1, 8, $subject->subject_sem)}} <br>
		{{Form::label('subject_branch', 'Branch')}}
		{{Form::select('subject_branch', $branches, $subject->branch->branch_id)}}
		{{Form::submit('Save changes', array('class'=>'button'))}}
		{{Form::close()}}
		<br>
	</div>
</div>

@stop