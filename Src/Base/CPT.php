<?php
/**
 * @package: PedroNunesPlugin
 */

namespace PZN\Playground\Base;

/**
 * Cria e gerencia tipos custom de post
 */
final class CPT extends Base {

    protected function register() {
        add_action( 'init', [ $this, 'create_articles' ] );
    }

    /**
    * Creates the article custom post type.
    */
    public function create_articles() {
        //registering a new post type, like post, page, etc. It' have its own data type in the db
        $args = array(
            'public' => true,
            'label'  => 'Articles'
        );
        register_post_type( 'article', $args );
    }

}