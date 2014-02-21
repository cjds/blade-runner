<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gradhat | Welcome</title>
    {{HTML::style('css/foundation.css')}}
    {{HTML::script('js/modernizr.js')}}
    {{HTML::script('js/jquery.js')}}

    <style>
    .row {min-width:100% !important;}

      .top-bar{
        background: #008cba;
      }

       .top-bar-section ul li a{
          background: #008cba !important;
       }

        .top-bar-section ul li.has-form{
          background: #008cba !important;
       }

       .top-bar-section ul li a:hover{
          background: #20acda !important;
          text-decoration: underline;;
       }

       .divider{
          border-right:  solid 1px #20acda !important;
       }

    .notification{
      border: solid 4px #ac0330 ;
      background:#ac0330;
    }

    .notification:hover{
      border: solid 4px #ff3350 ;
      background:#ff3350 ;
    }

      section[role='main']{
        margin-top: 20px;
      }

      post-div{
        color:#cccccc;
      }

    section[role='footer'] ul li{
      display: inline;
      margin-right:40px;
      float:right;
    }
      .tag{
        background-color: #008cba;
        color:#aaf;
        padding:3px;
        border-bottom:solid 3px #30ccfa;
        border-right:solid 3px #30ccfa;
        border-radius: 4px;
        margin: 4px;
        display: inline-block;
      }

      .tag a{
        color:#fff;
        font-size: 0.75em;

      }

      .tag a:hover{
        color:#fff;
        text-decoration: underline;  
      }

      .tag:hover{
        background-color: #20acca;
        border-bottom:solid 3px  #008cba;
        border-right:solid 3px  #008cba;
      }
    </style>
  </head>
  <body>
    
    <nav class="top-bar" data-topbar>
  <ul class="title-area">
    <li class="name">
      <h1>{{HTML::link('view/questions', 'Gradhat')}}</h1>
    </li>
    
  </ul>

  <section class="top-bar-section">
    <!-- Right Nav Section -->
    <ul class="right">
    	@if(Auth::user())
        	<li class='hide-for-small'>{{HTML::link('view/profile', ucwords(Auth::user()->user_username));}}</li>
          <li class="divider"></li>
          <li class='hide-for-small'><a href="#">{{number_format(Auth::user()->user_points)}} pts </a></li>
          <li class="divider"></li>
          <li><a href="#"><span class='notification'>3</span></a></li>
          <li class="divider"></li>
          @if(Auth::user()->privelege_level>15)
            <li class='hide-for-small'>
                {{HTML::link('moderator/home', 'moderate');}}
                
            </li>
            <li class="divider"></li>
          @endif
          @if(Auth::user()->privelege_level>20)
            <li class="hide-for-smmall">{{HTML::link('admin/login','admin')}}</li>
            <li class="divider"></li>

          @endif
          <li class='hide-for-small'>{{HTML::link('logout', 'logout');}}</li>
        @else
	        <li class='hide-for-small'>{{HTML::link('login', 'login');}}</li>
        @endif

			<li class="divider hide-for-small"></li>
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


<section role="main">
@yield('content')	
</section>    
{{HTML::script('js/foundation.min.js')}}
    <script>
      $(document).foundation();
    </script>

  </body>
</html>
