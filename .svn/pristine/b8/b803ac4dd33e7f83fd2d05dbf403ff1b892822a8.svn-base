<?php 
/**
* 
*/
class UniversityQuestionDate extends Eloquent
{
	
	protected $table = "university_questions_dates";
	protected $primaryKey = 'id';

	function universityquestion()
	{
		return $this->belongsTo('UniversityQuestion', 'post_id');
	}
}
?>