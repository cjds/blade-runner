@extends('layouts.master')

@section('content')

<style type="text/css">
</style>



<div class="row">
	<div class="medium-10 medium-offset-1 small-12 columns" style='min-height:400px'>
	<div class="row">
	<h3>{{$name}}</h3>
	</div>
	<table class="table large-12 searchtable">
	<thead>
	<tr>
		<th>#</th>
		<th>Question</th>
		<th>Marks</th>
		<th class='hide-for-small'>Votes</th>
		<th class='hide-for-small'>Answers</th>
		<th class='hide-for-small'>Asked in</th>
		<th>Belongs to Module</th>
	</tr>
	</thead> 

	<tbody>
	@foreach($univques as $uq)
	<tr style='align:left'>
		<td>
			@foreach ($uq->universityquestiondates as $qno)
				{{$qno->question_number}}
				<br>
			@endforeach
		</td>
		<td>
			<a href="{{url('view/question')}}?qid={{$uq->post_id}}">{{ $uq->question->question_title }}
			</a>
			<br>
			@foreach($uq->question->tags as $tag)
				<span class='tag'><a href="{{url('search/questions/tag')}}{{'/'.$tag->tag_name}}">{{$tag->tag_name." "}}</a></span>
			@endforeach
		</td>
		<td>{{$uq->question_marks}}</td>
		<td class='hide-for-small'>{{($uq->question->post->votes()->sum('voteType')+0);}} </td>
		<td class='hide-for-small'>{{$uq->question->answers()->count('post_id');}} </td>
		<td class='hide-for-small'>
			@foreach ($uq->universityquestiondates as $date)
				{{$date->month_year}}

			@endforeach
		</td>
		<td><a href="{{url('univquestions/view')}}?mid={{$uq->module->module_id}}">{{$uq->module->module_name}}</td>
		</tr>
		@endforeach
	</tbody>
	</table>
	</div>
	</div>
@stop