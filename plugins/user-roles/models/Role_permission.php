<?php

namespace UserRoles;
use \Model\Model;

defined('ROOT') or die("Direct script access denied");

/**
 * Role_permission class
 */
class Role_permission extends Model {

	protected $table = 'role_permissions';
	public $primary_key = 'id';

	protected $allowedColumns = [
		'role_id',
		'permission',
		'disabled',
	];
	
	protected $allowedUpdateColumns = [
		'role_id',
		'permission',
		'disabled',
	];

	public function validate_insert(array $data):bool {
 		return empty($this->errors);
	}

	public function validate_update(array $data):bool {
		return empty($this->errors);
	}
}