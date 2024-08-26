<?php

namespace BasicPages;
use \Model\Model;

defined('ROOT') or die("Direct script access denied");

/**
 * Categories_map class
 */
class Categories_map extends Model {

	protected $table = 'pages_categories_map';
	public $primary_key = 'id';

	protected $allowedColumns = [
		'page_id',
		'category_id',
		'disabled',
	];
	
	protected $allowedUpdateColumns = [
		'page_id',
		'category_id',
		'disabled',
	];


	public function disable_all(int $page_id) {
 		
 		$this->query("update $this->table set disabled = 1 where page_id = :page_id",['page_id'=>$page_id]);
	}

	public function save_new(int $page_id, array $category_ids) {
 		foreach ($category_ids as $id) {

 			if($check = $this->first(['page_id'=>$page_id,'category_id'=>$id])) {
 				$this->update($check->id,['disabled'=>0]);
 			} else {
 				$this->insert([
 					'page_id'=>$page_id,
 					'category_id'=>$id,
 					'disabled'=>0,
 				]);
 			}
 		}
	}

	public function get_category_ids(int $page_id):array {

		if($rows = $this->where(['page_id'=>$page_id,'disabled'=>0]))
			return array_column($rows, 'category_id');

		return [];
	}
	
	public function get_category_rows(int $page_id):array {
		$cats_table = get_value()['tables']['categories_table'];

		if($rows = $this->query("select * from $cats_table where disabled = 0 && id in (select category_id from $this->table where page_id =:page_id && disabled = 0)",['page_id'=>$page_id]))
			return $rows;
		
		return [];
	}
}