<?php
/*
Plugin Name: jQuery Notify
Plugin URI: https://mindsharelabs.com/downloads/jquery-notify/
Description: An attractive, lightweight, and highly configurable jQuery notification pane.
Version: 0.5
Author: Mindshare Studios, Inc.
Author URI: https://mind.sh/are/
License: GNU General Public License v3
License URI: LICENSE
*/

/**
 *
 * Copyright 2016  Mindshare Studios, Inc. (http://mind.sh/are/)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 3, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

if (!class_exists("jQuery_Notify")) {
	/**
	 * Class jQuery_Notify
	 */
	class jQuery_Notify {

		/**
		 * @var
		 */
		public $speed;
		public $delay;
		public $autohide;
		public $style;
		public $hidedelay;
		public $close_button = TRUE;
		private $enable_jqnm;
		public $options;

		/**
		 * Output scripts in footer?
		 *
		 * @var bool
		 */
		private $in_footer = TRUE;

		/**
		 * SHORTCODE PROPERTIES
		 *
		 * @var
		 */
		private $content;

		/**
		 * jQuery_Notify constructor.
		 */
		public function __construct() {
			add_shortcode('jq_notify', array($this, 'shortcode'));
			add_action('init', array($this, 'register_scripts'));
			add_action('wp_footer', array($this, 'print_scripts'));

			$this->options = get_option('jqn_options');
		}

		/**
		 *
		 */
		public function register_scripts() {
			wp_register_script('jqnm-script', plugins_url('/script.js', __FILE__), array('jquery'), '1.0', $this->in_footer);
		}

		/**
		 *
		 */
		public function print_scripts() {
			$admin_offset = 0;

			if (!$this->enable_jqnm) {
				return;
			}

			if (is_admin_bar_showing()) {
				$admin_offset = 28;
			}

			$script_options = array(
				'offset'       => $admin_offset,
				'speed'        => $this->speed,
				'delay'        => $this->delay,
				'autohide'     => $this->autohide,
				'hidedelay'    => $this->hidedelay,
				'close_button' => $this->close_button,
			);

			wp_enqueue_style('jqnm-style', plugins_url('/css/style.css', __FILE__));
			wp_localize_script('jqnm-script', 'jqnm_script_vars', $script_options);
			wp_enqueue_script('jqnm-script');
			add_action('wp_footer', array($this, 'jqnm_output'));
		}

		/**
		 * TEMPLATE TAG
		 *
		 * @param $content
		 * @param $style
		 * @param $speed
		 * @param $delay
		 * @param $close_button
		 */
		public function template_tag($content, $style, $speed, $delay, $close_button) {
			$this->enable_jqnm = TRUE;
			$this->content = $content;
			$this->style = $style;
			$this->speed = $speed;
			$this->delay = $delay;
			$this->close_button = $close_button;

			if (!isset($this->options[ 'auto_hide' ])) {
				$this->autohide = 0;
			} else {
				$this->autohide = $this->options[ 'auto_hide' ];
			}

			if (!isset($this->options[ 'close_button' ])) {
				$this->close_button = TRUE;
			} else {
				$this->close_button = $this->options[ 'close_button' ];
			}

			$this->hidedelay = $this->options[ 'hide_delay' ];

			$this->print_scripts();
		}

		/**
		 * SHORTCODE
		 *
		 * @param      $atts
		 * @param null $content
		 */
		public function shortcode($atts, $content = NULL) {
			$this->enable_jqnm = TRUE;
			$this->content = $content;

			if ($this->options[ 'custom_style' ]) {
				$style = $this->options[ 'custom_style' ];
			} else {
				$style = $this->options[ 'style' ];
			}

			extract(
				shortcode_atts(
					array(
						'style'        => $style,
						'speed'        => $this->options[ 'speed' ],
						'delay'        => $this->options[ 'delay' ],
						'close_button' => $this->options[ 'close_button' ],
					), $atts
				)
			);

			$this->style = $style;
			/** @noinspection PhpUndefinedVariableInspection */
			$this->speed = $speed;
			/** @noinspection PhpUndefinedVariableInspection */
			$this->delay = $delay;

			if (!isset($this->options[ 'close_button' ])) {
				$this->close_button = TRUE;
			} else {
				$this->close_button = $this->options[ 'close_button' ];
			}

			if (!isset($this->options[ 'auto_hide' ])) {
				$this->autohide = 0;
			} else {
				$this->autohide = $this->options[ 'auto_hide' ];
			}
			$this->hidedelay = $this->options[ 'hide_delay' ];

			$this->print_scripts();
		}

		/**
		 * OUTPUT HTML
		 */
		public function jqnm_output() {
			if (!$this->options) {
				$this->options = get_option('jqn_options');
			}
			?>
			<div class="jqnm_<?php echo $this->style; ?> jqnm_message">
				<?php echo $this->content; ?>
				<?php if ($this->options[ 'close_button' ]) : ?>
					<div class="jqn-close"></div>
				<?php endif; ?>
			</div>
			<?php
		}
	} // End Class jQuery_Notify

}
$jquery_notification = new jQuery_Notify();

if (is_admin()) {
	// include options file
	require_once('jqn-options.php');
}

if (!function_exists("jq_notify")) {
	/**
	 * jQuery Notify template tag for use in themes / plugins.
	 *
	 * @param $content        string HTML content to display.
	 * @param $style          string 'default' (blue), 'error' (red), 'warning' (orange), and 'success' (green)
	 * @param $speed          integer Milliseconds for animation.
	 * @param $delay          integer Milliseconds to delay before showing the message.
	 * @param $close_button   boolean Display a close button or not.
	 */
	function jq_notify($content, $style, $speed, $delay, $close_button = TRUE) {

		global $jquery_notification;

		// For each property, if nothing is set, apply the default
		$style = isset($style) ? $style : $jquery_notification->options[ 'style' ];
		$speed = isset($speed) ? $speed : $jquery_notification->options[ 'speed' ];
		$delay = isset($delay) ? $delay : $jquery_notification->options[ 'delay' ];
		$close_button = isset($close_button) ? $close_button : $jquery_notification->options[ 'close_button' ];

		//$jquery_notification->options = update_option('jqn_options', $options);

		$jquery_notification->template_tag($content, $style, $speed, $delay, $close_button);
	}
}
