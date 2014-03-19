 <?php
class QuestionController extends BaseController{


	/**
	* This is the GET that displays the question form
	* @return the view required. if not logged in it redirects to the login view
	*
	*/
	public function getAddQuestion(){
		//Determine if user is authentic
		if (Auth::check()){
			$title="Add a New Question";
			return View::make('post')->with('title',$title)->with('type','new');
		}
		else{
			return Redirect::to('login');
		}
	}

	/**
	* This is the GET that displays the question form
	* @return adds the question and redirects to the question
	*
	*/
	public function postAddQuestion(){
		//Determine if user is authentic
		if (Auth::check()){
	    	$input=Input::all();
	    	//set up the rules
			$rules=array(
				'title'=>'required|max:255',
				'wmd-input'=>'required|max:10000',
				'tags'=>'required'
			);
			
			$v = Validator::make($input, $rules);
			
			if($v->passes()){
				$question=new Question();
				//$question->addQuestion(Auth::user(),$input['title'],$input['question'],array());
				$question->question_title=$input['title'];
				$question->question_body=$input['wmd-input'];
				$question_tags=explode(',', $input['tags']);
				for($i=0;$i<count($question_tags);$i++) {
					$question_tags[$i]=trim($question_tags[$i]);
				}
				$post=new Post();
				$post->post_type="Question";
				$post->creator()->associate(Auth::user());
				$post->save();
				$question->post()->associate($post);
				$question->push();
				foreach ($question_tags as $t) {
					$tag_id = Tag::firstOrCreate(array('tag_name' => $t));
					$question->tags()->attach($tag_id);
				}
				return Redirect::to('view/question?qid='.$question->post_id);
			}
			else{
				return Redirect::to('add/question')->withInput()->withErrors($v);
			}
		}
		else{
			return Redirect::to('login');			
		}
	}

	/**
	* This is the POST that takes data from the GET in getViewQuestion and stores a new Answer in the DB
	* @return It redirects to either the question's display page or the erors page
	*
	*/
	public function postAddAnswer(){
		//Determine if user is authentic
		if (Auth::check()){
	    	$input=Input::all();
	    	//set up the rules
			$rules=array(
				'wmd-input'=>'required|min:20|max:10000',
				'question_id'=>'required',
			);

			$messages = array(
    			'required' => 'The :attribute is required.',
    			'wmd-input.min'=>'The body must be at least 20 characters'
			);
			
			$v = Validator::make($input, $rules,$messages);
			
			if($v->passes()){
				$answer=new Answer();
				
				$answer->answer_body=$input['wmd-input'];			
				$answer->answer_question_id=$input['question_id'];			
				$post=new Post();
				$post->creator()->associate(Auth::user());
				$post->post_type='Answer';
				$post->save();
				$answer->post()->associate($post);
				$answer->push();
				return Redirect::to('view/question?qid='.$input['question_id']);
			}
			else{
				return Redirect::to('view/question?qid='.$input['question_id'])->withInput()->withErrors($v);
			}
		}
		else{
			return Redirect::to('login');			
		}
	}

	/**
	* This is the POST that takes data from the GET in getViewQuestion that allows you to upvote or downvote
	* @return It returns JSON of success or fail
	*
	*/
	public function postAddVote(){
		if (Auth::check()){
			$input=Input::all();
			$post_id=$input['post_id'];
			$vote_type=$input['type'];
			$post=Post::findOrFail($post_id);
			$creator = User::findOrFail($post->creator_id);
			$user=Auth::user();

			if($post_id!=null){

				if($user->user_id == $post->creator_id)
					return Response::json(array('status'=>'fail','type'=>'already_voted','message'=>"You can't vote on your own post"));
					
				else
				{
				$hasNotVoted=Vote::where('user_id',$user->user_id)->where('post_id',$post_id)->get()->isEmpty();
				
				if($hasNotVoted){
					$vote=new Vote();		
					$vote->voter()->associate($user);
					$vote->post()->associate($post);
					$vote->voteType=$vote_type;
					$vote->save();

					if(!Question::where('post_id', $post_id)->get()->isEmpty())
					{
						$question=Question::findOrFail($post_id);
						$points = ($vote_type == 1)?5:-1;
						$question->question_points += $vote_type;
						$creator->user_points += $points;
						$question->update();
						$creator->update();
					}

					else if(!Answer::where('post_id', $post_id)->get()->isEmpty())
					{
  						$answer=Answer::findOrFail($post_id);
						$points = ($vote_type == 1)?10:-2;
						$answer->answer_points += $vote_type;
						$creator->user_points += $points;
						$answer->update();
						$creator->update();
					}
						
					return Response::json(array('status'=>'pass','message'=>"Vote Successfully"));
				}
				else{
					return Response::json(array('status'=>'fail','type'=>'previous_vote','message'=>"You have already voted on this"));
				}
			}
				
			}
			else{
				return Response::json(array('status'=>'fail','type'=>'wrong_question','message'=>"Entered a Wrong Question, you did"));
			}
		}
		else{
			return Response::json(array('status'=>'fail','type'=>'login','message'=>"You must login or signup before voting"));
		}
	}

