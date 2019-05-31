<?php

echo 'The plugin was uninstalled';
        
if ( ! defined ( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

// // delete all plugin data from the db
// $articles = get_posts( array( 'post_type' => 'article', 'numberposts' => -1 ) );

// foreach( $articles as $article ) {
//     wp_delete_post( $article->ID, true );
// }

// Acessar o banco de dados por SQL
global $wpdb;
// deletar todos os dados com post type 'article'
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'article'" );

// já que deletamos todos os articles, podemos limpar as outras tabelas usando a wp_posts como refetencia
// aqui deletamos todos os meta dados dos posts que não estão presentes no wp_posts (q foram apagados na query acima)
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );

// aqui a mesma coisa, mas essa table aeh responsável pela relação entre terms e taxonomies. 
// o princípio é o mesmo da query acima, usar a wp_posts como referência
$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );

