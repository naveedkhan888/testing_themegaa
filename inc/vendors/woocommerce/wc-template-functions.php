<?php
if ( !themename_woocommerce_activated() ) return;

if (!function_exists('themename_xptheme_get_woocommerce_mini_cart')) {
    function themename_xptheme_get_woocommerce_mini_cart($args = array())
    {
        $args = wp_parse_args(
            $args,
            array(
                'icon_mini_cart'                => [
                    'value' => 'tb-icon tb-icon-bag',
                ],
                'show_title_mini_cart'          => '',
                'title_mini_cart'               => esc_html__('Shopping cart', 'themename'),
                'title_dropdown_mini_cart'      => esc_html__('Shopping cart', 'themename'),
                'price_mini_cart'               => '',
            )
        );

        $position = apply_filters('themename_cart_position', 10, 2);
 
        $mark = '';
        if (!empty($position)) {
            $mark = '-';
        }

        wc_get_template('cart/mini-cart-button'.$mark.$position.'.php', array('args' => $args)) ;
    }
}

if (!function_exists('themename_xptheme_woocommerce_get_cookie_display_mode')) {
    function themename_xptheme_woocommerce_get_cookie_display_mode()
    {
        $woo_mode = themename_xptheme_get_config('product_display_mode', 'grid');

        if (isset($_COOKIE['themename_display_mode']) && $_COOKIE['themename_display_mode'] == 'grid') {
            $woo_mode = 'grid';
        } elseif (isset($_COOKIE['themename_display_mode']) && $_COOKIE['themename_display_mode'] == 'grid2') {
            $woo_mode = 'grid2';
        } elseif (isset($_COOKIE['themename_display_mode']) && $_COOKIE['themename_display_mode'] == 'list') {
            $woo_mode = 'list';
        }

        return $woo_mode;
    }
}

if (!function_exists('themename_xptheme_woocommerce_get_display_mode')) {
    function themename_xptheme_woocommerce_get_display_mode()
    {
        $woo_mode = themename_xptheme_woocommerce_get_cookie_display_mode();

        if (isset($_GET['display_mode']) && $_GET['display_mode'] == 'grid') {
            $woo_mode = 'grid';
        } elseif (isset($_GET['display_mode']) && $_GET['display_mode'] == 'list') {
            $woo_mode = 'list';
        }

        if ( !themename_woo_is_vendor_page() && !is_shop() && !is_product_category() && !is_product_tag()) {
            $woo_mode = 'grid';
        }


        return $woo_mode;
    }
}


/*Check not child categories*/
if (!function_exists('themename_is_check_not_child_categories')) {
    function themename_is_check_not_child_categories()
    {
        if (is_product_category()) {
            $cat   = get_queried_object();
            $cat_id     = $cat->term_id;

            $args2 = array(
                'taxonomy'     => 'product_cat',
                'parent'       => $cat_id,
            );

            $sub_cats = get_categories($args2);
            if (!$sub_cats) {
                return true;
            }
        }

        return false;
    }
}

/*Check not product in categories*/
if (!function_exists('themename_is_check_hidden_filter')) {
    function themename_is_check_hidden_filter()
    {
        if (is_product_category()) {
            $checkchild_cat     =  themename_is_check_not_child_categories();

            if (!$checkchild_cat &&  'subcategories' === get_option('woocommerce_category_archive_display')) {
                return true;
            }
        }

        return false;
    }
}


// get layout configs
if (!function_exists('themename_xptheme_get_woocommerce_layout_configs')) {
    function themename_xptheme_get_woocommerce_layout_configs() {
        if(function_exists('dokan_is_store_page') && dokan_is_store_page() ) {
            return;
        }

        if (!is_product()) {
            $page = 'product_archive_sidebar';
        } else {
            $page = 'product_single_sidebar';
        }

        $sidebar = themename_xptheme_get_config($page);


        if (!is_singular('product')) {
            $product_archive_layout  =   (isset($_GET['product_archive_layout'])) ? $_GET['product_archive_layout'] : themename_xptheme_get_config('product_archive_layout', 'shop-left');


            if (themename_woo_is_mvx_vendor_store()) {
                $sidebar = 'mvx-marketplace-store';

                if (!is_active_sidebar($sidebar)) {
                    $configs['main'] = array( 'class' => 'archive-full' );
                }
            }

            if (function_exists('dokan_is_store_page') && dokan_is_store_page() && dokan_get_option('enable_theme_store_sidebar', 'dokan_appearance', 'off') === 'off') {
                $product_archive_layout = 'full-width';
            }

            if (isset($product_archive_layout)) {
                switch ($product_archive_layout) {
                    case 'shop-left':
                        $configs['sidebar'] = array( 'id'  => $sidebar, 'class' => 'xptheme-sidebar-shop col-12 col-xl-3'  );
                        $configs['main']    = array( 'class'    => 'col-12 col-xl-9' );
                        break;
                    case 'shop-right':
                        $configs['sidebar'] = array( 'id' => $sidebar,  'class' => 'xptheme-sidebar-shop col-12 col-xl-3' );
                        $configs['main']    = array( 'class'    => 'col-12 col-xl-9' );
                        break;
                    default:
                        $configs['main']    = array( 'class' => 'archive-full' );
                        $configs['sidebar'] = array( 'id'  => $sidebar, 'class' => 'sidebar-desktop'  );
                        break;
                }

                if (($product_archive_layout === 'shop-left' ||  $product_archive_layout === 'shop-right') && (empty($configs['sidebar']['id']) || !is_active_sidebar($configs['sidebar']['id']))) {
                    $configs['main'] = array( 'class' => 'archive-full' );
                }
            }
        } else {
            $product_single_layout  =   (isset($_GET['product_single_layout']))   ?   $_GET['product_single_layout'] :  themename_get_single_select_layout();
            $class_main = '';
            $class_sidebar = '';
            if ($product_single_layout == 'left-main' || $product_single_layout == 'main-right') {
                $class_main = 'col-12 col-xl-9';
                $class_sidebar = 'col-12 col-xl-3';

                $sidebar = themename_xptheme_get_config('product_single_sidebar', 'product-single');
            }
            if (isset($product_single_layout)) {
                switch ($product_single_layout) {
                    case 'vertical-left':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'vertical';
                        $configs['position']        = 'vertical-left';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'vertical-right':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'vertical';
                        $configs['position']        = 'vertical-right';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'horizontal-bottom':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'horizontal';
                        $configs['position']        = 'horizontal-bottom';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'horizontal-top':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'horizontal';
                        $configs['position']        = 'horizontal-top';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'stick':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'stick';
                        $configs['position']        = 'stick-full';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'gallery':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'gallery';
                        $configs['position']        = 'gallery-full';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'left-main':
                        $configs['sidebar']         = array( 'id'  => $sidebar, 'class' => $class_sidebar  );
                        $configs['main']            = array( 'class' => $class_main );
                        $configs['thumbnail']       = 'horizontal';
                        $configs['position']        = 'horizontal-bottom';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'main-right':
                        $configs['sidebar']         = array( 'id'  => $sidebar, 'class' => $class_sidebar  );
                        $configs['main']            = array( 'class' => $class_main );
                        $configs['thumbnail']       = 'horizontal';
                        $configs['position']        = 'horizontal-bottom';
                        $configs['breadscrumb']     = 'color';
                        break;
                    default:
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'horizontal';
                        $configs['position']        = 'horizontal-bottom';
                        $configs['breadscrumb']     = 'color';
                        break;
                }

                if (($product_single_layout === 'left-main' ||  $product_single_layout === 'main-right') && (empty($configs['sidebar']['id']) || !is_active_sidebar($configs['sidebar']['id']))) {
                    $configs['main'] = array( 'class' => 'archive-full' );
                }
            }
        }

        return $configs;
    }
}

