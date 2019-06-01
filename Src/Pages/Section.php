<?php

/**
 * @package: PedroNunesPlugin
 */

namespace PZN\NYT\Pages;

/**
 
 */
class Section {
    private $name;
    private $title;
    private $callback_function;
    private $page_name;

    private $fields = array();

    public function __construct( string $name, string $title, callable $callback_function, string $page_name ) {
        $this->name = $name;
        $this->title = $title;
        $this->callback_function = $callback_function;
        $this->page_name = $page_name;
    }

    public function get_name()      { return $this->name; }
    public function get_title()     { return $this->title; }
    public function get_callback()  { return $this->callback_function; }
    public function get_page_name() { return $this->page_name; }
    public function get_fields()    { return $this->fields; }

    public function add_field( $name, $title, $callback_function, $input_type ) {
        $new_field = new Field( $name, $title, $callback_function, $this->page_name, $this, $input_type);
        array_push( $this->fields, $new_field );
    }
}
