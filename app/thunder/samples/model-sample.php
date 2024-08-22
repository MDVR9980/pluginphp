<?php

namespace Model;

defined('ROOT') or die("Direct script access denied");

/**
 * {CLASS_NAME} class
 */
class {CLASS_NAME} extends Model
{

	protected $table = '{TABLE_NAME}s';
	protected $primary_key = 'id';

	protected $allowedColumns = [
		'column1',
		'date_created',
	];
	
	protected $allowedUpdateColumns = [
		'column1',
		'date_updated',
		'date_deleted',
		'deleted',
	];


	public function validate_insert(array $data):bool
	{

 		if(empty($data['email']))
 		{
 			$this->errors['email'] = 'Email is required';
 		}else
 		if($this->first(['email'=>$data['email']]))
 		{
 			$this->errors['email'] = 'That email is already in use';
 		}else
 		if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL))
 		{
 			$this->errors['email'] = 'Email is not valid';
 		}
 		

 		return empty($this->errors);
	}

	public function validate_update(array $data):bool
	{
		
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