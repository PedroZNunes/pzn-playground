<?php
/**
 * @package: PedroNunesPlugin
 */

namespace PZN\Playground\Pages\Settings;
use \PZN\Playground\Pages\Section as Section;

/*
* Classe base a todas as classes de inicialização
*/
abstract class Settings {
    protected $constants;

    protected $page_name;
    protected $form_name;

    protected $opt_group_name;
    
    protected $sections = array();
    protected $opt_name;
    protected $opt_values;

    public function __construct( string $page_name ) {
        $this->constants = \PZN\Playground\Constants::class;

        $this->page_name = $page_name;

        $this->register();
   }

   protected function access_check() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'you cannot access this page. DENIED', 'Access Denied' );
        }
    }
    
    protected abstract function register();
    
    protected abstract function create_sections();
    public abstract function print_page();

    // inicialização dos campos e seções
    public function page_init() {
        register_setting( 
            $this->opt_group_name,
            $this->opt_name, 
            array ( $this, 'sanitize' )
        );

    }
    
    protected function add_fields() {
        
        foreach ( $this->sections as $section ) {
            add_settings_section( 
                $section->get_name(), 
                $section->get_title(), 
                $section->get_callback(), 
                $section->get_page_name()
            );

            $fields = $section->get_fields();
            if ( ! empty( $fields ) ) {
                foreach ( $fields as $field ) {
                    $args = [
                        'name' => $field->get_name(),
                        'type' => $field->get_type()
                    ];
                    add_settings_field( 
                        $field->get_name(),
                        $field->get_title(),
                        $field->get_callback(),
                        $section->get_page_name(),
                        $section->get_name(),
                        $args
                    );
                }
            }
        }
    }
    

    //print a form field
    public function print_field( $args ) {
        $id    = $args['name'];
        $type  = $args['type'];

        $name  = $this->opt_name . "[$id]";
        $value = isset( $this->opt_values[$id] ) ? esc_attr(  $this->opt_values[$id] ) : '';

        echo $this->print_input_tag($type, $name, $id, $value);
    }

    public function psection_info() {}

    /**
     * Validação dos campos conforme necessário
     * @param   array $input Contains all settings fields as array keys
     * @return  array new sanitized inputs
     */
    public function sanitize( $input ) {
        $new_input = array();

        foreach ( $this->sections as $section ) {
            foreach ( $section->get_fields() as $field ) {
                if ( isset( $input[$field->get_name()] ) ) {
                    if ( $field->get_type() == 'text' ) {
                        $new_input[$field->get_name()] = sanitize_text_field( $input[$field->get_name()] );
                    }
                }
            }
        }

        return $new_input;
    }
    
    /**
     * @return string Text containing the HTML tag for the corresponding input field
     */
    private function print_input_tag(string $type, string $name, string $id, string $value='', string $autocomplete='') {
        $open_tag = "<input ";
        $close_tag = ">";

        $type_tag         = 'type="'         . $type . '" ';
        $name_tag         = 'name="'         . $name . '" ';
        $id_tag           = 'id="'           . $id   . '" ';
        $value_tag        = 'value="'        . (isset( $value ) ? esc_attr( $value ) : '') . '" ';
        $autocomplete_tag = 'autocomplete="' . $autocomplete . '" ';

        $out = $open_tag . $type_tag . $name_tag . $id_tag . $value_tag . $autocomplete_tag . $close_tag;
        return $out;
    }

 }