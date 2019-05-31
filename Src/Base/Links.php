<?php

/**
 * @package: PedroNunesPlugin
 */

namespace PZN\NYT\Base;

/** 
 * Classe responsável pela criação de action links na página de ativação do plugin
 */
class Links extends Base {
    
    protected function register() {
        add_filter( 'plugin_action_links_' . $this->constants::PLUGIN_NAME, array( $this, 'setup_action_links' ) );        
        // add_filter( 'plugin_action_links_' . Constants::PLUGIN_NAME, array( $this, 'setup_action_links' ) );        
    }

    //add links to the plugins page, under the plugin name. settings, support, upgrade, stuff like that
    public function setup_action_links( $links ) {
        $settings_link = '<a href="admin.php?page=pzn_nyt_articles">' . __('Settings', 'pzn_nyt') . '</a>';
        array_push( $links, $settings_link );
        return $links;
    }
}
