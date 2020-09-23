=== Widgets in Columns ===
Contributors: shazdeh
Plugin Name: Widgets in Columns
Tags: widget, admin, columns
Requires at least: 3.5
Tested up to: 3.9.1
Stable tag: 0.2.4

Using this plugin you can show your widgets in desired columns and rows. You can also display an icon beside the widget.

== Description ==

This plugin adds two options for widgets, one to set the width of the widget and also an option to show an icon beside the widget. You can define new rows of widgets using the Divider widget. Supports RTL layouts as well.

== Installation ==

1. Upload the whole plugin directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. That's it. All the configuring is in the usual widget admin interface.
4. Enjoy!

== Screenshots ==

1. New Width and Icon options added to widgets. There's also a Divider widget to break widgets in a new row.
2. Preview in 2011 theme

== Changelog ==

= 0.2.4 =
* Fixed a bug where the widget icon did not show when the Width of the widget was default
* Removed PHP notices
* New media uploader

= 0.2.3 =
* Fixed a small bug: double clear div output

= 0.2.2 =
* Changed 'dynamic_sidebar_params' hook's priority to make sure the wrapper divs will wrap everything else.

= 0.2.1 =
* Fixed a minor bug where, when no width option was set, the plugin would output an ampty div around the widget

= 0.2 =
* Added the Spacer widget
* Fixed a bug for widgets which had more than one digit ID
* Added the upload button for icon field