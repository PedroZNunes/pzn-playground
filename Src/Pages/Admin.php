<?php

namespace PZN\Playground\Pages;

use Settings\General;

use \PZN\Playground\API\SettingsPagesAPI as SettingsAPI;

class Admin {
    
    private $page_name = 'pzn_playground';
    private $admin_page;

    private static $instance;

    private function __construct() {

        // Criar lista de páginas a serem construídas
        $pages = [
            [
                'title'             => 'Playground Plusings from Pedro Nunes',
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
        $subpages = [];
        // $subpages = [
        //     [
        //         'parent_slug'       => $this->page_name,
        //         'title'             => 'Test Plugin',
        //         'menu_title'        => 'General',
        //         'capability'        => 'manage_options',
        //         'page_slug'         => $this->page_name,
        //         'callback_function' => ''
        //     ],
        //     [
        //         'parent_slug'       => $this->page_name,
        //         'title'             => 'Test Plugin',
        //         'menu_title'        => 'sub',
        //         'capability'        => 'manage_options',
        //         'page_slug'         => 'pzn_playground_test',
        //         'callback_function' => function() { echo '<h1>a</h1>';}
        //     ],
        // ];

        // Inicializar cada página a ser construída
        $this->admin_page = new Settings\General( $this->page_name );

        // Envia as listas de parâmetros pro API que vai gerar as páginas de acordo com as funções de callback enviadas
        new SettingsAPI( $pages, $subpages );
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
    }
}