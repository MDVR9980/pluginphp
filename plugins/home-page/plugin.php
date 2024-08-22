<?php

/**
 * Plugin name: Home Page
 * Description: Displays the home page of a website
 * 
 * 
 **/

add_action('view',function(){

	require plugin_path('views/view.php');
});


