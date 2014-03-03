<?php

class UserController extends BaseController {


//NOTE: Privelege level 20 is for admin ... 0 is for normal visitor.. and 15 is for Moderator 
// The gaps are kept so that more levels can come in the future
	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function posts(){
		return $this->hasMany('Post');
	}

	public function getLogin(){
		$title="Login";
		if(Auth::User()){
			return Redirect::to('view/questions');
		}	
		else{
			return View::make('login')->with('title',$title)->with('type','user');;
		}
	}

	public function postLogin(){
		$input=Input::all();
		$rules=array(
			'email'=>'required|email',
			'password'=>'required',
			);

		$v = Validator::make($input, $rules);
		
		if($v->passes()){
			$credentials= array('user_email' => $input['email'],'user_password' => $input['password'],'privelege_level'=>0);
			if(Auth::attempt($credentials,true)){
				return Redirect::to('login');
			}
			else{
				$errors= new Illuminate\Support\MessageBag;
				$errors->add('error', 'Your username or password is incorrect');
				return Redirect::to('login')->with('errors',$errors);
			}
		}
		else{
			return Redirect::to('login')->withInput()->withErrors($v);
		}
	}

	public function getRegister(){
		$title="Register";
		return View::make('register')->with('title',$title);
	}

	public function postRegister()
	{
		$input=Input::all();
		$rules=array(
			'user_username'=>'required|unique:users',
			'user_email'=>'required|unique:users|email',
			'user_password'=>'required',
			'user_confpassword'=>'same:user_password'
			);
		$v = Validator::make($input, $rules);
		if($v->passes()){
			$password = Hash::make($input['user_password']);
			$user=new User();
			$user->user_username=$input['user_username'];
			$user->user_password=$password;
			$user->user_email=$input['user_email'];
			$user->privelege_level=0;
			$user->confirmstring=substr(str_shuffle( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ), 0, 1).substr( md5( time() ), 1);
			$user->save();
			Mail::queue('emails.confirm', 
					array('user'=>$user->user_username,'link'=>URL::to('register/confirm/xy22'.$user->user_id.'az/'.$user->confirmstring)), 
					function($message){
       					$message->to($input['user_email'], 'Carl Saldanha')->subject('Welcome to GradHat');
    				}
    		);
			
			return Redirect::to('register/success');
		}
		else{
			return Redirect::to('register')->withInput()->withErrors($v);
		}
	}

	public function openIDLogin(){
		
	}

	public function getRegisterSuccess(){
		return View::make('templates.sendmessage', array('head'=>'Registration Successful','body'=>"Congratulations! Check your email address for confirmation email. "));
	}

	public function getRegisterConfirm($user_id,$confirmcode){
		$user=User::findOrFail($user_id);
		$returnString="You're authenticated! Thank You for confirming your email account.";
		if($user->confirmstring==$confirmcode){
			$user->confirmed=1;
			$user->save();

		}
		else{
			$returnString="I'm sorry but you seem to have got a wrong confirmation code.";
		}
		return View::make('templates.sendmessage', array('head'=>'Confirming Your E-mail','body'=>$returnString));
	}

	public function getLogout(){
		Auth::logout();
		return Redirect::to('login');
	}

	public function viewUserProfile(){
		if(Auth::check())
		{
			$user=Auth::user();
			$questions = Post::where('creator_id', $user->user_id)->where('post_type', 'Question')->get();
			$answers = Post::where('creator_id', $user->user_id)->where('post_type', 'Answer')->get();
			return View::make('profile')->with('title', 'Profile')
										->with('user', $user)->with('questions', $questions)->with('answers', $answers);
		}
		else
			return Redirect::to('login');
	}

	public function viewUserProfileByName($username){
		$user=User::where('user_username','LIKE',urldecode($username))->limit(1)->get();
		$user=$user[0];
			$questions = Post::where('creator_id', $user->user_id)->where('post_type', 'Question')->get();
			$answers = Post::where('creator_id', $user->user_id)->where('post_type', 'Answer')->get();
			return View::make('profile')->with('title', 'Profile')
										->with('user', $user)->with('questions', $questions)->with('answers', $answers);

	}
	public function getEditProfile(){
		if(Auth::check())
		{
			$user = Auth::user();
			$title = 'Edit Profile';
			return View::make('editprofile')->with('title', $title)->with('user', $user);
		}
		else
			return Redirect::to('login');
	}

	public function postEditProfile(){
		if(Auth::check())
		{
			$input = Input::all();
			$user = Auth::user();
			$rules=array(
			'username'=>'required|unique:users,user_username,{{$user->user_id}},user_id',
			'email'=>'required|email'
			);
			$v = Validator::make($input, $rules);
			if($v->passes())
			{
				$user->user_name = $input['name'];
				$user->user_username = $input['username'];
				$user->user_email = $input['email'];	
				$user->update();
				return Redirect::to('edit/profile');
			}
			else{
				$title = 'Edit Profile';
				return Redirect::to('edit/profile')->with('title', $title)->with('user', $user)->withInput()->withErrors($v);
				//return View::make('editprofile')->withInput()->withErrors($v)->with('title', $title)->with('user', Auth::user());
			}
		}
		else
			return Redirect::to('login');
	}

	public function getChangePassword() {
		if(Auth::check())
		{
			$user = Auth::user();
			$title = 'Change Password';
			return View::make('password')->with('title', $title)->with('user', $user);
		}
		else
			return Redirect::to('login');	
	}

	public function postChangePassword() {
		if(Auth::check())
		{
			$input = Input::all();
			$user = Auth::user();
			$rules = array(
			'password'=>'required',
			'confpassword'=>'same:password');
			$v = Validator::make($input, $rules);
			if ($v->passes())
			{
				$user->user_password = Hash::make($input['password']);
				$user->update();
				echo "Password changed successfully";
			}
			else
				return Redirect::to('edit/password')->withInput()->withErrors($v);
		}
	}
}
?>