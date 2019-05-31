<?php

/**
 * @package: PedroNunesPlugin
 */

namespace PZN\NYT\Base;

/**
 * Cria e gerencia tipos custom de post
 */
final class CPT extends Base{

    protected function register() {
        add_action( 'init', array ( $this, 'create_articles' ) );
    }

    /**
    * Creates the article custom post type.
    */
    public function create_articles() {
        //registering a new post type, like post, page, etc. It' have its own data type in the db
        $args = array(
            'public' => true,
            'label' => 'Articles'
        );
        register_post_type( 'article', $args);
    }

}