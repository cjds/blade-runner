@extends('layouts.simple')
<?php $header="Branches";?>
@section('simpledata')
	<ul>
		@foreach ($branches as $branch) 
			<li class='subheader' style='list-style:none'>
				@if($branch->branch_name=='Computers')
				<i class="fa fa-laptop"></i> 
				@elseif($branch->branch_name=='Information Technology')
				<i class="fa fa-flash"></i> 
				@elseif($branch->branch_name=='Electronics And Telecommunication')
				<i class="fa fa-desktop"></i> 
				@else
				<i class="fa fa-code-fork"></i> 
				@endif
				<a href="{{url('univquestions/view/branch')}}?bid={{$branch->branch_id}}"> {{$branch->branch_name}} </a>
			</li>
		@endforeach
	 </ul>
	<div style='margin-top:200px' class='columns'>
	<h6 class='subheader'>Need A Branch that's not on this list?</h6>
	<p >We're just starting out. So, we have very few branches here. We are continually looking for people to put more quality content on our website. If you think you might be intereseted feel free to 
	{{HTML::link('/contact','contact us')}}
	</p>
	</div>
</div>
</div>
</div>
@stop