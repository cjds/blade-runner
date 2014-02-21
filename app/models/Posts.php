<?php
class Posts extends Eloquent{

	protected $table='posts';

	public function creator(){
		return $this->belongsTo('User','creator_id');
	}

	public function editor(){
		return $this->belongsTo('User','editor_id');
	}
	
}

?>