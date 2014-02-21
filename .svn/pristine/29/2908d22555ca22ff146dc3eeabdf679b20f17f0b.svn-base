<?php 

class Tag extends Eloquent{

	protected $table="tags";
	protected $primaryKey = 'tags_id';
	protected $fillable = array('tag_name');
	

	public function posts(){
		return $this->belongsToMany('Question');
	}
}

?>