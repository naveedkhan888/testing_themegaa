<?php
if ( !themename_woocommerce_activated() ) return;

// Two product thumbnail
if (!function_exists('themename_xptheme_woocommerce_get_two_product_thumbnail')) {
    function themename_xptheme_woocommerce_get_two_product_thumbnail()
    {
        global $product;

        $size = 'woocommerce_thumbnail';
        $placeholder = wc_get_image_size($size);
        $placeholder_width = $placeholder['width'];
        $placeholder_height = $placeholder['height'];
        $post_thumbnail_id =  $product->get_image_id();

        $output='';
        $class = 'image-no-effect';
        if (has_post_thumbnail()) {
            $attachment_ids = $product->get_gallery_image_ids();

            $class = ($attachment_ids && isset($attachment_ids[0])) ? 'attachment-shop_catalog image-effect' : $class;

            $output .= wp_get_attachment_image($post_thumbnail_id, $size, false, array('class' => $class ));

            if ($attachment_ids && isset($attachment_ids[0])) {
                $output .= wp_get_attachment_image($attachment_ids[0], $size, false, array('class' => 'image-hover' ));
            }
        } else {
            $output .= '<img src="'.wc_placeholder_img_src().'" alt="'. esc_attr__('Placeholder', 'themename'). '" class="'. esc_attr($class) .'" width="'. esc_attr($placeholder_width) .'" height="'. esc_attr($placeholder_height) .'" />';
        }
        return trim($output);
    }
}

// Slider product thumbnail
if (!function_exists('themename_xptheme_woocommerce_get_silder_product_thumbnail')) {
    function themename_xptheme_woocommerce_get_silder_product_thumbnail()
    {
        global $product;

        wp_enqueue_script('slick');
        wp_enqueue_script('themename-custom-slick');

        $size = 'woocommerce_thumbnail';
        $placeholder = wc_get_image_size($size);
        $placeholder_width = $placeholder['width'];
        $placeholder_height = $placeholder['height'];
        $post_thumbnail_id =  $product->get_image_id();

        $output='';
        $class = 'image-no-effect';

        if (has_post_thumbnail()) {
            $class = 'item-slider';

            $output .= '<div class="xptheme-product-slider-gallery">';

            $output .= '<div class="gallery_item first xptheme-image-loaded">'.wp_get_attachment_image($post_thumbnail_id, $size, false, array('class' => $class )).'</div>';

            $attachment_ids = $product->get_gallery_image_ids();

            foreach ($attachment_ids as $attachment_id) {
                $output .= '<div class="gallery_item xptheme-image-loaded">'.wp_get_attachment_image($attachment_id, $size, false, array('class' => $class )).'</div>';
            }

            $output .= '</div>';
        } else {
            $output .= '<div class="gallery_item first xptheme-image-loaded">';

            $output .= '<img src="'.wc_placeholder_img_src().'" alt="'. esc_attr__('Placeholder', 'themename') .'" class="'. esc_attr($class) .'" width="'. esc_attr($placeholder_width) .'" height="'. esc_attr($placeholder_height) .'" />';
            $output .= '</div>';
        }

        return trim($output);
    }
}

if (!function_exists('themename_product_block_image_class')) {
    function themename_product_block_image_class($class = '')
    {
        $images_mode   = apply_filters('themename_woo_display_image_mode', 10, 2);

        if ($images_mode !=  'slider') {
            return;
        }
        $class = ' has-slider-gallery';

        echo trim($class);
    }
}

if (!function_exists('themename_slick_carousel_product_block_image_class')) {
    function themename_slick_carousel_product_block_image_class($class = '')
    {
        $images_mode   = apply_filters('themename_woo_display_image_mode', 10, 2);

        if ($images_mode !=  'slider') {
            return;
        }
        $class = ' slick-has-slider-gallery';

        echo trim($class);
    }
}


if (!function_exists('themename_xptheme_product_class')) {
    function themename_xptheme_product_class($class = array())
    {

        $class_array    = array();

        $class_varible  = themename_is_product_variable_sale();

        $class    = trim(join(' ', $class));
        if (!is_array($class)) {
            $class = explode(" ", $class);
        }

        array_push($class_array, "product-block", "grid", "product", themename_xptheme_get_theme(), $class_varible);

        $class_array    = array_merge($class_array, $class);

        $class_array    = trim(join(' ', $class_array));

        echo 'class="' . esc_attr($class_array) . '"';
    }
}