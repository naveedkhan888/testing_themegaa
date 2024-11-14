<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;


global $product;

// Ensure visibility
if (! $product || ! $product->is_visible()) {
    return;
}

$woo_display = themename_xptheme_woocommerce_get_display_mode();

$show_des 		= isset($show_des) ? $show_des : false;
$countdown 		= isset($countdown) ? $countdown : false;
$flash_sales 	= isset($flash_sales) ? $flash_sales : false;

// Increase loop count
 
// Extra post classes
$classes    = array();
$skin       = themename_xptheme_get_theme();
if ((isset($list) && $list === 'list')) {
    $inner = $list;
} elseif (empty($list) && $woo_display == 'list') {
    $inner = 'list';
} else {
    $inner = 'inner';
}
?>
<div <?php wc_product_class( $classes, $product ); ?>>
	<?php 
    if( $inner === 'list' ) {
        wc_get_template( 'item-product/list.php' ); 
    } else {
        wc_get_template( 'item-product/skins/'.$skin.'/'.$inner.'.php', array('show_des'=> $show_des, 'countdown'=> $countdown, 'flash_sales'=> $flash_sales ) ); 
    }
    ?>
</div>

