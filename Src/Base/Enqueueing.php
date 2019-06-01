<?php
/**
 * @package: PedroNunesPlugin
 */

namespace PZN\NYT\Base;

/**
 * Classe responsável pela inicialização de todos os serviços do plugin.
 * Essa abordagem transforma as classes em serviços com funções específicas.
 */
final class Enqueueing extends Base {
        
    /**
     * Armazena todas as classes a serem inicializadas em uma fila
     * @return array() de classes
     */
    protected function register() {
        add_action ( 'admin_enqueue_scripts', array( $this, 'on_enqueue_scripts' ) );
    }
    
    /**
     * Enqueuing scripts and styles
     */ 
    public function on_enqueue_scripts() {
        wp_enqueue_script( 'pzn_nyt_admin_script', $this->constants::BASE_URL . '/assets/main_admin.js' );
        wp_enqueue_style(  'pzn_nyt_admin_style',  $this->constants::BASE_URL . '/assets/main_admin.css' );
    }

    
}