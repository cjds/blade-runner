@extends('layouts.master')

@section('content')
<script type="text/javascipt">
	
</script>

<div class="row">
	<div class="large-4 small-12 columns">		
		<div class="row">
			<div class='large-4 small-2 columns'>
				<img src="http://www.gravatar.com/avatar/{{md5($user->user_email)}}?d=identicon" alt=""> 
			</div>
			<div class='large-8 small-10 columns'>
				<h4>{{$user->user_username}}'s profile</h4>
			</div>
		</div>
	
		<br>
		<div class="row">
			<table class="table large-11 large-offset-1 small-12 column" style='padding:0px'>
				<tr>
					<td >Name</td>
					<td style='border:1px #ccc'>{{$user->user_name}}</td>
				</tr>

				<tr>
					<td>Username</td>
					<td>{{$user->user_username}}</td>
				</tr>
				@if(Auth::user()==$user)
				<tr>
					<td>Email</td>
					<td>{{$user->user_email}}</td>
				</tr>
				@endif
				<tr>
					<td>Points</td>
					<td>{{$user->user_points}}</td>
				</tr>

			</table>
		</div>
		@if(Auth::user()==$user)
		<div class='row'>

			<ul style='list-style:none;display:inline' class='large-12 columns'>
				<li><a href="{{url('edit/profile')}}">Edit Profile</a></li>
				<li><a href="{{url('edit/password')}}">Change Password</a></li>
			</ul>
		</div>
		@endif
	</div>
</div>

<div class="row">
	<div class='large-6 small-12 columns'>
	<h4>Questions asked</h4>
	<div class="large-11">
	<table class="searchtable table small-12">
	<thead>
	<tr>
		<th>Question</th>
		<th>Answers</th>
		<th>Votes</th>
	</tr>
	</thead> 

	<tbody>
	<?php $count=((count($questions)<5)?count($questions):5)?>
	@for($i=0;$i<$count;$i++)
		<td>{{HTML::link('view/question?qid='.$questions[$i]->post_id,$questions[$i]->type->question_title)}}</a>
	
		</td>
		<td>{{$questions[$i]->type->answers()->count('post_id')}} </td>
		<td> {{$questions[$i]->type->question_points}} </td>
		</tr>
	@endfor
	</tbody>

	</table>
	@if(count($questions)>5)
	{{HTML::link('user/'.$user->user_id.'/questions', 'more',array('class'=>'right', 'style'=>"margin-right:10px"))}}
	@endif
	</div>
</div>

<div class='large-6 small-12 columns'>
	<h4>Answers given</h4>
	<div class="large-11">
	<table class=" searchtable table small-12">
	<thead>
	<tr>
		<th>Answer</th>
		<th>Votes</th>
	</tr>
	</thead> 

	<tbody>
	<?php $count=((count($answers)<5)?count($answers):5)?>
	@for($i=0;$i<$count;$i++)
		<tr style='align:left'>
			<td>{{HTML::link('view/question?qid='.$answers[$i]->type->question->post_id,substr($answers[$i]->type->answer_body,0, 50))}}</td>
			<br>
			<td> {{$answers[$i]->type->answer_points}} </td>
		</tr>
	@endfor
	</tbody>
	</table>
	@if(count($answers)>5)
	{{HTML::link('user/'.$user->user_id.'/answers', 'more',array('class'=>'right', 'style'=>"margin-right:10px"))}}
	@endif
	</div>
</div>
</div>

@stop