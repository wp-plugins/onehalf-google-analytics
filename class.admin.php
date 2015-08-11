<?php
defined('ABSPATH') or die('No access!');

if (!class_exists('OHGoogleAnalytics_Admin')) {
    /**
     * Class OHGoogleAnalytics_Admin
     */
    class OHGoogleAnalytics_Admin
    {
        private static $initiated = false;

        /**
         * Initialize class
         */
        public static function init()
        {
            if (!self::$initiated) {
                self::init_hooks();
            }
        }

        /**
         * Initialize WordPress hooks
         */
        private static function init_hooks()
        {
            self::$initiated = true;

            add_action('admin_menu', array('OHGoogleAnalytics_Admin', 'admin_menu'));
        }

        /**
         * Setup admin menu
         */
        public static function admin_menu()
        {
            /* Main menu */
            add_menu_page(
                OHGoogleAnalytics::$name,
                OHGoogleAnalytics::$name,
                'manage_options',
                OHGoogleAnalytics::$name,
                array('OHGoogleAnalytics_Admin', 'admin_page_main')
            );
        }

        /**
         * Display admin main page
         */
        public static function admin_page_main()
        {
            if (isset($_POST['action'])) {
                if(isset($_POST['OHGoogleAnalytics_Enabled']) && $_POST['OHGoogleAnalytics_Enabled'] > 0) {
                    if (trim($_POST['OHGoogleAnalytics_Google_Analytics_ID']) != '') {
                        update_option('OHGoogleAnalytics_Enabled', 1, true);
                    } else {
                        $message = 'Can\'t activate plugin with empty Google Analytics ID.';
                    }
                } else {
                    update_option('OHGoogleAnalytics_Enabled', 0, true);
                }

                update_option('OHGoogleAnalytics_Google_Analytics_ID', esc_attr($_POST['OHGoogleAnalytics_Google_Analytics_ID']), true);
            }

            include(plugin_dir_path(__FILE__) . 'admin-main.php');
        }
    }
}