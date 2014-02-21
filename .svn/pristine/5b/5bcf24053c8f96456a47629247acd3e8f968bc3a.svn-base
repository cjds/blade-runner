<?php
class SuggestedAnswer extends Eloquent{

	protected $table='suggested_edits_answers';
 	protected $primaryKey   = 'suggest_edits_id';


	public function post(){
		return $this->belongsTo('SuggestedPost','suggest_edits_id');
	}

	//public function post(){
	//	return $this->morphMany('SuggestedPost','type','post_type','suggest_edits_id');
	//}
}

?>