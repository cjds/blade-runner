<?php

class Module extends Eloquent{

	protected $table ='modules';
 	protected $primaryKey  = 'module_id';


	public function subject(){
		return $this->belongsTo('Subject','module_subject_id');
	}
	
}

?>