@extends('layouts.master')

@section('content')

<div class="row">
	<div class="large-4 small-12 columns">
		<h3>Edit Module</h3>
		{{Form::open(array('url'=>'admin/modules/edit'))}}
		{{Form::hidden('module_id', $module->module_id);}}
		{{Form::label('module_name', 'Module Name')}} 
		{{Form::text('module_name', $module->module_name, array('style' => 'width:400px'))}} <br>
		{{Form::label('module_subject', 'Subject')}}
		{{Form::select('module_subject', $subjects, $module->subject->subject_id)}}
		{{Form::submit('Save Changes', array('class'=>'button'))}}
		{{Form::close()}}
		<br>
	</div>
</div>
@stop