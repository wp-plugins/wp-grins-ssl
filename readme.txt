=== WP Grins SSL ===
Tags: clickable, smilies, comments, bbpress, wpgrins
Contributors: alexkingorg, ronalfy, Ipstenu
Requires at least: 3.0
Tested up to: 3.4
Stable tag: 4.0
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5227973

WP Grins SSL provides smilies for your comment area and is compatible with SSL Administration.

== Description ==

WP Grins SSL will provide clickable smilies for both the post form in the admin interface and the comments form of your blog.  WP Grins SSL is a fork of WP Grins that allows for use on a site using [Administration over SSL](http://codex.wordpress.org/Administration_Over_SSL) or not, auto-detecting which is why and displaying either way.

Tested on Single Site and MultiSite.

* [Plugin Site](http://halfelf.org/plugins/wp-grins-ssl/)
* [Donate](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5227973)

== Installation ==

No special installation procedures required. 

Works on MultiSite as per-site or network activated.

== Changelog ==

= 4.0 =
* 27 April 2012 by Ipstenu
* Major bump. Why? Oh this little thing I like to call bbPress. Fully supported.

= 3.1 =
* 17 April 2012 by Ipstenu
* Trying to fix why it decides, magically, not to show up. Sometimes. Should work. Works on 3.4...

= 3.0 =
* 22 February 2012 by Ipstenu
* Reverted back to Alex's use of Prototype because something went funky cold medina with ajax.

= 2.2 =
* 1 October 2011 by Ipstenu
* Minification for faster everythinging.

= 2.1 =
* 22 September 2011 by Ipstenu
* Removing PHP 4 support (WP doesn't).
* Cleaning out unused aspects from removal of admin panel.

= 2.0 =
* 21 September 2011 by Ipstenu
* Fixed issue with SSL adminstration causing the icons not to show up.
* Removed admin panel. It's 2011. If your theme doesn't have wp_head, you have other issues.
* Consolidated stylesheets (dropping support for IE 6).
* Renamed files and pulled into one directory.
* Compressed files.

= 1.1 = 
* 04 November 2009 by Ronalfy
* Fixed bug where grins would show up in the comments panel.
* Re-did the JavaScript to it's completely separate and only runs when necessary.
* Added admin panel option to manual insert smilies on a page or a post.

= 1.0 = 
* 25 October 2009 by Ronalfy
* First release.  Yay!

== Frequently Asked Questions ==

= Why don't the smilies show up in my comments form? =
Your theme must include the `wp_head` call and the comments field in your theme must have an id of `comment`.  This version of the plugin does not support manual insertion, because, frankly, no decent WordPress theme is lacking `wp_head` anymore.

= Why did this start with version 2? =
Because the previous fork-source was 1.0, and this is really just an extension of all that work.  Wanted to keep Ronafly's credits up in there!
