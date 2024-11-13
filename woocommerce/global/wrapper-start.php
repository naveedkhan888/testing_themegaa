<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */
 
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$configs 			= themename_class_wrapper_start();
$sidebar_configs  	= themename_tbay_get_woocommerce_layout_configs();

$product_archive_layout  =   (isset($_GET['product_archive_layout'])) ? $_GET['product_archive_layout'] : themename_tbay_get_config('product_archive_layout', 'shop-left');
$product_single_layout  =   (isset($_GET['product_single_layout']))   ?   $_GET['product_single_layout'] :  themename_get_single_select_layout();
$class_row = '';


if (!is_singular('product')) {
    $class_row .= ($product_archive_layout === 'shop-right') ? ' tb-column-reverse' : '';
    $class_row .= ($product_archive_layout !== 'full-width') ? ' row-shop-sidebar' : '';

	if ( !themename_tbay_get_config('show_product_breadcrumb', false) ) {
		remove_action('themename_woo_template_main_wrapper_before', 'woocommerce_breadcrumb', 20);
	}
} else {
    $class_row .= ($product_single_layout === 'main-right') ? ' tb-column-reverse' : '';

	if ( !themename_tbay_get_config('show_single_product_breadcrumb', false) ) {
		remove_action('themename_woo_template_main_wrapper_before', 'woocommerce_breadcrumb', 20);
	}
}
?>
	<div id="main-wrapper" class="<?php echo esc_attr($configs['main']); ?>">
		<?php do_action('themename_woo_template_main_wrapper_before'); ?>

		<div id="main-container" class="container">
			<?php 
				if( !is_singular('product') && woocommerce_product_loop() ) {
					/**
					 * Hook: woocommerce_before_shop_loop.
					 *
					 * @hooked woocommerce_output_all_notices - 10
					 * @hooked woocommerce_result_count - 20
					 * @hooked woocommerce_catalog_ordering - 30
					 */
					do_action( 'woocommerce_before_shop_loop' );
				} 
			?>
			<div class="row <?php echo esc_attr($class_row); ?>">
				<?php if (!empty($sidebar_configs['sidebar']['id'])) {
					get_sidebar('shop');
				} ?>
				<div id="main" class="<?php echo themename_wc_wrapper_class($configs['content']) ;?>"><!-- .content -->

				<?php do_action('themename_woo_template_main_before'); ?>

				<?php $display_type = woocommerce_get_loop_display_mode();
					if('subcategories' === $display_type || 'both' === $display_type) { ?>
					<ul class="all-subcategories"><?php themename_woocommerce_sub_categories(); ?></ul>
				<?php } ?>