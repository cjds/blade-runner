<?php

class Subject extends Eloquent{

	protected $table ='subjects';
 	protected $primaryKey  = 'subject_id';


	public function branch(){
		return $this->belongsTo('Branch','subject_branch_id');
	}
	
	public function modules(){
		return $this->hasMany('Module', 'module_subject_id');
	}
}

?>