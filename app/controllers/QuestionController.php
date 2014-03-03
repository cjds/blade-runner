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
				'title'=>'required',
				'wmd-input'=>'required',
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
	* This is the GET that displays the question form for editing
	* @return the view required. if not logged in it redirects to the login view
	*
	*/
	public function getEditQuestion(){
		//Determine if user is authentic
		$question_id=Input::get('qid',-1);

		$question=Question::findOrFail($question_id);
		if (Auth::check()){
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
				'title'=>'required',
				'wmd-input'=>'required',
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
				'wmd-input'=>'required',
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
		return View::make('viewquestion')->with('title','View the Question')->with('question',$question)->with('user_id',$user_id);
	}

	/**
	* This is the GET that returns the entire list of questions
	* @return The search page showing all the questions
	*
	*/
	public function viewAllQuestions (){
		$questions = Question::paginate(15);
		return $this->sortQuestionList('none','all');
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
				'wmd-input'=>'required|min:20',
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

	public function getQuestionsForUser($user_id){
		return $this->searchHandler('none','all','','',$user_id,'question');
	}

	public function getAnswersForUser($user_id){
		return $this->searchHandler('none','all','','',$user_id,'answer');
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
				return Response::json(array('status'=>'fail','type'=>'wrong_question','message'=>"You Entered a Wrong Question Id"));
			}
		}
		else{
			return Redirect::to('login');			
		}
	}



	public function viewQuestionsByTags ($tag_name){
	 	$tag_name=urldecode($tag_name); 

		return $this->searchHandler('none','all','',$tag_name);
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
			$questions =$questions->orderBy('updated_at','DESC');
		}
		else if($sort=='oldest'){
			$questions =$questions->orderBy('updated_at','ASC');
		}
		$questions =$questions->paginate(15);
		return View::make('searchview')->with('title', 'Questions List')
										->with('questions', $questions)
										->with('keyword', $input)
										->with('filter',$type)
										->with('sort',$sort)
										->with('tag', $tag);
	}

	public function getModeratorReviews(){
		//Determine if user is authentic and above Moderator level 15...
		if (Auth::privelegecheck(15)){
			
			return View::make('review')->with('title','Moderator Reviews');
		}
		else{
			return Redirect::to('login');
		}
	}


	public function postJSONNextModeratorReview(){
		$input=Input::all();
		//Determine if user is authentic and above Moderator level 15...
		if (Auth::privelegecheck(15)){
			if($input['type']=='approve' || $input['type']=='reject'){
				
				$suggested_edits_id=$input['suggested_edits_id'];
				$suggestedEdit=SuggestedPost::findOrFail($suggested_edits_id);
				$suggestedEdit->status=1;
				$suggestedEdit->moderator()->associate(Auth::user());
				if($input['type']=='approve'){
					$suggestedEdit->approvals=$suggestedEdit->approvals+1;
					$post=$suggestedEdit->post;

					//Set all the previous suggested edits that haven't before this to status -1 ..rejected
					SuggestedPost::where('original_post_id',$suggestedEdit->original_post_id)->where('created_at','>',$suggestedEdit->created_at)->update(array('status'=>-1));

					if($suggestedEdit->post_type=='SuggestedQuestion'){
						$post->editor()->associate($suggestedEdit->editor);
						//Normal stuff
						$post->type->question_body=$suggestedEdit->type->suggested_edits_question_body;
						$post->type->question_title=$suggestedEdit->type->suggested_edits_question_title;

						//Attach the new tags
						$question_tags=explode(',',$suggestedEdit->type->suggested_edits_question_tags);
						for ($i=0; $i < count($question_tags); $i++) { 
							$question_tags[$i]=trim($question_tags[$i]);
						}
						$post->type->tags()->detach();

						foreach ($question_tags as $t) {
							$tag_id = Tag::firstOrCreate(array('tag_name' => $t));
							$post->type->tags()->attach($tag_id);
						}

						$post->push();
					}
					else if($suggestedEdit->post_type=='SuggestedAnswer'){
						$post->editor()->associate($suggestedEdit->editor);
						$post->type->answer_body=$suggestedEdit->type->suggested_edits_answer_body;
						$post->push();
					}
					
				}
				else if($input['type']=='reject'){
					$suggestedEdit->rejections=$suggestedEdit->approvals-1;
					$suggestedEdit->status=-1;
				}
				$suggestedEdit->save();
				return Response::json(array('status'=>'success','message'=>'Edit Completed',));
			}
			else{
				return Response::json(array('status'=>'fail','message'=>'Wrong Input',));
			}
		}
		else{
			return Response::json(array('status'=>'fail','message'=>'Not Enough Authority',));
		}
	}

	public function getJSONNextModeratorReview(){
		if (Auth::privelegecheck(15)){
			$post=SuggestedPost::where('status',0)->orderBy('created_at', 'DESC')->take(1)->get();
			if($post->isEmpty()){
				return Response::json(array('status'=>'fail','type'=>'no_review_left','message'=>'No more reviews left'));
			}
			else{
				$post=$post[0];	
				if($post->post_type=="SuggestedQuestion"){
					
					$tagArray=array();
					foreach ($post->post->type->tags as $tag) 
					 $tagArray[]=$tag->tag_name;

					return Response::json(array('status'=>'success',
												'message'=>'Review Successfully got',
												'type'=>'question',
												'original_title'=> $post->post->type->question_title,
												'new_title'=>$post->type->suggested_edits_question_title,
												'original_body'=>$post->post->type->question_body,
												'new_body'=>$post->type->suggested_edits_question_body,
												'original_tags'=>implode(',', $tagArray),
												'new_tags'=>$post->type->suggested_edits_question_tags,
												'suggested_edits_id'=>$post->suggested_edits_id,
												'edit_explanation'=> $post->editExplanation
												)
										);
				}
				else{
					foreach ($post->post->type->question->tags as $tag) 
						$tagArray[]=$tag->tag_name;
					return Response::json(array('status'=>'success',
												'message'=>'Review Successfully got',
												'type'=>'answer',
												'question_body'=>$post->post->type->question->question_body	,
												'question_title'=>$post->post->type->question->question_title,
												'question_tags'=>implode(',', $tagArray),
												'original_body'=>$post->post->type->answer_body	,
												'new_body'=>$post->type->suggested_edits_answer_body,
												'suggested_edits_id'=>$post->suggested_edits_id,											
												'edit_explanation'=> $post->editExplanation
												)
										);	
				}
			}
			
		}
		else{
			return Response::json(array('status'=>'fail','type'=>'user_authority','message'=>'You do not have sufficient authority'));
		}
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
	

	public function getJSONRelatedQuestions(){
	    $q = urldecode(Input::get('query'));
	    $num = Input::get('count');
	    if($num==null)	$num=5;
	    
	    $query = Question::where('question_title',"LIKE","%".$q[0]."%");
	    for($i=1;$i<count($q);$i++){
	        $query = $query->orWhere('question_title',"LIKE","%".$q[i]."%");
	    }
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


}
?>
