<?php
/**
 * Class Link Taxonomies
 *
 * @package Link
 */

/**
 * Link taxonomies
 */
class Link_Taxonomies {

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
	 * @param str $plugin_name The plugin name.
	 * @param str $plugin_version The plugin version.
	 * @access public
	 */
	public function __construct( $plugin_name, $plugin_version ) {
		$this->plugin_name    = $plugin_name;
		$this->plugin_version = $plugin_version;

		add_action( 'init', array( &$this, 'register_taxonomy' ) );
	}


	/**
	 * Register Custom Taxonomy
	 *
	 * @return void
	 * @access public
	 */
	public function register_taxonomy() {

		$labels = array(
			'name'                       => _x( 'Catégories', 'Taxonomy General Name', 'link' ),
			'singular_name'              => _x( 'Catégorie', 'Taxonomy Singular Name', 'link' ),
			'menu_name'                  => __( 'Catégories', 'link' ),
			'all_items'                  => __( 'Toutes les Catégories', 'link' ),
			'parent_item'                => __( 'Catégorie parente', 'link' ),
			'parent_item_colon'          => __( 'Catégorie parente :', 'link' ),
			'new_item_name'              => __( 'Nom de la nouvelle catégorie', 'link' ),
			'add_new_item'               => __( 'Ajouter une nouvelle catégorie', 'link' ),
			'edit_item'                  => __( 'Éditer la catégorie', 'link' ),
			'update_item'                => __( 'Mettre à jour la catégorie', 'link' ),
			'view_item'                  => __( 'Voir la catégorie', 'link' ),
			'separate_items_with_commas' => __( 'Séparer les catégories par des virgules', 'link' ),
			'add_or_remove_items'        => __( 'Ajouter ou supprimer la catégorie', 'link' ),
			'choose_from_most_used'      => __( 'Choisir parmi les catégories les plus utilisées', 'link' ),
			'popular_items'              => __( 'Catégorie populaire', 'link' ),
			'search_items'               => __( 'Catégories recherchées', 'link' ),
			'not_found'                  => __( 'Aucune catégorie n\'a été trouvée', 'link' ),
			'no_terms'                   => __( 'Pas de catégorie', 'link' ),
			'items_list'                 => __( 'Liste des catégories', 'link' ),
			'items_list_navigation'      => __( 'Liste de navigation des catégories', 'link' ),
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
		);
		register_taxonomy( 'link_category', array( 'link' ), $args );
	}
}
