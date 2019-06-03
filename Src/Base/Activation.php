<?php
/**
 * @package: PedroNunesPlugin
 */

namespace PZN\Playground\Base;

/*
* Classe responsável pela ativação correta do plugin
*/
final class Activation extends Base {
    
    protected function register() {
        // registra a função de ativação do plugin no hook apropriado
        register_activation_hook( $this->constants::MAIN_FILE, array( $this, 'on_activation' ) );
    }

    /**
     * gerar um tipo custom de post, colunas custom no banco de dados, ou inicializar variáveis
     */
    public function on_activation() {
        // flush rewrite rules (contar pro wordpress q mexi no db pra q ele ajuste as regras de escrita (?))
        flush_rewrite_rules();
    }
}