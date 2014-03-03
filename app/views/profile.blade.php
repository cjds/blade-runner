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
			<table class="table large-12 small-12 column" style='padding:0px'>
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
	@foreach($questions as $question)
		<tr>
		<td>{{HTML::link('view/question?qid='.$question->post_id,$question->type->question_title)}}</a>
		
		</td>
		<td>{{$question->type->answers()->count('post_id')}} </td>
		<td> {{$question->type->question_points}} </td>
		</tr>
		@endforeach
	</tbody>

	</table>
	@if(count($questions)>5))
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
	@foreach($answers as $answer)
	<tr style='align:left'>
		<td>{{HTML::link('view/question?qid='.$answer->type->question->post_id,substr($answer->type->answer_body,0, 50))}}</td>
		<br>
		<td> {{$answer->type->answer_points}} </td>
		</tr>
		@endforeach
	</tbody>
	</table>
	@if(count($answers)>5))
	{{HTML::link('user/'.$user->user_id.'/answers', 'more',array('class'=>'right', 'style'=>"margin-right:10px"))}}
	@endif
	</div>
</div>
</div>

@stop