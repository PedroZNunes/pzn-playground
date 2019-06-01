<?php

namespace PZN\NYT\Pages;

use Settings\General;

use \PZN\NYT\API\SettingsPagesAPI as SettingsAPI;

class Admin {
    
    private $page_name = 'pzn_nyt_articles';
    private $admin_page;

    private static $instance;

    private function __construct() {
        $pages = [
            [
                'title'             => 'New York Times Articles Plugin',
                'menu_title'        => 'NYT Articles',
                'capability'        => 'manage_options',
                'page_slug'         => $this->page_name,
                'callback_function' => array( $this, 'create_admin_page' ),
                'icon_url'          => 'dashicons-sos',
                'position'          => '110'
            ]
        ];

        /** Quando criar subpages, é criada uma default como primeira subpage. dá pra mudar o nome dela e dar append no conteúdo da principal
         * criando uma subpage com os mesmos dados pra principal, soh mudando o nome (e adicionando função de callback se quiser)
         */
        $subpages = [
            [
                'parent_slug'       => 'pzn_nyt_test',
                'title'             => 'Test Plugin',
                'menu_title'        => 'General',
                'capability'        => 'manage_options',
                'page_slug'         => 'pzn_nyt_test',
                'callback_function' => ''
            ],
        ];

        $this->admin_page = new Settings\General( $this->page_name );

        // Envia as listas de parâmetros pro API que vai gerar as páginas de acordo com as funções de callback enviadas
        new SettingsAPI( $pages, $subpages );

        // $this->register();
    }

    /**
     * Singleton instance generator
     */
    public static function get_instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new Admin();
        }
        
        return self::$instance;
    }
    
    //função para imprimir as coisas na tela
    public function create_admin_page() {
        $this->admin_page->print_page();
        // new Settings\General( $this->page_name );

        // $file_path = str_replace ("\\", DIRECTORY_SEPARATOR, Constants::BASE_DIR . "\\templates\\options-page.php");
        // include_once( $file_path );
    }
}