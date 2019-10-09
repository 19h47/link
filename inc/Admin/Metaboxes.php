<?php
/**
 * Class Link Metaboxes
 *
 * @package Link
 */

namespace Link\Admin;

/**
 * Metaboxes
 *
 * @author     Jérémy Levron <jeremylevron@19h47.fr>
 */
class Metaboxes {

	/**
	 * The ID of this plugin.
	 *
	 * @since       1.0.0
	 * @access      private
	 * @var         string          $plugin_name        The ID of this plugin.
	 */
	private $plugin_name;


	/**
	 * The version of this plugin.
	 *
	 * @since       1.0.0
	 * @access      private
	 * @var         string          $plugin_version     The current version of this plugin.
	 */
	private $plugin_version;


	/**
	 * Constructor
	 *
	 * @param string $plugin_name The plugin name.
	 * @param string $plugin_version The plugin version.
	 */
	public function __construct( string $plugin_name, string $plugin_version ) {
		$this->plugin_name    = $plugin_name;
		$this->plugin_version = $plugin_version;

		if ( is_admin() ) {
			add_action( 'load-post.php', array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_color_picker' ) );
	}

	/**
	 * Enqueue color picker
	 *
	 * @access public
	 * @return void
	 */
	public function enqueue_color_picker() {

		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_script(
			'link-color-picker',
			plugin_dir_url( __FILE__ ) . 'js/' . $this->plugin_name . '-color-picker.js',
			array( 'wp-color-picker' ),
			'1.0.0',
			true
		);
	}



	/**
	 * Meta box initialization
	 *
	 * @see https://generatewp.com/snippet/90jakpm/
	 */
	public function init_metabox() {
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
		add_action( 'save_post', array( $this, 'save_metabox' ), 10, 2 );
	}


	/**
	 * Adds the meta box
	 *
	 * $id, $title, $callback, $page, $context, $priority, $callback_args.
	 *
	 * @see  https://developer.wordpress.org/reference/functions/add_meta_box/
	 */
	public function add_metabox() {

		add_meta_box(
			'link_information',
			__( 'Information', 'link' ),
			array( $this, 'render_metabox' ),
			'link',
			'normal',
			'default'
		);
	}


	/**
	 * Renders the meta box
	 *
	 * @param obj $post Post object.
	 */
	public function render_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'save_metabox_link', 'save_metabox_link_nonce' );

		// Retrieve an existing value from the database.
		$link_url         = get_post_meta( $post->ID, 'link_url', true );
		$link_color       = get_post_meta( $post->ID, 'link_color', true );
		$link_description = get_post_meta( $post->ID, 'link_description', true );

		// Set default values.
		if ( empty( $link_url ) ) {
			$link_url = '';
		}

		if ( empty( $link_color ) ) {
			$link_color = '';
		}

		if ( empty( $link_description ) ) {
			$link_description = '';
		}

		include plugin_dir_path( __FILE__ ) . 'partials/link-form.php';
	}


	/**
	 * Handles saving the meta box
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 * @return null
	 */
	public function save_metabox( int $post_id, WP_Post $post ) {

		// Add nonce for security and authentication.
		$nonce_name   = '';
		$nonce_action = 'save_metabox_link';

		if ( isset( $_POST['save_metabox_link_nonce'] ) ) {
			$nonce_name = sanitize_text_field( wp_unslash( $_POST['save_metabox_link_nonce'] ) );
		}

		// Check if nonce is set.
		if ( ! isset( $nonce_name ) ) {
			return;
		}

		// Check if nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
			return;
		}

		// Check if user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		// Sanitize user input.
		$link_url         = '';
		$link_color       = '';
		$link_description = '';

		if ( isset( $_POST['link_url'] ) ) {
			$link_url = sanitize_text_field( wp_unslash( $_POST['link_url'] ) );
		}

		if ( isset( $_POST['link_color'] ) ) {
			$link_color = sanitize_text_field( wp_unslash( $_POST['link_color'] ) );
		}

		if ( isset( $_POST['link_description'] ) ) {
			$link_description = sanitize_text_field( wp_unslash( $_POST['link_description'] ) );
		}

		// Update the meta field in the database.
		update_post_meta( $post_id, 'link_url', $link_url );
		update_post_meta( $post_id, 'link_color', $link_color );
		update_post_meta( $post_id, 'link_description', $link_description );
	}
}
