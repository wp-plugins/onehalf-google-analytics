<?php
/**
 * @package OHGoogleAnalytics
 */

/* 
Plugin Name: OneHalf Google Analytics
Plugin URI: http://semargal.com
Description: Enables Google Analytics on all blog pages.
Version: 1.0
Author: Ivan Ivanov
Author URI: http://semargal.com
License: GPLv2 or later
*/

defined('ABSPATH') or die('No access!');

if (!class_exists('OHGoogleAnalytics')) {
    /**
     * Class OHGoogleAnalytics
     */
    class OHGoogleAnalytics
    {
        public static $version = '1.0';
        public static $name = 'OH Google Analytics';

        public function __construct()
        {
            register_activation_hook(__FILE__, array('OHGoogleAnalytics', 'plugin_activate'));
            register_deactivation_hook(__FILE__, array('OHGoogleAnalytics', 'plugin_deactivate'));
            register_uninstall_hook(__FILE__, array('OHGoogleAnalytics', 'plugin_uninstall'));

            if (get_option('OHGoogleAnalytics_Enabled')) {
                add_action('wp_footer', array('OHGoogleAnalytics', 'hook_footer'));
            }

            if (is_admin()) {
                require_once(plugin_dir_path(__FILE__) . 'class.admin.php');

                add_action('init', array('OHGoogleAnalytics_Admin', 'init'));
            }
        }

        /**
         * Activate plugin
         */
        public static function plugin_activate()
        {
            self::set_option('OHGoogleAnalytics_Version', self::$version);

            /* setup default options */
            self::set_option('OHGoogleAnalytics_Enabled', '0');
        }

        /**
         * Deactivate plugin
         */
        public static function plugin_deactivate()
        {
            self::delete_options();
        }

        /**
         * Uninstall plugin
         */
        public static function plugin_uninstall()
        {
            self::delete_options();
        }

        /**
         * Delete plugin options
         */
        private static function delete_options()
        {
            delete_option('OHGoogleAnalytics_Version');

            delete_option('OHGoogleAnalytics_Enabled');
        }

        /**
         * Set option
         */
        private static function set_option($option, $value, $autoload = 'yes')
        {
            update_option($option, $value, $autoload);
        }

        /**
         * Hook footer
         */
        public static function hook_footer()
        {
            $out = "
                <script>
                  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                  ga('create', '" . esc_attr(get_option('OHGoogleAnalytics_Google_Analytics_ID')) . "', 'auto');
                  ga('send', 'pageview');

                </script>
            ";

            echo $out;
        }
    }
}

# Start plugin
$OHGoogleAnalytics = new OHGoogleAnalytics();
