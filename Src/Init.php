<?php

/**
 * @package: PedroNunesPlugin
 */

namespace PZN\Playground;

/*
* Classe responsável pela inicialização de todos os serviços do plugin.
* Essa abordagem transforma as classes em serviços com funções específicas.
*/
final class Init{

    /*
    * Armazena todas as classes a serem inicializadas em uma fila
    * @return array() de classes
    */
    private static function get_services() {
        return [
            Base\Activation::class,
            Base\Links::class,
            Base\CPT::class,
            Base\Deactivation::class,
            Base\Enqueueing::class,
            Pages\Admin::class
        ];
    }

    // fila de serviços
    public static function register_services() {
        $instances = [];

        foreach ( self::get_services() as $class ) {
            if ( is_subclass_of( $class, 'PZN\\Playground\\Base\\Base' ) ) {
                $instances[$class] = self::instantiate( $class );
            } else if ( method_exists( $class, 'get_instance' ) ) { //if singleton
                $instances[$class] = $class::get_instance();
            }
        }
    }

    private static function instantiate( $class ) {
        return new $class();
    }
}