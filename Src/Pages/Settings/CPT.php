<?php
/**
 * @package: PedroNunesPlugin
 */

namespace PZN\Playground\Pages\Settings;
use \PZN\Playground\Pages\Section as Section;


/**
 * Criar a página responsável por custom post types
 */
final class CPT extends Settings {

    protected function register() {  
        $this->form_name      = 'cpt-form';
        $this->opt_group_name = 'pzn_play_cpt_opt_group';
        $this->opt_name       = 'pzn_play_cpt_opt';

        // Read in existing option value from database
        $this->opt_values   = get_option( $this->opt_name );
        // $this->create_sections();
        
        add_action( 'admin_init', [$this, 'page_init'] );
    }

    /**
     * create the sections and fields used in the form using custom classes Field and Section
     */
    protected function create_sections() {
        $filters_section = new Section (
            'custom_post_type_section', 
            'Custom Post Type Section Header', 
            array( $this, 'psection_info' ), 
            $this->page_name
        );

        $filters_section->add_field(
            'cpt_option_a',
            'Option A',
            array( $this, 'print_field' ),
            'text'
        );

        $filters_section->add_field(
            'cpt_option_b',
            'Option B',
            array( $this, 'print_field' ),
            'text'
        );

        array_push( $this->sections, $filters_section );
    }


    public function create_page(){
        $this->access_check();
        $this->add_fields();

        $this->print_page();
    }

}
