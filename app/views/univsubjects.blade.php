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
		<?php $k=0;?>
		@foreach ($branch->subjects as $subject) 
			@if($subject->subject_sem == $i)
				<h5 style='text-align:center'>
				{{HTML::link('univquestions/view?sid='.$subject->subject_id, $subject->subject_name);}}</h5>
				<div class='medium-6 columns small-12 box-right'>
				<h6 class='subheader' style='text-align:center'>Modules</h6>
				
				<?php $j=0;?>
				@foreach ($subject->modules as $module)
					@if(($j)%2==0)
						<div class='row'>
					@endif
					<div class='columns medium-6 small-6' style='text-align:center'>
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
				</div>
				
				<div class='large-6 columns small-12'>
				<h6 class='subheader' style='text-align:center'>Papers</h6>
				<?php $count=0;?>

				@foreach($universityquestiondates[$k] as $date)

					@if(($count)%2==0)
						<div class='row'>
					@endif
					<div class='columns medium-6 small-6 ' style='text-align:center'>
						{{HTML::link('univquestions/view/paper/'.urlencode($date)."?sid=".$subject->subject_id, $date);}} 
					</div>
					@if(($count)%2==1)
						</div>
					@endif
				<?php $count++;?>
				@endforeach
				@if(($count)%2==1)
						</div>
					@endif
				</div>
			@endif
			<br>
			<hr>
			<?php $k++;?>
		@endforeach
		</div>
		</dd>	
	@endfor


@stop