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
    protected $page_builder;

    protected $constants;

    protected $page_name;
    protected $form_name;

    protected $opt_group_name;
    
    protected $sections = array();
    protected $opt_name;
    protected $opt_values;

    protected $template;

    public function __construct( string $page_name ) {
        $this->constants = \PZN\Playground\Constants::class;

        $this->page_name = $page_name;
        // register template  template
        $this->register_template();

        $this->register();
   }

   protected function access_check() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'you cannot access this page. DENIED', 'Access Denied' );
        }
    }
    
    protected function register_template() {
        $filenames = explode( '\\', get_called_class() );
        
        $filepath = $this->constants::BASE_DIR . $this->constants::TEMPLATES_DIR . array_pop( $filenames ) . '.php';
        $this->template = $filepath;
    }

    protected function print_page() {
        include_once ($this->template);
    }
    
    protected abstract function register();
    
    
    // inicialização dos campos e seções
    public function page_init() {
        $this->create_sections();
        $this->register_settings();
    }
    
    protected abstract function create_sections();
    
    protected function register_settings() {
        register_setting( 
            $this->opt_group_name,
            $this->opt_name, 
            array ( $this, 'sanitize' )
        );
    }
    
    public abstract function create_page();
    
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
                        'name'    => $field->get_name(),
                        'type'    => $field->get_type(),
                        'value'   => $field->get_default_value(),
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
    

    public function psection_info() {}


    //print a form field
    public function print_field( $args ) {
        $id      = $args['name'];
        $name    = $this->opt_name . "[$id]";
        $type    = $args['type'];
        $value   = $args['value'];
        $extra_tags = [];

        switch ($type) {
            case 'text':
                $value = isset( $this->opt_values[$id] ) ? esc_attr(  $this->opt_values[$id] ) : $args['value'];
                $autocomplete = 'autocomplete="" ';
                array_push( $extra_tags, $autocomplete );
                break;

            case 'checkbox':
                if ( ! isset( $this->opt_values[$id] ) ) {
                    $this->opt_values[$id] = '0';
                }
                $checked = $this->opt_values[$id];
                $checked = checked( 1, $checked, false ) . ' ';
                array_push( $extra_tags, $checked );

                $value = '1';
                break;

            default:
                
                break;
        }

            
        echo $this->print_input_tag($type, $name, $id, $value, $extra_tags);
    }

    /**
     * @return string Text containing the HTML tag for the corresponding input field
     */
    private function print_input_tag(string $type, string $name, string $id, string $value = '', array $extra_tags = [] ) {
        $open_tag    = "<input ";
        $close_tag   = ">";

        $type_tag         = 'type="'         . $type . '" ';
        $name_tag         = 'name="'         . $name . '" ';
        $id_tag           = 'id="'           . $id   . '" ';
        $value_tag        = 'value="'        . ( isset( $value ) ? esc_attr( $value ) : '' ) . '" ';

        $html = $open_tag . $type_tag . $name_tag . $id_tag . $value_tag;
        foreach ( $extra_tags as $tag ) {
            $html .= $tag;
        }
        $html .= $close_tag;
        return $html;
    }

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
                    elseif ( $field->get_type() == 'checkbox' ) {
                        $new_input[$field->get_name()] = ( $input[$field->get_name()] !== 0 ? 1 : 0 );
                    }
                }
            }
        }

        return $new_input;
    }
    

 }

