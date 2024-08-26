<?php

namespace Migration;

defined('FCPATH') or die("Direct script access denied");

/**
 * Pages_categories_map class
 */
class Pages_categories_map extends Migration {

	public function up() {

		$this->addColumn('id int unsigned auto_increment');
		$this->addColumn('page_id int unsigned default 0');
		$this->addColumn('category_id int unsigned default 0');
		$this->addColumn('disabled tinyint(1) unsigned default 0');

		$this->addPrimaryKey('id');
		$this->addKey('page_id');
		$this->addKey('category_id');
		$this->addKey('disabled');

		$this->createTable('pages_categories_map');
	}

	public function down() {
		$this->dropTable('pages_categories_map');
	}
}