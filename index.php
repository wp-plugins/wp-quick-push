<?php
/**
 * @package WP_QUICK_PUSH
 * @version 1.01
 */
/*
Plugin Name: WP Quick Push
Plugin URI: http://wordpress.org/plugins/wp-quick-push/
Description: Quickly send notification to Push enabled devices from WordPress dashboard. The Plugin also facilitates customized JSON data support for your applications.  Currently supporting only Parse.com Push Service (for iOS, Android, Windows etc.). One must have cURL enabled on the host and some patience.
Author: TheCreatology
Version: 1.01
Author URI: http://www.thecreatology.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if (!defined('WQP_VERSION')) define('WQP_VERSION', '1.01');

/* Trigger Dependencies */
function quickpush_admin_init() {
    
    if ( !function_exists('curl_version') ) {

        function quickpush_curl_alert() {
            echo "<div id='quickpush-curl-alert' class='updated fade'><p><strong>".__("We couldn't find cURL enabled on this server. Please contact your hosting provider to enable this PHP extension.", 'quickpush_context')."</strong> </p></div>";
        }
        add_action('admin_notices', 'quickpush_curl_alert');
        
        return; 
    } else if ( get_option('quickpush_appID') == null || get_option('quickpush_restApi') == null) {
        
        function quickpush_appname_warning() {
            echo "<div id='quickpush-warn' class='updated fade'><p><strong>".sprintf(__("'WP Quick Push %s' plugin needs your attention.", 'quickpush_context'), WQP_VERSION) . sprintf(__(' <a href="%s"><u>Click here</u></a> to configure this plugin.', 'quickpush_context'), get_bloginfo('url').'/wp-admin/admin.php?page=WP-Quick-Push-Settings')."</strong></p></div>";
        }
        add_action('admin_notices', 'quickpush_appname_warning'); 
        return; 
    }
}

/* Setup WP Interface */
function quickpush_sender() {
    include('includes/quickpush_sender.php');
}
function quickpush_admin_opt() {
    include('includes/quickpush_settings.php');
}
function quickpush_admin_actions() {  
    add_menu_page("WP Quick Push", "WP Quick Push", 'manage_options', "WP-Quick-Push", "quickpush_sender" );
        $pending_notf_page = add_submenu_page( "WP-Quick-Push", "Quick Push", "Quick Push", "manage_options", "WP-Quick-Push", "quickpush_sender" );
        $pending_notf_page = add_submenu_page( "WP-Quick-Push", "Settings", "Settings", "manage_options", "WP-Quick-Push-Settings", "quickpush_admin_opt" );
    wp_enqueue_script("dashboard");
} 
/* Trigger House keeping */
function quickpush_plugin_on_uninstall(){
//Trash Everything
    delete_option('quickpush_appName');
	delete_option('quickpush_appID');
	delete_option('quickpush_restApi');
	delete_option('quickpush_enableSound');
 	delete_option('quickpush_NoChannel');
 	delete_option('quickpush_pushChannels');
}
  
/* Register Functions */
add_action('admin_init', 'quickpush_admin_init', 1);
add_action('admin_menu', 'quickpush_admin_actions');  
register_uninstall_hook(__FILE__, 'quickpush_plugin_on_uninstall');
?>