<?php 
class AdminController extends BaseController{
	public function getAdminLogin(){
		$title="Admin Login";
		if(Auth::privelegecheck(20)){
			return Redirect::to('admin/home');
		}
		return View::make('login')->with('title',$title)->with('type','admin');
	}

	public function getinviteMail(){
		if(Auth::privelegecheck(20)){
			
			return View::make('inviteemail');
		}

		return View::make('login')->with('title','Logins')->with('type','admin');
	}

	public function postinviteMail(){
		if(Auth::privelegecheck(20)){
			$input=Input::all();
			$recepient=explode(',', $input['recepient']);
			foreach ($recepient as $rec) {
				$mail_id['email']=$rec;
				$mail_id['username']=$rec;
				
				Mail::queue('emails.invite', 
					array('data'=>$input['maintext']), 
					function($message) use ($mail_id){
       					$message->to($mail_id['email'], $mail_id['username'])->subject('Invitation for Gradhat');
       				}
       			);
    		}
			return 'Done. We really need to do something over here';
		}
		return View::make('login')->with('title','Logins')->with('type','admin');
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

	public function getEditBranch(){
		$branch_id=Input::get('bid',-1);
		$branch=Branch::findOrFail($branch_id);
		if (Auth::check()){
			$title="Edit Branch";
			return View::make('editbranch')->with('title',$title)->with('branch',$branch);
		}
		else{
			return Redirect::to('login');
		}
	}

	public function postEditBranch(){
		$input = Input::all();
		$rules = array('branch_name' => 'required');
		$v = Validator::make($input, $rules);
		if($v->passes()){
			$branch=Branch::findOrFail($input['branch_id']);
			$branch->branch_name = $input['branch_name'];
			$branch->branch_shortname = $input['branch_shortname'];
			$branch->update();
			$branches = Branch::all();
			return View::make('branches')->with('title', 'Manage Branches')->with('branches',$branches);
		}
		else
			return Redirect::to('admin/branches/edit?bid='.$input['branch_id'])->withInput()->withErrors($v);

	}

	public function getBranches(){
		$branches = Branch::all();
		$branches_array = array();
		foreach ($branches as $branch) {
			$branches_array[$branch->branch_id] = $branch->branch_name;
		}
		return $branches_array;
	}

	public function manageSubjects(){
		if(Auth::privelegecheck(20))
		{
			$title = 'Manage Subjects';
			// $subjects = Subject::all()
			// 			->groupBy('subject_branch_id')
			// 			->orderBy('subject_sem');
			$subjects = Subject::all();
			$branches = $this->getBranches();
			return View::make('subjects')->with('title', $title)->with('subjects', $subjects)->with('branches', $branches);
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

	public function getEditSubject(){
		$subject_id=Input::get('sid',-1);
		$subject=Subject::findOrFail($subject_id);
		if (Auth::check()){
			$title="Edit Subject";
			$branches = $this->getBranches();
			return View::make('editsubject')->with('title',$title)->with('subject',$subject)->with('branches', $branches);
		}
		else{
			return Redirect::to('login');
		}
	}

	public function postEditSubject(){
		$input = Input::all();
		$rules = array(
			'subject_name' => 'required',
			'subject_sem' => 'required',
			'subject_branch' => 'required');
		$v = Validator::make($input, $rules);
		if($v->passes()){
			$subject=Subject::findOrFail($input['subject_id']);
			$subject->subject_name = $input['subject_name'];
			$subject->subject_shortname = $input['subject_shortname'];
			$subject->subject_sem = $input['subject_sem'];
			$subject->subject_branch_id = $input['subject_branch'];
			$subject->update();
			$subjects = Subject::all();
			$branches = $this->getBranches();
			return View::make('subjects')->with('title', 'Manage Subjects')->with('subjects',$subjects)->with('branches', $branches);
		}
		else
			return Redirect::to('admin/subjects/edit?sid='.$input['subject_id'])->withInput()->withErrors($v);
	}

	public function getSubjects(){
		$subjects = Subject::all();
		$subjects_array = array();
		foreach ($subjects as $subject) {
			$subjects_array[$subject->subject_id] = $subject->subject_name;
		}
		return $subjects_array;
	}

	public function manageModules(){
		if(Auth::privelegecheck(20))
		{
			$title = 'Manage Modules';
			// $subjects = Subject::all()
			// 			->groupBy('subject_branch_id')
			// 			->orderBy('subject_sem');
			$modules = Module::all();
			$subjects = $this->getSubjects();
			return View::make('modules')->with('title', $title)->with('subjects', $subjects)->with('modules', $modules);
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

	public function getEditModule(){
		$module_id=Input::get('mid',-1);
		$module=Module::findOrFail($module_id);
		if (Auth::check()){
			$title="Edit Module";
			$subjects = $this->getSubjects();
			return View::make('editmodule')->with('title',$title)->with('module',$module)->with('subjects', $subjects);
		}
		else{
			return Redirect::to('login');
		}
	}

	public function postEditModule(){
		$input = Input::all();
		$rules = array(
			'module_name' => 'required',
			'module_subject' => 'required');
		$v = Validator::make($input, $rules);
		if($v->passes()){
			$module=Module::findOrFail($input['module_id']);
			$module->module_name = $input['module_name'];
			$module->module_subject_id = $input['module_subject'];
			$module->update();
			$modules = Module::all();
			$subjects = $this->getSubjects();
			return View::make('modules')->with('title', 'Manage Modules')->with('modules',$modules)->with('subjects', $subjects);
		}
		else
			return Redirect::to('admin/modules/edit?mid='.$input['module_id'])->withInput()->withErrors($v);
	}

}
?>