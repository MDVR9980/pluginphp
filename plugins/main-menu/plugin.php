<?php

/**
 * Plugin name: Main Menu
 * Description: A way for admin to manage menu pages
 **/

set_value([
	'admin_route'	        =>'admin',
	'plugin_route'       	=>'main-menu',
	'tables'		        =>[
		'users_table' 		=> 'menus',
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

	$permissions[] = 'view_menu_pages';
	$permissions[] = 'add_menu_page';
	$permissions[] = 'edit_menu_page';
	$permissions[] = 'delete_menu_page';

	return $permissions;
});

/** add to amin links **/
add_action('header-footer_main_menu',function($data) {

	$image = new \Core\Image;
	require plugin_path('views/frontend/menu.php');
});

/** add to amin links **/
add_filter('basic-admin_before_admin_links',function($links) {

	if(user_can('view_menu_pages')) {
		$vars = get_value();
		$obj = (object)[];
		$obj->title = 'Menu';
		$obj->link = ROOT . '/'.$vars['admin_route'].'/'.$vars['plugin_route'];
		$obj->icon = 'fa-solid fa-bars';
		$obj->parent = 0;
		$links[] = $obj;
	}
	return $links;
});

add_filter('header-footer_before_menu_links',function($links) {

	$vars = get_value();
	$menu = new \MainMenu\Menu;

	$menu->order = 'asc';
	$menu->order_column = 'list_order';
	$menu::$query_id = 'get-menus-with-children';
    $rows = $menu->where(['disabled'=>0,'parent'=>0]);
    $rows = empty($rows) ? [] : $rows;
    $links = empty($links) ? [] : $links;

    $links = array_merge($links,$rows);

	return $links;
});

/** edit admin section title **/
add_filter('basic-admin_before_section_title',function($title) {

	$vars = get_value();

	if($vars['plugin_route'] == URL(1)) {
		$page_number = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
		$page_number = $page_number < 1 ? 1 : $page_number;

		$title = $title . ' (page '.$page_number.')';
	}
	return $title;
});

/** run this after a form submit **/
add_action('controller',function() {

	$req = new \Core\Request;
	$vars = get_value();
	
	$admin_route = $vars['admin_route'];
	$plugin_route = $vars['plugin_route'];

	if(URL(1) == $vars['plugin_route'] && $req->posted()) {
		$ses = new \Core\Session;
		$menu = new \MainMenu\Menu;
		$menu_roles_map = new \MainMenu\Menu;

		$id = URL(3) ?? null;
		if($id)
			$row = $menu->first(['id'=>$id]);

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

	$menu = new \MainMenu\Menu;
	$all_items = $menu->query("select * from menus");

	if(URL(1) == $vars['plugin_route']) {

		$id = URL(3) ?? null;
		if($id) {
			$menu::$query_id = 'get-menus';
			$row = $menu->first(['id'=>$id]);
		}

		if(URL(2) == 'add') { 
			require plugin_path('views/admin/add.php');
		} else
		if(URL(2) == 'edit') {
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

			$menu->limit = $limit;
			$menu->offset = $offset;
			$menu::$query_id = 'get-menus';
			
			if(!empty($_GET['find'])) {
				$find = '%' . trim($_GET['find']) . '%';
				$query = "select * from menus where title like :find limit $limit offset $offset";
				$rows = $menu->query($query,['find'=>$find]);
			} else {
				$rows = $menu->getAll();
			}
			require plugin_path('views/admin/list.php');
		}
	}
});

/** for manipulating data after a query operation **/
add_filter('after_query',function($data) {

	if(empty($data['result']))
		return $data;

	if($data['query_id'] == 'get-menus') {

		$role_map = new \MainMenu\Menu;

		foreach ($data['result'] as $key => $row) {
		
			$query = "select * from user_roles where disabled = 0 && id in (select role_id from user_roles_map where disabled = 0 && user_id = :user_id)";
			$roles = $role_map->query($query,['user_id'=>$row->id]);
			if($roles)
				$data['result'][$key]->roles = array_column($roles, 'role');
			
			/** get user's roles **/
			$menu_roles_map = new \MainMenu\Menu;
				
			$role_ids = $menu_roles_map->where(['user_id'=>$row->id,'disabled'=>0]);
			if($role_ids)
				$data['result'][$key]->role_ids = array_column($role_ids, 'role_id');

		}
	} else
	if($data['query_id'] == 'get-menus-with-children') {
		$menu = new \MainMenu\Menu;
		foreach ($data['result'] as $key => $row) {
			$menu->order = 'asc';
			$menu->order_column = 'list_order';
			$children = $menu->where(['parent'=>$row->id,'disabled'=>0]);
			if($children) {
				$data['result'][$key]->children = $children;

				foreach ($children as $ikey => $irow) {
					$grandchildren = $menu->where(['parent'=>$irow->id,'disabled'=>0]);
					if($grandchildren)
						$data['result'][$key]->children[$ikey]->grandchildren = $grandchildren;
				}	
			}
		}
	}
	return $data;
});