	/**
	* This is the GET that displays the question form for editing
	* @return the view required. if not logged in it redirects to the login view
	*
	*/
	public function getEditQuestion(){
		
		$question_id=Input::get('qid',-1);

		$question=Question::findOrFail($question_id);
		if (Auth::check()){
			//Check if it is a University question
			$universityQuestion=UniversityQuestion::find($question_id);
			//If it a university question and user is a moderator then edit it University style
			if($universityQuestion!=null){
				//if he is a moderator
				if(Auth::privelegecheck(15)){
					$subjects=Subject::all();

					foreach ($subjects as $subject) {
						$subjects_array[$subject->subject_id]['name'] = $subject->subject_name;
						if($universityQuestion->subject->subject_id==$subject->subject_id)
							$subjects_array[$subject->subject_id]['selected']='selected';
						else
							$subjects_array[$subject->subject_id]['selected']='';
					}
					$modules_array=array();
					foreach ($subjects as $subject) {
						$modules_array[$subject->subject_id]=array();
						$i=0;
						foreach ($subject->modules as $key => $value) {
							$modules_array[$subject->subject_id][$i]['name']=$value->module_name;
							$modules_array[$subject->subject_id][$i]['id']=$value->module_id;
							if($universityQuestion->module->module_id==$value->module_id)
								$modules_array[$subject->subject_id][$i]['selected']='selected';
							else
								$modules_array[$subject->subject_id][$i]['selected']='';
							$i++;
						}
					}

					return View::make('newunivquestion')->with('title', 'Edit University Question')->with('subjects', $subjects_array)->with('modules', $modules_array)->with('type', 'new')->with('data',$universityQuestion);
				}
			}
			$title="Edit Question";
			return View::make('post')->with('title',$title)->with('question',$question)->with('type','editquestion');
		}
		else{
			return Redirect::to('login');
		}
	}	

	/**
	* This is the POST that takes data from the GET and stores a new Question in the DB
	* @return It redirects to either the question's display page or the erors page
	*
	*/
	public function postEditQuestion(){
		//Determine if user is authentic
		if (Auth::check()){
	    	$input=Input::all();
	    	//set up the rules
			$rules=array(
				'title'=>'required|max:255',
				'wmd-input'=>'required|max:10000',
				'tags'=>'required',
				'question_id'=>'required|exists:questions,post_id'
			);
			$messages = array(
    			'tags.required' => 'There needs to be at least one tag',
			);
			$v = Validator::make($input, $rules,$messages);
			
			if($v->passes()){
				$post=Post::findOrFail($input['question_id']);
				if($this->editPost($post,'question',$input['wmd-input'],explode(',',$input['tags']),$input['title']))
						return Redirect::to('view/question?qid='.$input['question_id']);
			}
			else{
				return Redirect::to('edit/question?qid='.$input['question_id'])->withInput()->withErrors($v);
			}
		}	
		else{
			return Redirect::to('login');			
		}
	}

