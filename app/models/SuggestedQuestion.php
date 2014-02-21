<?php
class SuggestedQuestion extends Eloquent{

	protected $table='suggested_edits_questions';
 	protected $primaryKey   = 'suggested_edits_id';


	public function post(){
		return $this->belongsTo('SuggestedPost','suggested_edits_id');
	}

	//public function post(){
	//	return $this->morphMany('SuggestedPost','type','post_type','suggested_edits_id');
	//}

}

?>