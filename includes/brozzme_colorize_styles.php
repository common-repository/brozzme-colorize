<?php
if (!defined('ABSPATH')) {
    exit;
}

class bcolor_colorize_Styles {


    public function __construct()
    {
        add_action('wp_head', array($this, 'bcolor_colorize_styles'));

    }

    public function bcolor_colorize_styles(){
        $options = get_option('bcolor_colorize_settings');

        $color = $options['bcolor_colorize_color'];
        $ios_color = $options['bcolor_ios_colorize_set'];
        // this is for Chrome, Firefox OS, Opera and Vivaldi
        echo '<meta name="theme-color" content="'.$color.'">
        ';
        // Windows Phone **
        echo '<meta name="msapplication-navbutton-color" content="'.$color.'">
        ';
        // iOS Safari
        echo '<meta name="apple-mobile-web-app-capable" content="yes">
        ';
        echo '<meta name="apple-mobile-web-app-status-bar-style" content="'.$ios_color.'">
        ';

    }

}