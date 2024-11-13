<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.1
 */

defined('ABSPATH') || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if (! function_exists('wc_get_gallery_image_html')) {
    return;
}

global $product;

$attachment_ids = $product->get_gallery_image_ids();

wp_enqueue_script('slick');
wp_enqueue_script('themename-custom-slick');

$sidebar_configs    = themename_tbay_get_woocommerce_layout_configs();
$images_layout      = ( !empty($sidebar_configs['thumbnail']) ) ? $sidebar_configs['thumbnail'] : 'horizontal';
$images_position      = ( !empty($sidebar_configs['position']) ) ? $sidebar_configs['position'] : 'horizontal-top';
$is_rtl 			= (is_rtl()) ? 'yes' : 'no'; 

$columns           = apply_filters('woocommerce_product_thumbnails_columns', 4);
$less_tablet           = apply_filters('woocommerce_product_thumbnails_columns_less_tablet', 5);
$post_thumbnail_id = $product->get_image_id();

$video_url              = $product->get_meta( '_aora_video_url' );

$wrapper_classes   = apply_filters('woocommerce_single_product_image_gallery_classes', array(
    'woocommerce-product-gallery',
    'woocommerce-product-gallery--' . ($product->get_image_id() ? 'with-images' : 'without-images'),
    'woocommerce-product-gallery--columns-' . absint($columns),
    'images', 
    ( !empty($attachment_ids) || !empty($video_url) ) ? 'has-gallery' : 'no-gallery',
));

?>



<div class="<?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?>" data-columns="<?php echo esc_attr($columns); ?>" data-tabletcolumns="<?php echo esc_attr($less_tablet); ?>" data-rtl="<?php echo esc_attr($is_rtl); ?>" data-position=<?php echo esc_attr($images_position); ?> data-layout=<?php echo esc_attr($images_layout); ?> style="opacity: 0; transition: opacity .25s ease-in-out;">

	<div class="woocommerce-product-gallery__wrapper">
		<?php
        do_action('themename_woocommerce_before_product_thumbnails');
        
        if ($product->get_image_id()) {
            $html = wc_get_gallery_image_html($post_thumbnail_id, true);
        } else {
            $wrapper_classname = $product->is_type( 'variable' ) && ! empty( $product->get_available_variations( 'image' ) ) ?
            'woocommerce-product-gallery__image woocommerce-product-gallery__image--placeholder' :
            'woocommerce-product-gallery__image--placeholder';
            $html              = sprintf( '<div class="%s">', esc_attr( $wrapper_classname ) );
            $html .= sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_attr__('Awaiting product image', 'themename'));
            $html .= '</div>';
        }

            
        echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
        do_action('woocommerce_product_thumbnails');
        
        ?>
	</div>
    <?php 
		do_action( 'themename_woocommerce_after_product_thumbnails' );
	?>
</div>
