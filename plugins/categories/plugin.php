<?php

/**
 * Plugin name: Categories
 * Description: A way for admin to manage categories
 **/

set_value([

	'admin_route'	=>'admin',
	'plugin_route'	=>'categories',
	'tables'		=>[
		'categories_table' 		=> 'categories',
	],

	'optional_tables'		=>[
	],
]);


/** check if all tables exist **/
$db = new \Core\Database;
$tables = get_value()['tables'];

if(!$db->table_exists($tables)){
	dd("Missing database tables in ".plugin_id() ." plugin: ". implode(",", $db->missing_tables));
	die;
}

/** set category permissions for this plugin **/
add_filter('permissions',function($permissions) {

	$permissions[] = 'view_categories';
	$permissions[] = 'view_category_details';
	$permissions[] = 'add_category';
	$permissions[] = 'edit_category';
	$permissions[] = 'delete_category';

	return $permissions;
});


/** add to amin links **/
add_filter('basic-admin_before_admin_links',function($links) {

	if(user_can('view_categories')) {
		$vars = get_value();

		$obj = (object)[];
		$obj->title = 'Categories';
		$obj->link = ROOT . '/'.$vars['admin_route'].'/'.$vars['plugin_route'];
		$obj->icon = 'fa-solid fa-layer-group';
		$obj->parent = 0;
		$links[] = $obj;
	}
	return $links;
});

/** run this after a form submit **/
add_action('controller',function() {

	$req = new \Core\Request;
	$vars = get_value();
	
	$admin_route = $vars['admin_route'];
	$plugin_route = $vars['plugin_route'];

	if(URL(1) == $vars['plugin_route'] && $req->posted()) {
		$ses = new \Core\Session;
		$category = new \Categories\Category;
		$category_roles_map = new \UsersManager\User_roles_map;

		$id = URL(3) ?? null;
		if($id)
			$row = $category->first(['id'=>$id]);

		if(URL(2) == 'add') {
			require plugin_path('controllers/add-controller.php');
		} else
		if(URL(2) == 'edit') {
			require plugin_path('controllers/edit-controller.php');
		} else
		if(URL(2) == 'delete') {
			require plugin_path('controllers/delete-controller.php');
		}
	}
});

/** displays the view file **/
add_action('basic-admin_main_content',function() {

	$ses = new \Core\Session;
	$vars = get_value();

	$admin_route = $vars['admin_route'];
	$plugin_route = $vars['plugin_route'];
	
	$errors = $vars['errors'] ?? [];

	$category = new \Categories\Category;

	if(URL(1) == $vars['plugin_route']) {

		$id = URL(3) ?? null;
		if($id) {
			$category::$query_id = 'get-categories';
			$row = $category->first(['id'=>$id]);
		}

		if(URL(2) == 'add') {
			$category_role = new \UsersManager\User_role;
			require plugin_path('views/admin/add.php');
		} else
		if(URL(2) == 'edit') {
			$category_role = new \UsersManager\User_role;
			require plugin_path('views/admin/edit.php');
		} else
		if(URL(2) == 'delete') {
			require plugin_path('views/admin/delete.php');
		} else
		if(URL(2) == 'view') {
			require plugin_path('views/admin/view.php');
		} else {
			$limit = 30;
			$pager = new \Core\Pager($limit);
			$offset = $pager->offset;

			$category->limit = $limit;
			$category->offset = $offset;
			$category::$query_id = 'get-categories';
			
			if(!empty($_GET['find'])) {
				$find = '%' . trim($_GET['find']) . '%';
				$query = "select * from categories where (category like :find) limit $limit offset $offset";
				$rows = $category->query($query,['find'=>$find]);
			} else {
				$rows = $category->getAll();
			}
			require plugin_path('views/admin/list.php');
		}
	}
});

/** for manipulating data after a query operation **/
add_filter('after_query',function($data) {
	
	if(empty($data['result']))
		return $data;

	if($data['query_id'] == 'get-categories') {
		$role_map = new \UsersManager\User_roles_map;
		foreach ($data['result'] as $key => $row) {
			
			$query = "select * from category_roles where disabled = 0 && id in (select role_id from category_roles_map where disabled = 0 && category_id = :category_id)";
			$roles = $role_map->query($query,['category_id'=>$row->id]);
			if($roles)
				$data['result'][$key]->roles = array_column($roles, 'role');
			
			/** get category's roles **/
			$category_roles_map = new \UsersManager\User_roles_map;
				
			$role_ids = $category_roles_map->where(['category_id'=>$row->id,'disabled'=>0]);
			if($role_ids)
				$data['result'][$key]->role_ids = array_column($role_ids, 'role_id');
		}
	}
	return $data;
});