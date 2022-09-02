<?php
/**
* @package managementtodo
*/
namespace Inc\Basic;

use \Inc\Basic\BasicController;
use \Inc\Pages\Admin;

class Model extends BasicController
{
	private static $wpdb;

	public function __construct(){
		global $wpdb;
		self::$wpdb = $wpdb;
	}
/**
 * Creating database tables
 */
	public static function matodo_install() {
		// where and what we will store - db structure
		$matodo_table = self::$wpdb->prefix . "matodo";
		$matodo_comments_table = self::$wpdb->prefix . "matodo_comments";
		$matodo_structure = "
		CREATE TABLE IF NOT EXISTS `$matodo_table` (
			`id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
			`date` DATE NOT NULL ,
			`title` TEXT NOT NULL ,
			`desc` TEXT NOT NULL ,
			`from` BIGINT( 20 ) UNSIGNED NOT NULL ,
			`for` BIGINT( 20 ) UNSIGNED NOT NULL DEFAULT '0',
			`until` DATE NOT NULL ,
			`status` TINYINT( 1 ) NOT NULL DEFAULT '0',
			`priority` TINYINT( 1 ) NOT NULL DEFAULT '0',
			`notify` BINARY NOT NULL DEFAULT '0',
			PRIMARY KEY ( `id` )
		) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci";
		$matodo_comments_structure = "
		CREATE TABLE IF NOT EXISTS `$matodo_comments_table` (
			`id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
			`date` DATE NOT NULL ,
			`task` BIGINT( 20 ) UNSIGNED NOT NULL ,
			`body` TEXT NOT NULL ,
			`from` BIGINT( 20 ) UNSIGNED NOT NULL ,
			PRIMARY KEY ( `id` )
		) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci";
		
		// Sending all this to mysql queries
		self::$wpdb->query($matodo_structure);
		self::$wpdb->query($matodo_comments_structure);
		$today_date = gmdate('Y-m-d');
	}
	/**
	 * Users id -> nicename
	 */
	public static function matodo_from($raw_from) {
		if(is_int($raw_from) && ($raw_from != '0')) {
			$from = get_userdata($raw_from);
			return $from->display_name;
		}
		else if (is_string($raw_from)) {
			$from = get_userdata($raw_from);
			return $from->ID;
		}
		else return "Nobody";
	}

	/**
	 * Users email
	 */
	public static function matodo_to(int $id) {
		if(is_int($id) && ($id != '0')) {
			$to = get_userdata($id);
			return $to->user_email;
		}
	}
	/**
	 * Displaying a nicer date
	 */
	public static function matodo_date($raw_date) {
		if($raw_date != "0000-00-00") {
			return mysql2date(get_option('date_format'), $raw_date); //Let's use wordpress prefered date settings
		}
		else return "Not set";
	}

	/**
	 * Displaying a nicer status
	 */
	public static function matodo_status($raw_status) {
		switch ($raw_status) {
		default: return "Pending";
		//case 1: return "Pending";
		case 2: return "ReSolved";
		}
	}

	/**
	 * Displaying a nicer priority
	 */
	public static function matodo_priority($raw_priority) {
		switch ($raw_priority) {
		default: return "Low";
		//case 1: return "Low";
		case 2: return "Normal";
		case 3: return "High";
		case 4: return "Important";
		}
	}

	/**
	 * Displaying a nicer notice
	 */
	public static function matodo_notice($raw_notice) {
		switch ($raw_notice) {
		default: return "No";
		case 1: return "Yes";
		}
	}

	/**
	 * Add a task to db
	 */
	public static function matodo_addtask(array $newdata) {
		$matodo_table = self::$wpdb->prefix . "matodo";
		$today_date = gmdate('Y-m-d');
		$matodo_query = "INSERT INTO `".$matodo_table."` (`id`, `date`, `title`, `desc`, `from`, `for`, `until`,`status`,`priority`,`notify`)VALUES (NULL , '$today_date', '".$newdata['matodo_title']."','".$newdata['matodo_description']."','".$newdata['matodo_from']."','".$newdata['matodo_for']."','".$newdata['matodo_deadline']."','".$newdata['matodo_status']."','".$newdata['matodo_priority']."','".!empty($newdata['matodo_notify'])."')";
		self::$wpdb->query($matodo_query);
	}

