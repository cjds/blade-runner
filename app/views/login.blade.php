@extends('layouts.master')

@section('content')
<div class="row">

<div class="large-4 small-12 medium-6 columns">
	<div class="well">
		<h3>Please Login</h3>

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

		{{Form::text('email','',array('placeholder'=>'Enter Email Address'))}}<br>
		
		{{Form::password('password', array('placeholder'=>'Enter Password'));}}<br>
		{{Form::submit('Login', array('class'=>'button success'));}}
		<br>
		If you are not yet a user you can 		{{HTML::link('register', 'register', array('class'=>''));}}
		{{Form::close();}}
	</div>
</div>
</div>

@stop