<?php
/**
 * Link
 *
 * @link    https://github.com/19h47/link
 * @since   1.0.0
 * @package Link
 *
 * @wordpress-plugin
 * Plugin Name: Link
 * Plugin URI:  https://github.com/19h47/link
 * Description: Enables a Link, taxonomy and metaboxes. bring back to life blogroll! 🔗
 * Version:     2.0.0
 * Author:      Jérémy Levron
 * Author URI:  http://www.19h47.fr
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: link
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-link.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function run_link() {
	$plugin = new Link();
	$plugin->run();
}
run_link(); // Run, Forrest, run!
