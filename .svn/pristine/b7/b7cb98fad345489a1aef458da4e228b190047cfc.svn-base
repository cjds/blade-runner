@extends('layouts.master')
@section('content')

{{Form::open(array('url'=>'edit/profile'))}}
<div class='row '>
	<div class='columns'>
		<h3>Edit Profile</h3>
	</div>
</div>
@if($errors->any())
	<div class='row'>
		<div class='large-4 small-12 columns'>			
			<div class='errors'>
				{{implode('',$errors->all('<div data-alert class="alert-box warning">:message <a href="#" class="close">&times;</a></div>'))}}
			</div>

		</div>
	</div>

	@endif
<div class="row">
	<div class='columns'>
	<table class="large-4 small-12   table">
		<tr>
			<td>{{Form::label('name','Name')}}</td>
			<td>{{Form::text('name', (Input::old('name')!='')?Input::old('name'):$user->user_name)}}</td>
		</tr>
		<tr>
			<td>{{Form::label('username', 'Username')}}</td>
			<td>{{Form::text('username', (Input::old('username')!='')?Input::old('username'):$user->user_username)}}</td>
		</tr>
		<tr>
			<td>{{Form::label('email', 'Email')}}</td>
			<td>{{Form::text('email', (Input::old('email')!='')?Input::old('email'):$user->user_email)}}</td>
		</tr>
		<tr>
			<td colspan="2">{{Form::submit('Save Changes',array('class' => 'button' ))}}</td>
		</tr>
	</table>
	</div>
</div>

@stop