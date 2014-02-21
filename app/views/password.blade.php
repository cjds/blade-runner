@extends('layouts.master')
@section('content')

{{Form::open(array('url'=>'edit/password'))}}
<div class="row">
	<table class="span4 offset1 table">
		<tr>
			<td>{{Form::label('password', 'New Password')}}</td>
			<td>{{Form::password('password')}}</td>
		</tr>
		<tr>
			<td>{{Form::label('password', 'Confirm Password')}}</td>
			<td>{{Form::password('confpassword')}}</td>
		</tr>
		<tr>
			<td>{{Form::submit('Update Password')}}</td>
		</tr>
	</table>
</div>

@stop