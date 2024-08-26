<?php

namespace UserRoles;
use \Model\Model;

defined('ROOT') or die("Direct script access denied");

/**
 * User_role class
 */
class User_role extends Model {

	protected $table = 'user_roles';
	public $primary_key = 'id';

	protected $allowedColumns = [
		'role',
		'disabled',
	];
	
	protected $allowedUpdateColumns = [
		'role',
		'disabled',
	];


	public function validate_insert(array $data):bool {

 		if(empty($data['role'])) {
 			$this->errors['role'] = 'Role is required';
 		} else
 		if($this->first(['role'=>$data['role']])) {
 			$this->errors['role'] = 'That role is already in use';
 		} else
 		if(!preg_match("/^[a-zA-Z ]+$/",$data['role'])) {
 			$this->errors['role'] = 'Role can only have letters and spaces';
 		}
 		return empty($this->errors);
	}

	public function validate_update(array $data):bool {
		
		$role_arr = [
			'role'=>$data['role']
		];
		$role_arr_not = [
			$this->primary_key => $data[$this->primary_key] ?? 0
		];
		
		if(empty($data['role'])) {
 			$this->errors['role'] = 'Role is required';
 		} else
 		if($this->first($role_arr,$role_arr_not)) {
 			$this->errors['role'] = 'That role is already in use';
 		} else 		
 		if(!preg_match("/^[a-zA-Z ]+$/",$data['role'])) {
 			$this->errors['role'] = 'Role can only have letters and spaces';
 		}

		return empty($this->errors);
	}
}