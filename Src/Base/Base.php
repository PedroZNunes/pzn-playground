<?php

namespace PZN\NYT\Base;

/*
* Classe base a todas as classes de inicialização
*/
abstract class Base {
   protected $constants;

   public function __construct() {
      $this->constants = \PZN\NYT\Constants::class;

      $this->register();
   }
    protected abstract function register();
 }