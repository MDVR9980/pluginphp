<?php

define('DEBUG', true);

define('APP_NAME', 'PluginPHP App');
define('APP_DESCRIPTION', 'The best website');

if((empty($_SERVER['SERVER_NAME']) && strpos(PHP_SAPI, 'cgi') !== 0) || (!empty($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost'))
{
	/** The name of your database */
    define( 'DB_NAME', 'pluginphp_db' );

    /** Database username */
    define( 'DB_USER', 'root' );

    /** Database password */
    define( 'DB_PASSWORD', '' );

    /** Database hostname */
    define( 'DB_HOST', 'localhost' );

    /** Database driver */
    define( 'DB_DRIVER', 'mysql' );

    define('ROOT', 'http://localhost/pluginphp');

}else
{
	/** The name of your database */
    define( 'DB_NAME', 'pluginphp_db' );

    /** Database username */
    define( 'DB_USER', 'root' );

    /** Database password */
    define( 'DB_PASSWORD', '' );

    /** Database hostname */
    define( 'DB_HOST', 'localhost' );

    /** Database driver */
    define( 'DB_DRIVER', 'mysql' );
	
	define('ROOT', 'http://yourwebsite.com');
}



