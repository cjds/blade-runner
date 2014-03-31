<?php
class Notes extends Eloquent{

	protected $table='notes';
 	protected $primaryKey   = 'note_id';
 	protected $softDelete = true;
	
	public function module(){
		return $this->belongsTo('Modules','module_id');
	}

	public function user(){
		return $this->belongsTo('User','user_id');
	}

	
}

?>