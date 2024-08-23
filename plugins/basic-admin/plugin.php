<?php

/**
 * Plugin name: Basic Admin
 * Description: Provides a basic admin area
 * 
 **/

set_value([

	'plugin_route'	=>'admin',

]);

/** set user permissions for this plugin **/
add_filter('permissions',function($permissions){

	$permissions[] = 'view_admin_page';

	return $permissions;
});


/** run this after a form submit **/
add_action('before_controller',function(){

	$vars = get_value();

	if(page() == $vars['plugin_route'] && !user_can('view_admin_page')) {
		message('Access to admin page denied! please try a different login');
		redirect('login');
	}
});

/** run this after a form submit **/
add_action('controller',function(){

	do_action(plugin_id() . '_controller');
});

/** displays the view file **/
add_action('view',function(){

	$vars = get_value();

	$section_title = ucfirst(str_replace('-', ' ', (URL(1) ?? '')));
	if(empty($section_title))
		$section_title = "Dashboard";

	$links = [];

	$links = do_filter(plugin_id() . '_before_admin_links', $links);

	require plugin_path('views/view.php');
});