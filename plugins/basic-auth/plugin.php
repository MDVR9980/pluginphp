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
	'logout_page'		=> 'logout',
	'forgot_page'		=> 'forgot',
	'tables'			=> [

	],

]);

/** run this after a form submit **/
add_action('controller',function(){

	$vars = get_value();
	$req = new \Core\Request;
	$ses = new \Core\Session;

	if($req->posted() && page() == $vars['login_page']) {
		require plugin_path('controllers/loginController.php');
	} else 
	if($req->posted() && page() == $vars['signup_page']) {
		require plugin_path('controllers/signupController.php');
	} else 
	if(page() == $vars['logout_page']) {
		require plugin_path('controllers/logoutController.php');
	}
});

/** add menu links **/
add_filter('header-footer_before_menu_links',function($links) {

	$ses = new \Core\Session;
	$link		 = (object)[];
	$link->id	 = 0;
	$link->title = 'Login';
	$link->slug  = 'login';
	$link->icon = '';
	$link->permission = 'not_logged_in';
	$links[] = $link;

	$link		 = (object)[];
	$link->id	 = 0;
	$link->title = 'Signup';
	$link->slug  = 'signup';
	$link->icon = '';
	$link->permission = 'not_logged_in';
	$links[] = $link;

	$link		 = (object)[];
	$link->id	 = 0;
	$link->title = 'Logout';
	$link->slug  = 'logout';
	$link->icon = '';
	$link->permission = 'logged_in';
	$links[] = $link;

	$link		 = (object)[];
	$link->id	 = 0;
	$link->title = 'Hi,  ' . $ses->user('first_name');
	$link->slug  = 'profile/' . $ses->user('id');
	$link->icon = '';
	$link->permission = 'logged_in';
	$links[] = $link;

	return $links;
});

/** displays the view file **/
add_action('view',function(){

	$vars = get_value();

	if(page() == $vars['login_page']) {
		require plugin_path('views/login.php');
	} else 
	if(page() == $vars['signup_page']) {
		$errors = $vars['errors'] ?? [];
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

