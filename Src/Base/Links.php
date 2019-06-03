<?php
/**
 * @package: PedroNunesPlugin
 */

namespace PZN\Playground\Base;

/** 
 * Classe responsável pela criação de action links na página de ativação do plugin
 */
final class Links extends Base {
    
    protected function register() {
        add_filter( 'plugin_action_links_' . $this->constants::PLUGIN_NAME, array( $this, 'setup_action_links' ) );        
    }

    //add links to the plugins page, under the plugin name. settings, support, upgrade, stuff like that
    public function setup_action_links( $links ) {
        $settings_link = '<a href="admin.php?page=pzn_playground">' . __('Settings', 'pzn_playground') . '</a>';
        array_push( $links, $settings_link );
        return $links;
    }
}
