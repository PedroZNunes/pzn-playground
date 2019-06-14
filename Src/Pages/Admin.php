<?php

namespace PZN\Playground\Pages;


use \PZN\Playground\API\SettingsPagesAPI as SettingsAPI;
USE \PZN\Playground\Templates as Templates;

class Admin {
    
    private $page_name = 'pzn_playground';
    private $admin_page;
    private $templateS_folder = 'Templates/';

    private static $instance;

    private function __construct() {

        // Criar lista de páginas a serem construídas
        $pages = [
            [
                'title'             => 'Playground Plugins from Pedro Nunes',
                'menu_title'        => 'Playground Plugin',
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
        $subpages = [
            [
                'parent_slug'       => $this->page_name,
                'title'             => 'Dashboard',
                'menu_title'        => 'General',
                'capability'        => 'manage_options',
                'page_slug'         => $this->page_name,
                'callback_function' => ''
            ],
            [
                'parent_slug'       => $this->page_name,
                'title'             => 'Random Submenu A',
                'menu_title'        => 'Database Connection',
                'capability'        => 'manage_options',
                'page_slug'         => $this->page_name . '_sub_a',
                'callback_function' => array( $this, 'create_sub_admin_page_a' ),
            ],
            [
                'parent_slug'       => $this->page_name,
                'title'             => 'Random Submenu B',
                'menu_title'        => 'Custom Post Types',
                'capability'        => 'manage_options',
                'page_slug'         => $this->page_name . '_sub_b',
                'callback_function' => array( $this, 'create_sub_admin_page_b' ),
            ]
        ];

        // Inicializar cada página a ser construída
        $this->admin_page = new Settings\Dashboard( $this->page_name );
        $this->db_conection_page = new Settings\DBConnection( $this->page_name );
        $this->cpt_page = new Settings\CPT( $this->page_name );

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
        $this->admin_page->create_page();
    }
        //função para imprimir as coisas na tela
    public function create_sub_admin_page_a() {
        $this->db_conection_page->create_page();
    }
        //função para imprimir as coisas na tela
    public function create_sub_admin_page_b() {
        $this->cpt_page->create_page();
    }
}