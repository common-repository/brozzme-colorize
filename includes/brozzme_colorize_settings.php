<?php


if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('bcolor_Settings')) {

    class bcolor_Settings
    {

        public function __construct() {
            add_action('admin_menu', array($this, 'add_admin_pages'), 110);
            add_action('admin_init', array($this, 'settings_fields'));

        }

        public function add_admin_pages() {
            add_submenu_page( BFSL_PLUGINS_DEV_GROUPE_ID,
                __('Colorize settings', B7E_COLORIZE_TEXT_DOMAIN),
                __('Colorize settings', B7E_COLORIZE_TEXT_DOMAIN),
                'manage_options',
                B7E_COLORIZE,
                array( $this, 'settings_page' )
            );

        }
        
        public function settings_page() {
            ?>
            <div class="wrap">
                <h2>Brozzme Colorize address bar</h2>
                <?php

                $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general_settings';
                ?>

                <h2 class="nav-tab-wrapper">
                    <a href="?page=<?php echo B7E_COLORIZE;?>&tab=general_settings" class="nav-tab <?php echo $active_tab == 'general_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'General settings', 'brozzme-colorize' );?></a>
                    <a href="admin.php?page=<?php echo B7E_COLORIZE;?>&tab=colorize_settings" class="nav-tab <?php echo $active_tab == 'colorize_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Colorize settings', 'brozzme-colorize' );?></a>

                    <a href="admin.php?page=<?php echo B7E_COLORIZE;?>&tab=help_options" class="nav-tab <?php echo $active_tab == 'help_options' ? 'nav-tab-active' : ''; ?>">Help</a>
                </h2>
                <form action='options.php' method='post'>
                    <?php
                    if( $active_tab == 'help_options' ) {
                        settings_fields('BrozzmeHelp');

                        $this->brozzme_colorize_help_page();
                    }
                    elseif( $active_tab == 'colorize_settings' ) {
                        settings_fields('BrozzmeColorizeSettings');
                        do_settings_sections('BrozzmeColorizeSettings');
                        submit_button();
                    }

                    else {
                        settings_fields('BrozzmeColorizeGeneralSettings');
                        do_settings_sections('BrozzmeColorizeGeneralSettings');
                        submit_button();
                    }

                    ?>

                </form>
            </div>
        <?php
        }


        public function settings_fields(){

            register_setting( 'BrozzmeColorizeGeneralSettings', 'bcolor_general_settings' );
            register_setting( 'BrozzmeColorizeSettings', 'bcolor_colorize_settings' );
            add_settings_section(
                'BrozzmeColorizeGeneralSettings_section',
                __( 'General settings option for Brozzme Colorize', 'brozzme-colorize' ),
                array($this, 'brozzme_colorize_general_settings_section_callback'),
                'BrozzmeColorizeGeneralSettings'
            );
            /* General settings */
            add_settings_field(
                'bcolor_enable',
                __( 'Enable Brozzme Colorize', 'brozzme-colorize' ),
                array($this, 'bcolor_enable_render'),
                'BrozzmeColorizeGeneralSettings',
                'BrozzmeColorizeGeneralSettings_section'
            );

            /* Colorize settings */
            add_settings_section(
                'BrozzmeColorizeSettings_section',
                __( 'Colorize settings', 'brozzme-colorize' ),
                array($this, 'brozzme_colorize_colorize_settings_section_callback'),
                'BrozzmeColorizeSettings'
            );
            add_settings_field(
                'bcolor_colorize_color',
                __( 'Font color', 'brozzme-colorize' ),
                array($this, 'bcolor_colorize_color_render'),
                'BrozzmeColorizeSettings',
                'BrozzmeColorizeSettings_section'
            );
            add_settings_field(
                'bcolor_ios_colorize_set',
                __( 'Ios color schema', 'brozzme-colorize' ),
                array($this, 'bcolor_ios_colorize_set_render'),
                'BrozzmeColorizeSettings',
                'BrozzmeColorizeSettings_section'
            );

        }
        public function brozzme_colorize_general_settings_section_callback(){

        }
        public function brozzme_colorize_colorize_settings_section_callback(){

        }
        // general settings
        function bcolor_enable_render (){
            $options = get_option( 'bcolor_general_settings' );
            ?>
            <select name="bcolor_general_settings[bcolor_enable]">
                <option value="true" <?php if ( $options['bcolor_enable'] == 'true' ) echo 'selected="selected"'; ?>><?php _e( 'Yes', 'brozzme-colorize' );?></option>
                <option value="false" <?php if ( $options['bcolor_enable'] == 'false' ) echo 'selected="selected"'; ?>><?php _e( 'No', 'brozzme-colorize' );?></option>

            </select>
        <?php
        }

        // Colorize styling settings
        public function bcolor_colorize_color_render(){
            $options = get_option( 'bcolor_colorize_settings' );
            ?>
            <input type='text' name='bcolor_colorize_settings[bcolor_colorize_color]' value='<?php echo $options['bcolor_colorize_color']; ?>' class='color-field'>
            <p><?php _e('This color will not works on ios', 'brozzme-colorize');?></p>
        <?php


        }
        public function bcolor_ios_colorize_set_render(){

            $options = get_option( 'bcolor_colorize_settings' );
            ?>
            <select name="bcolor_colorize_settings[bcolor_ios_colorize_set]">
                <option value="default" <?php if ( $options['bcolor_ios_colorize_set'] == 'default' ) echo 'selected="selected"'; ?>><?php _e( 'Default', 'brozzme-colorize' );?></option>
                <option value="black-translucent" <?php if ( $options['bcolor_ios_colorize_set'] == 'black-translucent' ) echo 'selected="selected"'; ?>><?php _e( 'Black translucent', 'brozzme-colorize' );?></option>
                <option value="black" <?php if ( $options['bcolor_ios_colorize_set'] == 'black' ) echo 'selected="selected"'; ?>><?php _e( 'Black', 'brozzme-colorize' );?></option>

            </select>
            <p><?php _e('If set to default, the status bar appears normal. If set to black, the status bar has a black background. If set to black-translucent, the status bar is black and translucent. If set to default or black, the web content is displayed below the status bar. If set to black-translucent, the web content is displayed on the entire screen, partially obscured by the status bar.', 'brozzme-colorize');?></p>
            <?php
        }

        public function brozzme_colorize_help_page(){
            ?>
            <div class="wrap">

                <h2><?php _e('Brozzme Colorize : HELP & Behaviours', 'brozzme-colorize');?></h2>

                <p><?php _e('Simply add colors to post and mobile address bar.', 'brozzme-colorize');?></p>
                <p><?php _e('This plugin will only works fine with Android, Windows Phone, but not with Ios. This functionnality has a different behaviour on ios, colour are not available with this support and only a translucent behaviour will be shown. Hope the ios webkit will change soon, I will make any update of in the option settings and class to make it available. For more informations, read details in the colorize settings panel','brozzme-colorize');?></p>
                <p><?php _e('To get more customization, you can search for Brozzme Material Loading plugin on the WordPress directory.', 'brozzme-colorize');?></p>
            </div>
        <?php

        }

    }
}