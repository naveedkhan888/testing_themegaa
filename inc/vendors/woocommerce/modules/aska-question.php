<?php
if ( !lasa_woocommerce_activated() ) return;

/**
 * ------------------------------------------------------------------------------------------------
 * Size Guide button
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('lasa_the_aska_question')) {
    function lasa_the_aska_question( $product_id )
    {
        $aska_question          = maybe_unserialize(lasa_tbay_get_config('single_aska_question'));

        if( empty(trim($aska_question)) ) return;
        
        wp_enqueue_script('jquery-magnific-popup');
        wp_enqueue_style('magnific-popup');


        $title = lasa_tbay_get_config('single_aska_question_title');
        $icon = lasa_tbay_get_config('single_aska_question_icon');

        $product    = wc_get_product( $product_id );
        $image_id   = $product->get_image_id();
        $image      = wp_get_attachment_image( $image_id, 'woocommerce_thumbnail' );
        ?>
        <li class="item tbay-aska-question">
            <a href="#tbay-content-aska-question" class="popup-button-open">
                <?php 
                    if( !empty($icon) ) {
                        echo '<i class="'. esc_attr($icon). '"></i>';
                    }
                ?>
                <span><?php echo esc_html($title); ?></span>
            </a>
            <div id="tbay-content-aska-question" class="tbay-popup-content popup-aska-question zoom-anim-dialog mfp-hide">
                <div class="content">
                    <h3 class="tbay-headling-popup"><?php esc_html_e('Ask a Question', 'lasa'); ?></h3>
                    <div class="tbay-product d-flex">
                        <div class="image">
                            <?php echo trim($image); ?>  
                        </div>
                        <div class="product-info">
                            <h4 class="name"><?php echo trim($product->get_name()); ?></h4>
                            <span class="price"><?php echo trim($product->get_price_html()); ?></span>
                        </div>
                    </div>
                    <div class="tbay-wrap">
                        <?php echo do_shortcode($aska_question); ?>
                    </div>
                </div>
            </div>
        </li>
        <?php
    }
}