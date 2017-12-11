<?php

/**
 * Metaboxes
 *
 * @author     Levron Jérémy <levronjeremy@19h47.fr>
 */
class Link_Metaboxes {

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
     */
    public function __construct( $plugin_name, $plugin_version ) {
        $this->plugin_name = $plugin_name;
        $this->plugin_version = $plugin_version;

        if ( is_admin() ) {

            add_action( 'load-post.php', array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );

        }

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_color_picker' ) );
    }


    function enqueue_color_picker() {

        wp_enqueue_style( 'wp-color-picker' );

        wp_enqueue_script(
            'link-color-picker',
            plugin_dir_url( __FILE__ ) . 'js/' . $this->plugin_name . '-color-picker.js',
            array( 'wp-color-picker' ),
            null,
            true
        );

        // var_dump(get_template_directory_uri() . '/inc/post-types/link/js/link.js');
    }



    /**
     * Meta box initialization
     *
     * @see https://generatewp.com/snippet/90jakpm/
     */
    public function init_metabox() {

        add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
        add_action( 'save_post', array( $this, 'save_metabox' ), 10, 2 );

        add_action( 'save_post', array( $this, 'save_image' ), 10, 2 );
    }


    /**
     * Adds the meta box
     *
<<<<<<< HEAD
     *
	 * $id, $title, $callback, $page, $context, $priority, $callback_args
=======
     * $id, $title, $callback, $page, $context, $priority, $callback_args
>>>>>>> 94cff20d04a01750eb3f1cd572a32374ac6d755c
	 * @see  https://developer.wordpress.org/reference/functions/add_meta_box/
	 */
    public function add_metabox() {

        add_meta_box(
        	'link_information',
        	__( 'Information', $this->plugin_name ),
        	array( $this, 'render_metabox' ),
        	'link',
        	'normal',
        	'default'
        );
    }


    /**
     * Renders the meta box
     */
    public function render_metabox( $post ) {

        // Add nonce for security and authentication.
        wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );

        // Retrieve an existing value from the database
        $link_url = get_post_meta( $post->ID, 'link_url', true );
        $link_color = get_post_meta( $post->ID, 'link_color', true );
        $link_description = get_post_meta( $post->ID, 'link_description', true );


        // Set default values
        if ( empty( $link_url ) ) $link_url = '';
        if ( empty( $link_color ) ) $link_color = '';
        if ( empty( $link_description ) ) $link_description = '';

<<<<<<< HEAD

        include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-form.php' );
=======
        
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-form.php' );
>>>>>>> 94cff20d04a01750eb3f1cd572a32374ac6d755c

    }


    /**
     * Handles saving the meta box
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
     */
    public function save_metabox( $post_id, $post ) {

        // Add nonce for security and authentication.
        $nonce_name = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
        $nonce_action = 'custom_nonce_action';

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
        $link_url = isset( $_POST[ 'link_url' ] ) ? sanitize_text_field( $_POST[ 'link_url' ] ) : '';
        $link_color = isset( $_POST[ 'link_color' ] ) ? sanitize_text_field( $_POST[ 'link_color' ] ) : '';
        $link_description = isset( $_POST[ 'link_description' ] ) ? sanitize_text_field( $_POST[ 'link_description' ] ) : '';


        // Update the meta field in the database.
        update_post_meta( $post_id, 'link_url', $link_url );
        update_post_meta( $post_id, 'link_color', $link_color );
        update_post_meta( $post_id, 'link_description', $link_description );
    }
}
