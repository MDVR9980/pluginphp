<?php

/**
 * Plugin name: Users Manager
 * Description: A way for admin to manage users
 **/

set_value([
	'admin_route'	        =>'admin',
	'plugin_route'	        =>'users',
	'tables'		        =>[
		'users_table' 		=> 'users',
	],

	'optional_tables'		=> [
		'roles_table' 		=> 'user_roles',
		'permissions_table' => 'role_permissions',
		'roles_map_table' 	=> 'user_roles_map',
	],
]);

/** check if all tables exist **/
$db = new \Core\Database;
$tables = get_value()['tables'];

if(!$db->table_exists($tables)) {
	dd("Missing database tables in ".plugin_id() ." plugin: ". implode(",", $db->missing_tables));
	die;
}

/** set user permissions for this plugin **/
add_filter('permissions',function($permissions) {

	$permissions[] = 'all';
	$permissions[] = 'view_users';
	$permissions[] = 'view_user_details';
	$permissions[] = 'add_user';
	$permissions[] = 'edit_user';
	$permissions[] = 'delete_user';

	return $permissions;
});

/** add to amin links **/
add_filter('basic-admin_before_admin_links',function($links) {

	if(user_can('view_users')) {
		$vars = get_value();

		$obj = (object)[];
		$obj->title = 'Users';
		$obj->link = ROOT . '/'.$vars['admin_route'].'/'.$vars['plugin_route'];
		$obj->icon = 'fa-solid fa-people-group';
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
		$user = new \UsersManager\User;
		$user_roles_map = new \UsersManager\User_roles_map;

		$id = URL(3) ?? null;
		if($id)
			$row = $user->first(['id'=>$id]);

		if(URL(2) == 'add') {
			require plugin_path('controllers/add-controller.php');
		}else
		if(URL(2) == 'edit') {
			require plugin_path('controllers/edit-controller.php');
		}else
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

	$user = new \UsersManager\User;

	if(URL(1) == $vars['plugin_route']) {

		$id = URL(3) ?? null;
		if($id) {
			$user::$query_id = 'get-users';
			$row = $user->first(['id'=>$id]);
		}
		if(URL(2) == 'add') {
			$user_role = new \UsersManager\User_role;
			require plugin_path('views/add.php');
		} else
		if(URL(2) == 'edit') {
			$user_role = new \UsersManager\User_role;
			require plugin_path('views/edit.php');
		} else
		if(URL(2) == 'delete') {
			require plugin_path('views/delete.php');
		} else
		if(URL(2) == 'view') {
			require plugin_path('views/view.php');
		} else {
			$limit = 30;
			$pager = new \Core\Pager($limit);
			$offset = $pager->offset;

			$user->limit = $limit;
			$user->offset = $offset;
			$user::$query_id = 'get-users';
			
			if(!empty($_GET['find'])) {
				$find = '%' . trim($_GET['find']) . '%';
				$query = "select * from users where (first_name like :find || last_name like :find) limit $limit offset $offset";
				$rows = $user->query($query,['find'=>$find]);
			} else {
				$rows = $user->getAll();
			}

			require plugin_path('views/list.php');
		}

	}
});

/** for manipulating data after a query operation **/
add_filter('after_query',function($data) {
	
	if(empty($data['result']))
		return $data;

	if($data['query_id'] == 'get-users') {
		$role_map = new \UsersManager\User_roles_map;
		foreach ($data['result'] as $key => $row) {
			
			$query = "select * from user_roles where disabled = 0 && id in (select role_id from user_roles_map where disabled = 0 && user_id = :user_id)";
			$roles = $role_map->query($query,['user_id'=>$row->id]);
			if($roles)
				$data['result'][$key]->roles = array_column($roles, 'role');
			
			/** get user's roles **/
			$user_roles_map = new \UsersManager\User_roles_map;
				
			$role_ids = $user_roles_map->where(['user_id'=>$row->id,'disabled'=>0]);
			if($role_ids)
				$data['result'][$key]->role_ids = array_column($role_ids, 'role_id');

		}
	}
	return $data;
});