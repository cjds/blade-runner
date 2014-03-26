<!DOCTYPE html>
<html lang="en-US">
<head  charset="utf-8">
<style>
	header{
		background: #008cba !important;
		min-height: 30px;
		margin-bottom: 0px;
		padding-bottom: 0px;
	}
	.sides{
		padding-left: 5px;
		 border:#ddd solid thin;

	}
	footer{
		background: #f9f9ff !important;
	}
</style>
</head>
<body>
<div class='wrapper'>
<header>
	<a href="{{ URL::to('view/questions')}}">
    	{{HTML::image('img/logo.png', 'gradhat', array('style'=>"height:40px;margin-top:2px;margin-left:5px;margin-right:5px"));}}
    </a>
</header>
<section class='sides'>

{{$data}}
<br>
<blockquote>Please do not respond to this email</blockquote>
</section>
<footer>

</footer>
</div></body>
</html>