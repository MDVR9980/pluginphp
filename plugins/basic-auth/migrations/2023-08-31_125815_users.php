<?php

namespace Migration;

defined('FCPATH') or die("Direct script access denied");

/**
 * Users class
 */
class Users extends Migration {

	public function up() {

		$this->addColumn('id int unsigned auto_increment');
		
		$this->addColumn('first_name varchar(30) null');
		$this->addColumn('last_name varchar(30) null');
		$this->addColumn('image varchar(1024) null');
		$this->addColumn('gender varchar(6) null');
		$this->addColumn('email varchar(100) null');
		$this->addColumn('password varchar(255) null');

		$this->addColumn('deleted tinyint(1) unsigned default 0');
		$this->addColumn('date_created datetime default null');
		$this->addColumn('date_updated datetime default null');
		$this->addColumn('date_deleted datetime default null');

		$this->addPrimaryKey('id');
		$this->addKey('first_name');
		$this->addKey('last_name');
		$this->addKey('email');
		$this->addKey('deleted');
		$this->addKey('date_created');
		$this->addKey('date_deleted');

		/** more keys:
		 * $this->addFullTextKey('column2');
		 * $this->addUniqueKey('deleted');
		 */

		$this->createTable('users');

		 //to seed data:
		 $this->addData([
		 	'first_name'=>'Admin',
		 	'last_name'=>'Admin',
		 	'email'=>'email@email.com',
		 	'password'=>password_hash('password', PASSWORD_DEFAULT),
		 	'gender'=>'male',
		 	'date_created'=>date("Y-m-d H:i:s"),
		 ]);

		 $this->insert('users');
	}

	public function down() {
		$this->dropTable('users');
	}
}