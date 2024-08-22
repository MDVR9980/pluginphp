<?php

/**
 * Plugin name: Basic Authentication
 * Description: lets users login and signup
 * 
 * 
 **/

set_value([

	'login_page'		=>'login',
	'signup_page'		=>'signup',
	'forgot_page'		=> 'forgot',
	'tables'			=> [

	],

]);

/** run this after a form submit **/
add_action('controller',function(){

	$vars = get_value();

	require plugin_path('controllers/controller.php');
});


/** displays the view file **/
add_action('view',function(){

	$vars = get_value();

	if(page() == $vars['login_page']) {
		require plugin_path('views/login.php');
	} else 
	if(page() == $vars['signup_page']) {
		require plugin_path('views/signup.php');
	}
});


/** for manipulating data after a query operation **/
add_filter('after_query',function($data){

	
	if(empty($data['result']))
		return $data;

	foreach ($data['result'] as $key => $row) {
		


	}

	return $data;
});


