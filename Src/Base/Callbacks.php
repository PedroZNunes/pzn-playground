<?php

namespace PZN\Playground\Base;

use PZN\Playground\Constants;
use PZN\Playground\Pages\Settings\Settings;

final class Callbacks {
    static private $cpt;
    static private $dashboard;
    static private $db_connection;

    static public function get_template ( Settings $sender ) {
        $classname = get_class ( $sender );
        // $filename = preg_match('/\\(?:.(?!\\))+$/', $classname); //
        $filenames = explode( '\\', $classname );
        
        //preg_match('/\\(?:.(?!\\))+$/', $classname, $filename); //
        $filepath = Constants::BASE_DIR . Constants::TEMPLATES_DIR . array_pop( $filenames ) . '.php';
        include_once ( $filepath );
    }
    
}
