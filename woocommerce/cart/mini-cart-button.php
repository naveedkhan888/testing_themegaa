<?php
    if ( class_exists('WOOCS') && WC()->cart->is_empty() ) wp_enqueue_script( 'wc-cart-fragments' );
    
    global $woocommerce;
    $_id = themename_tbay_random_key();
    
    extract($args);

    $data_dropdown = ( is_checkout() || is_cart() ) ? '' : 'data-bs-toggle="dropdown" aria-expanded="true" role="button" aria-haspopup="true" data-delay="0"';
?>
<div class="tbay-topcart normal">
    <div id="cart-<?php echo esc_attr($_id); ?>" class="cart-dropdown cart-popup dropdown">
        <a class="dropdown-toggle mini-cart" <?php echo trim($data_dropdown); ?> href="<?php echo ( is_checkout() ) ? wc_get_cart_url() : 'javascript:void(0);'; ?>" title="<?php esc_attr_e('View your shopping cart', 'themename'); ?>">    
            <?php  themename_tbay_minicart_button($icon_mini_cart, $show_title_mini_cart, $title_mini_cart, $price_mini_cart); ?>
        </a>   
        <?php if( !is_checkout() && !is_cart() ) : ?>         
            <div class="dropdown-menu">
                <div class="widget_shopping_cart_content">
                    <?php woocommerce_mini_cart(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>    