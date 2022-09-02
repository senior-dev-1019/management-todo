<?php
/**
* @package managementtodo
*/
namespace Inc\Basic;
class Deactivation{
	public static function deactivate(){
		flush_rewrite_rules();
	}
}