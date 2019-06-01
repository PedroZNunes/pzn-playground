<?php

/**
 * @package: PedroNunesPlugin
 */

namespace PZN\NYT\Pages;

/**
 
 */
class Field {
    private $name;
    private $title;
    private $callback_function;
    private $page_name;
    private $section;
    private $type;

    public function __construct( string $name, string $title, callable $callback_function, string $page_name, object $section, string $type)
    {
        $this->name = $name;
        $this->title = $title;
        $this->callback_function = $callback_function;
        $this->page_name = $page_name;
        $this->section = $section;
        $this->type = $type;
    }

    public function get_name()          { return $this->name; }
    public function get_title()         { return $this->title; }
    public function get_callback()      { return $this->callback_function; }
    public function get_page_name()     { return $this->page_name; }
    public function get_section_name()  { return $this->section->get_name(); }
    public function get_type()    { return $this->type; }
}
