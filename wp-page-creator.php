<?php
/*
Plugin Name: Wordpress Page creator
Description: Creates New page panel from where admin can add new pages.
Version: 1.0
Author: james

*/

	    define('WP_PAGE_PLUGIN_DIR', dirname( __FILE__ ));
		define('WP_PAGE_PLUGIN_FILE',__FILE__);
		define('WP_PAGE_PLUGIN_URL',plugins_url( '' , __FILE__ ));

	//Actions and Filters	
		//Add Actions
		add_action('admin_menu', 'wp_add_page');
		if(isset($_GET['page'])&&$_GET['page']=='wp_add_page'){
			add_action('admin_print_scripts', 'wp_add_script');
			add_action('admin_print_styles', 'wp_add_style');
		}
	
	function wp_add_page(){
		//add the options page for this plugin
		add_menu_page(' WP Page ',' WP Page ','manage_options','wp_add_page','wp_add_page_create');
	}
	
	function wp_add_script(){
		wp_register_script('wp-js', WP_PAGE_PLUGIN_URL.'/wp-page-script.js', array('jquery'));
		wp_enqueue_script('wp-js');
	}
	
	function wp_add_style(){
		wp_register_style('wp-css',WP_PAGE_PLUGIN_URL.'/wp-page-style.css');
		wp_enqueue_style('wp-css');
	}
	
	function wp_add_page_create()
	{
	 require( dirname( __FILE__ ) . '/add_page.php' );
	}
?>
