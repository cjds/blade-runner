<?php 
 class Question extends Eloquent{

	protected $table="questions";
	protected $primaryKey = 'post_id';
	protected $fillable = array('post_id');

	public function post(){
		return $this->belongsTo('Post','post_id');
	}

	public function tags(){
		return $this->belongsToMany('Tag');
	}

	public function answers(){
		return $this->hasMany('Answer','answer_question_id');
	}


	/*
	* Adds the question Object to the database as well as a Post Object to the post table
	*
	* @param creator_id : The user ID of the creator of the post
	* @param question_title: string The title
	* @param question_body: This will be formatted HTML stored as a string
	* @param question_tags : The question tags separated by commas stored as one long string
	* @return the Question Object created
	*/
	public function addQuestion($creator_id,$question_title, $question_body, $question_tags){
		$this->question_title=$question_title;
		$this->question_body=$question_body;
		$this->question_tags=$question_tags;
		//$this->post()=new Post();
		//$this->save();

	}
}

?>