	public function editPost($post,$type,$body,$question_tags=array(),$title=""){
		//If its edited by the creator or a moderator don't add it to the review queue
		if(Auth::privelegecheck(15) || Auth::user()==$post->creator){
				//Set all the previous suggested edits that haven't before this to status -1 ..rejected
				SuggestedPost::where('original_post_id',$post->post_id)->where('created_at','>', time())->update(array('status'=>-1));

				
				//Update the Post itself
				$universityQuestionCheck=UniversityQuestion::find($post->post_id);
				//If the editor is not the creator and this is not a university question update it
				if($universityQuestionCheck==null){
					if(Auth::user()==$post->creator){
						$post->setAttribute('editor_id', null);
						$post->setRelation('editor', null);
					}
					else
						$post->editor()->associate(Auth::user());
				}

				if($type=='question'){
					$post->type->question_title=$title;
					$post->type->question_body=$body;
					$post->type->tags()->detach();
					foreach ($question_tags as $t) {
						$tag_id = Tag::firstOrCreate(array('tag_name' => $t));
						$post->type->tags()->attach($tag_id);
					}
				}
				else{
					$post->type->answer_body=$body;
				}
					$post->push();
		}
		//Time to add to the Review Queue
		else{
			$suggestedpost=new SuggestedPost();
	 		$suggestedpost->editor()->associate(Auth::user());
			$suggestedpost->post()->associate($post);
			if($type=='question'){
				$question=new SuggestedQuestion();
				$question->suggested_edits_question_title=$title;
				$question->suggested_edits_question_body=$body;			
				$question->suggested_edits_question_tags=implode(',', $question_tags);
				$suggestedpost->post_type='SuggestedQuestion';
			}
			else{
				$question=new SuggestedAnswer();
				$question->suggested_edits_answer_body=$body;
				$suggestedpost->post_type='SuggestedAnswer';			
			}
			$suggestedpost->save();

			$question->post()->associate($suggestedpost);
			$question->push();
		}
		return true;
	}


	public function getEditAnswer(){
		//Determine if user is authentic
		$answer_id=Input::get('aid',-1);

		$answer=Answer::findOrFail($answer_id);
		if (Auth::check()){
			$title="Edit Question";	
			return View::make('post')->with('title',$title)->with('question',$answer)->with('type','editanswer');
		}
		else{
			return Redirect::to('login');
		}
	}

	public function postEditAnswer(){
		//Determine if user is authentic
		if (Auth::check()){
	    	$input=Input::all();
	    	//set up the rules
			$rules=array(
				'wmd-input'=>'required|max:10000',
				'question_id'=>'required|exists:answers,post_id'
			);

			$v = Validator::make($input, $rules);
			
			if($v->passes()){
				$post=Post::findOrFail($input['question_id']);
				if($this->editPost($post,'answer',$input['wmd-input']))
						return Redirect::to('view/question?qid='.$post->type->question->post_id);
			}
			else{
				return Redirect::to('edit/answer?aid='.$input['question_id'])->withInput()->withErrors($v);
			}
		}	
		else{
			return Redirect::to('login');			
		}	
	}

	/**
	* This is the GET that displays a question. This will be one of the major display pages of the site
	* with links to allow editing, adding an answer, moderator work, etc.
	* @return Just the question display page
	*
	*/	
	public function getViewQuestion(){
		$question_id=Input::get('qid',-1);
		$question=Question::findOrFail($question_id);
		$univquestion=UniversityQuestion::find($question_id);
		$posts = $question->answers;
		$html = new Mark\Michelf\Markdown;
		$question->question_body=$html->defaultTransform($question->question_body);
		
   		$question->question_body = str_replace('</math>','$',str_replace('<math>','$', $question->question_body));
		if(Auth::user()){
			$user_id=Auth::user()->user_id;
		}
		else{
			$user_id=-1;
		}
		return View::make('viewquestion')->with('title','View the Question')->with('question',$question)->with('user_id',$user_id)->with('university_question',$univquestion);
	}

	/**
	* This is the GET that returns the entire list of questions
	* @return The search page showing all the questions
	*
	*/
	public function viewAllQuestions (){
		$questions = Question::paginate(15);
		return $this->sortQuestionList('recent','all');
	}

	public function getQuestionsForUser($user_id){
		return $this->searchHandler('recent','all','','',$user_id,'question');
	}

	public function getAnswersForUser($user_id){
		return $this->searchHandler('recent','all','','',$user_id,'answer');
	}

	public function viewQuestionsByTags ($tag_name){
	 	$tag_name=urldecode($tag_name); 

		return $this->searchHandler('recent','all','',$tag_name);
	 }

	/**
	* This is the GET that displays a list of all the questions with links to them
	* Sorting through the various methods .. will describe in more detail 
	* @return Its a GET look above
	*
	*/
	public function viewQuestionList(){
		//$questions = Question::whereRaw("MATCH(question_title, question_body) AGAINST(? IN BOOLEAN MODE)", array($input))->get();
		return $this->searchHandler('none','all',Input::get('search'),Input::get('tag'));
	}

	public function sortQuestionList($sort,$type){

		return $this->searchHandler($sort,$type,Input::get('search'),Input::get('tag'));
	}


