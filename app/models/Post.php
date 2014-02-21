<?php
class Post extends Eloquent{

	protected $table='posts';
 	protected $primaryKey   = 'post_id';
	 protected $softDelete = true;

	public function creator(){
		return $this->belongsTo('User','creator_id');
	}

	public function editor(){
		return $this->belongsTo('User','editor_id');
	}

	public function votes(){
		return $this->hasMany('Vote','post_id');
	}

	public function type(){
		return $this->morphTo('Post','post_type','post_id');
	}
}

?>