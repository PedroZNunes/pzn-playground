<?php
/**
 * @package: PedroNunesPlugin
 */

namespace PZN\Playground\Base;

/*
* Classe base a todas as classes de inicialização
*/
abstract class Base {
   protected $constants;

   public function __construct() {
      $this->constants = \PZN\Playground\Constants::class;

      $this->register();
   }
    protected abstract function register();
 }