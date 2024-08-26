<?php

namespace Migration;

defined('FCPATH') or die("Direct script access denied");

/**
 * Pages class
 */
class Pages extends Migration {

	public function up() {

		$this->addColumn('id int unsigned auto_increment');
		$this->addColumn('user_id int unsigned null');
		$this->addColumn('title varchar(100) null');
		$this->addColumn('image varchar(1024) null');
		$this->addColumn('description varchar(255) null');
		$this->addColumn('keywords varchar(255) null');
		$this->addColumn('slug varchar(100) null');
		$this->addColumn('content mediumtext null');
		$this->addColumn('views int default 0 null');
		$this->addColumn('display_title tinyint(1) default 1 null');
		$this->addColumn('display_featured_image tinyint(1) default 1 null');

		$this->addColumn('disabled tinyint(1) unsigned default 0');
		$this->addColumn('date_created datetime default null');
		$this->addColumn('date_updated datetime default null');
		$this->addColumn('date_deleted datetime default null');

		$this->addPrimaryKey('id');
		$this->addKey('title');
		$this->addKey('user_id');
		$this->addKey('slug');
		$this->addKey('views');
		$this->addKey('disabled');
		$this->addKey('date_created');
		$this->addKey('date_deleted');
 
		$this->createTable('pages');
	}

	public function down() {
		$this->dropTable('pages');
	}
}