	public function searchHandler($sort,$type,$input,$tag,$user_id='',$user_request=''){
			
		$type = urldecode($type);
		
		$questions=new Question;
		if ($type == 'answered') {
			$questions=$questions->answered();
		}
		elseif ($type == 'unanswered') {
			$questions=$questions->unanswered();	
		}


		if ($input !='') {

			$questions = $questions
					->whereRaw("(question_title LIKE '%".$input."%' OR question_body LIKE '%".$input."%')");
		}
			
		if ($tag != '') {
				$questions =$questions
					->whereHas('tags', function($q) use ($tag){
    						$q->where('tag_name', 'like', $tag);
					});
			
		}

		if($user_id!=''){
			if($user_request=='question'){
				$questions =$questions
					->whereHas('post', function($q) use ($user_id){
    						$q->whereHas('creator', function($q) use ($user_id){
    							$q->where('user_id', 'like', $user_id);
    						});
					});
			}
			else{
				$questions =$questions
					->whereHas('answers', function($q) use ($user_id){
    					$q->whereHas('post', function($q) use ($user_id){
    						$q->whereHas('creator', function($q) use ($user_id){
    							$q->where('user_id', 'like', $user_id);
    						});		
    					});
					});	
			}
		}

		if($sort == 'recent' ){
			$questions =$questions->orderBy('updated_at','ASC');
		}
		else if($sort=='oldest'){
			$questions =$questions->orderBy('updated_at','DESC');
		}
		$questions =$questions->paginate(15);
		return View::make('searchview')->with('title', 'Questions List')
										->with('questions', $questions)
										->with('keyword', $input)
										->with('filter',$type)
										->with('sort',$sort)
										->with('tag', $tag);
	}

	
	//This is a POST that lets you flag any post for innappropriate content and responds via JSON	
	public function postJSONAddFlag(){
		if(Auth::user()){
			$input=Input::all();
			$flag=new Flag();
			$post=Post::findOrFail($input['post_id']);
			$flag->post()->associate($post);
			if($input['flag-reason']=='Other')
				$flag->flag_reason=$input['flag-reason']."<br>".$input['custom-reason'];
			else
				$flag->flag_reason=$input['flag-reason']."<br>".$input['custom-reason'];
			$flag->creator()->associate(Auth::user());
			$flag->save();
			return Response::json(array('status'=>'success ','message'=>"Thanks! We'll take a look at it"));	
		}
		else{
			return Response::json(array('status'=>'fail','type'=>'user_authority','message'=>'You do not have sufficient authority'));	
		}
	}

	
	public function getJSONRelatedQuestions(){
	    $q = Input::get('query');
	    $num = Input::get('count');
	    if($num==null)	$num=5;
	    
	    $query = Question::where('question_title',"LIKE","%".$q."%");
	    /*for($i=1;$i<count($q);$i++){
	        $query = $query->orWhere('question_title',"LIKE","%".$q[i]."%");
	    }*/
	    return $query->take($num)->get()->toJson();
	}

	public function postJSONRelatedQuestionsTag(){
	    $q = urldecode(Input::get('qid'));
	    $num = Input::get('count');
	    if($num==null)
	    	$num=5;

	    $question=Question::findOrFail($q);
	    foreach($question->tags as $tag){
	    	$searchTerms[]=$tag->tag_name;
	    }

	    $query = Question::where('post_id','!=',$q)->whereHas('tags',function($q) use ($searchTerms){
	    	foreach ($searchTerms as $tag) {
	    		$q->where('tag_name','like', $tag);
	    	}
    		
		});

	    return $query->take($num)->get()->toJson();
	}

	// public function viewUnivQuestions($type,$name){
	// 	if($type=='subject'){
	// 		//Show list of modules and papers
	// 		$hello=urldecode($name);
	// 		$uniq= UniversityQuestion::whereHas('subject',function($p) use $hello{
	// 				$p->where('subject_name',urldecode($name));
	// 		});
	// 		return View::make('univquestions')->with('title', 'University Questions')->with('univques', $univques);
	// 	}
	// 	else if($type=='module'){
	// 		//Show questions
	// 	}
	// 	else if($type=='papers'){
	// 		//Show questions

	// 	}
	// 	else if($type=='branches'){
	// 		//Show all sems and subjects
	// 	}

	// }

