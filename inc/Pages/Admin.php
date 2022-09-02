<?php

/**
 * @package managementtodo
 */

namespace Inc\Pages;

use \Inc\Basic\BasicController;
use \Inc\Basic\Model;
use \Inc\Setting\SettingClass;

class Admin extends BasicController
{
	public $settings;
	public $pages = array();
	public $subpages = array();

	public function __construct()
	{
		$this->settings = new SettingClass();
		add_shortcode('ma-todo', array($this, 'matodo_shortcode_main'));
	}

	public function register()
	{

		$this->pages = array(

			array(
				'page_title' => __('MA To Do', 'matodo'),
				'menu_title' => __('MA To Do', 'matodo'),
				'capability' => 'edit_posts',
				'menu_slug' => 'ma-todo',
				'callback' =>  array($this, 'matodo_manage'),
				'icon_url' =>  'dashicons-editor-ol',
				'position' =>  5
			)

		);

		$this->settings->AddPage($this->pages)->register();
	}

	public function matodo_manage()
	{
		Model::matodo_manage();
	}

	public function matodo_settings()
	{
		Model::matodo_settings();
	}

	public static function get_role()
	{
		$current_user = wp_get_current_user();
		foreach ($current_user->roles as $role) {
			if ($role = "administrator" || $role = "editor") { return $role; }
		}
		return $role;
	}

	public static function get_user_id()
	{
		$current_user = wp_get_current_user();
		return $current_user->ID;
	}

	public static function matodo_add_form()
	{
		$role = self::get_role();
		if ($role == 'administrator' || $role == 'editor') {
			require_once(parent::$plugin_path . 'components/add_task.php');
		} else {
			echo '<div class="narrow"></div>';
		}
	}

	public static function matodo_add_button()
	{
		$role = self::get_role();
		if ($role == 'administrator' || $role == 'editor') {
			echo '<button class="addTask" type="button" id="addTask-button">Add Task</button><br><br>';
		}
	}

	public static function matodo_delete_button($delete)
	{
		$role = self::get_role();
		if ($role == 'administrator') {
			echo $delete;
		}
	}

	public function matodo_shortcode_main()
	{
		return Model::matodo_shortcode();
	}

	// redirect to tasks
	public static function matodo_cancel()
	{
		if (isset($_POST['cancel'])) {
			echo '<script>window.location.href="?page=ma-todo"</script>';
		}
	}

	//countdown timer
	public static function matodo_countdown_timer($item, $status)
	{
		$now = date('Y-m-d H:i:s');
		$deadline = $item;
		$timefirst = strtotime($now);
		$timesecond = strtotime($deadline);
		$difference = $timesecond - $timefirst;
	}
}
