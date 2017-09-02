<?php

/**
 * Register post types
 *
 * @author     Levron Jérémy <levronjeremy@19h47.fr>
 */
class Link_Registrations {
	
	/**
	 * Post type name
	 * 
	 * @var string
	 */
	public $post_type = 'link';
	

	/**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;
    

    /**
     * The version of the plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $plugin_version;
	

	/**
	 * init
	 */
	public function __construct( $plugin_name, $plugin_version ) {
		
		$this->plugin_name = $plugin_name;
        $this->plugin_version = $plugin_version;
		
		// Add the Run post type
		add_action( 'init', array( $this, 'register_post_type' ) );
	}


	/**
	 * Register the custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	public function register_post_type() {
		
		$labels = array(
			'name'                  => _x( 'Liens', 'Lien Nom pluriel', $this->plugin_name ),
	        'singular_name'         => _x( 'Lien', 'Lien Nom singulier', $this->plugin_name ),
	        'menu_name'             => __( 'Liens', $this->plugin_name ),
	        'name_admin_bar'        => __( 'Lien', $this->plugin_name ),
	        // 'parent_item_colon'     => __( '', $this->plugin_name ),
	        'all_items'             => __( 'Tous les liens', $this->plugin_name ),
	        'add_new_item'          => __( 'Ajouter un nouveau lien', $this->plugin_name ),
	        'add_new'               => __( 'Ajouter', $this->plugin_name ),
	        'new_item'              => __( 'Nouveau lien', $this->plugin_name ),
	        'edit_item'             => __( 'Modifier le lien', $this->plugin_name ),
	        'update_item'           => __( 'Mettre à jour le lien', $this->plugin_name ),
	        'view_item'             => __( 'Voir le lien', $this->plugin_name ),
	        'view_items'            => __( 'Voir les liens', $this->plugin_name ),
	        'search_items'          => __( 'Chercher parmi les liens', $this->plugin_name ),
	        'not_found'             => __( 'Aucun lien trouvé.', $this->plugin_name ),
	        'not_found_in_trash'    => __( 'Aucun lien trouvé dans la corbeille.', $this->plugin_name ),
	        'featured_image'        => __( 'Image à la une', $this->plugin_name ),
	        'set_featured_image'    => __( 'Mettre une image à la une', $this->plugin_name ),
	        'remove_featured_image' => __( 'Retirer l\'image mise en avant', $this->plugin_name ),
	        'use_featured_image'    => __( 'Mettre une image à la une', $this->plugin_name ),
	        'insert_into_item'      => __( 'Insérer dans le lien', $this->plugin_name ),
	        'uploaded_to_this_item' => __( 'Ajouter à ce lien', $this->plugin_name ),
	        'items_list'            => __( 'Liste des liens', $this->plugin_name ),
	        'items_list_navigation' => __( 'Navigation de liste des liens', $this->plugin_name ),
	        'filter_items_list'     => __( 'Filtrer la liste des liens', $this->plugin_name ),
		);
		$rewrite = array(
	        'slug'                	=> 'liens',
	        'with_front'          	=> true,
	        'pages'               	=> true,
	        'feeds'               	=> true,
	    );
		$args = array(
			'label'               	=> 'link',
	        'description'         	=> __( 'Les liens', $this->plugin_name ),
	        'labels'              	=> $labels,
	        'supports'            	=> array( 'title', 'thumbnail' ),
	        'taxonomies'          	=> array( 'link_category' ),
	        'hierarchical'        	=> false,
	        'public'              	=> true,
	        'show_ui'             	=> true,
	        'show_in_nav_menus'   	=> true,
	        'show_in_menu'        	=> true,
	        'show_in_admin_bar'   	=> true,
	        'show_in_rest'   		=> true,
	        'menu_position'       	=> 5,
	        'menu_icon'           	=> 'dashicons-admin-links',
	        'can_export'          	=> true,
	        'has_archive'         	=> true,
	        'exclude_from_search' 	=> false,
	        'publicly_queryable'  	=> true,
	        'rewrite'             	=> $rewrite,
	        'capability_type'     	=> 'post',
		);
		register_post_type( 'link', $args );
	}
}