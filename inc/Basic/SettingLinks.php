<?php
/**
* @package managementtodo
*/
namespace Inc\Basic;

use \Inc\Basic\BasicController;

class SettingLinks extends BasicController
{
	
	public function register(){
		add_filter("plugin_action_links_".parent::$plugin,array($this, 'settings_link'));
	}

	public function settings_link($links){
		//add custom setting link
		$settings_link = '<a href="admin.php?page=wptodo_settings">Settings</a>';
		array_push($links, $settings_link);
		return $links;
	}
}