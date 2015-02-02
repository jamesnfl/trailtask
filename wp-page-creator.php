<?php
/*
Plugin Name: wp Page 
Plugin URI: wp_page
Description: site.
Version: 1.0
Author: james
Author URI: 

*/
if (!class_exists("wp_add_page_creator")) {
	class wp_add_page_creator{
		//the constructor that initializes the class
		function wp_add_page_creator() {
		
		}
	}
	
	//initialize the class to a variable
	$wp_addvar = new wp_add_page_creator();
	
	//Actions and Filters	
	if (isset($wp_addvar)) {
		//Add Actions
		add_action('admin_menu', 'wp_add_page');
		if(isset($_GET['page'])&&$_GET['page']=='wp_add_page'){
			add_action('admin_print_scripts', 'wp_add_script');
			add_action('admin_print_styles', 'wp_add_style');
		}
	}
	
	function wp_add_page(){
		//add the options page for this plugin
		add_menu_page(' WP Page ',' WP Page ','manage_options','wp_add_page','wp_add_page_create');
	}
	
	function wp_add_script(){
		wp_register_script('wp-js', WP_PLUGIN_URL.'/wp-page-creator/my-script.js', array('jquery'));
		wp_enqueue_script('wp-js');
	}
	
	function wp_add_style(){
		wp_register_style('wp-css',WP_PLUGIN_URL.'/wp-page-creator/my-style.css');
		wp_enqueue_style('wp-css');
	}
	
	function wp_add_page_create()
	{
	 require( dirname( __FILE__ ) . '/add_page.php' );
	}
}
?>