	public function getAddUnivQuestion(){
		if(Auth::privelegecheck(15))
		{
			$title = 'Add New University Question';
			$subjects_array = array();
			$modules_array = array();
			$subjects = Subject::orderBy('subject_name')->get();

			foreach ($subjects as $subject) {
				$subjects_array[$subject->subject_id]['name'] = $subject->subject_name;
				$subjects_array[$subject->subject_id]['selected'] = '';
			}
			/*foreach ($modules as $module) {
				$modules_array[$module->module_id] = $module->module_name;
			}*/
			foreach ($subjects as $subject) {
				$modules_array[$subject->subject_id]=array();
				$i=0;
				foreach ($subject->modules as $key => $value) {

					$modules_array[$subject->subject_id][$i]['name']=$value->module_name;
					$modules_array[$subject->subject_id][$i]['id']=$value->module_id;
					$modules_array[$subject->subject_id][$i]['selected']='';
					$i++;
				}
			}
			return View::make('newunivquestion')->with('title', $title)->with('subjects', $subjects_array)->with('modules', $modules_array)->with('type', 'new')->with('data',null);
		}
		else
			return Redirect::to('login');
	}

	public function postAddUnivQuestion(){
		$input = Input::all();
		$rules = array(
			'title' => 'required',
			'wmd-input' => 'required',
			'ques_no' => 'required',
			'month' => 'required',
			'year' => 'required',
			'marks' => 'required',
			'subject' => 'required',
			'module' => 'required');
		$v = Validator::make($input, $rules);
		if($v->passes())
		{
			$post=new Post();
			$question = new Question();
			$univQuestion = new UniversityQuestion();
			
			$question->question_title=$input['title'];
			$question->question_body=$input['wmd-input'];
			$question_tags=explode(',', $input['tags']);
			for($i=0;$i<count($question_tags);$i++) {
				$question_tags[$i]=trim($question_tags[$i]);
			}
			$post->post_type="Question";
			$post->creator()->associate(User::findOrFail(25));
			$post->save();
			$question->post()->associate($post);
			$question->push();
			foreach ($question_tags as $t) {
				$tag_id = Tag::firstOrCreate(array('tag_name' => $t));
				$question->tags()->attach($tag_id);
			}
			
			$univQuestion->question_marks = $input['marks'];
			$univQuestion->question_subject_id = $input['subject'];
			$univQuestion->question_module_id = $input['module'];
			$univQuestion->question()->associate($question);
			$univQuestion->push();
			for($i=0;$i<count($input['year']);$i++){
				$univQuestionDate=new UniversityQuestionDate();
				$univQuestionDate->question_number = $input['ques_no'][$i];
				$month_year = $input['month'][$i]." ".$input['year'][$i];
				$univQuestionDate->month_year = $month_year;
				$univQuestionDate->universityquestion()->associate($univQuestion);
				$univQuestionDate->push();	
			}
			
			return Redirect::to('view/question?qid='.$post->post_id);
		}
		else
			echo ':(';
	}



	public function postEditUnivQuestion(){
		$input = Input::all();
		$rules = array(
			'title' => 'required',
			'wmd-input' => 'required',
			'ques_no' => 'required',
			'month' => 'required',
			'year' => 'required',
			'marks' => 'required',
			'subject' => 'required',
			'module' => 'required');
		$v = Validator::make($input, $rules);
		if($v->passes())
		{
			$univQuestion = UniversityQuestion::findOrFail($input['postid']);
			
			$question =$univQuestion->question;
			$post=$question->post;
			$question->tags()->detach();
			$question->question_title=$input['title'];
			$question->question_body=$input['wmd-input'];
			$question_tags=explode(',', $input['tags']);

			for($i=0;$i<count($question_tags);$i++) {
				$question_tags[$i]=trim($question_tags[$i]);
			}
			//$post->post_type="Question";
			//$post->creator()->associate(User::findOrFail(25));
			//$post->save();
			//$question->post()->associate($post);
			$question->push();
			foreach ($question_tags as $t) {
				$tag_id = Tag::firstOrCreate(array('tag_name' => $t));
				$question->tags()->attach($tag_id);
			}
			
			$univQuestion->question_marks = $input['marks'];
			$univQuestion->question_subject_id = $input['subject'];
			$univQuestion->question_module_id = $input['module'];
			$univQuestion->question()->associate($question);
			$univQuestion->push();
			$univQuestion->universityquestiondates()->delete($univQuestion->post_id);
			foreach($input['year'] as $key=>$year){

				$univQuestionDate=new UniversityQuestionDate();
				$univQuestionDate->question_number = $input['ques_no'][$key];
				$month_year = $input['month'][$key]." ".$input['year'][$key];
				$univQuestionDate->month_year = $month_year;
				$univQuestionDate->universityquestion()->associate($univQuestion);
				$univQuestionDate->push();	
			}
			
			return Redirect::to('view/question?qid='.$post->post_id);
		}
		else
			echo ':(';
	}

