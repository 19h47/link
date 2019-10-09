<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link https://github.com/19h47/link
 * @since 2.0.0
 *
 * @package Link
 * @subpackage Link/Front
 */

namespace Link\Front;

use WP_Query;

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Link
 * @subpackage Link/Front
 * @author     Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
class Front {

	/**
	 * The ID of this plugin.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	protected $plugin_name;


	/**
	 * The version of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $plugin_version    The current version of this theme.
	 */
	private $plugin_version;


	/**
	 * Construct function
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $plugin_version The version of this plugin.
	 * @access public
	 */
	public function __construct( string $plugin_name, string $plugin_version ) {

		$this->plugin_name    = $plugin_name;
		$this->plugin_version = $plugin_version;
	}

	/**
	 * Shortcode function
	 *
	 * @param  array $atts Array of attributes.
	 * @return $var
	 * @access public
	 */
	public function shortcode_function( array $atts = array() ) {
		$output = '';
		$var    = '';
		$args   = shortcode_atts(
			array(
				'posts_per_page' => 3,
				'thumbnail_size' => 'full',
			),
			$atts
		);

		$query = new WP_Query(
			array(
				'post_type'      => 'link',
				'posts_per_page' => $args['posts_per_page'],
				'order'          => 'ASC',
				'orderby'        => 'title',
			)
		);

		if ( ! $query->have_posts() ) {
			return $output;
		}

		$output = '<ul class="Link-listing">';

		while ( $query->have_posts() ) {
			$query->the_post();
			$link_url       = get_post_meta( get_the_ID(), 'link_url', true );
			$post_thumbnail = get_the_post_thumbnail( get_the_ID(), $args['thumbnail_size'], array( 'title' => get_the_title() ) );

			if ( $post_thumbnail )  {
				$output .= '<li class="Link-listing__item" id="link-' . get_the_ID() . '">';
				$output .= $link_url ? "<a class=\"Link-listing__link\" href=\"{$link_url}\" target=\"_blank\">" : '';
				$output .= $post_thumbnail;
				$output .= $link_url ? '</a>' : '';
				$output .= '</li>';
			}
		}

		wp_reset_postdata();

		$output .= '</ul>';

		return $output;
	}
}
