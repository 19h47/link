<?php
/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://www.19h47.fr
 * @since      1.0.0
 *
 * @package    Link
 * @subpackage run/admin
 */


/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @since      1.0.0
 * @package    Link
 * @subpackage link/admin
 * @author     Levron Jérémy <levronjeremy@19h47.fr>
 */
class Link_Admin {

	/**
	 * The unique identifier of this theme.
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
	public function __construct( $plugin_name, $plugin_version ) {

		$this->plugin_name = $plugin_name;
		$this->plugin_version = $plugin_version;


		add_action( 'admin_head', array( $this, 'css' ) );
		add_filter( 'dashboard_glance_items', array( $this, 'at_a_glance' ) );

		$this->load_dependencies();
	}


	/**
	 * Load dependencies
	 *
	 * @acces private
	 */
	private function load_dependencies() {

		/**
		 * Registrations
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-link-registrations.php';

		new Link_Registrations( $this->plugin_name, $this->plugin_version );


		/**
		 * Metaboxes
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-link-metaboxes.php';

		new Link_Metaboxes( $this->plugin_name, $this->plugin_version );


		/**
		 * Columns
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-link-columns.php';

		new Link_Columns( $this->plugin_name, $this->plugin_version );


		/**
		 * Taxonomies
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-link-taxonomies.php';

		new Link_Taxonomies( $this->plugin_name, $this->plugin_version );

	}


	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script(
			$this->plugin_name . '-color-picker',
			plugin_dir_url( __FILE__ ) . 'js/link-color-picker.js',
			array( 'jquery' ),
			$this->version,
			false
		);
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/link-admin.css',
			array(),
			$this->version,
			'all'
		);
	}


	/**
	 * "At a glance" items (dashboard widget): add the projects.
	 *
	 * @access public
	 */
	public function at_a_glance( $items ) {
		$post_type = 'link';
		$post_status = 'publish';

		$object = get_post_type_object( $post_type );

		$num_posts = wp_count_posts( $post_type );

		if (
			! $num_posts ||
			! isset ( $num_posts->{ $post_status } ) ||
			0 === (int) $num_posts->{ $post_status }
		) {

			return $items;
		}

		$text = sprintf(
			_n( '%1$s %4$s%2$s', '%1$s %4$s%3$s', $num_posts->{ $post_status } ),
			number_format_i18n( $num_posts->{ $post_status } ),
			strtolower( $object->labels->singular_name ),
			strtolower( $object->labels->name ),
			'pending' === $post_status ? 'Pending ' : ''
		);

		if ( current_user_can( $object->cap->edit_posts ) ) {
			$items[] = sprintf( '<a class="%1$s-count" href="edit.php?post_status=%2$s&post_type=%1$s">%3$s</a>', $post_type, $post_status, $text );

		} else {
			$items[] = sprintf( '<span class="%1$s-count">%s</span>', $text );
		}

		return $items;
	}
}
