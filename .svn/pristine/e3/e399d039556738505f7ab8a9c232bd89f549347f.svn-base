<?php

class TagController extends BaseController{

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

	public function postAddQuestion(){
		//Determine if user is authentic
		if (Auth::check()){
	    	$input=Input::all();
	    	//set up the rules
			$rules=array(
				'title'=>'required',
				'question'=>'required',
			);
			
			$v = Validator::make($input, $rules);
			
			if($v->passes()){
				$question=new Question();
				//$question->addQuestion(Auth::user(),$input['title'],$input['question'],array());
				$question->question_title=$input['title'];
				$question->question_body=$input['question'];
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
				return Redirect::to('add/question?qid='.$question->post_id)->withInput()->withErrors($v);
			}
		}
		else{
			return Redirect::to('login');			
		}
	}

	public function getViewQuestion(){
		$question_id=Input::get('qid',-1);
		$question=Question::findOrFail($question_id);

		return View::make('viewquestion')->with('title','View the Question')->with('question',$question);
	}

	public function viewQuestionsByTags ($tag_name){
		$tag_name=urldecode($tag_name);
		$tag_id=Input::get('tid', -1);
		$tag=Tag::where('tag_name',$tag_name)->first();
		
		$questions=$tag->posts;
		return View::make('searchview')->with('title', 'Questions List')->with('questions', $questions);
	}

	// public function viewQuestionList (){
	// 	$input = Input::all();
	// 	$keywords = explode(' ', $input['search']);
	// 	$questions = Question::all();
	// 	$required_questions = array();
	// 	foreach ($questions as $question) {
	// 		$question_title_array = explode(' ', $question->question_title);
	// 		if(array_intersect($question_title_array, $keywords))
	// 		{
	// 			$required_questions[] = $question;
	// 		}
	// 	}
	// 	foreach ($questions as $question) {
	// 		$question_body_array = explode(' ', $question->question_body);
	// 		if(array_intersect($question_body_array, $keywords) && !in_array($question, $required_questions))
	// 		{
	// 			$required_questions[] = $question;
	// 		}
	// 	}
	// 	return View::make('searchview')->with('title', 'Questions List')->with('questions', $required_questions);
	// }

	public function viewQuestionList(){
		$input = Input::get('search');
		$questions = Question::whereRaw("MATCH(question_title, question_body) AGAINST(? IN BOOLEAN MODE)", array($input))->get();

		return View::make('searchview')->with('title', 'Questions List')->with('questions', $questions);
	}

	public function viewAllQuestions (){
		$questions = Question::all();
		return View::make('searchview')->with('title', 'Questions List')->with('questions', $questions);
	}
}
?>