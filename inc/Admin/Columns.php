<?php
/**
 * Class Link Columns
 *
 * @package Link
 */

namespace Link\Admin;

/**
 * Columns
 */
class Columns {

	/**
	 * The ID of this plugin.
	 *
	 * @since       1.0.0
	 * @access      private
	 * @var         string          $plugin_name        The ID of this plugin.
	 */
	private $plugin_name;


	/**
	 * The plugin_version of this plugin.
	 *
	 * @since       1.0.0
	 * @access      private
	 * @var         string          $plugin_version     The current plugin_version of this plugin.
	 */
	private $plugin_version;


	/**
	 * Constructor
	 *
	 * @param str $plugin_name The plugin name.
	 * @param str $plugin_version The plugin version.
	 * @access public
	 */
	public function __construct( $plugin_name, $plugin_version ) {
		$this->plugin_name    = $plugin_name;
		$this->plugin_version = $plugin_version;

		add_filter( 'manage_link_posts_columns', array( $this, 'add_link_columns' ) );
		add_action( 'manage_link_posts_custom_column', array( $this, 'link_custom_columns' ), 10, 2 );

		add_filter( 'manage_edit-link_sortable_columns', array( $this, 'order_column_register_sortable' ) );
	}


	/**
	 * Add link columns
	 *
	 * @param arr $columns Array of columns.
	 */
	public function add_link_columns( $columns ) {

		$columns['colors']          = __( 'Couleur' );
		$columns['featured-image']  = __( 'Image' );
		$columns['link_categories'] = __( 'Catégorie' );
		$columns['link_status']     = __( 'État' );
		$columns['link_order']      = __( 'Ordre' );

		$order = array( 'cb', 'featured-image', 'title', 'link_categories', 'colors', 'link_status', 'link_order' );

		foreach ( $order as $colname ) {
			$new[ $colname ] = $columns[ $colname ];
		}

		return $new;
	}


	/**
	 * Link custom columns
	 *
	 * @param arr $column_name Array of column name.
	 * @param int $post_id The post ID.
	 * @access public
	 */
	public function link_custom_columns( $column_name, $post_id ) {
		switch ( $column_name ) {
			case 'colors':
				$data = get_post_meta( $post_id, 'link_color', true );

				if ( $data ) {
					?>
					<div id="link_colors-<?php echo esc_attr( $post_id ); ?>" data-color="<?php echo esc_attr( $data ); ?>" class="color-indicator" style="background-color: <?php echo esc_attr( $data ); ?>"></div>
					<?php
				} else {
					echo '—';
				}
				break;

			case 'featured-image':
				if ( has_post_thumbnail( $post_id ) ) {
					?>
					<a href="<?php echo esc_attr( get_edit_post_link( $post_id ) ); ?>"><?php echo get_the_post_thumbnail( $post_id, 'full' ); ?></a>
					<?php
				} else {
					echo '—';
				}
				break;

			case 'link_categories':
				$data = wp_get_post_terms( $post_id, 'link_category' );

				if ( $data ) {
					foreach ( $data as $link_category ) {
						$terms = $link_category->name . ', ';
					}
					echo esc_html( rtrim( $terms, ', ' ) );
				} else {
					echo esc_html( '—' );
				}

				break;

			case 'link_order':
				echo esc_html( get_post_field( 'menu_order', $post_id ) );

				break;

			case 'link_status':
				$status = get_post_status( $post_id );

				switch ( $status ) {
					case 'private':
						esc_html_e( 'Privately Published' );

						break;

					case 'publish':
						esc_html_e( 'Published' );

						break;

					case 'future':
						esc_html_e( 'Scheduled' );

						break;
					case 'pending':
						esc_html_e( 'Pending Review' );

						break;

					case 'draft':
					case 'auto-draft':
						esc_html_e( 'Draft' );

						break;
				}

				break;
		}
	}


	/**
	 * Order column
	 *
	 * @param arr $columns Array of columns.
	 * @access public
	 */
	public function order_column_register_sortable( $columns ) {

		$columns['link_order'] = 'menu_order';

		return $columns;
	}
}
