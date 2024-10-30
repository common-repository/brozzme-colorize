<?php
/**
 * Plugin Name: Brozzme Colorize Bar
 * Plugin URI: https://brozzme.com/colorize-bar/
 * Description: Simply add colors to mobile address bar
 * Version: 1.00
 * Author: Benoti
 * Author URI: https://brozzme.com
 * text-domain: brozzme-colorize
 */

if ( !defined( 'ABSPATH' ) ) exit ( 'restricted access' );

class brozzme_colorize_start {

        public function __construct() {

            // Define plugin constants
            $this->basename			 = plugin_basename( __FILE__ );
            $this->directory_path    = plugin_dir_path( __FILE__ );
            $this->directory_url	 = plugins_url( dirname( $this->basename ) );

            // group menu ID
            $this->plugin_dev_group = 'Brozzme';
            $this->plugin_dev_group_id = 'brozzme-plugins';

            // plugin info
            $this->plugin_name = 'brozzme-colorize';
            $this->settings_page_slug = 'brozzme-colorize-settings';
            $this->tools_page_slug = 'brozzme-colorize-main';
            $this->plugin_version = '1.0';
            $this->plugin_text_domain = 'brozzme-colorize';

            $this->_define_constants();
            $this->_init();
            // Run our activation and deactivation hooks
            register_activation_hook( __FILE__, array( $this, 'activate' ) );
            register_deactivation_hook( __FILE__, array($this, 'deactivate') );


        }

        public function _define_constants(){

            defined('BFSL_PLUGINS_DEV_GROUPE')    or define('BFSL_PLUGINS_DEV_GROUPE', $this->plugin_dev_group);
            defined('BFSL_PLUGINS_DEV_GROUPE_ID') or define('BFSL_PLUGINS_DEV_GROUPE_ID', $this->plugin_dev_group_id);

            defined('B7E_COLORIZE')    or define('B7E_COLORIZE', $this->plugin_name);
            defined('B7E_COLORIZE_SLUG')  or define('B7E_COLORIZE_SLUG', $this->settings_page_slug);
            defined('B7E_COLORIZE_TOOLS')  or define('B7E_COLORIZE_TOOLS', $this->tools_page_slug);
            defined('B7E_COLORIZE_DIR')    or define('B7E_COLORIZE_DIR', $this->directory_path);
            defined('B7E_COLORIZE_DIR_URL')    or define('B7E_COLORIZE_DIR_URL', $this->directory_url);
            defined('B7E_COLORIZE_VERSION')        or define('B7E_COLORIZE_VERSION', $this->plugin_version);
            defined('B7E_COLORIZE_TEXT_DOMAIN')    or define('B7E_COLORIZE_TEXT_DOMAIN', $this->plugin_text_domain);
        }

        public function _init() {

            if (!class_exists('bfsl_page_plugins')){
                include_once ($this->directory_path . 'includes/plugins_page.php');
            }
            $this->admin_page();

           // $this->load_meta_box();

            // Load translations
            load_plugin_textdomain( 'brozzme-colorize', false, dirname( $this->basename ) . '/languages' );

            add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, '_plugin_action_links' ) );

            add_action( 'wp_enqueue_scripts', array( $this, 'load_front_ressources' ) );

            add_action( 'admin_enqueue_scripts', array( $this, 'add_color_picker' ) );


        }
        private function admin_page() {
            include_once $this->directory_path . 'includes/brozzme_colorize_settings.php';
            new bcolor_Settings();
        }

        public function activate() {

            if ( !get_option('bcolor_general_settings') ) {
                $arg = array(
                    'bcolor_enable'            => 'true', // set to 1 to enable plugin

                );
                add_option( 'bcolor_general_settings', $arg );
            }
            if ( !get_option('bcolor_colorize_settings') ) {
                $arg = array(
                    'bcolor_colorize_color'             => '#ff6400',
                    'bcolor_ios_colorize_set'           => 'black-translucent'
                );
                add_option( 'bcolor_colorize_settings', $arg );
            }
        }

        public function deactivate()
        {

        }
        public function register_ressources(){
           if ( !is_admin() ) {
            wp_enqueue_style('b-colorize', plugins_url('/css/style.css', __FILE__), array(), false, false);
           }

        }

        public function load_front_ressources(){
            if(!is_admin()){
                include_once $this->directory_path . 'includes/brozzme_colorize_styles.php';
                new bcolor_colorize_Styles();
            }

        }
        
        public function _plugin_action_links($links) {
    
    
            $links[] = '<a href="'. esc_url( get_admin_url(null, 'admin.php?page=' .B7E_COLORIZE ) ) .'">Settings</a>';
            $links[] = '<a href="https://brozzme.com" target="_blank">More plugins by Brozzme</a>';
    
            return $links;
        }
        

        public function add_color_picker( $hook ) {
            
            // first check that $hook_suffix is appropriate for your admin page
            if ( $hook == 'settings_page_brozzme-colorize-settings' ) {

            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'brozzme-color-picker', plugin_dir_url( __FILE__ ) . 'js/color-picker-custom.js', array( 'wp-color-picker' ), false, true );

            }
        }

}

new brozzme_colorize_start();







