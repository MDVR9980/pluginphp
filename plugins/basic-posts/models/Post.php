<?php

namespace BasicPosts;
use \Model\Model;

defined('ROOT') or die("Direct script access denied");

/**
 * Post class
 */
class Post extends Model {

	protected $table = 'posts';
	public $primary_key = 'id';

	protected $allowedColumns = [
		'user_id',
		'title',
		'image',
		'description',
		'keywords',
		'slug',
		'content',
		'views',
		'display_title',
		'disabled',
		'date_created',
		'display_featured_image',
	];
	
	protected $allowedUpdateColumns = [
		'user_id',
		'title',
		'image',
		'description',
		'keywords',
		'slug',
		'content',
		'views',
		'display_title',
		'disabled',
		'date_updated',
		'date_deleted',
		'display_featured_image',
	];


	public function validate_insert(array $data):bool {
		$this->errors = [];

 		if(empty($data['title'])) {
 			$this->errors['title'] = 'A title is required';
 		}
 		return empty($this->errors);
	}

	public function validate_update(array $data):bool {
		$this->errors = [];
		
		if(empty($data['title'])) {
 			$this->errors['title'] = 'A title is required';
 		}

		return empty($this->errors);
	}
}