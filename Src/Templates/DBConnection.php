<div class="wrap">;

    <h2> <?php __( 'Database Connection Options', 'pzn_playground' ) ?> </h2>;

    <!-- settings form -->
    <form name=<?php esc_attr_e( $this->form_name, 'pzn_playground' ); ?> method="post" action="options.php">

        <?php
        // This prints out all hidden setting fields
        settings_fields( $this->opt_group_name );
        do_settings_sections( $this->page_name );
        submit_button();
        ?>

    </form>;
</div>