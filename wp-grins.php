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

// Prototype is licenced as MIT, which is compatible with GPL - http://www.gnu.org/licenses/license-list.html#Expat


/*
Plugin Name: WP Grins SSL
Plugin URI: http://wordpress.org/extend/plugins/wp-grins-ssl
Description: A Clickable Smilies hack for WordPress.
Version: 3.1
Author: Alex King, Ronald Huereca, Mika Epstein
Author URI: http://www.ipstenu.org
Props:  Original author, Alex King.  Original fork, Ronald Huereca
*/

function wp_grins() { // left in for legacy reasons
	print('');
}

function wp_grins_head() {
	print('<script type="text/javascript" src="'.get_bloginfo('wpurl').'/index.php?ak_action=wp_grins_js"></script>'."\n");
        wp_enqueue_style('wp-grins', plugins_url('wp-grins-ssl/wp-grins.css'));
}

function wp_grins_js() {
	if (function_exists('wp_enqueue_script')) {
		wp_enqueue_script('prototype');
	}
	if (isset($_GET['ak_action']) && $_GET['ak_action'] == 'wp_grins_js') {
		global $wpsmiliestrans;

		header("Content-type: text/javascript");
	
		$grins = '';
		$smiled = array();
		foreach ($wpsmiliestrans as $tag => $grin) {
			if (!in_array($grin, $smiled)) {
				$smiled[] = $grin;
				$tag = str_replace(' ', '', $tag);
				$grins .= '<img src="'.get_bloginfo('wpurl').'/wp-includes/images/smilies/'.$grin.'" alt="'.$tag.'" onclick="grin(\''.$tag.'\');"/> ';
			}
		}

?>
function insertAfter(node, referenceNode) {
	referenceNode.parentNode.insertBefore(node, referenceNode.nextSibling);
}
function loadGrins() {
	var grinsDiv = document.createElement('div');
	grinsDiv.id = 'wp_grins';
	grinsDiv.innerHTML = '<?php print(str_replace("'", "\'", $grins)); ?>';
	if ($('postdiv')) {
		var type = 'child';
		var node = $('postdiv');
	}
	else if (document.getElementById('postdivrich')) {
		var type = 'child';
		var node = $('postdivrich');
	}
	else if (document.getElementById('comment')) {
		var type = 'before';
		var node = $('comment');
	}
	else {
		return;
	}
	switch (type) {
		case 'child':
			grinsDiv.style.paddingTop = '5px';
			node.appendChild(grinsDiv);
			break;
		case 'before':
			node.parentNode.insertBefore(grinsDiv, node);
			break;
	}
}
Event.observe(window, 'load', loadGrins, false);
function grin(tag) {
	var myField;
	if ($('content') && $('content').type == 'textarea') {
		myField = document.getElementById('content');
		if ($('postdivrich') && typeof tinyMCE != 'undefined' && (!$('edButtons') || $('quicktags').style.display == 'none')) {
			tinyMCE.execInstanceCommand('mce_editor_0', 'mceInsertContent', false, '&nbsp;' + tag + '&nbsp;');
			tinyMCE.selectedInstance.repaint();
			return;
		}
	}
	else if ($('comment') && $('comment').type == 'textarea') {
		myField = $('comment');
	}
	else {
		return false;
	}
	if (document.selection) {
		myField.focus();
		sel = document.selection.createRange();
		sel.text = ' ' + tag + ' ';
		myField.focus();
	}
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		var cursorPos = endPos;
		myField.value = myField.value.substring(0, startPos)
					  + ' ' + tag + ' '
					  + myField.value.substring(endPos, myField.value.length);
		cursorPos += tag.length + 2;
		myField.focus();
		myField.selectionStart = cursorPos;
		myField.selectionEnd = cursorPos;
	}
	else {
		myField.value += tag;
		myField.focus();
	}
}
<?php
		die();
	}
}

add_action('init', 'wp_grins_js');
add_action('wp_head', 'wp_grins_head');

// donate link on manage plugin page
add_filter('plugin_row_meta', 'execphp_donate_link', 10, 2);
function execphp_donate_link($links, $file) {
	if ($file == plugin_basename(__FILE__)) {
		$donate_link = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=ipstenu%40ipstenu%2eorg">Donate</a>';
		$links[] = $donate_link;
	}
	return $links;
}

?>
