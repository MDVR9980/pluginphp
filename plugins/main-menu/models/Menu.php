<?php

namespace MainMenu;
use \Model\Model;

defined('ROOT') or die("Direct script access denied");

/**
 * Menu class
 */
class Menu extends Model {

	protected $table = 'menus';
	public $primary_key = 'id';

	protected $allowedColumns = [
		'title',
		'slug',
		'icon',
		'parent',
		'is_mega',
		'image',
		'mega_image',
		'disabled',
		'permission',
		'list_order',
	];
	
	protected $allowedUpdateColumns = [
		'title',
		'slug',
		'icon',
		'parent',
		'is_mega',
		'image',
		'mega_image',
		'disabled',
		'permission',
		'list_order',
	];


	public function validate_insert(array $data):bool {

 		if(empty($data['title'])) {
 			$this->errors['title'] = 'Title is required';
 		} else
 		if($this->first(['title'=>$data['title']])) {
 			$this->errors['title'] = 'That title is already in use';
 		} else
 		if(!preg_match("/^[a-zA-Z \-]+$/", trim($data['title']))) {
 			$this->errors['title'] = 'Title does not allowed special characters';
 		}
 		return empty($this->errors);
	}

	public function validate_update(array $data):bool {
		
		$title_arr = [
			'title'=>$data['title']
		];
		$title_arr_not = [
			$this->primary_key => $data[$this->primary_key] ?? 0
		];
		
		if(empty($data['title'])) {
 			$this->errors['title'] = 'Title is required';
 		} else
 		if($this->first($title_arr,$title_arr_not)) {
 			$this->errors['title'] = 'That title is already in use';
 		} else 		
 		if(!preg_match("/^[a-zA-Z \-]+$/", trim($data['title']))) {
 			$this->errors['title'] = 'Title does not allowed special characters';
 		}

		return empty($this->errors);
	}
}