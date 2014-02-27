<?php 
/**
*  
*/
class UniversityQuestion extends Eloquent
{
	
	protected $table = "university_questions";
	protected $primaryKey = 'post_id';

	public function question(){
		return $this->belongsTo('Question', 'post_id');
	}	

	public function universityquestiondates(){
		return $this->hasMany('UniversityQuestionDate', 'post_id');
	}

	public function subject(){
		return $this->belongsTo('Subject', 'question_subject_id');
	}

	public function module(){
		return $this->belongsTo('Module', 'question_module_id');
	}
}
?>