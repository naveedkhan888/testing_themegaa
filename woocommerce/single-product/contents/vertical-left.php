<?php
/**
 * The template Image layout normal
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Themename
 * @since Themename 1.0
 */

global $product;

//check Enough number image thumbnail
$attachment_ids 		= $product->get_gallery_image_ids();
$video_url              = $product->get_meta('_themename_video_url');

$class_thumbnail         = (empty($attachment_ids) && empty($video_url)) ? 'no-gallery-image' : '';
?>
<div class="single-main-content">

    <div class="row">
        <div class="image-mains col-lg-6 <?php echo esc_attr($class_thumbnail); ?>">
            <?php
                /**
                 * woocommerce_before_single_product_summary hook
                 *
                 * @hooked woocommerce_show_product_images - 20
                 */
                do_action('woocommerce_before_single_product_summary');
            ?>
        </div>

        <div class="information col-lg-6">
            <div class="summary entry-summary ">
                <?php
                    /**
                     * Hook: woocommerce_single_product_summary.
                     *
                     * @hooked woocommerce_template_single_title - 5
                     * @hooked woocommerce_template_single_rating - 10
                     * @hooked woocommerce_template_single_price - 10
                     * @hooked woocommerce_template_single_excerpt - 20
                     * @hooked woocommerce_template_single_add_to_cart - 30
                     * @hooked woocommerce_template_single_meta - 40
                     * @hooked woocommerce_template_single_sharing - 50
                     * @hooked WC_Structured_Data::generate_product_data() - 60
                     */
                    do_action('woocommerce_single_product_summary');
                ?>
            </div><!-- .summary -->
        </div>

    </div>
</div>
<?php
/**
 * woocommerce_after_single_product_summary hook
 *
 * @hooked woocommerce_output_product_data_tabs - 10
 * @hooked woocommerce_upsell_display - 15
 * @hooked woocommerce_output_related_products - 20
 */
do_action('woocommerce_after_single_product_summary');