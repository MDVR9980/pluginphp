<?php

/**
 * Plugin name: Basic Posts
 * Description: Creates posts for your website
 **/

set_value([

	'admin_route'	=>'admin',
	'plugin_route'	=>'posts',
	'tables'		=> [
		'posts_table' => 'posts',
		'categories_table' => 'categories',
	],

]);

/** check if all tables exist **/
$db = new \Core\Database;
$tables = get_value()['tables'];

if(!$db->table_exists($tables)) {
	dd("Missing database tables in ".plugin_id() ." plugin: ". implode(",", $tables));
	die;
}

/** set user permissions for this plugin **/
add_filter('permissions',function($permissions) {

	$permissions[] = 'view_posts';
	$permissions[] = 'add_post';
	$permissions[] = 'edit_post';
	$permissions[] = 'delete_post';

	return $permissions;
});


/** run this after a form submit **/
add_action('controller',function() {

	$req = new \Core\Request;
	$vars = get_value();
	
	$admin_route = $vars['admin_route'];
	$plugin_route = $vars['plugin_route'];

	if(page() == $vars['admin_route'] && URL(1) == $vars['plugin_route'] && $req->posted()) {
		$ses = new \Core\Session;
		$post = new \BasicPosts\Post;

		$id = URL(3) ?? null;
		if($id)
			$row = $post->first(['id'=>$id]);

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
add_action('view',function() {

	$vars = get_value();
	$post = new \BasicPosts\Post;

	$row = $post->first(['slug'=>page()]);
	if($row) {
		$content = new \BasicPosts\Content;
		$row->content = $content->add_root($row->content);

		require plugin_path('views/frontend/view.php');
	}
});

/** displays the view file **/
add_action('basic-admin_main_content',function() {
	
	$ses = new \Core\Session;
	$vars = get_value();

	$admin_route = $vars['admin_route'];
	$plugin_route = $vars['plugin_route'];
	
	$errors = $vars['errors'] ?? [];

	$post = new \BasicPosts\Post;
	$categories_map = new \BasicPosts\Categories_map;

	if(page() == $vars['admin_route'] && URL(1) == $vars['plugin_route']) {

		$id = URL(3) ?? null;
		if($id) {
			$post::$query_id = 'get-posts';
			$row = $post->first(['id'=>$id]);

			$content = new \BasicPosts\Content;
			$row->content = $content->add_root($row->content);
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

			$post->limit = $limit;
			$post->offset = $offset;
			$post::$query_id = 'get-posts';
			
			if(!empty($_GET['find'])) {
				$find = '%' . trim($_GET['find']) . '%';
				$posts_table = $tables = $vars['tables']['posts_table'];

				$query = "select * from $posts_table where (title like :find) limit $limit offset $offset";
				$rows = $post->query($query,['find'=>$find]);
			} else {
				$rows = $post->getAll();
			}

			require plugin_path('views/admin/list.php');
		}
	}
});

/** add to amin links **/
add_filter('basic-admin_before_admin_links',function($links) {

	if(user_can('view_posts')) {
		$vars = get_value();

		$obj = (object)[];
		$obj->title = 'Posts';
		$obj->link = ROOT . '/'.$vars['admin_route'].'/'.$vars['plugin_route'];
		$obj->icon = 'fa-solid fa-file-lines';
		$obj->parent = 0;
		$links[] = $obj;
	}
	return $links;
});


/** for manipulating data after a query operation **/
add_filter('after_query',function($data) {

	$categories_map = new \BasicPosts\Categories_map;

	if(empty($data['result']))
		return $data;

	if($data['query_id'] == 'get-posts') {
		$db = new \Core\Database;
		foreach ($data['result'] as $key => $row) {
			
			$user_row = $db->get_row("select * from users where id = :id limit 1",['id'=>$row->user_id]);
			if($user_row)
				$data['result'][$key]->user_row = $user_row;

			$category_rows = $categories_map->get_category_rows($row->id);
			if($category_rows)
				$data['result'][$key]->category_rows = $category_rows;
		}
	}
	return $data;
});

add_action('basic-posts-show_posts',function($data) {

	echo "this is from the posts plugin";
	dd($data);
});