<?php

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
	 * @access public
	 */
	public function __construct( $plugin_name, $plugin_version ) {
		$this->plugin_name = $plugin_name;
        $this->plugin_version = $plugin_version;

        add_action( 'init', array( &$this, 'register_taxonomy' ) );
	}


	// Register Custom Taxonomy
	function register_taxonomy() {

		$labels = array(
			'name'                       => _x( 'Catégories', 'Taxonomy General Name', $this->plugin_name ),
			'singular_name'              => _x( 'Catégorie', 'Taxonomy Singular Name', $this->plugin_name ),
			'menu_name'                  => __( 'Catégories', $this->plugin_name ),
			'all_items'                  => __( 'Toutes les Catégories', $this->plugin_name ),
			'parent_item'                => __( 'Catégorie parente', $this->plugin_name ),
			'parent_item_colon'          => __( 'Catégorie parente :', $this->plugin_name ),
			'new_item_name'              => __( 'Nom de la nouvelle catégorie', $this->plugin_name ),
			'add_new_item'               => __( 'Ajouter une nouvelle catégorie', $this->plugin_name ),
			'edit_item'                  => __( 'Éditer la catégorie', $this->plugin_name ),
			'update_item'                => __( 'Mettre à jour la catégorie', $this->plugin_name ),
			'view_item'                  => __( 'Voir la catégorie', $this->plugin_name ),
			'separate_items_with_commas' => __( 'Séparer les catégories par des virgules', $this->plugin_name ),
			'add_or_remove_items'        => __( 'Ajouter ou supprimer la catégorie', $this->plugin_name ),
			'choose_from_most_used'      => __( 'Choisir parmi les catégories les plus utilisées', $this->plugin_name ),
			'popular_items'              => __( 'Catégorie populaire', $this->plugin_name ),
			'search_items'               => __( 'Catégories recherchées', $this->plugin_name ),
			'not_found'                  => __( 'Aucune catégorie n\'a été trouvée', $this->plugin_name ),
			'no_terms'                   => __( 'Pas de catégorie', $this->plugin_name ),
			'items_list'                 => __( 'Liste des catégories', $this->plugin_name ),
			'items_list_navigation'      => __( 'Liste de navigation des catégories', $this->plugin_name ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		register_taxonomy( 'link_category', array( 'link' ), $args );

	}
}