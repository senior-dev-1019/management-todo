<?php
/**
* @package managementtodo
*/
/*
Plugin Name: Management To Do
Plugin URI: https://artem-portfolio-fsorcin.vercel.app
Description: A full featured plugin for creating and managing a "to do" list.
Version:1.0.1
Author: Artem Syvko
Author URI: https://artem-portfolio-fsorcin.vercel.app
License: GPLv2 or later
Text Domain: managementtodo
*/
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

Copyright (C) 2022  artemsyvko.

*/
defined('ABSPATH') or die('Hey, What are you doing here?');

if(file_exists(dirname(__FILE__).'/vendor/autoload.php')){
	require_once dirname(__FILE__).'/vendor/autoload.php';
}

function activate_matodo(){
	\Inc\Basic\Activation::activate();
}
register_activation_hook( __FILE__, 'activate_matodo' );

function deactivate_matodo(){
	\Inc\Basic\Deactivation::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_matodo' );

if( class_exists( 'Inc\\Init' ) ){
	\Inc\Init::register_services();
}
