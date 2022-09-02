<?php
/**
* @package managementtodo
*/
namespace Inc\Basic;
class Activation{
	public static function activate(){
		flush_rewrite_rules();
		Model::matodo_install();
	}
}