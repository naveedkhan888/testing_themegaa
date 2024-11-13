<?php
/**
 * Single Product stock.
 *
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if (! defined('ABSPATH')) {
    exit;
}
$stock_style    = themename_tbay_get_config('single_stock_style', 'style1');
?>
<?php if(  $stock_style === 'style1' || $class === 'out-of-stock' ) : ?>
<p class="stock <?php echo esc_attr($class); ?>"><?php echo wp_kses_post($availability); ?></p>
<?php else : ?>
<?php themename_single_product_stock_style2($class, $product); ?>
<?php endif; ?>