	/**
	 * Update a task
	 */
	public static function matodo_updatetask(array $newdata) {
		$matodo_table = self::$wpdb->prefix . "matodo";
		$matodo_query = "UPDATE `".$matodo_table."` SET `title`='".$newdata['matodo_title']."', `desc`='".$newdata['matodo_description']."', `for`='".$newdata['matodo_for']."', `until`='".$newdata['matodo_deadline']."', `status`='".$newdata['matodo_status']."', `priority`='".$newdata['matodo_priority']."', `notify`='".!empty($newdata['matodo_notify'])."' WHERE `id`='".$newdata['matodo_taskid']."'";
		self::$wpdb->query($matodo_query);

		//echo '<script>window.location.href="?page=ma-todo"</script>';
	}
	/**
	 * Delete a task
	 */
	public static function matodo_deletetask(int $id) {
		if(isset($id)){
			$matodo_table = self::$wpdb->prefix . "matodo";
			$matodo_comments_table = self::$wpdb->prefix . "matodo_comments";
			$q = self::$wpdb->query("DELETE FROM `".$matodo_table."` WHERE `id`=$id");
			self::$wpdb->query("DELETE FROM `".$matodo_comments_table."` WHERE `task`=$id");
			echo '<script>window.location.href="?page=ma-todo"</script>';
		}
	}

