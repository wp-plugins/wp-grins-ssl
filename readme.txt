=== WP Grins SSL ===
Tags: clickable, smilies, comments, admin, wpgrins
Contributors: alexkingorg,ronalfy,ipstenu
Requires at least: 3.0
Tested up to: 3.3
Stable tag: 2.0
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5227973

WP Grins SSL provides smilies for your comment area and is compatible with SSL Administration.

== Description ==

WP Grins SSL will provide clickable smilies for both the post form in the admin interface and the comments form of your blog.  WP Grins SSL is a fork of WP Grins Lite, which is a fork of WP grins, and uses the lighter footprint of the jQuery library.  It also allows for use on a site using [Administration over SSL](http://codex.wordpress.org/Administration_Over_SSL).

== Installation ==

No special installation procedures required.

== Changelog ==

= 2.0 =
* Released 21 September 2011 by Ipstenu
* Fixed issue with SSL adminstration causing the icons not to show up.
* Removed admin panel. It's 2011. If your theme doesn't have wp_head, you have other issues.
* Consolidated stylesheets (dropping support for IE 6).
* Renamed files and pulled into one directory.
* Compressed files.

= 1.1 = 
* Released 04 November 2009 by Ronalfy
* Fixed bug where grins would show up in the comments panel.
* Re-did the JavaScript to it's completely separate and only runs when necessary.
* Added admin panel option to manual insert smilies on a page or a post.

= 1.0 = 
* Released 25 October 2009 by Ronalfy
* First release.  Yay!

== Screenshots ==

== Usage ==
Click on the smilies icons to insert their tags into the text field.

== Frequently Asked Questions ==

= Why don't the smilies show up in my comments form? =
Your theme must include the `wp_head` call and the comments field in your theme must have an id of `comment`.  This version of the plugin does not support manual insertion, because, frankly, no decent WordPress theme is lacking `wp_head` anymore.

= Why did this start with version 2? =
Because the previous fork-source was 1.0, and this is really just an extension of all that work.  Wanted to keep Ronafly's credits up in there!
