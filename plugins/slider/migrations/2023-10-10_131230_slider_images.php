<?php

namespace Migration;

defined('FCPATH') or die("Direct script access denied");

/**
 * Slider_images class
 */
class Slider_images extends Migration {

	public function up() {

		$this->addColumn('id int unsigned auto_increment');
		$this->addColumn('image varchar(1024) null');
		$this->addColumn('caption varchar(255) null');
		$this->addColumn('link varchar(1024) null');
		$this->addColumn('disabled tinyint(1) default 0 null');

		$this->addPrimaryKey('id');
 
		$this->createTable('slider_images');
	}

	public function down() {
		$this->dropTable('slider_images');
	}
}