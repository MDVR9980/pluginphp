<?php

namespace Migration;

defined('FCPATH') or die("Direct script access denied");

/**
 * User_roles class
 */
class User_roles extends Migration
{

	public function up() {

		$this->addColumn('id int unsigned auto_increment');
		$this->addColumn('role varchar(100) null');
		$this->addColumn('disabled tinyint(1) unsigned default 0');

		$this->addPrimaryKey('id');
		$this->addKey('disabled');

		$this->createTable('user_roles');

		// to seed data:
		$this->addData([
			'role'    => 'admin',
			'disabled'=> 0,
		]);
		$this->insert('user_roles');
		 
	}

	public function down() {
		$this->dropTable('user_roles');
	}
}