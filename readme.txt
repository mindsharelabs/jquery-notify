=== jQuery Notify ===
Contributors: mindshare, sekatsim
Donate link: http://jquery-notify.mindsharelabs.com/
Tags: notification, notify, jquery, popup, message
Requires at least: 3.0
Tested up to: 3.4.1
Stable tag: 0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

An attractive, lightweight, and highly configurable jQuery notification pane.

== Description ==

jQuery Notify: a fast and easy way to display notifications on your website. Some possible uses:

*   Form validation ("Please fill out all of the fields.")
*   A welcome message the first time someone visits your site.
*   Newsletter subscription form
*   Submission confirmation: ("Message sent. We'll be in touch soon.")
*   Breaking news, updates, special offers
*   Advertising

Try a [demo](http://jquery-notify.mindsharelabs.com/).

<h4>Features:</h4>

*   Can be used on a per-page basis with a shortcode, or embedded directly into your template
*   Elegantly styled and animated in W3C valid HTML5 and CSS3, without any images
*   Animation speed and delay settings available from the shortcode
*   Comes with four styles: 'default' (blue), 'error' (red), 'warning' (orange), and 'success' (green)
*   Supports unlimited user-created styles

   We'll be working to add new features as we think of them. Please comment in the forum if you have any
feature requests.

== Installation ==

1. Upload the `jquery-notify` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

<h4>Shortcode</h4>
The shortcode syntax is:
`[jq_notify style=$style, speed=$speed, delay=$delay] Content [/jq_notify]`

**$style** (optional): sets the style of the panel. Options are: *default*, *error*, *warning*, and *success*

**$speed** (optional): time it takes (in milliseconds) for the panel to slide out.  Larger numbers = slower. Default: 1000ms

**$delay** (optional): delay (in milliseconds) between when the page has finished loading and when the panel slides out. Default: 500ms


For example:
`[jq_notify style="warning" speed=700 delay=1000]
<h2>Notification Title</h2>
<p>Notification body content.</p>
[/jq_notify]`

<h4>Template tag</h4>
`jq_notify($content, $style, $speed, $delay)`

For example:
`$content = "<h3>This is the content</h3><p>And this is some more</p>";
jq_notify($content, 'default', 2000, 500, );`



== Frequently Asked Questions ==

= How do I add custom styles? =

In your custom stylesheet for your theme, add a new selector, using the following as a template:

`.jqnm_message.my-style-name{
		 background-color: #4ea5cd;
		 border-color: #3b8eb5;
}`

You would then use this style with `[jq_notify style="my-style-name"] Content [/jq_notify]`


== Screenshots ==

1. The plugin in action, using the "success" style
2. The plugin in action, using the "default" style
3. The plugin in action, using the "error" style

== Changelog ==

= 0.3 =
*   Fixed issue with default parameters not being applied to the template tag (thanks, jefs42)
*   Added option to auto-hide notification pane after a delay

= 0.2 =
*   Added options page
*   Option to set global defaults
*   Option to enable close button
*   Added default parameters to template tag

= 0.1 =
*   First release