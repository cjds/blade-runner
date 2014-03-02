@extends('layouts.master')

@section('content')

<div class="large-4 large-offset-1 small-12 medium-6 columns">
	<div class="row">
		<h3>Please Login</h3>
	</div>
	<div class="row">
		@if($type=='admin')
			{{Form::open(array('url'=>'admin/login'))}}
		@elseif($type=='user')
			{{Form::open(array('url'=>'login'))}}	
		@endif
		@if($errors->any())
			<div class='errors'>
				
				{{implode('',$errors->all('<div data-alert class="alert-box warning">:message <a href="#" class="close">&times;</a></div>'))}}
			</div>
		@endif
	</div>
	<div class="row">
		{{Form::text('email','',array('placeholder'=>'Enter Email Address'))}}<br>
		
		{{Form::password('password', array('placeholder'=>'Enter Password'));}}<br>
		{{Form::submit('Login', array('class'=>'button success'));}}
		<br>	
		If you are not yet a user you can 		{{HTML::link('register', 'register', array('class'=>''));}}
		{{Form::close();}}
	</div>
</div>

@stop