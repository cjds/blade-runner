@extends('layouts.master')

@section('content')

<style type="text/css">
	h4{
		display: inline;;
		font-size:12px; 
		text-decoration: underline;
	}
</style>



<div class="row">
	<div class="large-8 small-12 columns">
	<table class="table large-12">
	<thead>
	<tr>
		<th>#</th>
		<th>Question</th>
		<th>Marks</th>
		<th>Votes</th>
		<th>Answers</th>
		<th>Asked in</th>
	</tr>
	</thead> 

	<tbody>
	@foreach($univques as $uq)
	<tr style='align:left'>
		<td>{{$uq->question_number}}</td>
		<td>
			<a href="{{url('view/question')}}?qid={{$uq->post_id}}">{{ $uq->question->question_title }}
			</a>
			<br>
			@foreach($uq->question->tags as $tag)
				<a href="{{url('search/questions/tag')}}{{'/'.$tag->tag_name}}">{{$tag->tag_name." "}}</a>
			@endforeach
		</td>
		<td>{{$uq->question_marks}}</td>
		<td>{{($uq->question->post->votes()->sum('voteType')+0);}} </td>
		<td>{{$uq->question->answers()->count('post_id');}} </td>
		<td>
			@foreach ($uq->universityquestiondates as $date)
				{{$date->month_year}}
			@endforeach
			</td>
		</tr>
		@endforeach
	</tbody>
	</table>
	</div>
	</div>
@stop