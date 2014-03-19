<?php

class TagController extends Controller{

	public function getAddQuestion(){

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

	public function jsonGetTags(){
		$q = Input::get('query');
	    $num = Input::get('count');
	    if($num==null)	$num=5;
	    
	    $query = Tag::where('tag_name',"LIKE",$q."%");
	    /*for($i=1;$i<count($q);$i++){
	        $query = $query->orWhere('question_title',"LIKE","%".$q[i]."%");
	    }*/
	    $json=array();
	    $i=0;
	   foreach($query->take($num)->get() as $q){
	   		$json[$i]->label=$q->tag_name;
	   		$json[$i]->value=$q->tag_name;
	   		$i++;
	   }

	   return json_encode($json);
	}
}
?>