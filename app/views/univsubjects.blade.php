@extends('layouts.simple')

@section('content')


<style>
.accordion dd .content a{
background:none !important;
}
</style>
<?php $header=$branch->branch_name?>
@section('simpledata')
<dl class="accordion" data-accordion>
  
	@for ($i=3; $i <= 8; $i++)
		<dd>
		<a href="#panel{{$i}}">Semester {{$i}} </a>
		
		<div id="panel{{$i}}" class="content">
		@foreach ($branch->subjects as $subject) 
			@if($subject->subject_sem == $i)
				<h5>
				{{HTML::link('univquestions/view?sid='.$subject->subject_id, $subject->subject_name);}}</h5>
				<h6 class='subheader'>Modules</h6>
				
				<?php $j=0;?>
				@foreach ($subject->modules as $module)
					@if(($j)%2==0)
						<div class='row'>
					@endif
					<div class='columns medium-5 small-6 medium-offset-1'>
						{{HTML::link('univquestions/view?mid='.$module->module_id, $module->module_name);}}
						</div>
					@if(($j)%2==1)
						</div>
					@endif
					<?php $j++;?>
				@endforeach 
				@if(($j)%2==1)
				</div>
				@endif
				
				<h6 class='subheader'>Papers</h6>
				
				@foreach(array(2013,2012,2011,2010) as $j)
				
				<div class='row'>
				<div class='columns medium-5 small-6 medium-offset-1'>
				{{HTML::link('univquestions/view/paper/May'.$j."?sid=".$subject->subject_id, "May ".$j);}}  
				</div>
				<div class='columns medium-5 small-6 medium-offset-1'>
				{{HTML::link('univquestions/view/paper/December'.$j."?sid=".$subject->subject_id, "December ".$j);}}
				</div>
				</div>
				
				@endforeach
				</ul>
				<hr>
			@endif
		@endforeach
		</div>
		</dd>	
	@endfor


@stop