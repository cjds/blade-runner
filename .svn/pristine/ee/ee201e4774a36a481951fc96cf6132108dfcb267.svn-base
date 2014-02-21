<?php
class SuggestedPost extends Eloquent{

	protected $table='suggested_edits';
 	protected $primaryKey   = 'suggested_edits_id';

 	public function post(){
		return $this->belongsTo('Post','original_post_id');
	}

	public function moderator(){
		return $this->belongsTo('User','moderator_id');
	}
	
	public function editor(){
		return $this->belongsTo('User','question_editor_id');
	}
	
	public function type(){
		return $this->morphTo('SuggestedPost','post_type','suggested_edits_id');
	}
}

?>