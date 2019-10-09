<?php
/**
 * Class Link registrations
 *
 * @package Link
 */

namespace Link\Admin;

/**
 * Register post types
 *
 * @author     Jérémy Levron <jeremylevron@19h47.fr>
 */
class Registrations {

	/**
	 * Post type name
	 *
	 * @var string
	 */
	public $post_type = 'link';


	/**
	 * The unique identifier of this plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;


	/**
	 * The version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_version    The current version of this plugin.
	 */
	private $plugin_version;

	/**
	 * Init
	 *
	 * @param string $plugin_name The plugin name.
	 * @param string $plugin_version The plugin version.
	 * @access public
	 */
	public function __construct( string $plugin_name, string $plugin_version ) {

		$this->plugin_name    = $plugin_name;
		$this->plugin_version = $plugin_version;

		// Add the Link post type.
		add_action( 'init', array( $this, 'register_post_type' ) );
	}


	/**
	 * Register the custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	public function register_post_type() {

		$labels = array(
			'name'                  => _x( 'Liens', 'Lien Nom pluriel', 'link' ),
			'singular_name'         => _x( 'Lien', 'Lien Nom singulier', 'link' ),
			'menu_name'             => __( 'Liens', 'link' ),
			'name_admin_bar'        => __( 'Lien', 'link' ),
			'all_items'             => __( 'Tous les liens', 'link' ),
			'add_new_item'          => __( 'Ajouter un nouveau lien', 'link' ),
			'add_new'               => __( 'Ajouter', 'link' ),
			'new_item'              => __( 'Nouveau lien', 'link' ),
			'edit_item'             => __( 'Modifier le lien', 'link' ),
			'update_item'           => __( 'Mettre à jour le lien', 'link' ),
			'view_item'             => __( 'Voir le lien', 'link' ),
			'view_items'            => __( 'Voir les liens', 'link' ),
			'search_items'          => __( 'Chercher parmi les liens', 'link' ),
			'not_found'             => __( 'Aucun lien trouvé.', 'link' ),
			'not_found_in_trash'    => __( 'Aucun lien trouvé dans la corbeille.', 'link' ),
			'featured_image'        => __( 'Image à la une', 'link' ),
			'set_featured_image'    => __( 'Mettre une image à la une', 'link' ),
			'remove_featured_image' => __( 'Retirer l\'image mise en avant', 'link' ),
			'use_featured_image'    => __( 'Mettre une image à la une', 'link' ),
			'insert_into_item'      => __( 'Insérer dans le lien', 'link' ),
			'uploaded_to_this_item' => __( 'Ajouter à ce lien', 'link' ),
			'items_list'            => __( 'Liste des liens', 'link' ),
			'items_list_navigation' => __( 'Navigation de liste des liens', 'link' ),
			'filter_items_list'     => __( 'Filtrer la liste des liens', 'link' ),
		);

		$rewrite = array(
			'slug'       => 'liens',
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'               => 'link',
			'description'         => __( 'Les liens', 'link' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
			'taxonomies'          => array( 'link_category' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_nav_menus'   => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'show_in_rest'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-admin-links',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
		);
		register_post_type( 'link', $args );
	}
}
