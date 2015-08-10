<?php
/*
Plugin Name: jQuery Notify
Plugin URI: http://jquery-notify.mindsharelabs.com/
Description: An attractive, lightweight, and highly configurable jQuery notification pane.
Version: 0.4
Author: Mindshare Studios, Inc.
Author URI: https://mind.sh/are/
License: GPLv3

    Copyright 2012  Mindshare Studios, Inc.  (email : info@mindsharestudios.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
if(!class_exists("jQuery_Notify")) {
    class jQuery_Notify {

        private $enable_jqnm;
        private $options;
        private $in_footer = TRUE;

        //SHORTCODE PROPERTIES
        private $content;

        public function __construct() {
            add_shortcode('jq_notify', array($this, 'shortcode'));
            add_action('init', array($this, 'register_scripts'));
            add_action('wp_footer', array($this, 'print_scripts'));

            $this->options = get_option('jqn_options');
        }

        public function register_scripts() {
            wp_register_script(
                'jqnm-script',
                plugins_url('/script.js', __FILE__),
                array('jquery'),
                '1.0',
                $this->in_footer);
        }

        public function print_scripts() {
            $admin_offset = 0;

            if(!$this->enable_jqnm) {
                return;
            }

            if(is_admin_bar_showing()) {
                $admin_offset = 28;
            }

            $script_options = array('offset' => $admin_offset, 'speed' => $this->speed, 'delay' => $this->delay, 'autohide' => $this->autohide, 'hidedelay' => $this->hidedelay);

            wp_enqueue_style('jqnm-style', plugins_url('/style.css', __FILE__));
            wp_localize_script('jqnm-script', 'jqnm_script_vars', $script_options);
            wp_enqueue_script('jqnm-script');
            add_action('wp_footer', array($this, 'jqnm_output'));
        }

        //TEMPLATE TAG
        public function template_tag($content, $style, $speed, $delay) {
            $this->enable_jqnm = TRUE;
            $this->content = $content;
            $this->style = $style;
            $this->speed = $speed;
            $this->delay = $delay;

            if(!isset($this->options['auto_hide'])) {
                $this->autohide = 0;
            } else {
                $this->autohide = $this->options['auto_hide'];
            }
            $this->hidedelay = $this->options['hide_delay'];

            return $this->print_scripts();
        }

        // SHORTCODE
        public function shortcode($atts, $content = NULL) {
            $this->enable_jqnm = TRUE;
            $this->content = $content;

            if($this->options['custom_style']) {
                $style = $this->options['custom_style'];
            } else {
                $style = $this->options['style'];
            }

            extract(shortcode_atts(array(
                'style' => $style,
                'speed' => $this->options['speed'],
                'delay' => $this->options['delay']
            ), $atts));

            $this->style = $style;
            $this->speed = $speed;
            $this->delay = $delay;

            if(!isset($this->options['auto_hide'])) {
                $this->autohide = 0;
            } else {
                $this->autohide = $this->options['auto_hide'];
            }
            $this->hidedelay = $this->options['hide_delay'];

            return $this->print_scripts();
        }

        //OUTPUT HTML
        public function jqnm_output() {
            ?>
            <div class="jqnm_<?php echo $this->style; ?> jqnm_message">
                <?php
                echo $this->content;
                if($this->options['close_button']) {
                    echo '<div class="jqn-close"></div>';
                }
                ?>
            </div>        <?php }

    } // End Class jQuery_Notify
}

if(class_exists("jQuery_Notify")) {
    $jquery_notification = new jQuery_Notify();

    function jq_notify($content, $style, $speed, $delay) {
        $jquery_notification = new jQuery_Notify();
        $options = get_option('jqn_options');
        // For each property, if nothing is set, apply the default
        $style = isset($style) ? $style : $options['style'];
        $speed = isset($speed) ? $speed : $options['speed'];
        $delay = isset($delay) ? $delay : $options['delay'];
        $jquery_notification->template_tag($content, $style, $speed, $delay);
    }
}
if(is_admin()) {
    require_once('jqn-options.php');
} // include options file
