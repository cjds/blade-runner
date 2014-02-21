<?php
class Vote extends Eloquent{

	protected $votes='votes';
 	protected $primaryKey   = 'vote_id';


	public function voter(){
		return $this->belongsTo('User','user_id');
	}

	public function post(){
		return $this->belongsTo('Post','post_id');
	}

	


}

?>