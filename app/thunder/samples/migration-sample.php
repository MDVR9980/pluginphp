<?php

namespace Migration;

defined('FCPATH') or die("Direct script access denied");

/**
 * {CLASS_NAME} class
 */
class {CLASS_NAME} extends Migration
{

	public function up()
	{

		$this->addColumn('id int unsigned auto_increment');
		$this->addColumn('column1 varchar(255) null');
		$this->addColumn('column2 text null');
		$this->addColumn('deleted tinyint(1) unsigned default 0');
		$this->addColumn('date_created datetime default null');
		$this->addColumn('date_updated datetime default null');
		$this->addColumn('date_deleted datetime default null');

		$this->addPrimaryKey('id');
		$this->addKey('deleted');
		$this->addKey('date_created');
		$this->addKey('date_deleted');

		/** more keys:
		 * $this->addFullTextKey('column2');
		 * $this->addUniqueKey('deleted');
		 */

		$this->createTable('{TABLE_NAME}');

		/**
		 * to seed data:
		 * $this->addData([
		 * 	'username'=>'john'
		 * 	'email'=>'email@email.com'
		 * 	'gender'=>'male'
		 * ]);
		 * $this->insert('{TABLE_NAME}')
		 */

	}

	public function down()
	{
		$this->dropTable('{TABLE_NAME}');
	}
}