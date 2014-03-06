@extends('layouts.master')

@section('content')

<div class="row">
	<div class="columns">

		<h3>Edit Branch</h3>
		{{Form::open(array('url'=>'admin/branches/edit'))}}
		{{Form::hidden('branch_id', $branch->branch_id);}}
		{{Form::label('branch_name', 'Branch Name')}} 
		{{Form::text('branch_name', $branch->branch_name, array('style' => 'width:400px'))}} <br>
		{{Form::label('branch_shortname', 'Branch Shortname')}} 
		{{Form::text('branch_shortname', $branch->branch_shortname, array('style' => 'width:400px'))}} <br>
		{{Form::submit('Save changes', array('class' => 'button'))}}
		{{Form::close()}}

	</div>
</div>

@stop