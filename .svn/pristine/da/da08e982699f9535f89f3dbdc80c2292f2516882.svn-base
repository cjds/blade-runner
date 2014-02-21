<?php
class Answer extends Eloquent{

	protected $table='answers';
 	protected $primaryKey   = 'post_id';
 	protected $fillable = array('post_id');

	public function post(){
		return $this->belongsTo('Post','post_id');
	}

	public function question(){
		return $this->belongsTo('Question','answer_question_id');
	}

	
}

?>