if (!function_exists('themename_class_wrapper_start')) {
    function themename_class_wrapper_start()
    {
        $configs['content']                 = 'content';
        $configs['main']                    = 'main-wrapper ';

        if( function_exists('dokan_is_store_page') && dokan_is_store_page() ) return $configs;

        $sidebar_configs                    = themename_xptheme_get_woocommerce_layout_configs();
        $configs['content']                 = themename_add_cssclass($configs['content'], $sidebar_configs['main']['class']);

        if (!is_product()) {
            $configs['content']  = themename_add_cssclass($configs['content'], 'archive-shop');
            $class_main         =  (isset($_GET['product_archive_layout'])) ? $_GET['product_archive_layout'] : themename_xptheme_get_config('product_archive_layout', 'shop-left');


            $configs['main']  = themename_add_cssclass($configs['main'], $class_main);
        } elseif (is_product()) {
            $configs['content']  = themename_add_cssclass($configs['content'], 'singular-shop');

            $class_main         =  (isset($_GET['product_single_layout']))   ?   $_GET['product_single_layout'] :  themename_xptheme_get_config('product_single_layout', 'horizontal-bottom');


            $configs['main']  = themename_add_cssclass($configs['main'], $class_main);
        }

        return $configs;
    }
}

//get value fillter
if (! function_exists('themename_woocommerce_get_fillter')) {
    function themename_woocommerce_get_fillter($name, $default)
    {
        if (isset($_GET[$name])) :
            return $_GET[$name]; else :
            return $default;
        endif;
    }
}

//Count product of category

if (! function_exists('themename_get_product_count_of_category')) {
    function themename_get_product_count_of_category($cat_id)
    {
        $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => -1,
            'tax_query'             => array(
                array(
                    'taxonomy'      => 'product_cat',
                    'field' => 'term_id', //This is optional, as it defaults to 'term_id'
                    'terms'         => $cat_id,
                    'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                ),
                array(
                    'taxonomy'      => 'product_visibility',
                    'field'         => 'slug',
                    'terms'         => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
                    'operator'      => 'NOT IN'
                )
            )
        );
        $loop = new WP_Query($args);

        return $loop->found_posts;
    }
}

//Count product of tag

if (! function_exists('themename_get_product_count_of_tags')) {
    function themename_get_product_count_of_tags($tag_id)
    {
        $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => -1,
            'tax_query'             => array(
                array(
                    'taxonomy'      => 'product_tag',
                    'field' => 'term_id', //This is optional, as it defaults to 'term_id'
                    'terms'         => $tag_id,
                    'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                ),
                array(
                    'taxonomy'      => 'product_visibility',
                    'field'         => 'slug',
                    'terms'         => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
                    'operator'      => 'NOT IN'
                )
            )
        );
        $loop = new WP_Query($args);

        return $loop->found_posts;
    }
}


/*Remove filter*/
if (! function_exists('themename_woocommerce_sub_categories')) {
    function themename_woocommerce_sub_categories($echo = true)
    {
        ob_start();

        wc_set_loop_prop('loop', 0);
        
        $loop_start = apply_filters('themename_get_woocommerce_sub_categories', ob_get_clean());

        if ($echo) {
            echo trim($loop_start); // WPCS: XSS ok.
        } else {
            return $loop_start;
        }
    }
}


if (! function_exists('themename_is_product_variable_sale')) {
    function themename_is_product_variable_sale()
    {
        global $product;

        $class =  '';
        if ($product->is_type('variable') && $product->is_on_sale()) {
            $class = 'xptheme-variable-sale';
        }
        
        return $class;
    }
}

if (! function_exists('themename_woo_content_class')) {
    function themename_woo_content_class($class = '')
    {
        $sidebar_configs = themename_xptheme_get_woocommerce_layout_configs();

        if (!(isset($sidebar_configs['right']) && is_active_sidebar($sidebar_configs['right']['sidebar'])) && !(isset($sidebar_configs['left']) && is_active_sidebar($sidebar_configs['left']['sidebar']))) {
            $class .= ' col-12';
        }
        
        return $class;
    }
}

if (! function_exists('themename_wc_wrapper_class')) {
    function themename_wc_wrapper_class($class = '')
    {
        $content_class = themename_woo_content_class($class);
        
        return apply_filters('themename_wc_wrapper_class', $content_class);
    }
}


if (!function_exists('themename_find_matching_product_variation')) {
    function themename_find_matching_product_variation($product, $attributes)
    {
        foreach ($attributes as $key => $value) {
            if (strpos($key, 'attribute_') === 0) {
                continue;
            }

            unset($attributes[ $key ]);
            $attributes[ sprintf('attribute_%s', $key) ] = $value;
        }

        if (class_exists('WC_Data_Store')) {
            $data_store = WC_Data_Store::load('product');
            return $data_store->find_matching_product_variation($product, $attributes);
        } else {
            return $product->get_matching_variation($attributes);
        }
    }
}

