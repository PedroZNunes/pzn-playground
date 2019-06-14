<div class="wrap">;

    <h2> <?php __( 'My Playground plugin', 'pzn_playground' ); ?> </h2>

    <!-- settings form -->
    <form name=<?php esc_attr_e( $sender->form_name, 'pzn_playground' ); ?> method="post" action="options.php">

        <?php
        // This prints out all hidden setting fields
        settings_fields( $sender->opt_group_name );
        do_settings_sections( $sender->page_name );
        submit_button();
        ?>

    </form>
</div>