	public function univQuestionsMainPage(){
		$branches = Branch::all();
		$subjects = Subject::all();
		$univQuestionDates = UniversityQuestionDate::all();
		
		return View::make('univquestionshome')->with('title', 'University Questions')->with('branches', $branches);
	}

	public function viewUnivQuestions(){
		$subject_id = Input::get('sid', -1);
		$module_id =Input::get('mid', -1);
		if($module_id!=-1){
			$name=Module::findOrFail($module_id)->module_name;
		}
		else{
			$name=Subject::findOrFail($subject_id)->subject_name;
		}
		$univques = UniversityQuestion::where('question_subject_id', $subject_id)->orWhere('question_module_id', $module_id)->get();
		return View::make('univquestions')->with('title', 'University Questions')->with('univques', $univques)->with('name',$name);

	}

	public function viewUnivQuestionsByDate($exam){
		$exam =urldecode($exam);
		
		$subject_id=Input::get('sid',-1);
		
		$univques = UniversityQuestion::whereHas('universityquestiondates',function($q) use ($exam){
			$q->where('month_year','like',$exam);
		})->whereHas('subject',function($q) use ($subject_id){
			$q->where('subject_id',$subject_id);
		})->get();


		//	->where('university_questions.question_subject_id', $subject_id)
		//	->where('university_questions_dates.month_year', 'like', $exam)
		//	->orderBy('university_questions_dates.question_number')
	//		->get();
			return View::make('univquestions')->with('title', 'University Questions')->with('univques', $univques)->with('name',$exam);
	}
	
	public function deleteQuestion(){
		if(Auth::check()){
			if(Auth::privelegecheck(15)){
				$question_id=Input::get('qid',-1);
				
				$question = Question::findOrFail($question_id);
				$universityQuestion=UniversityQuestion::find($question_id);
					//If it a university question and user is a moderator then edit it University style
				if($universityQuestion!=null){
					foreach ($universityQuestion->universityquestiondates as $date) {
						$date->delete();
					}
					$universityQuestion->delete();
				}
				$question->tags()->detach();
				//Delete the ANSWERS
				foreach ($question->answers as $key => $answer) {
				 	$answer->post->delete();
				 	$answer->delete();
				 } 
				 //Delete the POST 
				 $question->post->delete();
				$question->delete();
			}
		}
		return Redirect::to('view/questions');

	}

	public function getSubUnderBranch(){
		$branch_id= Input::get('bid', -1);
		$branch=Branch::findOrFail($branch_id);
		$univdates=array();
		$i=0;

		//To get only the sems we have data for
		$sems=array();
		//To get all the years we have data for
		foreach($branch->subjects as $subject){
			if(!in_array($subject->subject_sem, $sems)){
        		$sems[]=$subject->subject_sem;
        	}
			$univdates[$i]=array();
			$sub_id=$subject->subject_id;
			$uniDates=UniversityQuestionDate::whereHas('universityquestion',function($q) use ($sub_id){
				$q->whereHas('subject',function($q) use ($sub_id){
					$q->where('subject_id','=',$sub_id);
				});
			})->get();
			foreach ($uniDates as $date) {
				if(!in_array($date->month_year, $univdates[$i])){
					$univdates[$i][]=$date->month_year;
				}
			}
			$i++;
		}

		sort($sems);

		return View::make('univsubjects')->with('title', $branch->branch_name.' University Questions')->with('branch',$branch)->with('universityquestiondates',$univdates)
			->with('sems',$sems);
	}


	public function jsonGetTags(){
		$q = Input::get('term');
	    $num = Input::get('count');
	    if($num==null)	$num=5;
	    
	    $query = Tag::where('tag_name',"LIKE",$q."%");
	    /*for($i=1;$i<count($q);$i++){
	        $query = $query->orWhere('question_title',"LIKE","%".$q[i]."%");
	    }*/
	    $json=array();
	    $i=0;
	   foreach($query->take($num)->get() as $p){
	   	   $json[$i] = new stdClass();

	   		$json[$i]->label=$p->tag_name;
	   		$json[$i]->value=$p->tag_name;
	   		$i++;
	   }

	   return json_encode($json);
	}

}

?>
