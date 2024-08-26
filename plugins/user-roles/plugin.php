<?php

/**
 * Plugin name: User Roles
 * Description: A way for admin to manage user roles
 **/

set_value([
	'admin_route'	=>'admin',
	'plugin_route'	=>'user-roles',
	'tables'		=>[
		'users_table' 		=> 'users',
		'roles_table' 		=> 'user_roles',
		'permissions_table' => 'role_permissions',
		'roles_map_table' 	=> 'user_roles_map',
	],
]);

/** check if all tables exist **/
$db = new \Core\Database;
$tables = get_value()['tables'];

if(!$db->table_exists($tables)){
	dd("Missing database tables in ".plugin_id() ." plugin: ". implode(",", $db->missing_tables));
	die;
}

/** set user permissions for this plugin **/
add_filter('permissions',function($permissions) {

	$permissions[] = 'view_roles';
	$permissions[] = 'add_role';
	$permissions[] = 'edit_role';
	$permissions[] = 'edit_permissions';
	$permissions[] = 'delete_role';

	return $permissions;
});

/** add to amin links **/
add_filter('basic-admin_before_admin_links',function($links) {

	if(user_can('view_roles')) {
		$vars = get_value();

		$obj = (object)[];
		$obj->title = 'User Roles';
		$obj->link = ROOT . '/'.$vars['admin_route'].'/'.$vars['plugin_route'];
		$obj->icon = 'fa-solid fa-unlock';
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
		$user_role = new \UserRoles\User_role;

		$id = URL(3) ?? null;
		if($id)
			$row = $user_role->first(['id'=>$id]);

		if(URL(2) == 'add') {
			require plugin_path('controllers/add-controller.php');
		} else
		if(URL(2) == 'edit') {
			require plugin_path('controllers/edit-controller.php');
		} else
		if(URL(2) == 'delete') {
			require plugin_path('controllers/delete-controller.php');
		} else {
			$user_permission = new \UserRoles\Role_permission;
			require plugin_path('controllers/list-controller.php');
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

	$user_role = new \UserRoles\User_role;

	if(URL(1) == $vars['plugin_route']) {

		$id = URL(3) ?? null;
		if($id)
			$row = $user_role->first(['id'=>$id]);

		if(URL(2) == 'add') {
			require plugin_path('views/add.php');
		} else
		if(URL(2) == 'edit') {
			
			require plugin_path('views/edit.php');
		} else
		if(URL(2) == 'delete') {

			require plugin_path('views/delete.php');
		} else
		if(URL(2) == 'view') {

			require plugin_path('views/view.php');
		} else {
			$user_role->limit = 1000;

			$user_role::$query_id = 'get-roles';
			$rows = $user_role->getAll();

			require plugin_path('views/list.php');
		}
	}
});

/** for manipulating data after a query operation **/
add_filter('after_query',function($data) {

	if(empty($data['result']))
		return $data;

	if($data['query_id'] == 'get-roles') {
		$user_permission = new \UserRoles\Role_permission;

		foreach ($data['result'] as $key => $row) {
			$permissions = $user_permission->where(['role_id'=>$row->id,'disabled'=>0]);
			if($permissions)
				$data['result'][$key]->permissions = array_column($permissions, 'permission');
		}
	}
	return $data;
});