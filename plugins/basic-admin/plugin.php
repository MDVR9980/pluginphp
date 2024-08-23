<?php

/**
 * Plugin name: Eathorne
 * Description: Provides a basic admin area
 **/

set_value([

	'plugin_route'	=>'admin',
	'logout_page'	=>'logout',

]);

/** set user permissions for this plugin **/
add_filter('permissions',function($permissions) {

	$permissions[] = 'view_admin_page';

	return $permissions;
});


/** run this after a form submit **/
add_action('before_controller',function() {

	$vars = get_value();

	if(false && page() == $vars['plugin_route'] && !user_can('view_admin_page')) {
		message("Access to admin page denied! please try a different login");
		redirect('login');
	}
});

/** run this after a form submit **/
add_action('controller',function() {

	do_action(plugin_id() . '_controller');

});


/** displays the view file **/
add_action('view',function() {

	$vars = get_value();

	$section_title = ucfirst(str_replace("-"," ",(URL(1) ?? '')));
	
	if(empty($section_title))
		$section_title = "Dashboard";

	$section_title = do_filter(plugin_id().'_before_section_title',$section_title);

	$links = [];
	$obj = (object)[];
	$obj->title = 'Dashboard';
	$obj->link = ROOT . '/'.$vars['plugin_route'];
	$obj->icon = 'fa-solid fa-gauge';
	$obj->parent = 0;
	$links[] = $obj;

	$links = do_filter(plugin_id().'_before_admin_links',$links);

	$bottom_links = [];

	$obj = (object)[];
	$obj->title = 'Website Home';
	$obj->link = ROOT;
	$obj->icon = 'fa-solid fa-earth-africa';
	$obj->parent = 0;
	$bottom_links[] = $obj;

	$obj = (object)[];
	$obj->title = 'Logout';
	$obj->link = ROOT . '/' .$vars['logout_page'];
	$obj->icon = 'fa-solid fa-right-from-bracket';
	$obj->parent = 0;
	$bottom_links[] = $obj;
	
	require plugin_path('views/view.php');
});