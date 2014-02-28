<style>
	header{
		background: #008cba !important;
		min-height: 30px;
	}
	.sides{
		 border-left:#ddd solid thin;
		  border-right:#ddd solid thin;
	}
	.wrapper{
		width:400px;
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
Hi, Welcome to gradhat. 
<br>
 {{HTML::link('/', 'Here');}}'s a link to our site.
 </p>
</section>
<footer>
}LINKS
</footer>
</div>