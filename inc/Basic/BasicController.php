<?php
/**
* @package managementtodo
*/
namespace Inc\Basic;


class BasicController
{
	public static $plugin_path;
	public static $plugin_url;
	public static $plugin;
	
	public function __construct(){
		self::$plugin_path = plugin_dir_path( dirname( __FILE__ , 2 ) );
		self::$plugin_url = plugin_dir_url( dirname( __FILE__ , 2 ) );
		self::$plugin = plugin_basename( dirname( __FILE__ , 3 ) ) . '/management-todo.php';
	}
}