<?php

/**
 * @package: PedroNunesPlugin
 */

namespace PZN\NYT\Base;

/** 
 * Classe responsável pela desativação correta do plugin.
 */
final class Deactivation extends Base {

    /**
     * Registra o método de desativação no hook do wordpress
     */
    protected function register() {
        register_deactivation_hook( $this->constants::MAIN_FILE, array( $this, 'on_deactivation' ) );
    }

    public function on_deactivation() {
        flush_rewrite_rules();
    }
}