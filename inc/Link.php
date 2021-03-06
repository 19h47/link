<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/19h47/link
 * @since      1.0.0
 *
 * @package    Link
 */

namespace Link;

use Link\{ Loader };
use Link\Admin\{ Admin };
use Link\Front\{ Front };

/**
 * The core plugin class.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Link
 * @author     Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 */
class Link {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this theme.
	 */
	protected $plugin_name;


	/**
	 * The version of the theme.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_version    The current version of this theme.
	 */
	private $plugin_version;


	/**
	 * Construct function
	 *
	 * @access public
	 */
	public function __construct() {
		$this->plugin_name    = 'link';
		$this->plugin_version = '1.0.0';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_front_hooks();
	}


	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function load_dependencies() {
		$this->loader = new Loader();
	}


	/**
	 * Register all of the hooks related to the front functionnality of the plugin
	 *
	 * @since 2.0.0
	 */
	private function define_front_hooks() {
		$plugin_public = new Front( $this->get_plugin_name(), $this->get_version() );

		/**
		 * Register shortcode via loader
		 *
		 * Use: [link args]
		 *
		 * @link https://github.com/DevinVinson/WordPress-Plugin-Boilerplate/issues/262
		 */
		$this->loader->add_shortcode( 'link', $plugin_public, 'shortcode_function', $priority = 10, $accepted_args = 2 );
	}


	/**
	 * Register all of the hooks related to the dashboard functionality of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		$this->loader->run();
	}


	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since  1.0.0
	 * @return string   The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}


	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since  1.0.0
	 * @return Loader Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}


	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since  1.0.0
	 * @return string   The version number of the plugin.
	 */
	public function get_version() {
		return $this->plugin_version;
	}
}
