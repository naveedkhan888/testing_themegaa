<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $post;

$heading = (apply_filters('woocommerce_product_description_heading', esc_html__('Product Description ', 'themename')));

?>
<div class="tbay-product-description <?php echo ( (bool) themename_tbay_get_config('enable_collapse_product_details_tab', false) ) ? 'fix-height' : '' ?>">
  <?php if ($heading): ?>
    <h2 class="title-desc"><?php echo esc_html($heading); ?></h2>
  <?php endif; ?>
 
  <div class="tbay-product-description--content"><?php the_content(); ?></div>
</div>