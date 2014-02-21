<?php 

class Branch extends Eloquent{

	protected $table = 'branches';
	protected $primaryKey = 'branch_id';

	public function subjects(){
		return $this->hasMany('Subject', 'subject_branch_id');
	}
}

 ?>