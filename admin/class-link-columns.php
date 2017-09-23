<?php

/**
 * Columns
 */
class Link_Columns {
    
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
     */
    public function __construct( $plugin_name, $plugin_version ) {
        $this->plugin_name = $plugin_name;
        $this->plugin_version = $plugin_version;
        
        add_filter( 'manage_link_posts_columns', array( $this, 'add_link_columns' ) );
        add_action( 'manage_link_posts_custom_column' , array( $this, 'link_custom_columns' ), 10, 2 );

        add_filter( 'manage_edit-link_sortable_columns' , array( $this, 'order_column_register_sortable' ) );

        add_action( 'restrict_manage_posts', array( $this, 'tsm_filter_post_type_by_taxonomy') );
        add_filter( 'parse_query', array( $this, 'tsm_convert_id_to_term_in_query' ) );
    
    }


    /**
     * add link columns
     * 
     * @param $columns
     */
    public function add_link_columns( $columns ) {
        
        $columns['colors'] = __( 'Couleur' );
        $columns['featured-image'] = __( 'Image' );
        $columns['link_categories'] = __( 'Catégorie' );
        $columns['link_status'] = __( 'État' );
        $columns['link_order'] = __( 'Ordre' );

        $order = array( 'cb', 'featured-image', 'title', 'link_categories', 'colors', 'link_status', 'link_order' );
        
        foreach ( $order as $colname ) {

            $new[$colname] = $columns[$colname]; 
        }

        return $new;
    }


    /**
     * link custom columns
     * 
     * @param $column_name 
     * @param $post_id     
     */
    public function link_custom_columns( $column_name, $post_id ) {
        switch ( $column_name ) {
            case 'colors' :
                $data = get_post_meta( $post_id, 'link_color', true );
            
               if ( $data ) {

                    echo '<div id="link_colors-' . $post_id . '" ';
                    echo 'data-color="' . $data . '" ';
                    echo 'class="color-indicator" style="background-color:';
                    echo $data;
                    echo '"></div>';

               } else {
                    echo '—';
               }

                break;

            case 'featured-image' : 
                $data = get_the_post_thumbnail( $post_id, array( 60, 60 ) );

                if ( $data ) {

                    echo "<a href=\"" . get_edit_post_link( $post_id ) . "\">" . $data . "</a>";

                } else {
                    echo '—';
                }

            break;

            case 'link_categories' : 
                
                $data = wp_get_post_terms( $post_id, 'link_category' );

                if ( $data ) {
                    foreach( $data as $link_category ) {
                        
                        // $edit_link = get_term_link( $link_category, 'link_category' );

                        $terms .= $link_category->name . ', ';
                    }
                    echo rtrim( $terms, ', ' );
                } else {
                    echo '—';
                }

            break;

            case 'link_order' : 
                
                echo get_post_field( 'menu_order', $post_id );

            break;

            case 'link_status' : 
                
                $status = get_post_status( $post_id );

                switch ( $status ) {
                    case 'private':
                        
                        _e('Privately Published');
                        
                        break;
                        
                    case 'publish':

                        _e( 'Published' );

                        break;

                    case 'future':

                        _e( 'Scheduled');

                        break;
                    case 'pending':
                        _e( 'Pending Review' );

                        break;
                    case 'draft':

                    case 'auto-draft':

                        _e( 'Draft' );

                        break;
                }

            break;
        }
    }

    
    /**
     * Order column
     */
    function order_column_register_sortable( $columns ){

        $columns['link_order'] = 'menu_order';

        return $columns;
    }


    /**
     * Display a custom taxonomy dropdown in admin
     * @author Mike Hemberger
     * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
     */
    function tsm_filter_post_type_by_taxonomy() {
        
        global $typenow;

        $taxonomy  = 'link_category'; // change to your taxonomy
        
        if ( $typenow != 'link' ) {
            return;
        }

        $selected = isset( $_GET[$taxonomy] ) ? $_GET[$taxonomy] : '';

        $info_taxonomy = get_taxonomy($taxonomy);
        wp_dropdown_categories( array(
            'show_option_all'   => __( "Voir toutes les {$info_taxonomy->label}" ),
            'taxonomy'          => $taxonomy,
            'name'              => $taxonomy,
            'orderby'           => 'name',
            'selected'          => $selected,
            'show_count'        => false,
            'hide_empty'        => false,
        ));
        
    }


    /**
     * Filter posts by taxonomy in admin
     * @author  Mike Hemberger
     * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
     */
    function tsm_convert_id_to_term_in_query($query) {
        global $pagenow;

        if ( $pagenow != 'edit.php' ) {
            return;
        }
        
        $post_type = 'link'; // change to your post type
        $taxonomy  = 'link_category'; // change to your taxonomy
        $q_vars    = &$query->query_vars;

        if ( 
            isset( $q_vars['post_type'] ) && 
            $q_vars['post_type'] == $post_type && 
            isset( $q_vars[$taxonomy] ) && 
            is_numeric( $q_vars[$taxonomy] ) && $q_vars[$taxonomy] != 0 
        ) {
            $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
            $q_vars[$taxonomy] = $term->slug;
        }
    }
}
