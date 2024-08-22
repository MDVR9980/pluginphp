<?php

namespace mdvr;

use \Model\Model;
defined('ROOT') or die("Direct script access denied");

/**
 * User class
 */
class User extends Model
{

	protected $table = 'users';
	public $primary_key = 'id';

	protected $allowedColumns = [
		'first_name',
		'last_name',
		'gender',
		'iamge',
		'email',
		'password',
		'date_created',
	];
	
	protected $allowedUpdateColumns = [
		'first_name',
		'last_name',
		'gender',
		'iamge',
		'email',
		'password',
		'deleted',
		'date_updated',
		'date_deleted',
	];


	public function validate_insert(array $data):bool
	{

 		if(empty($data['first_name']))
 		{
 			$this->errors['first_name'] = 'A first name is required';
 		}else
		if(!preg_match("/^[a-zA-Z]+$/", trim($data['first_name']))) {
			$this->errors['first_name'] = 'Only letters with no spaces allowed in first name';
		}

		if(empty($data['last_name']))
 		{
 			$this->errors['last_name'] = 'A last name is required';
 		}else
		if(!preg_match("/^[a-zA-Z]+$/", trim($data['last_name']))) {
			$this->errors['last_name'] = 'Only letters with no spaces allowed in last name';
		}


 		if($this->first(['email'=>$data['email']]))
 		{
 			$this->errors['email'] = 'That email is already in use';
 		}else
 		if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL))
 		{
 			$this->errors['email'] = 'Email is not valid';
 		}
 		
		if(empty($data['gender'])) {
			$this->errors['gender'] = 'Gender is required';
		}

		if(!empty($data['password'])) {
			if($data['password' != $data['retype_password']]) {
				$this->errors['password'] = 'Password do not match' ;
			}
		}
		

 		return empty($this->errors);
	}

	public function validate_update(array $data):bool
	{
		
		if(empty($data['first_name']))
 		{
 			$this->errors['first_name'] = 'A first name is required';
 		}else
		if(!preg_match("/^[a-zA-Z]+$/", trim($data['first_name']))) {
			$this->errors['first_name'] = 'Only letters with no spaces allowed in first name';
		}

		if(empty($data['last_name']))
 		{
 			$this->errors['last_name'] = 'A last name is required';
 		}else
		if(!preg_match("/^[a-zA-Z]+$/", trim($data['last_name']))) {
			$this->errors['last_name'] = 'Only letters with no spaces allowed in last name';
		}



		$email_arr = [
			'email'=>$data['email']
		];
		$email_arr_not = [
			$this->primary_key => $data[$this->primary_key] ?? 0
		];
		
		if(empty($data['email']))
 		{
 			$this->errors['email'] = 'Email is required';
 		}else
 		if($this->first($email_arr,$email_arr_not))
 		{
 			$this->errors['email'] = 'That email is already in use';
 		}else 		
 		if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL))
 		{
 			$this->errors['email'] = 'Email is not valid';
 		}

		return empty($this->errors);
	}
}