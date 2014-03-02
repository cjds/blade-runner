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

	public function getLogin(){
		$title="Login";
		if(Auth::User()){
			return Redirect::to('view/questions');
		}	
		else{
			return View::make('login')->with('title',$title)->with('type','user');;
		}
	}

	public function getRegister(){
		$title="Register";
		return View::make('register')->with('title',$title);
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
       					$message->to($input['user_email'], 'Carl Saldanha')->subject('Welcome to Gradhat');
    				}
    		);
			
			return Redirect::to('register/success');
		}
		else{
			return Redirect::to('register')->withInput()->withErrors($v);
		}
	}

	public function getLogout(){
		Auth::logout();
		return Redirect::to('login');
	}

	public function getAdminLogin(){
		$title="Admin Login";
		if(Auth::privelegecheck(20)){
			return Redirect::to('admin/home');
		}
		return View::make('login')->with('title',$title)->with('type','admin');
	}


	public function postAdminLogin(){
		$input=Input::all();
		$rules=array(
			'email'=>'required|email',
			'password'=>'required',
			);

		$v = Validator::make($input, $rules);
		
		if($v->passes()){
			$credentials= array('user_email' => $input['email'],'user_password' => $input['password'],'privelege_level'=>20);
			if(Auth::attempt($credentials,true)){
				return Redirect::to('admin/home');
			}
			else{
				return Redirect::to('admin/login')->with('errors',array('general'=>array('Your username or password is incorrect')));
			}
		}
		else{
			return Redirect::to('admin/login')->withInput()->withErrors($v);
		}
	}

	public function postchangeUserPriveleges(){
		if (Auth::privelegecheck(20)){		
			$input=Input::all();
			foreach ($input['privilegelevel'] as $key => $value) {
				$user=User::findOrFail($key);
				$user->privelege_level=$value;
				$user->save();
			}
		}
		return Redirect::to('admin/home');
	}

	public function getModeratorHome(){
		if (Auth::privelegecheck(15)){
			$title="Moderator Home";
			return View::make('moderatorhome')->with('title',$title);	
		}
		else
			return Redirect::to('login');

	}

	public function getAdminHome(){
		//For setting people to moderators 
		//Rest will come laater
		if (Auth::privelegecheck(20)){
			$title="Admin home";
			$users=User::all();
			return View::make('adminhome')->with('title',$title)->with('users',$users);
		}
		else
			return Redirect::to('admin/login');

	}

	public function openIDLogin(){
		
	}

	public function postBlockUser(){

		if (Auth::privelegecheck(20)){
			$input=Input::all();
			$user=User::findOrFail($input['user_id']);
			if($user->user_blocked){
				$user->user_blocked=false;
			}
			else
				$user->user_blocked=true;
			$user->save();
			return Response::json(array('status'=>'success','message'=>'User Blocked',));
		}
		else{
			return Response::json(array('status'=>'fail','message'=>'Not sufficient Authority',));
		}
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
}
?>