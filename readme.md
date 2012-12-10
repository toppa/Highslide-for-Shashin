Highslide for Shashin
=====================

Contributors: toppa
Donate link: http://www.toppa.com/highslide-for-shashin-wordpress-plugin
Requires at least: 3.0
Tested up to: 3.4
Stable tag: 1.1
License: Split - GPLv2 or later; Creative Commons for Highslide itself - see below

_Highslide for Shashin_ allows you to use Highslide with the Shashin plugin for WordPress.

Description
-----------

**Installation of [Shashin](http://wordpress.org/extend/plugins/shashin/) is required. Please download and activate it before installing _Highslide for Shashin_.**

_Highslide for Shashin_ installs as its own plugin. After you install it, "Highslide" will be available as a viewer option on the Shashin settings page. It also has its own settings page for Highslide's settings.

This plugin has a split license:

* All files in the directory shashin/Public/Display/highslide fall under [these license terms](http://www.highslide.com/#license). **It is important to note that Highslide is free for non-commercial use only.** Please follow the license terms link for further information.
* All other files are GPLv2
* Based on [this entry in the GPL FAQ](http://www.gnu.org/licenses/gpl-faq.html#GPLAndPlugins), it is my understanding that distributing this plugin under a split license is valid under the terms of GPLv2, as Highslide functions as an optional add-on to Shashin, and is invoked through 2 lines of code (one for Highslide's .js file and one for its .css file).

Installation
------------

**Requirements**

* Wordpress 3.0 or higher
* Shashin 3.1 or higher
* PHP 5.1.2 or higher
* mySQL 4.1 or higher

**First time installation**

1. If you don't have Shashin yet, download and activate [Shashin](http://wordpress.org/extend/plugins/shashin/).
1. Download [Highslide for Shashin](https://github.com/downloads/toppa/Highslide-for-Shashin/highslide-for-shashin.zip)
1. Unzip it, and use FTP to copy the "highslide-for-shashin" folder to your plugin directory. See the WordPress [Manual Plugin Installation instructions](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation) if you need more details.
1. Activate _Highslide for Shashin_ on your plugin admin page
1. Go to the Shashin Settings Menu and select the new option to use Highslide as the viewer
1. Go to the _Highslide for Shashin_ settings menu to configure Highslide as desired

Frequently Asked Questions
--------------------------

Please go to [the _Highslide for Shashin_ page on my site](http://www.toppa.com/highslide-for-shashin-wordpress-plugin) for a Usage Guide and other information.

For troubleshooting help, please [post a comment on my latest support post](http://www.toppa.com/category/wordpress-plugins/support/).

Changelog
---------

**1.1:** Bug fix: deactivate if Shashin is deactivated (to prevent WP from locking up)
**1.0:** First release
