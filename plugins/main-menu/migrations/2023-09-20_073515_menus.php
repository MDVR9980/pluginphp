<?php

namespace Migration;

defined('FCPATH') or die("Direct script access denied");

/**
 * Menus class
 */
class Menus extends Migration {

	public function up() {

		$this->addColumn('id int unsigned auto_increment');

		$this->addColumn('title varchar(50) null');
		$this->addColumn('slug varchar(100) null');
		$this->addColumn('icon varchar(100) null');
		$this->addColumn('parent int unsigned default 0 null');
		$this->addColumn('is_mega tinyint(1)unsigned default 0 null');
		$this->addColumn('image varchar(1024) null');
		$this->addColumn('mega_image varchar(1024) null');
		$this->addColumn('permission varchar(100) null');
		$this->addColumn('list_order int unsigned default 10 null');

		$this->addColumn('disabled tinyint(1) unsigned default 0');

		$this->addPrimaryKey('id');
		$this->addKey('title');
		$this->addKey('disabled');

		$this->createTable('menus');
	}

	public function down() {
		$this->dropTable('menus');
	}
}