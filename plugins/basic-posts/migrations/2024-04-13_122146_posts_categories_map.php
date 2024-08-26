<?php

namespace Migration;

defined('FCPATH') or die("Direct script access denied");

/**
 * Posts_categories_map class
 */
class Posts_categories_map extends Migration {

	public function up() {

		$this->addColumn('id int unsigned auto_increment');
		$this->addColumn('post_id int unsigned default 0');
		$this->addColumn('category_id int unsigned default 0');
		$this->addColumn('disabled tinyint(1) unsigned default 0');

		$this->addPrimaryKey('id');
		$this->addKey('post_id');
		$this->addKey('category_id');
		$this->addKey('disabled');

		$this->createTable('posts_categories_map');
	}

	public function down() {
		$this->dropTable('posts_categories_map');
	}
}