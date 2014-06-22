@extends('layouts.master')

@section('content')

<style type="text/css">

.searchtable th:active{
	cursor: pointer;
	}
</style>

<script type="text/javascript">
	
	$(document).ready(function() {
		$('.searchtable').tablesorter({sortList: [[0,0]] });	
	});
</script>

<div class="row">
	<div class="medium-10 medium-offset-1 small-12 columns" style='min-height:400px'>
	<div class="row">
	<h3>{{$name}}</h3>
	</div>
	<table class="table large-12 searchtable">
	<thead>
	<tr>
		@if($type=='exam' )
			<th>#</th>
		@endif
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
	<tr>
		@if($type=='exam' )
		<td>
		
			@foreach ($uq->universityquestiondates as $qno)
				@if( $qno->month_year==$name)
					{{$qno->question_number}}<br>
				@endif
			@endforeach
		</td>
		@endif
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
			<?php $count=1;?>
			@foreach ($uq->universityquestiondates as $date)
				<a href="{{url('univquestions/view/paper/'.$date->month_year)}}?sid={{$sid}}">{{$date->month_year}}({{$date->question_number}}) </a>
				@if($count++<count($uq->universityquestiondates)){{','}}
				@endif

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