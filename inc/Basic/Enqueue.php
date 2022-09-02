<?php
/**
* @package managementtodo
*/
namespace Inc\Basic;

use \Inc\Basic\BasicController;

class Enqueue extends BasicController
{
	
	public function register(){
		add_action('admin_enqueue_scripts', array($this, 'enqueue'),9999);

		add_action('wp_enqueue_scripts', array($this, 'enqueue'),9999);

		add_action("wp_ajax_delete_todo_item", array( $this, "delete_matodo_item") );
		add_action("wp_ajax_nopriv_delete_todo_item", array( $this, "delete_matodo_item"));
	}

	public function enqueue(){
		wp_enqueue_style('datatable', parent::$plugin_url . 'scripts/DataTables/datatables.min.css');
		wp_enqueue_style('jquery-ui', parent::$plugin_url . 'scripts/jquery-ui/jquery-ui.min.css');
		wp_enqueue_style('style', parent::$plugin_url . 'scripts/css/custome-style.css');
		
		wp_enqueue_script('datatable', parent::$plugin_url . 'scripts/DataTables/datatables.min.js', array(), false, true);
		wp_enqueue_script('jquery-ui', parent::$plugin_url . 'scripts/jquery-ui/jquery-ui.min.js', array(), false, true);
		wp_enqueue_script( 'ajax-script', parent::$plugin_url . 'scripts/js/script.js', array('jquery') );
      	wp_localize_script( 'ajax-script', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}

	public function delete_matodo_item(){
		global $wpdb;
		$id = $_REQUEST['item_id'];
		if( isset($id) ) {
			$matodo_table = $wpdb->prefix . "matodo";
			$matodo_comments_table = $wpdb->prefix . "matodo_comments";
			$q = $wpdb->query("DELETE FROM `".$matodo_table."` WHERE `id`=$id");
			$wpdb->query("DELETE FROM `".$matodo_comments_table."` WHERE `task`=$id");
			$result['type'] = "success";
			$result = json_encode($result);
	  		echo $result;		
	  	}
		die();
	}

}