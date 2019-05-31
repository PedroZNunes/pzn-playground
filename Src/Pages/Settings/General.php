<?php

/**
 * @package: PedroNunesPlugin
 */

namespace PZN\NYT\Pages\Settings;

use \PZN\NYT\Pages\Section as Section;

/**
 * Cria a pagina de settings principal
 */
class General {

    private $page_name;
    private $form_name = 'filter-form';

    private $opt_group_name = 'pzn_nyt_opt_group';
    
    private $sections;

    private $opt_name = 'nyt_options';
    private $news_desk_opt_name = 'news_desk';
    private $source_opt_name = 'source';
    
    private $opt_values;

    public function __construct( string $page_name ) {
        $this->page_name = $page_name;

        $this->create_sections();

        $this->register();
        $this->print_page();
    }

    private function register() { 
        add_action( 'admin_init' , array( $this, 'page_init' ) );
    }

    

    // inicialização dos campos e seções
    public function page_init() {
        register_setting( 
            $this->opt_group_name,
            $this->opt_name, 
            array ( $this, 'sanitize' )
        );

        foreach ($this->sections as $section) {
            add_settings_section( 
                $section->get_name(), 
                $section->get_title(), 
                $section->get_callback(), 
                $section->get_page_name()
            );
        }

        add_settings_field( 
            $this->news_desk_opt_name, 
            'News Desk:', 
            array( $this, 'pfield_news_desk' ), 
            $this->page_name, 
            $this->filters_sect_name
        );
        
        add_settings_field( 
            $this->source_opt_name,
            'Source:', 
            array( $this, 'pfield_source' ), 
            $this->page_name, 
            $this->filters_sect_name
        );
    }

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
            array( $this, 'pfield_news_desk' )
        );

        $filters_section->add_field(
            'source',
            'Source',
            array( $this, 'pfield_source' )
        );

        array_push( $this->sections, $filters_section );
    }

    private function print_page(){
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'you cannot access this page. DENIED', 'Access Denied' );
        }

        // Read in existing option value from database
        $this->opt_values = get_option( $this->opt_name );

        echo '<div class="wrap">';

        echo "<h2>" . __( 'New York Times Archives Plugin', 'pzn-nyt' ) . "</h2>"; ?>

        <!-- settings form -->
        <form name=<?php esc_attr_e( $this->form_name, 'pzn_nyt' ); ?> method="post" action="options.php">

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
     *
     * @param array $input Contains all settings fields as array keys
     */

    public function sanitize( $input ) {
        $new_input = array();
        if( isset( $input[$this->news_desk_opt_name] ) )
            $new_input[$this->news_desk_opt_name] = sanitize_text_field( $input[$this->news_desk_opt_name] );

        if( isset( $input[$this->source_opt_name] ) )
            $new_input[$this->source_opt_name] = sanitize_text_field( $input[$this->source_opt_name] );

        return $new_input;
    }

    //print a form field
    public function pfield_news_desk() {
        $name = $this->opt_name . "[$this->news_desk_opt_name]";
        $value = isset( $this->opt_values[$this->news_desk_opt_name] ) ? esc_attr(  $this->opt_values[$this->news_desk_opt_name] ) : '';

        echo $this->print_input_tag('text', $name, $this->news_desk_opt_name, $value);
    }

    public function pfield_source() {
        $name = $this->opt_name . "[$this->source_opt_name]";
        $value = isset( $this->opt_values[$this->source_opt_name] ) ? esc_attr(  $this->opt_values[$this->source_opt_name] ) : '';
        
        echo $this->print_input_tag('text', $name, $this->source_opt_name, $value);
    }

    public function psection_info() {
        echo '<p> Echo inside the Section </p>';
    }
    
    private function print_input_tag(string $type, string $name, string $id, string $value='', string $autocomplete='') {
        $open_tag = "<input ";
        $close_tag = ">";

        $type_tag =  'type="' . $type . '" ';
        $name_tag =  'name="' . $name . '" ';
        $id_tag =    'id="'   . $id   . '" ';
        $value_tag = 'value="'. (isset( $value ) ? esc_attr( $value ) : '') . '" ';
        $autocomplete_tag = 'autocomplete="' . $autocomplete . '" ';

        $out = $open_tag . $type_tag . $name_tag . $id_tag . $value_tag . $autocomplete_tag . $close_tag;
        return $out;
    }


}
