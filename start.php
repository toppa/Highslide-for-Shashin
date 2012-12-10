<?php
/*
Plugin Name: Highslide for Shashin
Plugin URI: http://www.toppa.com/highslide-for-shashin-wordpress-plugin/
Description: A plugin for integrating Highslide with Shashin.
Author: Michael Toppa
Version: 1.1
Author URI: http://www.toppa.com
*/

$hfsAutoLoaderPath = dirname(__FILE__) . '/../toppa-plugin-libraries-for-wordpress/ToppaAutoLoaderWp.php';
add_action('admin_init', 'hfsDeactivateIfNeeded');
add_action('wpmu_new_blog', 'hsfActivateForNewNetworkSite');
register_activation_hook(__FILE__, 'hfsActivate');
load_plugin_textdomain('hfs', false, basename(dirname(__FILE__)) . '/Languages/');

if (file_exists($hfsAutoLoaderPath)) {
    require_once($hfsAutoLoaderPath);
    $hfsToppaAutoLoader = new ToppaAutoLoaderWp('/toppa-plugin-libraries-for-wordpress');
    $hfsAutoLoader = new ToppaAutoLoaderWp('/highslide-for-shashin');
    $hfs = new HighslideForShashin();
    $hfs->run();
}

function hfsDeactivateIfNeeded() {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    if (!is_plugin_active('shashin/start.php')) {
        deactivate_plugins('highslide-for-shashin/start.php');
    }
}

function hfsActivateForNewNetworkSite($blog_id) {
    global $wpdb;

    if (is_plugin_active_for_network(__FILE__)) {
        $old_blog = $wpdb->blogid;
        switch_to_blog($blog_id);
        hfsActivate();
        switch_to_blog($old_blog);
    }
}

function hfsActivate() {
    $autoLoaderPath = dirname(__FILE__) . '/../toppa-plugin-libraries-for-wordpress/ToppaAutoLoaderWp.php';
    $shashinPath = dirname(__FILE__) . '/../shashin/start.php';

    if (!file_exists($autoLoaderPath)) {
        $message = __('To activate Highslide for Shashin you need to first install', 'hfs')
            . ' <a href="http://wordpress.org/extend/plugins/toppa-plugin-libraries-for-wordpress/">Toppa Plugins Libraries for WordPress</a>';
        hfsCancelActivation($message);
    }

    elseif (!file_exists($shashinPath)) {
        $message = __('To activate Highslide for Shashin you need to first install', 'hfs')
            . ' <a href="http://wordpress.org/extend/plugins/shashin/">Shashin</a>';
        hfsCancelActivation($message);
    }

    elseif (!function_exists('spl_autoload_register')) {
        hfsCancelActivation(__('You must have at least PHP 5.1.2 to use Highslide for Shashin', 'hfs'));
    }

    elseif (version_compare(get_bloginfo('version'), '3.0', '<')) {
        hfsCancelActivation(__('You must have at least WordPress 3.0 to use Highslide for Shashin', 'hfs'));
    }

    else {
        require_once($autoLoaderPath);
        $toppaAutoLoader = new ToppaAutoLoaderWp('/toppa-plugin-libraries-for-wordpress');
        $hfsAutoLoader = new ToppaAutoLoaderWp('/highslide-for-shashin');
        $hfs = new HighslideForShashin();
        $status = $hfs->install();

        if (is_string($status)) {
            hfsCancelActivation($status);
        }
    }
}

function hfsCancelActivation($message) {
    deactivate_plugins('highslide-for-shashin/start.php');
    wp_die($message);
}
