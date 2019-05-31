<?php

/**
 * @package: PedroNunesPlugin
 */

namespace PZN\NYT\API;

/**
 * Cria e gerencia tipos custom de post
 */
class SettingsPagesAPI {
    private $pages;
    private $submenu_pages;

    public function __construct( array $pages, array $submenu_pages = [] ) {
        $this->pages = $pages;
        $this->submenu_pages = $submenu_pages;

        $this->register();
    }

    private function register() {
        add_action( 'admin_menu', [$this, 'add_menu_pages'] );
    }

    public function add_menu_pages() {
        $pages = $this->pages;

        foreach( $pages as $page ) {
            add_menu_page( 
                $page['title'], 
                $page['menu_title'], 
                $page['capability'], 
                $page['page_slug'], 
                $page['callback_function'], 
                $page['icon_url'], 
                $page['position'] 
            );
        }

        $submenu_pages = $this->submenu_pages;
        if ( ! empty ($submenu_pages) ){
            foreach( $submenu_pages as $subpage ) {
                add_submenu_page( 
                    $subpage['parent_slug'],
                    $subpage['title'], 
                    $subpage['menu_title'], 
                    $subpage['capability'], 
                    $subpage['page_slug'], 
                    $subpage['callback_function']
                );
                
            }
        }
    }
    
    
}