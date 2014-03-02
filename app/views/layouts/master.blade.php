<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{URL::asset('icon/favicon.ico')}}" type="image/icon" >
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

    <meta name=”description” content="Gradhat provides the answers to all the mumbai university questions. We're a community of students and teachers helping people get through their exams">


    <meta property="og:title" content="{{$title}}"/>

    <title>{{$title}} | Gradhat</title>
    {{HTML::style('css/foundation.css')}}
    {{HTML::script('js/modernizr.js')}}
    {{HTML::script('js/jquery.js')}}

    <style>
    .inline{
      display: inline-block;
    }
    .row {min-width:100% !important;}

      .top-bar, .bottom-bar{
        background: #008cba;
       }

 

       section[role="main"] div{
        background: #fff;
       }


      p{
                  font-family: "Open Sans", "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        font-weight: 500
      }
       .top-bar-section ul li a, .bottom-bar-section ul li a{
          background: #008cba !important;
          font-family: "Open Sans", "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
          font-weight: 500
       }

        .top-bar-section ul li.has-form{
          background: #008cba !important;

       }

       .top-bar-section ul li a:hover, .bottom-bar-section ul li a:hover{
          background: #20acda !important;
          text-decoration: underline;
          -webkit-transition: all 0.3s; /* For Safari 3.1 to 6.0 */
          transition: all 0.3s;
       }

       .divider{
          border-right:  solid 1px #008cba !important;
       }

    .notification{
      border: solid 4px #ac0330 ;
      background:#ac0330;
    }

    .notification:hover{
      border: solid 4px #ff3350 ;
      background:#ff3350 ;
    }

    .box-solid-bottom{
      border-bottom:#bbb solid thin;
    }
    .box-sides{
      border-left:#ddd solid thin;
 border-right:#ddd solid thin;
    }

    .box-top{
      border-top:#ddd solid thin;
    }

    .box-bottom{
      border-bottom:#ddd solid thin;
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

      .user-div{
        background-color:#eef;
        font-size:0.8em;
        width:120px;
        margin-top: 7px;
        margin-bottom: 7px;
        padding:5px;
        display: inline-block;
      }

      .text-center{
        text-align: center;
      }

 

      
      .searchtable{
        border: none; 
      }
      .searchtable th{
        background-color: #eee;
        font-family:  "Open Sans", "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        font-weight: 500;

      }
      .searchtable tr{
         background-color: #fff !important ; 
      }

    .bluebox{
      
      background:#3BAC88;
      padding:3px;
    }

    .bluebox:hover{

      background: #9DEF88;
    }

    .related-questions{
      display: block;;
      font-size: 1.0;
      padding: 2px;
    }

    aside{
      margin-right:10px;
      background-color:#f9f9ff;
    }

    aside div{
      background:#008cba;
    }

    .name:hover{
      background:#20acda;
      -webkit-transition: all 0.3s; /* For Safari 3.1 to 6.0 */
      transition: all 0.3s;
    }
    .logo{
      opacity:0.8;
      filter:alpha(opacity=80); 
    }

    .logo:hover{
      opacity:1.0;
      filter:alpha(opacity=100); 
      -webkit-transition: all 0.3s; /* For Safari 3.1 to 6.0 */
      transition: all 0.3s;
    }
    </style>


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
          <li class="divider"></li>
        	<li class='hide-for-small'>
          <a href="{{ URL::to('view/profile')}}">
          
          {{ucwords(Auth::user()->user_username)}}
          <span class='bluebox'>{{number_format(Auth::user()->user_points)}} </span></a></li>
          <li class="divider"></li>
          <!--<li><a href="#"><span class='notification'>3</span></a></li>-->
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

	        <li class='hide-for-small'>
          <a href="{{ URL::to('login')}}">login</a></li>
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


<section role="main" class='row' data-equalizer>
@yield('content')	
</section>    

<style>
footer div{
  margin-top: 30px;
  margin-bottom: 20px;
}
footer div ul li{
  margin-top: 0.2em;
}
footer div ul{
  margin-top: 0.8em;
  list-style: none;
}

footer div div{
  text-align:center;padding-top:30px;padding-bottom:0px
}
.bottom{
  background:#111;color:#eee;width:100%;padding:0px;
}

.bottom ul li{
  display: inline-block;

}

div.vertical-line{
  width: 1px; /* Line width */
  background-color: #008cba; /* Line color */
  height: 150px; /* Override in-line if you want specific height. */
  float: right; 
  margin-left:50px;
  margin-top: 0px;
  margin-bottom: 0px;
  padding-top: 0px;
  padding-bottom: 0px;
}


</style>
<footer style='background:#ddd; margin-top:50px;width:100%;margin-left:0px;margin-right:0px;padding-left:0px;padding-right:0px' class='columns'>
<div class='row' style=''>
<div class='large-3 columns' style=''>
<div class="vertical-line" ></div>
<img src='{{URL::asset("img/grad_caps.svg")}}' class='fa fa-2x'/>
  <h4 class='subheading'>Gradhat</h4>
  <p>Gradhat is a company that builds educational solutions and has fun doing it.
  You can find out more about us <a href="#" style='color:text-decoration:underline'>here.</a>
  </p>

</div>



<div class='large-3 columns' style='padding-top:30px;text-align:center'>
<div class="vertical-line" ></div>
<i class="fa fa-sitemap fa-2x"></i> 
<h4 class='subheading'>Site</h4>

<ul>
<li>Add A Question</li>
<li>View Questions</li>
<li>Mumbai University Questions</li>  
</ul>
</div>

<div class='large-3 columns' style='padding-top:30px;text-align:center'>
<div class="vertical-line" ></div>
<i class="fa fa-users fa-2x"></i>
<h4 class='subheading'>Social</h4>

<ul>
<li>Facebook</li>
<li>Twitter </li>
<li>Google+</li>  
</ul>
</div>
<div class='large-3 columns' style='padding-top:30px;text-align:center'>
<i class="fa fa-building-o fa-2x"></i> 
<h4 class='subheading'>Contact Us</h4>

<p>This site is still in beta. If you spot any errors please contact us on gradhat2013@gmail.com</p>
</div>
    

</div>

<div class="row bottom" style="">
{{HTML::image('img/logo.png', 'gradhat', array('style'=>"height:34px;margin-top:10px;margin-bottom:5px;margin-left:10px;display:inline","class"=>'logo'));}}
<p style='display:inline-block;font-size:0.8em;margin-top:1em;margin-right:30px;color:#ccc' class='right'>
Created and maintained by Gradhat Inc. All rights reserved
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
