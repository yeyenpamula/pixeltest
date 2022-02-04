<?php

/**
 * Thanks to https://www.businessbloomer.com
 */

/**
 * @snippet       Add Custom Field @ WooCommerce Checkout Page
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 3.8
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
  
add_action( 'woocommerce_before_order_notes', 'bbloomer_add_custom_checkout_field' );
  
function bbloomer_add_custom_checkout_field( $checkout ) { 
   woocommerce_form_field( 'date_of_delivery', array(        
      'type' => 'text',        
      'class' => array( 'form-row-wide' ),        
      'label' => 'Date of Delivery',        
      'placeholder' => 'YYYY-MM-DD',        
      'required' => true,        
      'default' => date('Y-m-d'),        
   ), $checkout->get_value( 'date_of_delivery' ) ); 
}

/**
 * @snippet       Validate Custom Field @ WooCommerce Checkout Page
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 3.8
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
add_action( 'woocommerce_checkout_process', 'bbloomer_validate_new_checkout_field' );
  
function bbloomer_validate_new_checkout_field() {    
   if ( ! $_POST['date_of_delivery'] ) {
      wc_add_notice( 'Please enter Date of Delivery !', 'error' );
   }
}

/**
 * @snippet       Save & Display Custom Field @ WooCommerce Order
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 3.8
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
add_action( 'woocommerce_checkout_update_order_meta', 'bbloomer_save_new_checkout_field' );

// save date of delivery
function bbloomer_save_new_checkout_field( $order_id ) { 
    if ( $_POST['date_of_delivery'] ) update_post_meta( $order_id, '_date_of_delivery', esc_attr( $_POST['date_of_delivery'] ) );
}

// show date of delivery on detail order after billing address
add_action( 'woocommerce_admin_order_data_after_billing_address', 'bbloomer_show_new_checkout_field_order', 10, 1 );
   
function bbloomer_show_new_checkout_field_order( $order ) {    
   $order_id = $order->get_id();
   if ( get_post_meta( $order_id, '_date_of_delivery', true ) ) echo '<p><strong>Date of Delivery:</strong> ' . get_post_meta( $order_id, '_date_of_delivery', true ) . '</p>';
}

// add date of delivery on email order
add_action( 'woocommerce_email_after_order_table', 'bbloomer_show_new_checkout_field_emails', 20, 4 );
  
function bbloomer_show_new_checkout_field_emails( $order, $sent_to_admin, $plain_text, $email ) {
    if ( get_post_meta( $order->get_id(), '_date_of_delivery', true ) ) echo '<p><strong>Date of Delivery:</strong> ' . get_post_meta( $order->get_id(), '_date_of_delivery', true ) . '</p>';
}