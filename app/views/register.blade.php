@extends('layouts.master')

@section('content')
<div class="row">
<div class="large-4 small-12 medium-6 columns">
		<h3>Please Register</h3>
		{{Form::open(array('url'=>'register'))}}
		@if($errors->any())
			<div class='errors'>
				
				{{implode('',$errors->all('<div data-alert class="alert-box warning">:message <a href="#" class="close">&times;</a></div>'))}}
			</div>
		@endif
		{{Form::text('user_username','',array('placeholder'=>'Enter Username'))}}<br>
		{{Form::text('user_email','',array('placeholder'=>'Enter Email Address'))}}<br>
		{{Form::password('user_password', array('placeholder'=>'Enter Password'));}}<br>
		{{Form::password('user_confpassword', array('placeholder'=>'Confirm Password'));}}<br>
		{{Form::submit('Register', array('class'=>'button success'));}}
		{{HTML::link('login', 'Login', array('class'=>'button '));}}
		{{Form::close();}}

</div>
</div>

@stop