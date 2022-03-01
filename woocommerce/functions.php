<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'et-font-awesome',get_stylesheet_directory_uri().'/css/font-awesome.css', array( 'fonts' ) );

    if ( is_rtl() ) {
        wp_enqueue_style("rtl-style",get_stylesheet_directory_uri().'/rtl.css', array('parent-style') );
    }
}

add_filter( 'wpo_wcpdf_invoice_title', 'wpo_wcpdf_invoice_title', 10, 2 );
function wpo_wcpdf_invoice_title ( $title, $document ) {
    $title = 'Online Proforma Invoice';
    return $title;
}

function show_loggedin_function( $atts ) {

	global $current_user, $user_login;
      	
	wp_get_current_user();
	add_filter('widget_text', 'do_shortcode');
	if ($user_login) 
		return ' <b>Welcome</b> <b>' . $current_user->display_name . '</b><b>!</b>';
	else
		return '<a href="https://www.albastakionline.com/login"><b>PLEASE LOGIN TO YOUR ACCOUNT</b></a>';
	
}
add_shortcode( 'show_loggedin_as1', 'show_loggedin_function' );

add_filter( 'yikes_woo_filter_all_product_tabs', 'yikes_woo_hide_tabs_from_non_logged_in_users', 10, 2 );

function yikes_woo_hide_tabs_from_non_logged_in_users( $tabs, $product ) {

	if ( isset( $tabs['discount'] ) && ! is_user_logged_in() ) {
		unset( $tabs['discount'] );
	}

	return $tabs;
}

/* Remove Add to cart from single product page */

add_action( 'init', 'hide_add_cart_not_logged_in' );

function hide_add_cart_not_logged_in() { 
if ( !is_user_logged_in() ) { 
    
    remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
    

}
}




add_filter( 'use_widgets_block_editor', '__return_false' );


// // disable zxcvbn.min.js in wordpress
// add_action( 'wp_print_scripts', function () {
// 	// Deregister script about password strength meter
// 	wp_dequeue_script('zxcvbn-async');
// 	wp_deregister_script('zxcvbn-async');
// } );

// /**
//  * @snippet       Disable WooCommerce Ajax Cart Fragments On Static Homepage
//  * @how-to        Get CustomizeWoo.com FREE
//  * @author        Rodolfo Melogli
//  * @compatible    WooCommerce 3.6.4
//  * @donate $9     https://businessbloomer.com/bloomer-armada/
//  */
 
// add_action( 'wp_enqueue_scripts', 'bbloomer_disable_woocommerce_cart_fragments', 11 ); 
 
// function bbloomer_disable_woocommerce_cart_fragments() { 
//    if ( is_front_page() ) wp_dequeue_script( 'wc-cart-fragments' ); 
// }