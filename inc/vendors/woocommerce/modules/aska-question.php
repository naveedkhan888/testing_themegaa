<?php
if ( !themename_woocommerce_activated() ) return;

/**
 * ------------------------------------------------------------------------------------------------
 * Size Guide button
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('themename_the_aska_question')) {
    function themename_the_aska_question( $product_id )
    {
        $aska_question          = maybe_unserialize(themename_xptheme_get_config('single_aska_question'));

        if( empty(trim($aska_question)) ) return;
        
        wp_enqueue_script('jquery-magnific-popup');
        wp_enqueue_style('magnific-popup');


        $title = themename_xptheme_get_config('single_aska_question_title');
        $icon = themename_xptheme_get_config('single_aska_question_icon');

        $product    = wc_get_product( $product_id );
        $image_id   = $product->get_image_id();
        $image      = wp_get_attachment_image( $image_id, 'woocommerce_thumbnail' );
        ?>
        <li class="item xptheme-aska-question">
            <a href="#xptheme-content-aska-question" class="popup-button-open">
                <?php 
                    if( !empty($icon) ) {
                        echo '<i class="'. esc_attr($icon). '"></i>';
                    }
                ?>
                <span><?php echo esc_html($title); ?></span>
            </a>
            <div id="xptheme-content-aska-question" class="xptheme-popup-content popup-aska-question zoom-anim-dialog mfp-hide">
                <div class="content">
                    <h3 class="xptheme-headling-popup"><?php esc_html_e('Ask a Question', 'themename'); ?></h3>
                    <div class="xptheme-product d-flex">
                        <div class="image">
                            <?php echo trim($image); ?>  
                        </div>
                        <div class="product-info">
                            <h4 class="name"><?php echo trim($product->get_name()); ?></h4>
                            <span class="price"><?php echo trim($product->get_price_html()); ?></span>
                        </div>
                    </div>
                    <div class="xptheme-wrap">
                        <?php echo do_shortcode($aska_question); ?>
                    </div>
                </div>
            </div>
        </li>
        <?php
    }
}