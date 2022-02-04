<?php
// callback function
function custom_woocommerce_shop_loop() { 
    
    $terms = get_terms([
        'taxonomy' => 'category',
    ]);
    
    foreach($terms as $term) {
      $args = array(
        'post_type' => 'product',
        'posts_per_page'  => -1,
        'tax_query' => array(
          array(
            'taxonomy' => 'designer',
            'field' => 'slug',
            'terms' => $term->slug,

          )
        )
      );
      
      $the_new_query = new WP_Query( $args ); 
      if ( $the_new_query->have_posts() ) : 
        echo '<h1>'.$term->name.'</h1>';
        echo '<ul>';
        while ( $the_new_query->have_posts() ) : $the_new_query->the_post();
        '<li>'.the_title().'</li>';
        endwhile;
        echo '</ul>';
      endif;
    }
}; 

// add the action 
add_action( 'woocommerce_shop_loop', 'custom_woocommerce_shop_loop', 10, 2 ); 
?>