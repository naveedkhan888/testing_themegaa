<?php

if ( !lasa_is_woo_variation_swatches_pro() ) return;

if ( ! function_exists( 'lasa_quantity_swatches_pro_field_archive' ) ) {
    function lasa_quantity_swatches_pro_field_archive( ) {

        global $product;
        if ( lasa_is_quantity_field_archive() ) {
            woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
        }

    }
}

if ( ! function_exists( 'lasa_variation_swatches_pro_group_button' ) ) {
    add_action('lasa_woo_before_shop_loop_item_caption', 'lasa_variation_swatches_pro_group_button', 5);
    function lasa_variation_swatches_pro_group_button() {
        if( !lasa_is_woo_variation_swatches_pro() ) return;

        $class_active = '';

        if( lasa_woocommerce_quantity_mode_active() ) {
            $class_active .= 'quantity-group-btn';

            if( lasa_is_quantity_field_archive() ) {
                $class_active .= ' active';
            }
        } else { 
            $class_active .= 'woo-swatches-pro-btn';
        }

        echo '<div class="'. esc_attr($class_active) .'">';

            if( lasa_woocommerce_quantity_mode_active() ) {
                lasa_quantity_swatches_pro_field_archive();
            }

            woocommerce_template_loop_add_to_cart();
        echo '</div>';
    }
}