if (! function_exists('themename_get_default_attributes')) {
    function themename_get_default_attributes($product)
    {
        if (method_exists($product, 'get_default_attributes')) {
            return $product->get_default_attributes();
        } else {
            return $product->get_variation_default_attributes();
        }
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Compare button
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('themename_the_yith_compare')) {
    function themename_the_yith_compare($product_id)
    {
        if (class_exists('YITH_Woocompare')) { ?>
            <?php
                $action_add = 'yith-woocompare-add-product';
                $url_args = array(
                    'action' => $action_add,
                    'id' => $product_id
                );
            ?>
            <div class="yith-compare">
                <a href="<?php echo esc_url(wp_nonce_url(add_query_arg($url_args), $action_add)); ?>" title="<?php esc_attr_e('Compare', 'themename'); ?>" class="compare" data-product_id="<?php echo esc_attr($product_id); ?>">
                    <span><?php esc_html_e('Add to compare', 'themename'); ?></span>
                </a>
            </div>
        <?php }
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * WishList button
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('themename_the_yith_wishlist')) {
    function themename_the_yith_wishlist()
    {
        if (!class_exists('YITH_WCWL')) {
            return;
        }

        $enabled_on_loop = 'yes' == get_option('yith_wcwl_show_on_loop', 'no');

        if (!class_exists('YITH_WCWL_Shortcode') || $enabled_on_loop) {
            return;
        }

        $active         = themename_xptheme_get_config('enable_wishlist_mobile', false);
        
        $class_mobile   = ($active) ? 'shown-mobile' : '';

        echo '<div class="button-wishlist '. esc_attr($class_mobile) .'" title="'. esc_attr__('Wishlist', 'themename') . '">'.YITH_WCWL_Shortcode::add_to_wishlist(array()).'</div>';
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Flash Sale
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('themename_xptheme_class_flash_sale')) {
    function themename_xptheme_class_flash_sale($flash_sales)
    {
        global $product;

        if (isset($flash_sales) && $flash_sales) {
            $class_sale    = (!$product->is_on_sale()) ? 'xptheme-not-flash-sale' : '';
            return $class_sale;
        }
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Item Deal ended Flash Sale
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('themename_xptheme_item_deal_ended_flash_sale')) {
    function themename_xptheme_item_deal_ended_flash_sale($flash_sales, $end_date)
    {
        global $product;
    
        $today      = strtotime("today");


        if ($today > $end_date) {
            return;
        }

        $output = '';
        if (isset($flash_sales) && $flash_sales && !$product->is_on_sale()) {
            $output .= '<div class="item-deal-ended">';
            $output .= '<span>'. esc_html__('Deal ended', 'themename') .'</span>';
            $output .= '</div>';
        }
        echo trim($output);
    }
}


/**
 * ------------------------------------------------------------------------------------------------
 * The Count Down Flash Sale
 * ------------------------------------------------------------------------------------------------
 */
if (!function_exists('themename_xptheme_label_flash_sale')) {
    function themename_xptheme_label_flash_sale()
    {
        if ( !themename_xptheme_get_config('enable_text_time_coutdown', false) ) {
            $dates = array(
                'days' => '',
                'hours' => '',
                'mins' => '',
                'secs' => '',
            );
        } else {
            $dates = array(
                'days' => apply_filters('themename_xptheme_countdown_flash_sale_day', '<span class="label">'. esc_html__('days', 'themename') .'</span>'),
                'hours' => apply_filters('themename_xptheme_countdown_flash_sale_hour', '<span class="label">'. esc_html__('hours', 'themename') .'</span>'),
                'mins' => apply_filters('themename_xptheme_countdown_flash_sale_mins', '<span class="label">'. esc_html__('mins', 'themename') .'</span>'),
                'secs' => apply_filters('themename_xptheme_countdown_flash_sale_secs', '<span class="label">'. esc_html__('secs', 'themename') .'</span>'),

            );
        }
        return $dates;
    }
}
if (!function_exists('themename_xptheme_countdown_flash_sale')) {
    function themename_xptheme_countdown_flash_sale($time_sale = '', $date_title = '', $date_title_ended = '', $strtotime = false)
    {
        wp_enqueue_script('jquery-countdowntimer');
        $_id        = themename_xptheme_random_key();

        $today      = strtotime("today");
       
        $dates = themename_xptheme_label_flash_sale();
        $days = $dates['days'];
        $hours = $dates['hours'];
        $mins = $dates['mins'];
        $secs = $dates['secs'];
        if ($strtotime) {
            $time_sale = strtotime($time_sale);
        } ?>
        <?php if (!empty($time_sale)) : ?>
            <div class="flash-sales-date">
                <?php if (($today <= $time_sale)): ?>
                    <?php if (isset($date_title) && !empty($date_title)) :  ?>
                        <div class="date-title"><?php echo trim($date_title); ?></div>
                    <?php endif; ?>
                    <div class="time <?php echo ( themename_xptheme_get_config('enable_text_time_coutdown', false) ) ? 'label-coutdown' : '';?>">
                        <div class="xptheme-countdown" id="xptheme-flash-sale-<?php echo esc_attr($_id); ?>" data-time="timmer"
                             data-date="<?php echo date('m', $time_sale).'-'.date('d', $time_sale).'-'.date('Y', $time_sale).'-'. date('H', $time_sale) . '-' . date('i', $time_sale) . '-' .  date('s', $time_sale) ; ?>" data-days="<?php echo esc_attr($days); ?>" data-hours="<?php echo esc_attr($hours); ?>" data-mins="<?php echo esc_attr($mins); ?>" data-secs="<?php echo esc_attr($secs); ?>" >
                        </div>
                    </div>
                <?php else: ?>
                    
                <?php if (isset($date_title_ended) && !empty($date_title_ended)) :  ?>
                    <div class="date-title"><?php echo trim($date_title_ended); ?></div>
                <?php endif; ?>
            <?php endif; ?> 
            </div> 
        <?php endif; ?> 
        <?php
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Count Down Flash Sale
 * ------------------------------------------------------------------------------------------------
 */
if (!function_exists('themename_xptheme_stock_flash_sale')) {
    function themename_xptheme_stock_flash_sale($flash_sales = '')
    {
        global $product;

        if ($flash_sales && $product->get_manage_stock()) : ?>
            <div class="stock-flash-sale stock">
                <?php
                    $total_sales        = $product->get_total_sales();
                    $stock_quantity     = $product->get_stock_quantity();
                            
                    $total_quantity   = (int)$total_sales + (int)$stock_quantity;

                    $divi_total_quantity = ($total_quantity !== 0) ? $total_quantity : 1;

                    $sold             = (int)$total_sales / (int)$divi_total_quantity;
                    $percentsold      = $sold*100; 
                ?>
                <div class="progress">
                    <div class="progress-bar active" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr($percentsold); ?>%">
                    </div>
                </div>
                <span class="tb-sold">
                    <span class="available"><?php esc_html_e('Available', 'themename'); ?>: <span class="sold-vl"><?php echo esc_html($stock_quantity) ?></span></span>
                    <span class="sold"><?php esc_html_e('Sold', 'themename'); ?>: <?php ?><span class="sold-vl"><?php echo esc_html($total_sales) ?></span></span>
                </span>
            </div>
        <?php endif;
    }
}


/**
 * ------------------------------------------------------------------------------------------------
 * Product name
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('themename_the_product_name')) {
    function themename_the_product_name()
    {
        $active         = themename_xptheme_get_config('enable_one_name_mobile', false);

        $class_mobile   = ($active) ? 'full_name' : ''; 

        do_action( 'woocommerce_shop_loop_item_title' );
        ?>
        <h3 class="name <?php echo esc_attr($class_mobile); ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php
    }
}

if (! function_exists('themename_woo_is_mvx_vendor_store')) {
    function themename_woo_is_mvx_vendor_store()
    {
        if (! class_exists('MVX')) {
            return false;
        }

        global $MVX;
        if (empty($MVX)) {
            return false;
        }

        if (is_tax($MVX->taxonomy->taxonomy_name)) {
            return true;
        }

        return false;
    }
}

/**
 * Check is vendor page
 *
 * @return bool
 */
if (! function_exists('themename_woo_is_vendor_page')) {
    function themename_woo_is_vendor_page()
    {
        if (function_exists('dokan_is_store_page') && dokan_is_store_page()) {
            return true;
        }

        if (class_exists('WCV_Vendors') && method_exists('WCV_Vendors', 'is_vendor_page')) {
            return WCV_Vendors::is_vendor_page();
        }

        if (themename_woo_is_mvx_vendor_store()) {
            return true;
        }

        if (function_exists('wcfm_is_store_page') && wcfm_is_store_page()) {
            return true;
        }

        return false;
    }
}


/**
 * Check is vendor page
 *
 * @return bool
 */


if (! function_exists('themename_custom_product_get_rating_html')) {
    function themename_custom_product_get_rating_html($html, $rating, $count)
    {
        global $product;

        $output = '';

        $review_count = $product->get_review_count();

        if (empty($review_count)) {
            $review_count = 0;
        }

        $class = (empty($review_count)) ? 'no-rate' : '';

        $output .='<div class="rating '. esc_attr($class) .'">';
        $output .= $html;
        $output .= '<div class="count"><span>'. $review_count .'</span></div>';
        $output .= '</div>';

        echo trim($output);
    }
}


/**
 * ------------------------------------------------------------------------------------------------
 * Mini cart Button
 * ------------------------------------------------------------------------------------------------
 */
if (!function_exists('themename_xptheme_minicart_button')) {
    function themename_xptheme_minicart_button($icon, $enable_text, $text, $enable_price)
    {
        global $woocommerce; ?>

        <span class="cart-icon">

            <?php if (!empty($icon['value'])) : ?>
                <i class="<?php echo esc_attr($icon['value']); ?>"></i>
            <?php endif; ?>
            <span class="mini-cart-items">
               <?php echo sprintf('%d', $woocommerce->cart->cart_contents_count); ?>
            </span>
        </span>

        <?php if ((($enable_text === 'yes') && !empty($text)) || ($enable_price === 'yes')) { ?>
            <span class="text-cart">

            <?php if (($enable_text === 'yes') && !empty($text)) : ?>
                <span><?php echo trim($text); ?></span>
            <?php endif; ?>

            <?php if ($enable_price === 'yes') : ?>
                <span class="subtotal"><?php echo WC()->cart->get_cart_subtotal();?></span>
            <?php endif; ?>

        </span>

        <?php }
    }
}

/*product time countdown*/
if (!function_exists('themename_woo_product_time_countdown')) {
    function themename_woo_product_time_countdown($countdown = false, $countdown_title = '')
    {
        global $product;

        if (!$countdown) {
            return;
        }

        wp_enqueue_script('jquery-countdowntimer');
        $time_sale = get_post_meta($product->get_id(), '_sale_price_dates_to', true);
        $_id = themename_xptheme_random_key();
        $dates = themename_xptheme_label_flash_sale();
        $days = $dates['days'];
        $hours = $dates['hours'];
        $mins = $dates['mins'];
        $secs = $dates['secs']; ?>
        <?php if ($time_sale): ?>
            <div class="time <?php echo ( themename_xptheme_get_config('enable_text_time_coutdown', false) ) ? 'label-coutdown' : '';?>">
                <div class="timming">
                    <?php if (isset($countdown_title) && !empty($countdown_title)) :  ?>
                        <div class="date-title"><?php echo trim($countdown_title); ?></div>
                    <?php endif; ?>
                    <div class="xptheme-countdown" id="xptheme-flash-sale-<?php echo esc_attr($_id); ?>" data-time="timmer" data-date="<?php echo date('m', $time_sale).'-'.date('d', $time_sale).'-'.date('Y', $time_sale).'-'. date('H', $time_sale) . '-' . date('i', $time_sale) . '-' .  date('s', $time_sale) ; ?>" data-days="<?php echo esc_attr($days); ?>" data-hours="<?php echo esc_attr($hours); ?>" data-mins="<?php echo esc_attr($mins); ?>" data-secs="<?php echo esc_attr($secs); ?>">
                    </div>
                </div>
            </div> 
        <?php endif; ?> 
        <?php
    }
}
if (!function_exists('themename_woo_product_time_countdown_stock')) {
    function themename_woo_product_time_countdown_stock($countdown = false)
    {
        global $product;
        if (!$countdown) {
            return;
        }

        if ($product->get_manage_stock()) {?>
            <div class="stock">
                <?php
                    $total_sales    = $product->get_total_sales();
                    $stock_quantity   = $product->get_stock_quantity();

                    if ($stock_quantity >= 0) {
                        $total_quantity   = (int)$total_sales + (int)$stock_quantity;
                        $sold         = (int)$total_sales / (int)$total_quantity;
                        $percentsold    = $sold*100;
                    }
                 ?>
              
                <?php if (isset($percentsold)) { ?>
                    <div class="progress">
                        <div class="progress-bar active" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr($percentsold); ?>%">
                        </div>
                    </div>
                <?php } ?>
                <?php if ($stock_quantity >= 0) { ?>
                    <span class="tb-sold"><?php esc_html_e('Sold', 'themename'); ?> : <span class="sold"><?php echo esc_html($total_sales) ?></span><span class="total">/<?php echo esc_html($total_quantity) ?></span></span>
                <?php } ?>
            </div>
        <?php }
    }
}

if (! function_exists('themename_get_single_select_layout')) {
    function themename_get_single_select_layout()
    {
        $custom = get_post_meta(get_the_ID(), '_themename_single_layout_select', true);

        return empty($custom) ? themename_xptheme_get_config('product_single_layout', 'horizontal-bottom') : $custom;
    }
}

if (!function_exists('themename_xptheme_minicart')) {
    function themename_xptheme_minicart()
    {
        $template = apply_filters('themename_xptheme_minicart_version', '');
        get_template_part('woocommerce/cart/mini-cart-button', $template);
    }
}

if (!function_exists('themename_xptheme_display_custom_tab_builder')) {
    function themename_xptheme_display_custom_tab_builder($tabs)
    {
        global $tabs_builder;
        $tabs_builder = true;
        $args = array(
            'name'        => $tabs,
            'post_type'   => 'xptheme_customtab',
            'post_status' => 'publish',
            'numberposts' => 1
        );

        $tabs = array();

        $posts = get_posts($args);
        foreach ($posts as $post) {
            $tabs['title'] = $post->post_title;
            $tabs['content'] = do_shortcode($post->post_content);
            return $tabs;
        }
        $tabs_builder = false;
    }
}

if (! function_exists('themename_get_product_categories')) {
    function themename_get_product_categories()
    {
        $category = get_terms(
            array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
            )
        );
        $results = array();
        if (!is_wp_error($category)) {
            foreach ($category as $category) {
                $results[$category->slug] = $category->name.' ('.$category->count.') ';
            }
        }
        return $results;
    }
}

if (!function_exists('themename_get_thumbnail_gallery_item')) {
    function themename_get_thumbnail_gallery_item()
    {
        return apply_filters('themename_get_thumbnail_gallery_item', 'flex-control-nav.flex-control-thumbs li');
    }
}

if (!function_exists('themename_get_gallery_item_class')) {
    function themename_get_gallery_item_class()
    {
        return apply_filters('themename_get_gallery_item_class', "woocommerce-product-gallery__image");
    }
}

if (! function_exists('themename_video_type_by_url')) {
    /**
     * Retrieve the type of video, by url
     *
     * @param string $url The video's url
     *
     * @return mixed A string format like this: "type:ID". Return FALSE, if the url isn't a valid video url.
     *
     * @since 1.1.0
     */
    function themename_video_type_by_url($url)
    {
        $parsed = parse_url(esc_url($url));

        switch ($parsed['host']) {

            case 'www.youtube.com':
            case    'youtu.be':
                $id = themename_get_yt_video_id($url);

                return "youtube:$id";

            case 'vimeo.com':
            case 'player.vimeo.com':
                preg_match('/.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/', $url, $matches);
                $id = $matches[5];

                return "vimeo:$id";

            default:
                return apply_filters('themename_woocommerce_featured_video_type', false, $url);

        }
    }
}
if (! function_exists('themename_get_yt_video_id')) {
    /**
     * Retrieve the id video from youtube url
     *
     * @param string $url The video's url
     *
     * @return string The youtube id video
     *
     * @since 1.1.0
     */
    function themename_get_yt_video_id($url)
    {
        $pattern =
            '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x';
        $result  = preg_match($pattern, $url, $matches);
        if (false !== $result) {
            return $matches[1];
        }

        return false;
    }
}

if (! function_exists('themename_get_product_menu_bar')) {
    function themename_get_product_menu_bar()
    {
        $menu_bar   = themename_xptheme_get_config('enable_sticky_menu_bar', false);

        if (isset($_GET['sticky_menu_bar'])) {
            $menu_bar = $_GET['sticky_menu_bar'];
        }

        return $menu_bar;
    }
    add_filter('themename_woo_product_menu_bar', 'themename_get_product_menu_bar');
}


/*cart fragments*/
if (! function_exists('themename_added_cart_fragments')) {
    function themename_added_cart_fragments($fragments)
    {
        ob_start();
        $cart = WC()->instance()->cart;
        $fragments['.mini-cart-items'] = '<span class="mini-cart-items">'.$cart->get_cart_contents_count().'</span>';
        $fragments['.subtotal'] = '<span class="subtotal">'.$cart->get_cart_subtotal().'</span>';

        return $fragments;
    }
    add_filter('woocommerce_add_to_cart_fragments', 'themename_added_cart_fragments', 10, 1);
}

// Quantity mode
if ( ! function_exists( 'themename_woocommerce_quantity_mode_active' ) ) {
    function themename_woocommerce_quantity_mode_active() {
        $catalog_mode = themename_catalog_mode_active();

        if( $catalog_mode ) return false;

        $active = themename_xptheme_get_config('enable_woocommerce_quantity_mode', false);

        $active = (isset($_GET['quantity_mode'])) ? $_GET['quantity_mode'] : $active;

        return $active;
    }
}

if ( ! function_exists( 'themename_quantity_field_archive' ) ) {
    function themename_quantity_field_archive( ) {

        global $product;
        if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
            woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
        }

    }
}

if ( ! function_exists( 'themename_is_quantity_field_archive' ) ) {
    function themename_is_quantity_field_archive( ) {
        global $product;

        if( $product && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
            $max_value = $product->get_max_purchase_quantity();
            $min_value = $product->get_min_purchase_quantity();

            if( $max_value && $min_value === $max_value ) {
                return false;     
            }
            
            return true;
        } else {
            return false;
        }
    }
}

if ( ! function_exists( 'themename_woocommerce_quantity_mode_add_class' ) ) {
    add_filter( 'woocommerce_post_class', 'themename_woocommerce_quantity_mode_add_class', 10, 2 );
    function themename_woocommerce_quantity_mode_add_class( $classes ){
        if( !themename_woocommerce_quantity_mode_active() ) return $classes;
        
        $classes[] = 'product-quantity-mode';

        return $classes;
    }
}

if ( ! function_exists( 'themename_woocommerce_quantity_mode_group_button' ) ) {
    function themename_woocommerce_quantity_mode_group_button() {
        if( !themename_woocommerce_quantity_mode_active() || themename_is_woo_variation_swatches_pro() ) return;

        global $product;
        if(  themename_is_quantity_field_archive() &&  $product->is_type( 'simple' ) ) {
            $class_active = 'active';
        } else {
            $class_active = '';
        } 

        echo '<div class="quantity-group-btn '. esc_attr($class_active) .'">';
            if( themename_is_quantity_field_archive() && $product->is_type( 'simple' ) ) {
                themename_quantity_field_archive();
            }
            woocommerce_template_loop_add_to_cart();
        echo '</div>';
    }
}  

if ( ! function_exists( 'themename_woocommerce_add_quantity_mode_grid' ) ) {
    add_action( 'themename_content_product_item_before', 'themename_woocommerce_add_quantity_mode_grid', 10 ); 
    function themename_woocommerce_add_quantity_mode_grid() {
        if( themename_is_woo_variation_swatches_pro() || themename_woocommerce_quantity_mode_active() ) {
            add_action('themename_woo_before_shop_loop_item_caption', 'themename_woocommerce_quantity_mode_group_button', 5);
            remove_action('themename_woocommerce_group_buttons', 'woocommerce_template_loop_add_to_cart', 50, 1);
            remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
            remove_action('themename_woocommerce_group_add_to_cart', 'woocommerce_template_loop_add_to_cart', 10, 1);
        }
    }
}

if ( ! function_exists( 'themename_woocommerce_add_quantity_mode_list' ) ) {
    function themename_woocommerce_add_quantity_mode_list() {
        if( themename_is_woo_variation_swatches_pro() || themename_woocommerce_quantity_mode_active() ) {
            add_action('woocommerce_after_shop_loop_item', 'themename_woocommerce_quantity_mode_group_button', 20);
            remove_action('themename_woocommerce_group_buttons_list', 'woocommerce_template_loop_add_to_cart', 40, 1);
        }

        if( themename_is_woo_variation_swatches_pro() ) {
            add_action('woocommerce_after_shop_loop_item', 'themename_variation_swatches_pro_group_button', 20);
        }
    }
}

if (! function_exists('themename_woocommerce_cart_item_name')) {
    function themename_woocommerce_cart_item_name($name, $cart_item, $cart_item_key)
    {
        if ( !themename_xptheme_get_config('show_checkout_image', true) || !is_checkout()) {
            return $name;
        }

        $_product       = $cart_item['data'];
        $thumbnail      = $_product->get_image('themename_photo_reviews_thumbnail_image');

        $output = $thumbnail;
        $output .= $name;

        return $output;
    }
    add_filter('woocommerce_cart_item_name', 'themename_woocommerce_cart_item_name', 10, 3);
}

if (! function_exists('themename_woocommerce_get_product_category')) {
    function themename_woocommerce_get_product_category()
    {
        global $product;
        echo wc_get_product_category_list($product->get_id(), ', ', '<span class="item-product-cate">', '</span>');
    }
}

if (!function_exists('themename_xptheme_woocommerce_full_width_product_archives')) {
    function themename_xptheme_woocommerce_full_width_product_archives($active)
    {
        $active = (isset($_GET['product_archive_layout'])) ? $_GET['product_archive_layout'] : themename_xptheme_get_config('product_archive_layout', 'full-width');

        if ($active === 'full-width') {
            $active = true;
        } else {
            $active = false;
        }

        return $active;
    }
    add_filter('themename_woo_width_product_archives', 'themename_xptheme_woocommerce_full_width_product_archives');
}


if (!function_exists('themename_add_image_sizes_wvs')) {
    function themename_add_image_sizes_wvs($image_subsizes)
    {
        $item = 'woocommerce_thumbnail';
        $size = wc_get_image_size($item);
    
        $title  = ucwords(str_ireplace(array( '-', '_' ), ' ', $item));
        $width  = $size[ 'width' ];
        $height = $size[ 'height' ];
        
        $image_subsizes[ $item ] = sprintf('%s (%d &times; %d)', $title, $width, $height);
    
        return $image_subsizes;
    }
    
    add_filter('wvs_get_all_image_sizes', 'themename_add_image_sizes_wvs', 10, 1);
}


if (!function_exists('themename_get_mobile_form_cart_style')) {
    function themename_get_mobile_form_cart_style()
    {
        $ouput = (!empty(themename_xptheme_get_config('mobile_form_cart_style', 'default'))) ? themename_xptheme_get_config('mobile_form_cart_style', 'default') : 'default';
    
        return $ouput;
    }
}


if (!function_exists('themename_open_woocommerce_catalog_ordering')) {
    function themename_open_woocommerce_catalog_ordering()
    {
        if( !themename_is_show_woo_catalog_ordering() ) return;

        echo '<div class="xptheme-ordering"><span>'. esc_html__('Sort by:', 'themename') .'</span>';
    }
    add_action('woocommerce_before_shop_loop', 'themename_open_woocommerce_catalog_ordering', 29);
}

if (!function_exists('themename_close_woocommerce_catalog_ordering')) {
    function themename_close_woocommerce_catalog_ordering()
    {
        if( !themename_is_show_woo_catalog_ordering() ) return;
        
        echo '</div>';
    }
    add_action('woocommerce_before_shop_loop', 'themename_close_woocommerce_catalog_ordering', 31);
}

if (!function_exists('themename_remove_add_to_cart_list_product')) {
    function themename_remove_add_to_cart_list_product()
    {
        remove_action('themename_woocommerce_group_buttons', 'woocommerce_template_loop_add_to_cart', 10);
    }
    add_action('themename_woocommerce_before_shop_list_item', 'themename_remove_add_to_cart_list_product', 10);
}


if (! function_exists('themename_compatible_checkout_order')) {
    function themename_compatible_checkout_order()
    {
        $active = false;

        if (class_exists('WooCommerce_Germanized')) {
            $active = true;
        }

        return $active;
    }
}

/*Get display product nav*/
if ( !function_exists('themename_xptheme_woocommerce_product_nav_display_mode') ) {
    function themename_xptheme_woocommerce_product_nav_display_mode($mode) {
        $mode = 'icon';

        $mode = (isset($_GET['display_nav_mode'])) ? $_GET['display_nav_mode'] : $mode;

        return $mode;
    }
    add_filter( 'themename_woo_nav_display_mode', 'themename_xptheme_woocommerce_product_nav_display_mode' );
}

/*Product nav icon*/
if ( !function_exists('themename_woo_product_nav_icon') ) {
    function themename_woo_product_nav_icon(){
          if ( themename_xptheme_get_config('show_product_nav', false) ) {
  
              $display_mode = apply_filters( 'themename_woo_nav_display_mode', 10,2 );
  
              $output = '';
  
              if( !is_singular( 'product' ) || (isset($display_mode) && $display_mode == 'image') ) return;
  
              $prev = get_previous_post();
              $next = get_next_post();
  
              $output .= '<div class="product-nav-icon pull-right">';  
              $output .= '<div class="link-icons">';
              $output .= themename_render_product_nav_icon($prev, 'left');
              $output .= themename_render_product_nav_icon($next, 'right');
              $output .= '</div>';
  
              $output .= '</div>';
  
              return $output;
          }
    }
}
if ( !function_exists('themename_render_product_nav_icon') ) {
    function themename_render_product_nav_icon($post, $position){
        if($post){
            $product = wc_get_product($post->ID);
            $output = '';
            $img = '';
            if(has_post_thumbnail($post)){
                $img = get_the_post_thumbnail($post, 'woocommerce_gallery_thumbnail');
            }
            $link = get_permalink($post);
  
            $output .= "<div class='". esc_attr( $position ) ."-icon icon-wrapper'>";
              $output .= "<div class='text'>";
  
                  $output .= ($position == 'left') ? "<a class='img-link left' href=". esc_url($link) ."><span class='product-btn-icon'></span>". esc_html__('Previous', 'themename') . "</a>" :'';                  
  
                  $output .= ($position == 'right') ? "<a class='img-link right' href=". esc_url($link) .">". esc_html__('Next', 'themename') . "<span class='product-btn-icon'></span></a>" :'';  
  
  
              $output .= "</div>";
              $output .= "<div class='image psnav'>";
              $output .= ($position == 'left') ? "<a class='img-link' href=". esc_url($link) .">". trim($img). "</a>" :'';  
              $output .= "<div class='product_single_nav_inner single_nav'>". themename_product_nav_inner_title_price($post, $product, $link) ."</div>";
              $output .= ($position == 'right') ? "<a class='img-link' href=". esc_url($link) .">". trim($img). "</a>" :'';   
              $output .= "</div>";
            $output .= "</div>";
  
            return $output;
        }
    }
}

if ( !function_exists('themename_product_nav_inner_title_price') ) {
    function themename_product_nav_inner_title_price($post, $product, $link){
  
        $ouput = "<a href=". esc_url($link) .">";
        $ouput .= "<span class='name-pr'>". esc_html($post->post_title) ."</span>";
  
        $is_catalog = ( get_post_meta( $product->get_id(), '_catalog', true) == 'yes' ) ? 'yes' : '';
  
        if( $is_catalog !== 'yes' ) {
          $ouput .=  "<span class='price'>" . $product->get_price_html() . "</span>";
        }
  
        $ouput .=  "</a>";
  
        return $ouput;
    }
}

if ( ! function_exists( 'themename_get_query_products' ) ) {
    function themename_get_query_products($categories = array(), $cat_operator = '', $product_type = 'newest', $limit = '', $orderby = '', $order = '')
    {
        $atts = [
            'limit' => $limit,
            'orderby' => $orderby,
            'order' => $order
        ];
        
        if (!empty($categories)) {
            if (!is_array($categories)) {
                $atts['category'] = $categories;
            } else {
                $atts['category'] = implode(', ', $categories);
                $atts['cat_operator'] = $cat_operator;
            }
        }
        
        $type = 'products';

        $shortcode = new WC_Shortcode_Products($atts, $type);
        $args = $shortcode->get_query_args();
        
        $args = themename_get_attribute_query_product_type($args, $product_type);
        return new WP_Query($args);
    }
}

if ( ! function_exists( 'themename_get_attribute_query_product_type' ) ) {
    function themename_get_attribute_query_product_type($args, $product_type)
    {
        switch ($product_type) {
            case 'best_selling':
                $args['meta_key']   = 'total_sales';
                $args['order']          = 'desc';
                $args['orderby']    = 'meta_value_num';
                $args['ignore_sticky_posts']   = 1;
                $args['meta_query'] = array();
                break;

            case 'featured':
                $args['ignore_sticky_posts']    = 1;
                $args['meta_query']             = array();
                $args['tax_query'][]              = array(
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN'
                    )
                );
                break;

            case 'top_rated':
                $args['meta_key']       = '_wc_average_rating';
                $args['orderby']        = 'meta_value_num';
                $args['order']          = 'desc';
                break;

            case 'newest':
                $args['meta_query'] = array();
                break;

            case 'random_product':
                $args['orderby']    = 'rand';
                $args['meta_query'] = array();
                break;

            case 'deals':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                $args['meta_query'] = array();
                $args['meta_query'][] =  array(
                    'relation' => 'AND',
                    array(
                        'relation' => 'OR',
                        array(
                            'key'           => '_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                        array(
                            'key'           => '_min_variation_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                    ),
                    array(
                        'key'           => '_sale_price_dates_to',
                        'value'         => time(),
                        'compare'       => '>',
                        'type'          => 'numeric'
                    ),
                );
                break;

            case 'on_sale':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                break;
        }

        if( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $args['meta_query'][] =  array(
                'relation' => 'AND',
                array(
                    'key' => '_stock_status',
                    'value' => 'instock',
                    'compare' => '=',
                )
            );
        }

        $product_visibility_term_ids = wc_get_product_visibility_term_ids();

        $args['tax_query'][] = array(
            'relation' => 'AND',
            array(
               'taxonomy' =>   'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => is_search() ? $product_visibility_term_ids[ 'exclude-from-search' ] : $product_visibility_term_ids[ 'exclude-from-catalog' ],
                'operator' =>   'NOT IN',
            )
        );

        return $args;
    }
}

if (! function_exists('themename_order_by_query')) {
    function themename_order_by_query($orderby, $order) {
        // it is always better to use WP_Query but not here
        $WC_Query_class = new WC_Query();

        switch ($orderby) {
            case 'id':
                $args['orderby'] = 'ID';
                break;
            case 'menu_order':
                $args['orderby'] = 'menu_order title';
                break;
            case 'title':
                $args['orderby'] = 'title';
                $args['order']   = ('DESC' === $order) ? 'DESC' : 'ASC';
                break;
            case 'relevance':
                $args['orderby'] = 'relevance';
                $args['order']   = 'DESC';
                break;
            case 'rand':
                $args['orderby'] = 'rand'; // @codingStandardsIgnoreLine
                break;
            case 'date':
                $args['orderby'] = 'date ID';
                $args['order']   = ('ASC' === $order) ? 'ASC' : 'DESC';
                break;
            case 'price':
            case 'price-desc':
                $callback = 'DESC' === $order ? 'order_by_price_desc_post_clauses' : 'order_by_price_asc_post_clauses';
                add_filter('posts_clauses', array( $WC_Query_class, $callback ));
                break;
            case 'popularity':
                add_filter('posts_clauses', array( $WC_Query_class, 'order_by_popularity_post_clauses' ));
                break;
            case 'rating':
                add_filter('posts_clauses', array( $WC_Query_class, 'order_by_rating_post_clauses' ));
                break;
        }
    }
}


if ( ! function_exists( 'themename_elementor_products_ajax_template' ) ) {
	function themename_elementor_products_ajax_template( $settings ) {
 
        extract($settings); 
   
        $loop = themename_get_query_products($categories, $cat_operator, $product_type, $limit, $orderby, $order);

        if ( preg_match('/\\\\/m', $attr_row) ) {
            $attr_row = preg_replace('/\\\\/m', '', $attr_row);
        }
		ob_start();

        if( $loop->have_posts() ) :

            wc_get_template('layout-products/layout-products.php', array( 'loop' => $loop, 'product_style' => $product_style, 'attr_row' => $attr_row));

        endif;

        wc_reset_loop();
		wp_reset_postdata();

        return [
            'html' => ob_get_clean(),
        ];
	}
}
if ( ! function_exists( 'themename_change_woocommerce_button_proceed_to_checkout' ) ) {
    function themename_change_woocommerce_button_proceed_to_checkout() { 
        remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
        add_action( 'themename_woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 10 );
    }
    add_action('woocommerce_before_cart','themename_change_woocommerce_button_proceed_to_checkout', 20);
}

if ( ! function_exists( 'themename_change_woocommerce_cross_sell_display' ) ) {
    function themename_change_woocommerce_cross_sell_display() { 
        remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
        add_action( 'themename_woocommerce_cross_sell_display', 'woocommerce_cross_sell_display', 10 );
    }
    add_action('woocommerce_before_cart','themename_change_woocommerce_cross_sell_display', 20);
}

if ( ! function_exists( 'themename_get_on_sale_query_args' ) ) {
    function themename_get_on_sale_query_args() { 
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1
        );

        $product_ids_on_sale    = wc_get_product_ids_on_sale();
        $product_ids_on_sale[]  = 0;
        $args['post__in'] = $product_ids_on_sale;

        return $args;
    }
}

if (!function_exists('themename_single_product_stock_style2')) {
    function themename_single_product_stock_style2( $class, $_product )
    {   
        if ($_product->get_manage_stock()) : ?>
            <div class="stock single-stock-style2 <?php echo esc_attr($class); ?>">
                <?php
                    $total_sales        = $_product->get_total_sales();
                    $stock_amount       = $_product->get_stock_quantity();
                            
                    $total_quantity   = (int)$total_sales + (int)$stock_amount;

                    $divi_total_quantity = ($total_quantity !== 0) ? $total_quantity : 1;

                    $sold             = (int)$total_sales / (int)$divi_total_quantity;
                    $percentsold      = $sold*100;  
                ?>
                <div class="progress">
                    <div class="progress-bar active" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr($percentsold); ?>%">
                    </div>
                </div>
                <div class="stock-bottom">
                    <div class="tb-available"><span class="stock-label"><?php esc_html_e('Available', 'themename'); ?>:</span> <span class="stock-value"><?php echo esc_html($stock_amount) ?></span></div>

                    <?php if( themename_xptheme_get_config('enable_total_sales', true) && $_product->get_type() !== 'external' ) : ?>
                        <div class="tb-sold"><span class="stock-label"><?php esc_html_e('Sold', 'themename'); ?>:</span> <span class="stock-value"><?php echo esc_html($total_sales) ?></span></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif;
    }
}

if ( ! function_exists( 'themename_product_active_button_popup_groups' ) ) {
	function themename_product_active_button_popup_groups( $product_id ) {
		$active = false;

		$aska_question          = maybe_unserialize(themename_xptheme_get_config('single_aska_question'));

        if( !empty($aska_question) ) return true;

		$delivery_return_type     = maybe_unserialize(get_post_meta($product_id, '_themename_delivery_return_type', true));

        if( !empty($delivery_return_type) && $delivery_return_type !== 'global' ) {
            $delivery_return          = maybe_unserialize(get_post_meta($product_id, '_themename_delivery_return', true));
        } else {
            $delivery_return          = maybe_unserialize(themename_xptheme_get_config('single_delivery_return'));
        }

		if( !empty($delivery_return) ) return true;


		$size_guide_type     = maybe_unserialize(get_post_meta($product_id, '_themename_size_guide_type', true));
		if( !empty($size_guide_type) && $size_guide_type !== 'global' ) {
            $size_guide          = maybe_unserialize(get_post_meta($product_id, '_themename_size_guide', true));
        } else {
            $size_guide          = maybe_unserialize(themename_xptheme_get_config('single_size_guide'));
        } 

        if( !empty($size_guide) ) return true;

		return $active;
	}
}

if ( ! function_exists( 'themename_product_popup_group_buttons' ) ) {
    function themename_product_popup_group_buttons() {
        global $product; 

        $product_id = method_exists($product, 'get_id') === true ? $product->get_id() : $product->ID;

        if( !themename_product_active_button_popup_groups($product_id) ) return; 
        ?>
        <ul class="xptheme-button-popup-wrap">
        <?php 
            themename_the_size_guide($product_id); 
            themename_the_delivery_return($product_id);
            themename_the_aska_question($product_id);
        ?>
        </ul>
    <?php
    }
}

if ( ! function_exists( 'themename_html_before_add_to_cart_button' ) ) {
    function themename_html_before_add_to_cart_button() {
        $content = themename_xptheme_get_config('html_before_add_to_cart_btn');
        if( !empty($content) ) {
            echo '<div class="xptheme-before-add-to-cart-btn">'. do_shortcode($content) .'</div>';
        }
    }
}

if ( ! function_exists( 'themename_html_after_add_to_cart_button' ) ) {
    function themename_html_after_add_to_cart_button()
    {
        $content = themename_xptheme_get_config('html_after_add_to_cart_btn');
        if( !empty($content) ) {
            echo '<div class="xptheme-after-add-to-cart-btn">'. do_shortcode($content) .'</div>';
        }
    }
}

if ( ! function_exists( 'themename_html_before_inner_product_summary' ) ) {
    function themename_html_before_inner_product_summary()
    {
        $content = themename_xptheme_get_config('html_before_inner_product_summary');
        if( !empty($content) ) {
            echo '<div class="xptheme-before-inner-product-summary">'. do_shortcode($content) .'</div>';
        }
    }
}

if ( ! function_exists( 'themename_html_after_inner_product_summary' ) ) {
    function themename_html_after_inner_product_summary()
    {
        $content = themename_xptheme_get_config('html_after_inner_product_summary');
        if( !empty($content) ) {
            echo '<div class="xptheme-after-inner-product-summary">'. do_shortcode($content) .'</div>';
        }
    }
}

if ( ! function_exists( 'themename_html_before_product_summary' ) ) {
    function themename_html_before_product_summary()
    {
        $content = themename_xptheme_get_config('html_before_product_summary');
        if( !empty($content) ) {
            echo '<div class="xptheme-before-product-summary">'. do_shortcode($content) . '</div>';
        }
    }
}

if ( ! function_exists( 'themename_html_after_product_summary' ) ) {
    function themename_html_after_product_summary()
    {
        $content = themename_xptheme_get_config('html_after_product_summary');
        if( !empty($content) ) {
            echo '<div class="xptheme-after-product-summary">'. do_shortcode($content) .'</div>';
        }
    }
}

if ( ! function_exists( 'themename_woocommerce_checkout_cart_item_quantity_filter' ) ) {
    add_filter( 'woocommerce_checkout_cart_item_quantity', 'themename_woocommerce_checkout_cart_item_quantity_filter', 1, 3 ); 
    function themename_woocommerce_checkout_cart_item_quantity_filter( $html, $cart_item, $cart_item_key ){
        
        if( themename_xptheme_get_config('show_checkout_quantity', false) ) {
            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
            $html = woocommerce_quantity_input(
                array(
                    'input_name'   => 'cart[' . $cart_item_key . '][qty]',
                    'input_value'  => $cart_item['quantity'],
                    'max_value'    => $_product->get_max_purchase_quantity(),
                    'min_value'    => '0',
                    'product_name' => $product_name
                ),
                $_product,
                false
            );
            
            return $html;
        } else {
            return $html;
        }
    }
}

if ( ! function_exists( 'themename_is_variable_product_out_of_stock' ) ) {
    function themename_is_variable_product_out_of_stock( $product ) {
        $children_count = 0; // initializing
        $variation_ids  = $product->get_visible_children();
            
        // Loop through children variations of the parent variable product
        foreach( $variation_ids as $variation_id ) {
            $variation = wc_get_product($variation_id); // Get the product variation Object
                
            if( ! $variation->is_in_stock() ) {
                $children_count++; // count out of stock children
            }
        }
        // Compare counts and return a boolean
        return count($variation_ids) == $children_count ? true : false;
    }
}

if ( ! function_exists( 'themename_woocommerce_single_title' ) ) {
    function themename_woocommerce_single_title() {
        the_title( '<h2 class="product_title entry-title">', '</h2>' );
    }
}

/*Get title vendor name in top bar mobile*/
if (! function_exists('themename_customize_woocommerce_pagination_args')) {
    function themename_customize_woocommerce_pagination_args($args)
    {
        $args['prev_text'] = is_rtl() ? '<i class="tb-icon tb-icon-arrow-right"></i>' : '<i class="tb-icon tb-icon-arrow-left"></i>';
        $args['next_text'] = is_rtl() ? '<i class="tb-icon tb-icon-arrow-left"></i>' : '<i class="tb-icon tb-icon-arrow-right"></i>';

        return $args;
    }
    add_filter('woocommerce_pagination_args', 'themename_customize_woocommerce_pagination_args', 10, 1);
}


/**
 *
 * Code used to change the price order in WooCommerce
 *
 * */
if(!function_exists('themename_woocommerce_price_html')){ 
    add_filter( 'woocommerce_format_sale_price', 'themename_woocommerce_price_html', 10, 3 );
    function themename_woocommerce_price_html( $price, $regular_price, $sale_price ) {
        // Define the pattern with capturing groups for the old and sale prices
        $pattern = '/(<del[^>]*>.*?<\/del>)(\s*<span class="screen-reader-text">.*?<\/span>\s*)(<ins[^>]*>.*?<\/ins>)(\s*<span class="screen-reader-text">.*?<\/span>)/s';

        // Define the replacement pattern to swap positions
        $replacement = '$3$4$1$2';

        return preg_replace($pattern, $replacement, $price);
    }
}

/*Fix page search when product_cat emty WOOF  v3.3.4.3*/
if (! function_exists('themename_woo_fix_form_search_cate_empty_woof_new_version')) {
    add_action( 'admin_init', 'themename_woo_fix_form_search_cate_empty_woof_new_version', 10 );
    function themename_woo_fix_form_search_cate_empty_woof_new_version()
    {
        $settings = get_option('woof_settings');

        $settings['force_ext_disable'] = 'url_request';

        update_option('woof_settings', $settings);
    }
}

if (! function_exists('themename_get_free_shipping_minimum')) {
    function themename_get_free_shipping_minimum($get_zone_locations = 'US') {
        if ( ! isset( $get_zone_locations ) ) return null;
    
        $result = null;
        $zone = null;
    
        $zones = WC_Shipping_Zones::get_zones();
        foreach ( $zones as $z ) {
            foreach ( $z['zone_locations'] as $zone_locations ) {
                if( $zone_locations->code == $get_zone_locations ) {
                    $zone = $z;
                    break;
                }
            }
        }

    
        if ( $zone ) {
            $shipping_methods_nl = $zone['shipping_methods'];

            $free_shipping_method = null;
            foreach ( $shipping_methods_nl as $method ) {
                if ( $method->id == 'free_shipping' ) {
                    $free_shipping_method = $method;
                    break;
                }
            }
            
        
            if ( $free_shipping_method ) {
                $result = $free_shipping_method->min_amount;
            }
        }

        return $result;
    }
}

if ( ! function_exists( 'themename_woocommerce_dequeue_script_layout_product' ) ) {
    add_action('wp_enqueue_scripts', 'themename_woocommerce_dequeue_script_layout_product', 10);
    function themename_woocommerce_dequeue_script_layout_product()
    {
        global $post;
        
        if ( is_product() || ( ! empty( $post->post_content ) && strstr( $post->post_content, '[product_page' ) ) ) {
            $sidebar_configs  = themename_xptheme_get_woocommerce_layout_configs();
            $images_layout      = ( !empty($sidebar_configs['thumbnail']) ) ? $sidebar_configs['thumbnail'] : 'horizontal';
    
            $images_layout_array = array('gallery', 'stick');
    
            if( in_array($images_layout, $images_layout_array) ) {
                wp_dequeue_script('flexslider');
                wp_dequeue_script('zoom');
            }
        }

    }
}