<?php

namespace Categories;
use \Model\Model;

defined('ROOT') or die("Direct script access denied");

/**
 * Category class
 */
class Category extends Model {

	protected $table = 'categories';
	public $primary_key = 'id';

	protected $allowedColumns = [
		'id',
		'category',
		'slug',
		'disabled',
	];
	
	protected $allowedUpdateColumns = [
		'category',
		'disabled',
	];


	public function validate_insert(array $data):bool {
		$this->errors = [];

 		if(empty($data['category'])) {
 			$this->errors['category'] = 'Category is required';
 		} else
 		if($this->first(['category'=>$data['category']])) {
 			$this->errors['category'] = 'That category is already in use';
 		}
 		
 		return empty($this->errors);
	}

	public function validate_update(array $data):bool {
		$this->errors = [];
		
		$category_arr = [
			'category'=>$data['category']
		];
		$category_arr_not = [
			$this->primary_key => $data[$this->primary_key] ?? 0
		];
		
		if(empty($data['category'])) {
 			$this->errors['category'] = 'Category is required';
 		} else
 		if($this->first($category_arr,$category_arr_not)) {
 			$this->errors['category'] = 'That category is already in use';
 		}

		return empty($this->errors);
	}
}