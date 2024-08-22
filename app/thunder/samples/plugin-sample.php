<?php

/**
 * Plugin name: 
 * Description: 
 * 
 * 
 **/

set_value([

	'plugin_route'	=>'my-plugin',
	'table'			=>'my_table',

]);

/** set user permissions for this plugin **/
add_filter('permissions',function($permissions){

	$permissions[] = 'my_permission';

	return $permissions;
});


/** run this after a form submit **/
add_action('controller',function(){

	$vars = get_value();

	require plugin_path('controllers/controller.php');
});


/** displays the view file **/
add_action('view',function(){

	$vars = get_value();

	require plugin_path('views/view.php');
});


/** for manipulating data after a query operation **/
add_filter('after_query',function($data){

	
	if(empty($data['result']))
		return $data;

	foreach ($data['result'] as $key => $row) {
		


	}

	return $data;
});


