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
Plugin URI: http://halfelf.org/plugins/wp-grins-ssl
Description: A Clickable Smilies hack for WordPress.
Version: 4.1
Author: Alex King, Ronald Huereca, Mika Epstein
Author URI: http://www.ipstenu.org
Props:  Original author, Alex King.  Original fork, Ronald Huereca
*/

if (!class_exists('WPGrins')) {
    class WPGrins	{
		/**
		* PHP 5 Constructor
		*/		
		function __construct(){
			//Scripts
			add_action('wp_print_scripts', array(&$this,'add_scripts_frontend'),1000);
			//Styles
			add_action('wp_print_styles', array(&$this,'add_styles_frontend'));
			
			//Ajax
			add_action('wp_ajax_grins', array(&$this,'ajax_print_grins'));
			add_action('wp_ajax_nopriv_grins', array(&$this,'ajax_print_grins')); 
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
				elseif ( function_exists('is_bbpress') && ( ( $valuebb == '0') || is_null($valuebb) ) ) {
					return;
				}
				elseif ( ( $valueco == '0') || is_null($valueco) ) {
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
                if (is_ssl()) {
                   	$schema_ssl = 'https'; 
                } else { 
                   	$schema_ssl = 'http'; 
                }
                return array(
                    'Ajax_Url' => admin_url('admin-ajax.php', $schema_ssl),
                    'LOCATION' => 'admin'
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

// Register and define the settings
add_action('admin_init', 'ippy_wpgs_admin_init');

function ippy_wpgs_admin_init(){

	register_setting(
		'discussion',               // settings page
		'ippy_wpgs_options'         // option name
	);
	
	add_settings_field(
		'ippy_wpgs_bbpress',        // id
		'Smilies',                  // setting title
		'ippy_wpgs_setting_input',  // display callback
		'discussion',               // settings page
		'default'                   // settings section
	);
	
	$options = get_option( 'ippy_wpgs_options' );
	$options['comments'] = '1';
	$options['bbpress'] = '0';
	update_option('ippy_wpgs_options', $options);
}

// Display and fill the form field
function ippy_wpgs_setting_input() {
	// get option value from the database
	$options = get_option( 'ippy_wpgs_options' );
	$valuebb = $options['bbpress'];
	$valueco = $options['comments'];
	
	// echo the field
	?>
<p><?php if ( function_exists('is_bbpress') ) { ?>
<input id='bbpress' name='ippy_wpgs_options[bbpress]' type='checkbox' value='<?php echo $valuebb; ?>' <?php if ( ( $valuebb != '0') && !is_null($valuebb) ) { echo ' checked="checked"'; } ?> /> Activate Smilies on bbPress<br /> <?php } ?>
<input id='comments' name='ippy_wpgs_options[comments]' type='checkbox' value='<?php echo $valuebb; ?>' <?php if ( ( $valueco != '0') && !is_null($valueco) ) { echo ' checked="checked"'; } ?> /> Activate Smilies on comments

	<?php
}