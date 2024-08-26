<?php

/**
 * Plugin name: Slider
 * Description: Creates a home page slider
 **/

set_value([

	'plugin_route'	=>'slider',
	'admin_route'	=>'admin',
	'table'			=>'slider_images',

]);

/** set user permissions for this plugin **/
add_filter('permissions',function($permissions) {

	$permissions[] = 'view_slider_images';
	$permissions[] = 'add_slider_image';
	$permissions[] = 'edit_slider_image';
	$permissions[] = 'delete_slider_image';

	return $permissions;
});

/** add to amin links **/
add_filter('basic-admin_before_admin_links',function($links) {

	if(user_can('view_slider_images')) {
		$vars = get_value();

		$obj = (object)[];
		$obj->title = 'Slider Images';
		$obj->link = ROOT . '/'.$vars['admin_route'].'/'.$vars['plugin_route'];
		$obj->icon = 'fa-solid fa-image';
		$obj->parent = 0;
		$links[] = $obj;
	}

	return $links;
},20);

/** run this after a form submit **/
add_action('controller',function() {

	$req = new \Core\Request;

	if($req->posted()) {		
		$vars = get_value();

		if(page() == $vars['admin_route'] && URL(1) == $vars['plugin_route'])
			require plugin_path('controllers/controller.php');
	}
});

/** displays the slider **/
add_action('view',function() {

	if(page() == 'home') {
		$vars = get_value();

		$slider = new \Slider\Slider_image;
		$slider->order_column = 'id';
		$slider->order = 'asc';

		$rows = $slider->where(['disabled'=>0]);

		require plugin_path('views/slider-view.php');
	}
});

/** displays admin section **/
add_action('basic-admin_main_content',function() {

	$vars = get_value();
	if(page() == $vars['admin_route'] && URL(1) == $vars['plugin_route']) {
		$tab = $_GET['tab'] ?? 'slider1';
		$plugin_route = $vars['plugin_route'];
		$admin_route = $vars['admin_route'];

		$id = 0;
		switch ($tab) {
			case 'slider1':
				$id = 1;
				break;
			case 'slider2':
				$id = 2;
				break;
			case 'slider3':
				$id = 3;
				break;
			case 'slider4':
				$id = 4;
				break;
			
			default:
				$id = 0;
				break;
		}
		$slider = new \Slider\Slider_image;
		$row = $slider->first(['id'=>$id]);
		require plugin_path('views/admin-view.php');
	}
});