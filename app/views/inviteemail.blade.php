<!DOCTYPE html>

<html lang="en-US">
<head  charset="utf-8">
    {{HTML::script("js/jquery.js")}}
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

<script>
	$(document).ready(function(){
		
		$('#showmail').click(function(){
			if($('#maindiv').css('display')=='none'){
				$('#maindiv').css('display','block');
			$('#display').css('display','none');
			}
			else{
			$('#maindiv').css('display','none');
			$('#display').html($('#maintext').val());
			$('#display').css('display','block');
			}
		})
	});
</script>
</head>
<body>
<div class='large-6 columns'>
<header>
	<a href="{{ URL::to('view/questions')}}">
    	{{HTML::image('img/logo.png', 'gradhat', array('style'=>"height:40px;margin-top:2px;margin-left:5px;margin-right:5px"));}}
    </a>
</header>
<section class='sides'>

<br>

<form action='' method="POST">
<div id='maindiv'>
To(separated by comma ):<br>
<textarea name='recepient' style="width:300px;height:50px">
</textarea><br>

<br>

Body(Enter content in HTML):<br>
<textarea name='maintext' id='maintext' style="width:700px;height:200px"> 
<h2>Hi, </h2>
<br>
This is a mail from all of us at GradHat. 
<br>We hope you can help us build our project into something useful.
<br>Thanks. 
</textarea>
	

</div>
<div id="display" style='display:none'>

</div>


<br>
<input type='button' id='showmail' class='button' value="Preview/Unpreview"/>
<input type='submit' class='button'/>
</form>
<br>

</section>
<footer>

</footer>
</div></body>
</html>