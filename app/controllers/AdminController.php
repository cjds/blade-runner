<?php 
class AdminController extends BaseController{
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

	public function manageBranches(){
		if(Auth::privelegecheck(20))
		{
			$title = 'Manage Branches';
			$branches = Branch::all();
			return View::make('branches')->with('title', $title)->with('branches', $branches);
		}
		else
			return Redirect::to('admin/login');
	}

	public function addNewBranch(){
		$input = Input::all();
		$rules = array('branch_name' => 'required');
		$v = Validator::make($input, $rules);
		if ($v->passes())
		{
			$branch = new Branch();
			$branch->branch_name = $input['branch_name'];
			$branch->branch_shortname = $input['branch_shortname'];
			$branch->save();
			return Redirect::to('admin/branches');
		}
		else
			return Redirect::to('admin/branches/add')->withInput()->withErrors($v);
	}

	public function manageSubjects(){
		if(Auth::privelegecheck(20))
		{
			$title = 'Manage Subjects';
			// $subjects = Subject::all()
			// 			->groupBy('subject_branch_id')
			// 			->orderBy('subject_sem');
			$subjects = Subject::all();
			$branches = Branch::all();
			$branches_array = array();
			foreach ($branches as $branch) {
				$branches_array[$branch->branch_id] = $branch->branch_name;
			}
			return View::make('subjects')->with('title', $title)->with('subjects', $subjects)->with('branches', $branches_array);
		}
		else
			return Redirect::to('admin/login');
	}

	public function addNewSubject(){
		$input = Input::all();
		$rules = array(
			'subject_name' => 'required',
			'subject_sem' => 'required',
			'subject_branch' => 'required');
		$v = Validator::make($input, $rules);
		if ($v->passes())
		{
			$subject = new Subject();
			$subject->subject_name = $input['subject_name'];
			$subject->subject_shortname = $input['subject_shortname'];
			$subject->subject_sem = $input['subject_sem'];
			$subject->subject_branch_id = $input['subject_branch'];
			$subject->save();
			return Redirect::to('admin/subjects');
		}
		else
			return Redirect::to('admin/subjects/add')->withInput()->withErrors($v);
	}

	public function manageModules(){
		if(Auth::privelegecheck(20))
		{
			$title = 'Manage Modules';
			// $subjects = Subject::all()
			// 			->groupBy('subject_branch_id')
			// 			->orderBy('subject_sem');
			$modules = Module::all();
			$subjects = Subject::all();
			$subjects_array = array();
			foreach ($subjects as $subject) {
				$subjects_array[$subject->subject_id] = $subject->subject_name;
			}
			return View::make('modules')->with('title', $title)->with('subjects', $subjects_array)->with('modules', $modules);
		}
		else
			return Redirect::to('admin/login');
	}

	public function addNewModule(){
		$input = Input::all();
		$rules = array(
			'module_name' => 'required',
			'module_subject' => 'required');
		$v = Validator::make($input, $rules);
		if ($v->passes())
		{
			$module = new Module();
			$module->module_name = $input['module_name'];
			$module->module_subject_id = $input['module_subject'];
			$module->save();
			return Redirect::to('admin/modules');
		}
		else
			return Redirect::to('admin/modules/add')->withInput()->withErrors($v);
	}

}
?>