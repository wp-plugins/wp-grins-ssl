<?php

// WP Grins SSL
//
// Original plugin WP Grins
// Copyright (c) 2004-2007 Alex King
// http://alexking.org/projects/wordpress
//
// SSL version created on June 20, 2008 by Ronald Huereca
// SSL version created on Sept 21, 2011 by Mika "Ipstenu" Epstein
// Copyright 20011 Mika Epstein (email: ipstenu@ipstenu.org)
//
// This is an add-on for WordPress
// http://wordpress.org/
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// *****************************************************************

/*
Plugin Name: WP Grins SSL
Plugin URI: http://tech.ipstenu.org/my-plugins/wp-grins-ssl
Description: A Clickable Smilies hack for WordPress.
Version: 2.0
Author: Alex King, Ronald Huereca, Mika Epstein
Author URI: http://www.ronalfy.com
Props:  Original author, Alex King.  Original fork, Ronald Huereca
*/

if (!class_exists('WPGrins')) {
    class WPGrins	{
		var $adminOptionsName = "wpgrinsssl";
		/**
		* PHP 4 Compatible Constructor
		*/
		function WPGrins(){$this->__construct();}
		
		/**
		* PHP 5 Constructor
		*/		
		function __construct(){
			//Scripts
			add_action('admin_print_scripts-post.php', array(&$this,'add_scripts'),1000); 
			add_action('admin_print_scripts-post-new.php', array(&$this,'add_scripts'),1000); 
			add_action('admin_print_scripts-page.php', array(&$this,'add_scripts'),1000); 
			add_action('admin_print_scripts-page-new.php', array(&$this,'add_scripts'),1000); 
			add_action('admin_print_scripts-comment.php', array(&$this,'add_scripts'),1000); 
			add_action('wp_print_scripts', array(&$this,'add_scripts_frontend'),1000);
			//Styles
			add_action('admin_print_styles-post.php', array(&$this,'add_styles'),1000); 
			add_action('admin_print_styles-post-new.php', array(&$this,'add_styles'),1000); 
			add_action('admin_print_styles-page.php', array(&$this,'add_styles'),1000); 
			add_action('admin_print_styles-page-new.php', array(&$this,'add_styles'),1000); 
			add_action('admin_print_styles-comment.php', array(&$this,'add_styles'),1000);
			add_action('wp_print_styles', array(&$this,'add_styles_frontend'));
			
			//Ajax
			add_action('wp_ajax_grins', array(&$this,'ajax_print_grins'));
			add_action('wp_ajax_nopriv_grins', array(&$this,'ajax_print_grins')); 
			
			//Admin options
			//add_action('admin_menu', array(&$this,'add_admin_pages'));
			//$this->adminOptions = $this->get_admin_options();
		}
		function ajax_print_grins() {
			echo $this->wp_grins();
			exit;
		}
		function wp_grins() {
				global $wpsmiliestrans;
				$grins = '';
				$smiled = array();
				foreach ($wpsmiliestrans as $tag => $grin) {
					if (!in_array($grin, $smiled)) {
						$smiled[] = $grin;
						$tag = esc_attr(str_replace(' ', '', $tag));
						$src = esc_url(site_url("wp-includes/images/smilies/{$grin}", "http"));
						$grins .= "<img src='$src' alt='$tag' onclick='jQuery.wpgrins.grin(\"$tag\");' />";
					}
				}
				return $grins;
		} //end function wp_grins
		
		function add_styles() {
			wp_enqueue_style('wp-grins', plugins_url('wp-grins-ssl/wp-grins.css'));
		}
		function add_styles_frontend() {
			if (!is_admin()) {
				if ((!is_single() && !is_page()) || 'closed' == $post->comment_status) {
					return;
				} 
				$this->add_styles();
			}
		}
		function add_scripts(){
			wp_enqueue_script('wp_grins_ssl', plugins_url('wp-grins-ssl/wp-grins.js'), array("jquery"), 1.0); 
			wp_localize_script( 'wp_grins_ssl', 'wpgrinsssl', $this->get_js_vars());
		}
		function add_scripts_frontend() {
			//Make sure the scripts are included only on the front-end
			if (!is_admin()) {
				if ((!is_single() && !is_page()) || 'closed' == $post->comment_status) {
					return;
				} 
				$this->add_scripts();
			}
		}
		//Returns various JavaScript vars needed for the scripts
		function get_js_vars() {
			if (is_admin()) {
				return array(
					'Ajax_Url' => admin_url('admin-ajax.php', 'http'),
					'LOCATION' => 'admin',
					'MANUAL' => 'false'
				);
			}
			return array(
					'Ajax_Url' => admin_url('admin-ajax.php', 'http'),
					'LOCATION' => 'post',
					'MANUAL' => esc_js($this->adminOptions['manualinsert'])
			);
		} //end get_js_vars
		
		/*END UTILITY FUNCTIONS*/
    }
}
//instantiate the class
if (class_exists('WPGrins')) {
	$GrinsSSL = new WPGrins();
}
// left in for legacy reasons
if (!function_exists('wp_grins')) {
	function wp_grins() { 
		print('');
	}
}
if (!function_exists('wp_print_grins')) {
	function wp_print_grins() {
		global $GrinsSSL;
		if (isset($GrinsSSL)) {
			return $GrinsSSL->wp_grins();
		}
	}
}
?>