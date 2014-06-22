@extends('layouts.master')

@section('content')



<style>
td.count{
	font-size: 1.7em;
	text-align: center;
}

td.count span{
	
	text-align: center;
}
.searchtable thead tr th{
	text-align:center;	
}

.sort{
	margin-bottom: 0;
	background-color: #eef;
}
</style>
<div class="large-offset-1 large-10 medium-12 small-12 columns box-top box-bottom box-sides"  data-equalizer-watch>

<div class='columns medium-12'>	
	@if($keyword=="" && $tagSearch =="")
		<div class="small-12 medium-8 columns">
		<h2>View Questions</h2>
		</div>
		<div class="small-12 medium-4 medium-right columns" style="margin-top:15px">
		@include('sortandfilter')
		</div>
	@else
		@if(trim($keyword)!="")
			<h3>Search for: {{$keyword}}</h3>
			<h6>{{HTML::link('search/questions/sort/'.$sort.'/filter/'.$filter.'?search='.$tagSearch, 'clear search')}}</h6>
		@endif
		
		<h3>Tags included: </h3>
		@foreach ($tag as $t) 
			@include ('layouts.tag',array('tag_name'=>$t))
		@endforeach
		<h6>{{HTML::link('search/questions/sort/'.$sort.'/filter/'.$filter.'?search='.$keyword, 'clear tag')}}</h6>
		
	{{Form::open(array('url'=>'search/questions','method'=>'get','role'=>"search"))}} 
	      <div class="row collapse margintop-20px">
        		<div class="small-8 medium-8 columns">
            {{Form::text('search',$keyword.$tagSearch,array('style'=>'','placeholder'=>'search'));}}
            </div>
               <div class="small-4 medium-1 columns">
            {{Form::submit('Submit', array('style'=>'','class'=>'tiny button'));}}
            {{Form::close();}}
            </div>
            <div class="small-12 medium-3 columns">
            @include('sortandfilter')
            </div>
            </div>

     
	
	@endif



<div class="row">
	<table class="large-12 small-12 searchtable ">
	  <thead>
	<tr>
		
		<th   class='hide-for-small'>Votes</th>
		<th >Answers</th>
		<th>Question</th>
		<th  class='hide-for-small'>Tags</th>
	</tr>
	</thead> 

	<tbody>
	@foreach($questions as $question)
	<tr>
		
		<td class='count hide-for-small medium-1'>{{($question->post->votes()->sum('voteType')+0);}}</td>
		<td class='count medium-1'>{{$question->answers()->count('post_id');}} </td>
	
		<td><a href="{{url('view/question')}}?qid={{$question->post_id}}"><span style='font-size:1.2em'>{{ $question->question_title }}</span></a><span class='right hide-for-small' style='font-size:0.8em'>asked by {{HTML::link('view/profile/'.urlencode($question->post->creator->user_username),$question->post->creator->user_username)}}</span>
			<br>
				@foreach($question->tags as $atag)
					@include('layouts.tag',array('tag_name'=>($atag->tag_name)))
				@endforeach
		</td>
		<td class='hide-for-small medium-3'>
		@foreach($question->tags as $atag)
			@include('layouts.tag',array('tag_name'=>($atag->tag_name)))
		@endforeach
		
		</td>
		</tr>
		@endforeach
	</tbody>
	</table>
</div>
<div class="row" style='margin:auto'>
	{{$questions->appends(array('search'=>$keyword.$tagSearch))->links()}}
</div>
	</div>
</div>
@stop