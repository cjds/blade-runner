@extends('layouts.master')



@section('content')

<script type="text/javascript">
 $(document).ready(function(){
	$('aside').height($('.main').height());
});
</script>
<div class="row">
<div class="medium-8 medium-offset-2 columns">
	<div class="row">
	<div class=" box-top box-sides small-12 medium-8 columns main  ">
		@yield('form')
	</div>
	<aside class=" hide-for-small  medium-4 box-top box-sides  columns"  data-equalizer-watch>

		@yield('aside')
	</aside>
	</div>
</div>
</div>	
@stop