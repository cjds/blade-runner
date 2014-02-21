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
			<table class="table large-12 small-12 column">
				<tr>
					<td>Name</td>
					<td>{{$user->user_name}}</td>
				</tr>
				<tr>
					<td>Username</td>
					<td>{{$user->user_username}}</td>
				</tr>
				<tr>
					<td>Email</td>
					<td>{{$user->user_email}}</td>
				</tr>
				<tr>
					<td>Points</td>
					<td>{{$user->user_points}}</td>
				</tr>

			</table>
		</div>

		<div class='row'>

			<ul style='list-style:none;display:inline' class='large-12 columns'>
				<li><a href="{{url('edit/profile')}}">Edit Profile</a></li>
				<li><a href="{{url('edit/password')}}">Change Password</a></li>
			</ul>
		</div>
	</div>
</div>

<div class="row">
	<div class='large-6 small-12 columns'>
	<h4>Questions by me</h4>

	<table class="table small-12 large-11">
	<thead>
	<tr>
		<th>Question</th>
		<th>Answers</th>
		<th>Points</th>
	</tr>
	</thead> 

	<tbody>
	@foreach($questions as $question)
		<tr style='align:left'>
		<td>{{HTML::link('view/question?qid='.$question->post_id,$question->type->question_title)}}</a>
		
		</td>
		<td>{{$question->type->answers()->count('post_id')}} </td>
		<td> {{$question->type->question_points}} </td>
		</tr>
		@endforeach
	</tbody>
	</table>
</div>

<div class='large-6 small-12 columns'>
	<h4>Answers by me</h4>
	<table class="table small-12 large-11">
	<thead>
	<tr>
		<th>Answer</th>
		<th>Points</th>
	</tr>
	</thead> 

	<tbody>
	@foreach($answers as $answer)
	<tr style='align:left'>
		<td>{{HTML::link('view/question?qid='.$answer->type->question->post_id,substr($answer->type->answer_body,0, 50))}}</td>
		<br>
		<td> {{$answer->type->answer_points}} </td>
		</tr>
		@endforeach
	</tbody>
	</table>

</div>
</div>

@stop