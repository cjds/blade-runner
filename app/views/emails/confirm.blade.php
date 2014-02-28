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
<div class='wrapper'>
<header>
	<a href="{{ URL::to('view/questions')}}">
    	{{HTML::image('img/logo.png', 'gradhat', array('style'=>"height:40px;margin-top:2px;margin-left:5px;margin-right:5px"));}}
    </a>
</header>
<section class='sides'>
<p>
<h2>Hi {{$user}}, </h2>
This is an authentication link you can use to confirm your email:
<br>
<a href='{{$link}}'>{{$link}}</a>
<br><br> Now that you're a member you can:
 <ul>
 <li>Post Questions</li>
 <li>View the Mumbai University Questions</li>
 </ul>
 </p>
</section>
<footer>

</footer>
</div>