<?php
/**
*
* Trigger this file on Plugin uninstall
*
* @package managementtodo
*/

if(! defined('WP_UNINSTALL_PLUGIN')){
	die;
}
global $wpdb;
$matodo_table = $wpdb->prefix . "matodo";
$matodo_comments_table = $wpdb->prefix . "matodo_comments";
$tables = array($matodo_table,$matodo_comments_table);
	foreach ($tables as $table) {
		$wpdb->query("DROP TABLE IF EXISTS `$table`");
	}