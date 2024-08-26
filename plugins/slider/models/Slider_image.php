<?php

namespace Slider;
use \Model\Model;

defined('ROOT') or die("Direct script access denied");

/**
 * Slider_image class
 */
class Slider_image extends Model {

	protected $table = 'slider_images';
	public $primary_key = 'id';

	protected $allowedColumns = [
		'id',
		'image',
		'caption',
		'link',
	];
	
	protected $allowedUpdateColumns = [
		'id',
		'image',
		'caption',
		'link',
	];

	public function validate_insert(array $data):bool {
 
 		return empty($this->errors);
	}

	public function validate_update(array $data):bool {
 
		return empty($this->errors);
	}
}