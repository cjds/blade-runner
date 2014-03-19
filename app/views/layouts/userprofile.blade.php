<div class='user-div'>
<img src="http://www.gravatar.com/avatar/{{md5($question->post->creator->user_email)}}?s=30&d=identicon" alt=""> 

{{HTML::link('view/profile/'.urlencode($user->user_username),(strlen($user->user_username) >18) ? substr($user->user_username,0,18).'...' : $user->user_username)}}
{{$add}}
</div>