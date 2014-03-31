<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{URL::asset('icon/favicon.ico')}}" type="image/icon" >
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

    <meta name=”description” content="GradHat provides the answers to all the mumbai university questions. We're a community of students and teachers helping people get through their exams">

    <meta property="og:url" content="http://blade-runner.gopagoda.com/" />
    <meta property="og:title" content="Gradhat" />
    <meta property="og:description" content="GradHat is a company that builds educational solutions and has fun doing it." />
    <meta property="og:image" content="{{URL::asset('img/logo cutout.jpg');}}" />



    <title>{{$title}} | GradHat</title> 
    {{HTML::style('css/foundation.css')}}
    {{HTML::script('js/modernizr.js')}}
    {{HTML::script("//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js")}}
    {{HTML::script("js/jquery.js")}}
    {{HTML::style('css/main.css')}}
  </head>

  <body>

    
<nav class="top-bar" data-topbar>
  <ul class="title-area">
    <li class="name">
      <a href="{{ URL::to('view/questions')}}">
        {{HTML::image('img/logo.png', 'gradhat', array('style'=>"height:34px;margin-top:5px;margin-left:5px;margin-right:5px","class"=>'logo'));}}
      </a>
    </li>
    
  </ul>

  <section class="top-bar-section"  class='columns'>
    <!-- Right Nav Section -->
    <ul class="right">
    	@if(Auth::user())
          <li class="divider  hide-for-small"></li>
        	<li>
          <a href="{{ URL::to('view/profile')}}">
          
          {{(Auth::user()->user_username)}}
          <span class='bluebox'>{{number_format(Auth::user()->user_points)}} </span></a></li>
          <li class="divider"></li>
          <!--<li><a href="#"><span class='notification'>3</span></a></li>-->
          <li class="divider"></li>
          @if(Auth::user()->privelege_level>=15)
            <li class='hide-for-small'>
                {{HTML::link('moderator/home', 'moderate');}}
                
            </li>
            <li class="divider"></li>
          @endif
          @if(Auth::user()->privelege_level>20)
            <li>{{HTML::link('admin/login','admin')}}</li>
            <li class="divider"></li>

          @endif
          <li>{{HTML::link('logout', 'logout');}}</li>
        @else

	        <li><a href="{{ URL::to('login')}}">login</a></li>
        @endif

			<li class="divider  hide-for-small"></li>
      		<li class="has-form">
        		<div class="row collapse">
          			<div class="large-8 small-12 columns">
           				{{Form::open(array('url'=>'search/questions','method'=>'get','class'=>"navbar-form navbar-right",'role'=>"search"))}} 
            			{{Form::text('search','',array('style'=>'height:30px;width:140px','placeholder'=>'search'));}}
            			{{Form::close();}}
          			</div>   
        		</div>
      		</li>
	</ul>

    <!-- Left Nav Section -->
    <ul class="left hide-for-small hide-for-medium">
      <li class="divider"></li>
      <li>{{HTML::link('add/question', 'ask a question')}}</li>
      <li class="divider"></li>
      <li>{{HTML::link('univquestions/mainpage', 'mumbai university questions')}}</li>
      <li class="divider"></li>
      
    </ul>


  </section>
</nav>




<section role="main" class='columns' data-equalizer>
@yield('content')	
</section>    

<footer style='background:#ddd; margin-top:50px;width:100%;margin-left:0px;margin-right:0px;padding-left:0px;padding-right:0px' class='columns'>
<div class='row' style=''>
<div class='large-3 medium-3 columns' style=''>
<div class="vertical-line hide-for-small" ></div>
<img src='{{URL::asset("img/grad_caps.svg")}}' class='fa fa-2x' style='height:32px'/>
  <h4 class='subheading'>GradHat</h4>
  <p>GradHat is a company that builds educational solutions and has fun doing it.
  You can find out more about us <a href="{{URL::to('contact')}}" style='color:text-decoration:underline'>here.</a>
  </p>

</div>



<div class='large-3 medium-3  columns' style='padding-top:30px;text-align:center'>
<div class="vertical-line hide-for-small" ></div>
<i class="fa fa-sitemap fa-2x"></i> 
<h4 class='subheading'>Site</h4>

<ul>
     <li>{{HTML::link('add/question', 'Ask A Question')}}</li>
     <li>{{HTML::link('univquestions/mainpage', 'Mumbai University Questions')}}</li>
     <li>{{HTML::link('/', 'View Questions')}}</li>
</ul>
</div>

<div class='large-3 medium-3 columns' style='padding-top:30px;text-align:center'>
<div class="vertical-line hide-for-small" ></div>
<i class="fa fa-users fa-2x"></i>
<h4 class='subheading'>Social</h4>

<ul>
<li>Facebook (not yet here)</li>
<li>Twitter (coming, we promise)</li>
<li>Google+ (does it matter)</li>  
</ul>
</div>
<div class='large-3 medium-3 columns' style='padding-top:30px;text-align:center'>
<i class="fa fa-building-o fa-2x"></i> 
<h4 class='subheading'>Contact Us</h4>

<p>This site is still in beta. If you spot any errors please contact us on <a href="mailto:gradhat2013@gmail.com" style='color:text-decoration:underline'>gradhat2013@gmail.com</a></p>
</div>
    

</div>

<div class="row bottom" style="">
<a href="{{ URL::to('view/questions')}}">
{{HTML::image('img/logo.png', 'gradhat', array('style'=>"height:34px;margin-top:10px;margin-bottom:5px;margin-left:10px;display:inline;opacity:0.6","class"=>'logo'));}}
</a>
<p style='display:inline-block;font-size:0.8em;margin-top:1em;margin-right:30px;color:#ccc' class='right'>
Created and maintained by GradHat Inc. 2013, All rights reserved
</p>
</div>
</footer>

<div id="push"></div>
</section> 

{{HTML::script('js/foundation.min.js')}}
    <script>
      $(document).foundation();
    </script>

  </body>
</html>
