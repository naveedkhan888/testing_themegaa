<?php
if ( !lasa_woocommerce_activated() ) return;

// breadcrumb for woocommerce page
if (!function_exists('lasa_tbay_woocommerce_breadcrumb_defaults')) {
    function lasa_tbay_woocommerce_breadcrumb_defaults($args)
    {
        if( lasa_checkout_optimized() ) return;
        
        global $post;

        if( is_product() ) {
            $breadcrumb_img = lasa_tbay_get_config('woo_single_breadcrumb_image');
            $breadcrumb_color = lasa_tbay_get_config('woo_single_breadcrumb_color');
            $breadcrumbs_layout = lasa_tbay_get_config('single_product_breadcrumb_layout', 'color');

            $breadcrumb_alignment = lasa_tbay_get_config('single_product_breadcrumb_text_alignment', 'center');
        } else {
            $breadcrumb_img = lasa_tbay_get_config('woo_breadcrumb_image');
            $breadcrumb_color = lasa_tbay_get_config('woo_breadcrumb_color');
            $breadcrumbs_layout = lasa_tbay_get_config('product_breadcrumb_layout', 'color');

            $breadcrumb_alignment = lasa_tbay_get_config('product_breadcrumb_text_alignment', 'center');
        }

        $style = array();
        $img = '';

        $sidebar_configs = lasa_tbay_get_woocommerce_layout_configs();



        if (isset($_GET['breadcrumbs_layout'])) {
            $breadcrumbs_layout = $_GET['breadcrumbs_layout'];
        }

        $class_container = '';
        if (isset($sidebar_configs['container_full']) &&  $sidebar_configs['container_full']) {
            $class_container = 'container-full';
        }

        switch ($breadcrumbs_layout) {
            case 'image':
                $breadcrumbs_class = ' breadcrumbs-image';
                break;
            case 'color':
                $breadcrumbs_class = ' breadcrumbs-color';
                break;
            case 'text':
                $breadcrumbs_class = ' breadcrumbs-text';
                break;
            default:
                $breadcrumbs_class  = ' breadcrumbs-text';
        }

        $breadcrumbs_class .= ' '.$breadcrumb_alignment;

        if (isset($breadcrumb_img['url']) && !empty($breadcrumb_img['url']) && $breadcrumbs_layout !=='color' && $breadcrumbs_layout !=='text') {
            $img = '<img src="'.esc_url($breadcrumb_img['url']).'" alt="'.esc_attr__('breadcrumb-img','lasa') .'" >';
        }

        if ($breadcrumb_color && $breadcrumbs_layout !== 'image') {
            $style[] = 'background-color:'.$breadcrumb_color; 
        }

        $estyle = (!empty($style) && $breadcrumbs_layout !=='text') ? ' style="'.implode(";", $style).'"':"";

        $title = $nav = '';

        if ($breadcrumbs_layout == 'image') {
            if (is_single() || is_shop() ) { 
                if( is_shop() ) {
                    $page_id = wc_get_page_id('shop');
                } else {
                    $page_id = get_queried_object()->term_id;
                }

                if( !is_product() ) {
                    //$title = '<h1 class="page-title">'. get_the_title($page_id) .'</h1>';
                }

            } elseif (is_archive()) {
                //$title = '<h1 class="page-title">'. single_cat_title('', false) .'</h1>'; 
            }  
        } else { 
            if( is_single() ) {
                $nav = lasa_woo_product_nav_icon();
                $breadcrumbs_class .= ' active-nav-icon';
            } 
            
        }

        $args['wrap_before'] = '<section id="tbay-breadcrumb" '.$estyle.' class="tbay-breadcrumb '.esc_attr($breadcrumbs_class).'">'.$img.'<div class="container '.$class_container.'"><div class="breadscrumb-inner">'. $title .'<ol class="tbay-woocommerce-breadcrumb breadcrumb">';
        $args['wrap_after'] = '</ol>'. $nav .'</div></div></section>';

        return $args;
    }
}