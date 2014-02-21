<?php 
class AdminController extends BaseController{
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

	public function getAddUnivQuestion(){
		if(Auth::privelegecheck(15))
		{
			$title = 'Add New University Question';
			$subjects_array = array();
			$subjects = Subject::all();
			foreach ($subjects as $subject) {
				$subjects_array[$subject->subject_id] = $subject->subject_name;
			}
			return View::make('newunivquestion')->with('title', $title)->with('subjects', $subjects_array)->with('type', 'new');
		}
		else
			return Redirect::to('login');
	}

	public function postAddUnivQuestion(){
		$input = Input::all();
		$rules = array(
			'title' => 'required',
			'question' => 'required',
			'ques_no' => 'required',
			'month' => 'required',
			'year' => 'required',
			'marks' => 'required',
			'subject' => 'required');
		$v = Validator::make($input, $rules);
		if($v->passes())
		{
			$post=new Post();
			$question = new Question();
			$univQuestion = new UniversityQuestion();
			$univQuestionDate = new UniversityQuestionDate();
			$question->question_title=$input['title'];
			$question->question_body=$input['question'];
			$question_tags=explode(',', $input['tags']);
			for($i=0;$i<count($question_tags);$i++) {
				$question_tags[$i]=trim($question_tags[$i]);
			}
			$post->post_type="Question";
			$post->creator()->associate(Auth::user());
			$post->save();
			$question->post()->associate($post);
			$question->push();
			foreach ($question_tags as $t) {
				$tag_id = Tag::firstOrCreate(array('tag_name' => $t));
			}
			$question->tags()->attach($tag_id);
			$univQuestion->question_marks = $input['marks'];
			$univQuestion->question_subject_id = $input['subject'];
			$univQuestion->question()->associate($question);
			$univQuestion->push();
			$univQuestionDate->question_number = $input['ques_no'];
			$month_year = $input['month']." ".$input['year'];
			$univQuestionDate->month_year = $month_year;
			$univQuestionDate->universityquestion()->associate($univQuestion);
			$univQuestionDate->push();
			echo ':)';
		}
		else
			echo ':(';
	}

	public function univQuestionsMainPage(){
		$branches = Branch::all();
		return View::make('univquestionshome')->with('title', 'University Questions')->with('branches', $branches);
	}

	public function viewUnivQuestions(){
		$subject_id = Input::get('sid', -1);
		$univques = UniversityQuestion::where('question_subject_id', $subject_id)->get();
		return View::make('univquestions')->with('title', 'University Questions')->with('univques', $univques);
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
			'name'=>'required',
			'username'=>'required',
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