	public static function delete_matodo_item(){
		// if(isset($_REQUEST['item_id'])){
		// 	$matodo_table = self::$wpdb->prefix . "matodo";
		// 	$matodo_comments_table = self::$wpdb->prefix . "matodo_comments";
		// 	$q = self::$wpdb->query("DELETE FROM `".$matodo_table."` WHERE `id`=$id");
		// 	self::$wpdb->query("DELETE FROM `".$matodo_comments_table."` WHERE `task`=$id");
			$result['type'] = "success";
			$result = json_encode($result);
	  		echo $result;		
	  	// }
			die();
	}
	/**
	 * Add a comment
	 */
	public static function matodo_addcomment(array $newdata) {
		$matodo_comments_table = self::$wpdb->prefix . "matodo_comments";
		$today_date = gmdate('Y-m-d');
		self::$wpdb->query("INSERT INTO $matodo_comments_table(`id`, `date`, `task`, `body`, `from`)
		VALUES(NULL, '$today_date', '".$newdata['matodo_comment_task']."', '".$newdata['matodo_comment_body']."', '".$newdata['matodo_comment_author']."')");

	}
	/**
	 * Edit a task
	 */
	public static function matodo_edit(int $id) {
		if(isset($id) && !empty($id)){
			$matodo_table = self::$wpdb->prefix . "matodo";
			$matodo_edit_item = self::$wpdb->get_results("SELECT * FROM `$matodo_table` WHERE `id`=$id");
			if(!$matodo_edit_item) {
				echo'<div class="wrap"><h2>There is no such task to edit. Please add one first.</h2></div>';
			}
			else {
				require_once(parent::$plugin_path . 'components/edit_task.php');
		 	}
		}
	}
	/**
	 * View a task
	 */
	public static function matodo_view(int $id) {
		if(isset($id) && !empty($id)){
			$matodo_table = self::$wpdb->prefix . "matodo";
			$matodo_comments_table = self::$wpdb->prefix . "matodo_comments";
			$matodo_view_item = self::$wpdb->get_results("SELECT * FROM `$matodo_table` WHERE `id`=$id");
			$matodo_view_item_comments = self::$wpdb->get_results("SELECT * FROM `$matodo_comments_table` WHERE `task`=$id");
			if(!$matodo_view_item) {
				echo'<div class="wrap"><h2>There is no such task to view. Please add one first.</h2></div>';
			}else{
				require_once(parent::$plugin_path . 'components/view_task.php');
			}
		}
	}
	/**
	 * Main admin page
	 */
	public static function matodo_manage_main(/*$matodo_filter_status*/) {
		$matodo_table = self::$wpdb->prefix . "matodo";
		require_once(parent::$plugin_path . 'components/admin.php');
	}
	/**
	 * Admin CP manage page
	 */
	public static function matodo_manage() {
		
		$matodo_table = self::$wpdb->prefix . "matodo";
		if(isset($_POST['matodo_addtask']) && isset($_POST['matodo_title'])) self::matodo_addtask($_POST); //If we have a new task let's add it
		if(isset($_POST['matodo_updatetask'])) self::matodo_updatetask($_POST); //Update my task
		if(isset($_POST['matodo_comment_task'])) self::matodo_addcomment($_POST); //Add comments to tasks
		//if(isset($_POST['matodo_filter_status']) != NULL) self::matodo_manage_main($_POST['matodo_filter_status']); 
		if(isset($_POST['matodo_deletetask'])) self::matodo_deletetask($_POST['matodo_taskid']); //Update my task
		if(isset($_GET['view'])) self::matodo_view($_GET['view']);
		else if(isset($_GET['edit'])) self::matodo_edit($_GET['edit']);
		else self::matodo_manage_main();
	}


	public static function matodo_shortcode(){
		ob_start();
		$matodo_table = self::$wpdb->prefix . "matodo";
		if(isset($_POST['matodo_addtask']) && isset($_POST['matodo_title'])) self::matodo_addtask($_POST); //If we have a new task let's add it
		if(isset($_POST['matodo_updatetask'])) self::matodo_updatetask($_POST); //Update my task
		if(isset($_POST['matodo_comment_task'])) self::matodo_addcomment($_POST); //Add comments to tasks
		//if(isset($_POST['matodo_filter_status']) != NULL) self::matodo_manage_main($_POST['matodo_filter_status']); 
		if(isset($_POST['matodo_deletetask'])) self::matodo_deletetask($_POST['matodo_taskid']); //Update my task
		if(isset($_GET['view'])) self::matodo_view($_GET['view']);
		else if(isset($_GET['edit'])) self::matodo_edit($_GET['edit']);
		else self::matodo_manage_main();

		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}

	public static function matodo_settings(){
		require_once(parent::$plugin_path . 'components/settings.php');
	}
	// redirect to tasks
	public static function matodo_edit_task(int $id){
		$edit = '';
		$role = Admin::get_role();
		if($role == 'administrator' || $role == 'editor'){
			$edit = '<a href="?page=ma-todo&edit='.$id.'" >Edit</a>';
		}
		return $edit;
	}

	public static function matodo_tasks(){
		$matodo_table = self::$wpdb->prefix . "matodo";
		$user = wp_get_current_user();
		$role = $user->roles[0];
		if($role == 'administrator' || $role == 'editor'){
			$matodo_manage_items = self::$wpdb->get_results("SELECT * FROM $matodo_table ORDER BY `priority` DESC");
		} else {
			$matodo_manage_items = self::$wpdb->get_results("SELECT * FROM $matodo_table WHERE `for`=$user->ID OR `from`=$user->ID ORDER BY `priority` DESC");
		}
		$matodo_counted = count($matodo_manage_items);
			$num = 0;
				while($num != $matodo_counted) {
					switch ($matodo_manage_items[$num]->status) {
						case 4:
								echo "<tr class='success' id='todo_".$matodo_manage_items[$num]->id."'>";
							  	echo "<td>".$matodo_manage_items[$num]->id."</td>";
							  	echo "<td><span style=\"float:right; display: inline;\">".self::matodo_edit_task($matodo_manage_items[$num]->id)."</span><a href=\"?page=ma-todo&view=".$matodo_manage_items[$num]->id."\">".$matodo_manage_items[$num]->title."</a></td>";
							break;
						case 5:
								echo "<tr class= 'info' id='todo_".$matodo_manage_items[$num]->id."'>";
							  	echo "<td>".$matodo_manage_items[$num]->id."</td>";
							  	echo "<td><span style=\"float:right; display: inline;\">".self::matodo_edit_task($matodo_manage_items[$num]->id). "</span><a href=\"?page=ma-todo&view=".$matodo_manage_items[$num]->id."\">".$matodo_manage_items[$num]->title."</a></td>";
							break;
						default:
							echo "<tr id='todo_".$matodo_manage_items[$num]->id."'>";
						  	echo "<td>".$matodo_manage_items[$num]->id."</td>";
						  	echo "<td><span  style=\"float:right; display: inline;\">".self::matodo_edit_task($matodo_manage_items[$num]->id). "</span><a href=\"?page=ma-todo&view=".$matodo_manage_items[$num]->id."\">".$matodo_manage_items[$num]->title."</a></td>";
							break;
					}

				  	echo "<td>".self::matodo_from((int)$matodo_manage_items[$num]->from)."</td>"; //we have to send int not strings
				  	echo "<td>".self::matodo_from((int)$matodo_manage_items[$num]->for)."</td>";
				  	echo "<td>".self::matodo_status($matodo_manage_items[$num]->status)."</td>";
				  	echo '<td><button onclick="deleteItem('.$matodo_manage_items[$num]->id.')">Delete</button></td>';
				  	echo "</tr>";
				  	echo "";
				  	$num++;
				}
	}	
}