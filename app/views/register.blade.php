@extends('layouts.master')

@section('content')
<div class="row">
<div class="span4 offset1">
	<div class="well">
		<legend>Please Register</legend>
		{{Form::open(array('url'=>'register'))}}
		@if($errors->any())
			<div class="alert alert-error">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				{{implode('',$errors->all('<li class="error">:message</li>'))}}
			</div>
		@endif
		{{Form::text('user_username','',array('placeholder'=>'Enter Username'))}}<br>
		{{Form::text('user_email','',array('placeholder'=>'Enter Email Address'))}}<br>
		{{Form::password('user_password', array('placeholder'=>'Enter Password'));}}<br>
		{{Form::password('user_confpassword', array('placeholder'=>'Confirm Password'));}}<br>
		{{Form::submit('Register', array('class'=>'btn btn-success'));}}
		{{HTML::link('login', 'Login', array('class'=>'btn btn-primary'));}}
		{{Form::close();}}
	</div>
</div>
</div>

@stop