@extends('layouts.master')

@section('content')



<style>
td.count{
	font-size: 1.7em;
	text-align: center;
}

.searchtable thead tr th{
	text-align:center;	
}
</style>

<div class="row">
	<div class="large-8 small-12 columns">
	<table class="large-8 small-12 searchtable">
	  <thead>
	<tr>
		<th>Votes</th>
		<th>Answers</th>
		<th>Question</th>
		<th  class='hide-for-small'>Tags</th>
	</tr>
	</thead> 

	<tbody>
	@foreach($questions as $question)
	<tr>
		<td class='count'>{{($question->post->votes()->sum('voteType')+0);}} </td>
		<td class='count'>{{$question->answers()->count('post_id');}} </td>
	
		<td><a href="{{url('view/question')}}?qid={{$question->post_id}}">{{ $question->question_title }}</a> - {{ $question->post->creator->user_username}}
			<br>
				@foreach($question->tags as $tag)
					<span class='tag hide-for-medium hide-for-large'>{{HTML::link('search/questions/tag/'.urlencode($tag->tag_name), $tag->tag_name);}}</span>
				@endforeach
		</td>
		<td class='hide-for-small'>
		@foreach($question->tags as $tag)
			<span class='tag'>{{HTML::link('search/questions/tag/'.urlencode($tag->tag_name), $tag->tag_name);}}</span>
		@endforeach
		
		</td>
		</tr>
		@endforeach
	</tbody>
	</table>
	</div>
</div>
@stop