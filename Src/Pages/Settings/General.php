<?php
/**
 * @package: PedroNunesPlugin
 */

namespace PZN\Playground\Pages\Settings;

use \PZN\Playground\Pages\Section as Section;

/**
 * Cria a pagina de settings principal
 */
final class General {

    private $page_name;
    private $form_name      = 'filter-form';
    private $opt_group_name = 'pzn_playground_opt_group';
    
    private $sections       = array();

    private $opt_name       = 'nyt_options';
    private $opt_values;

    public function __construct( string $page_name ) {
        $this->page_name    = $page_name;
        
        // Read in existing option value from database
        $this->opt_values   = get_option( $this->opt_name );

        $this->create_sections();

        $this->register();
    }


    private function access_check() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'you cannot access this page. DENIED', 'Access Denied' );
        }
    }
        /**
     * create the sections and fields used in the form using custom classes Field and Section
     */
    private function create_sections() {
        $filters_section = new Section (
            'filters', 
            'Archive Search Filters', 
            array( $this, 'psection_info' ), 
            $this->page_name
        );

        $filters_section->add_field(
            'news_desk',
            'News Desk',
            array( $this, 'print_field' ),
            'text'
        );

        $filters_section->add_field(
            'source',
            'Source',
            array( $this, 'print_field' ),
            'text'
        );

        array_push( $this->sections, $filters_section );
    }

    private function register() { 
        add_action( 'admin_init', [$this, 'page_init'] );
    }

    // inicialização dos campos e seções
    public function page_init() {
        register_setting( 
            $this->opt_group_name,
            $this->opt_name, 
            array ( $this, 'sanitize' )
        );

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


    public function print_page(){
        $this->access_check();

        echo '<div class="wrap">';

        echo "<h2>" . __( 'New York Times Archives Plugin', 'pzn-nyt' ) . "</h2>"; ?>

        <!-- settings form -->
        <form name=<?php esc_attr_e( $this->form_name, 'pzn_playground' ); ?> method="post" action="options.php">

        <?php
        // This prints out all hidden setting fields
        settings_fields( $this->opt_group_name );
        do_settings_sections( $this->page_name );
        submit_button();
        
        echo '</form>';
        echo '</div>';
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
                }
            }
        }

        return $new_input;
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
