<?php
/**
 * @package: PedroNunesPlugin
 */

namespace PZN\Playground\Base;

/** 
 * Classe responsável pela desativação correta do plugin.
 */
final class Deactivation extends Base {

    protected function register() {
        register_deactivation_hook( $this->constants::MAIN_FILE, array( $this, 'on_deactivation' ) );
    }

    public function on_deactivation() {
        flush_rewrite_rules();
    }
}