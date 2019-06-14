<?php
/**
 * @package: PedroNunesPlugin
 */

namespace PZN\Playground\Pages\Settings;
use \PZN\Playground\Pages\Section as Section;


/**
 * Cria a pagina de settings principal
 */
final class DBConnection extends Settings {

    protected function register() {  
        $this->form_name      = 'dbconnection-form';
        $this->opt_group_name = 'pzn_play_dbconn_opt_group';
        $this->opt_name       = 'pzn_play_dbconn_opt';

        // Read in existing option value from database
        $this->opt_values = get_option( $this->opt_name );
        $this->create_sections();
        
        add_action( 'admin_init', [$this, 'page_init'] );
    }


    /**
     * create the sections and fields used in the form using custom classes Field and Section
     */
    protected function create_sections() {
        $filters_section = new Section (
            'connection', 
            'Database Connection Options', 
            array( $this, 'psection_info' ), 
            $this->page_name
        );

        $filters_section->add_field(
            'dbconn_option_a',
            'Option A',
            array( $this, 'print_field' ),
            'text'
        );

        $filters_section->add_field(
            'dbconn_option_b',
            'Option B',
            array( $this, 'print_field' ),
            'text'
        );

        // array_push( $this->sections, $filters_section );


        // $checkbox_section = new Section (
        //     'connection_b', 
        //     'Database Connection Sub Options', 
        //     array( $this, 'psection_info' ), 
        //     $this->page_name
        // );

        // $checkbox_section->add_field(
        $filters_section->add_field(
            'dbconn_suboption_a',
            'Suboption A',
            array( $this, 'print_field' ),
            'checkbox',
            'Label for option one'
        );

        // $checkbox_section->add_field(
        $filters_section->add_field(
            'dbconn_suboption_b',
            'Suboption B',
            array( $this, 'print_field' ),
            'checkbox'
        );        
        
        // $checkbox_section->add_field(
        $filters_section->add_field(
            'dbconn_suboption_c',
            'Suboption C',
            array( $this, 'print_field' ),
            'checkbox'
        );

        array_push( $this->sections, $filters_section );

        // array_push( $this->sections, $checkbox_section );
    }

    public function create_page(){
        $this->access_check();
        $this->add_fields();

        $this->print_page();

    }

}
