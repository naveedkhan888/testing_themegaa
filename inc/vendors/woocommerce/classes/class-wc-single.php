<?php
if (! defined('ABSPATH') || !themename_woocommerce_activated()) {
    exit;
}

if (! class_exists('Themename_Single_WooCommerce')) :


    class Themename_Single_WooCommerce
    {
        public static $instance;
        protected $counter;

        public static function getInstance()
        {
            if (! isset(self::$instance) && ! (self::$instance instanceof Themename_Single_WooCommerce)) {
                self::$instance = new Themename_Single_WooCommerce();
            }

            return self::$instance;
        }

        /**
         * Setup class.
         *
         * @since 1.0
         *
         */
        public function __construct()
        {
            $this->counter = 0;

            add_action('after_setup_theme', array( $this, 'setup_support' ), 10);

            /*Group Product*/
            add_action('woocommerce_after_add_to_cart_button', array( $this, 'product_group_buttons'), 98);

            /*Group Product Affiliate*/
            add_action('woocommerce_before_single_product', array( $this, 'product_group_buttons_affiliate'), 10);

            /*Body Class*/
            add_filter('body_class', array( $this, 'body_class_single_one_page'), 10, 1);


            add_action('woocommerce_after_add_to_cart_button', array( $this, 'buy_now_html'), 5);

            /*Add To Cart Redirect*/
            add_filter('woocommerce_add_to_cart_redirect', array( $this, 'buy_now_redirect'), 99, 1);


            add_action('woocommerce_before_single_product', array( $this, 'product_group_buttons_out_of_stock'), 10);

            /*The list images review*/
            add_action('woocommerce_before_single_product_summary', array( $this, 'the_list_images_review'), 100);

            add_action('woocommerce_single_product_summary', array( $this, 'share_box_html'), 50);

            add_filter('post_class', array( $this, 'class_single_product'), 10, 1);

            add_filter('body_class', array( $this, 'class_body_single_product'), 10, 1);

            add_filter('themename_woo_tabs_style_single_product', array( $this, 'get_tabs_style_product'), 10, 1);

            add_action('woocommerce_before_add_to_cart_form', array( $this, 'the_product_single_time_countdown'), 25);
             

            if (!wp_is_mobile()) {
                add_action('woocommerce_before_single_product', array( $this, 'the_sticky_menu_bar'), 30);

                add_action('themename_sticky_menu_bar_product_summary', 'themename_woocommerce_single_title', 5);
                add_action('themename_sticky_menu_bar_product_summary', 'woocommerce_template_single_rating', 10);
                add_action('themename_sticky_menu_bar_product_summary', array( $this, 'the_product_single_one_page'), 15);


                add_action('themename_sticky_menu_bar_product_price_cart', 'woocommerce_template_single_price', 5);
                add_action('themename_sticky_menu_bar_product_price_cart', array( $this, 'the_sticky_menu_bar_custom_add_to_cart'), 10);
            }


            add_action('woocommerce_before_add_to_cart_button', array( $this, 'before_add_to_cart_form'), 97);
            add_action('woocommerce_after_add_to_cart_button', array( $this, 'close_after_add_to_cart_form'), 97);


            add_filter('woocommerce_output_related_products_args', array( $this, 'get_related_products_args'), 10, 1);

            /** Video **/
            add_action('woocommerce_product_thumbnails', array( $this, 'get_video_audio_content_last' ), 99);
            add_action('themename_woocommerce_before_product_thumbnails', array($this,'get_video_audio_content_first'), 10, 2);


            add_filter( 'woocommerce_single_product_zoom_enabled', array( $this, 'remove_support_zoom_image'), 10, 1 );

            add_filter('woocommerce_photo_reviews_thumbnail_photo', array( $this, 'get_photo_reviews_thumbnail_size'), 10, 2);
            add_filter('woocommerce_photo_reviews_large_photo', array( $this, 'get_photo_reviews_large_size'), 10, 2);

            /** Change size image photo reivew */
            add_filter('woocommerce_photo_reviews_reduce_array', array( $this, 'photo_reviews_reduce_array' ), 10, 1);

            /** Remove Review Tab */
            add_filter('woocommerce_product_tabs', array( $this, 'remove_review_tab'), 10);

            add_filter('woocommerce_product_tabs', array( $this, 'add_custom_product_tabs'), 20, 1);


            add_action('woocommerce_before_add_to_cart_button', array( $this, 'mobile_add_before_add_to_cart_button'), 10, 1);
            add_action('woocommerce_before_variations_form', array( $this, 'mobile_add_before_variations_form'), 10, 1);
            add_action('woocommerce_grouped_product_list_before', array( $this, 'mobile_before_grouped_product_list'), 10, 1);
            add_action('woocommerce_before_add_to_cart_form', array( $this, 'mobile_add_before_add_to_cart_form'), 20, 1);
            add_action('woocommerce_after_add_to_cart_form', array( $this, 'mobile_add_btn_after_add_to_cart_form'), 10, 1);
            
            add_action('woocommerce_after_add_to_cart_button', array( $this, 'custom_field_detail_product'), 25);
        }
        

        public function add_custom_product_tabs($tabs)
        {

            global $product;

            $product_id = method_exists($product, 'get_id') === true ? $product->get_id() : $product->ID;

            $tab_content    = maybe_unserialize(get_post_meta($product_id, '_themename_custom_tab_content', true));
            $name           = maybe_unserialize(get_post_meta($product_id, '_themename_custom_tab_name', true));
            $priority       = (int) maybe_unserialize(get_post_meta($product_id, '_themename_custom_tab_priority', true));

            if (empty($tab_content)) {
                return $tabs;
            }   

            $content = do_shortcode($tab_content);

            $tabs['themename-customtab'] = array(
                'title'		=> $name,
                'priority'	=> $priority,
                'callback'	=> array( $this, 'custom_product_tab_panel_content' ),
                'content'   => $content,
            );

            return $tabs;
        }

        public function custom_product_tab_panel_content($key, $tab)
        {
            echo trim($tab['content']);
        }

        public function setup_support()
        {
            add_theme_support('wc-product-gallery-zoom');
            add_theme_support('wc-product-gallery-lightbox');
            add_theme_support('wc-product-gallery-slider');

            if (class_exists('YITH_Woocompare')) {
                update_option('yith_woocompare_compare_button_in_products_list', 'no');
                update_option('yith_woocompare_compare_button_in_product_page', 'no');
            }

            if (class_exists('YITH_WCWL')) {
                update_option('yith_wcwl_button_position', 'shortcode');
            }
            if (class_exists('YITH_WCBR')) {
                update_option('yith_wcbr_single_product_brands_content', 'name');
            }

            add_filter('woocommerce_get_image_size_gallery_thumbnail', array( $this, 'get_image_size_gallery_thumbnail'), 10, 1);

            $ptreviews = $this->photo_reviews_thumbnail_image();

            add_image_size('themename_photo_reviews_thumbnail_image', $ptreviews['width'], $ptreviews['height'], $ptreviews['crop']);
        }

        public function get_image_size_gallery_thumbnail()
        {
            $xptheme_thumbnail_width       = get_option('xptheme_woocommerce_thumbnail_image_width', 100);
            $xptheme_thumbnail_height      = get_option('xptheme_woocommerce_thumbnail_image_height', 133);
            $xptheme_thumbnail_cropping    = get_option('xptheme_woocommerce_thumbnail_cropping', 'yes');
            $xptheme_thumbnail_cropping    = ($xptheme_thumbnail_cropping == 'yes') ? true : false;

            return array(
                'width'  => $xptheme_thumbnail_width,
                'height' => $xptheme_thumbnail_height,
                'crop'   => $xptheme_thumbnail_cropping,
            );
        }
 
        private function photo_reviews_thumbnail_image()
        {
            $thumbnail_cropping    	= get_option('themename_photo_reviews_thumbnail_image_cropping', 'yes');
            $cropping    			= ($thumbnail_cropping == 'yes') ? true : false;

            return array(
                'width'  => get_option('themename_photo_reviews_thumbnail_image_width', 100),
                'height' => get_option('themename_photo_reviews_thumbnail_image_height', 133),
                'crop'   => $cropping,
            );
        }

        public function product_group_buttons()
        {
            global $product; 
            
            $product_id = method_exists($product, 'get_id') === true ? $product->get_id() : $product->ID;
            ?>
            <?php if ( class_exists('YITH_WCWL') || class_exists('YITH_Woocompare') || !empty($size_guide) ) { ?>
            <div class="group-button">
                <?php if (class_exists('YITH_WCWL')) { ?>
                <div class="xptheme-wishlist">
                    <?php themename_the_yith_wishlist(); ?>
                </div>
                <?php } ?>
                <?php if (class_exists('YITH_Woocompare')) { ?>
                <div class="xptheme-compare">
                    <?php themename_the_yith_compare($product_id); ?>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
            <?php
        }

        public function buy_now_html()
        {
            if (themename_catalog_mode_active()) {
                return;
            }
 
            global $product;
            if (! intval(themename_xptheme_get_config('enable_buy_now', false))) {
                return;
            }

            if ($product->get_type() == 'external') {
                return;
            }

            $class = 'xptheme-buy-now button';

            if (!empty($product) && $product->is_type('variable')) {
                $default_attributes = themename_get_default_attributes($product);
                $variation_id = themename_find_matching_product_variation($product, $default_attributes);
                
                if (empty($variation_id)) {
                    $class .= ' disabled';
                }
            }
     
            echo '<button class="'. esc_attr($class) .'">'. esc_html__('Buy Now', 'themename') .'</button>';
            echo '<input type="hidden" value="0" name="themename_buy_now" />';
        }

        public function buy_now_redirect($url)
        {
            if (! isset($_REQUEST['themename_buy_now']) || $_REQUEST['themename_buy_now'] == false) {
                return $url;
            }

            if (empty($_REQUEST['quantity'])) {
                return $url;
            }

            if (is_array($_REQUEST['quantity'])) {
                $quantity_set = false;
                foreach ($_REQUEST['quantity'] as $item => $quantity) {
                    if ($quantity <= 0) {
                        continue;
                    }
                    $quantity_set = true;
                }

                if (! $quantity_set) {
                    return $url;
                }
            }

            $redirect = themename_xptheme_get_config('redirect_buy_now', 'cart') ;

            switch ($redirect) {
                case 'cart':
                    return wc_get_cart_url();

                case 'checkout':
                    return wc_get_checkout_url();
        
                default:
                    return wc_get_cart_url();
            }
        }

        public function product_group_buttons_out_of_stock()
        {
            global $product;

            if ($product->is_in_stock() || $product->is_type('variable')) {
                return;
            }

            remove_action('woocommerce_after_add_to_cart_button', array( $this, 'product_group_buttons'), 98);
            add_action('woocommerce_single_product_summary', array( $this, 'product_group_buttons'), 30);
        }

        public function product_group_buttons_affiliate()
        {
            global $product;

            if ( !$product->is_type('external') ) return;

            remove_action('woocommerce_after_add_to_cart_button', array( $this, 'product_group_buttons'), 98);
            add_action('woocommerce_after_add_to_cart_button', array( $this, 'product_group_buttons'), 20);
        }


        public function the_list_images_review()
        {
            global $product;

            if (! is_product() || (! class_exists('VI_Woo_Photo_Reviews') && ! class_exists('VI_WooCommerce_Photo_Reviews'))) {
                return;
            }

            $product_title = $product->get_title();
            $args     = array(
                'post_type'    => 'product',
                'type'         => 'review',
                'status'       => 'approve',
                'post_id'      => $product->get_id(),
                'meta_key'     => 'reviews-images'
            );

            $comments = get_comments($args);

            if (is_array($comments) || is_object($comments)) {
                $outputs = '<div id="list-review-images">';
                
                $outputs_content = '<ul id="image-review-collapse" class="collapse show">';

                $i = 0;
                foreach ($comments as $comment) {
                    $comment_id     = $comment->comment_ID;
                    $image_post_ids = get_comment_meta($comment_id, 'reviews-images', true);
                    $content        = get_comment( $comment_id )->comment_content;
                    $author         = '<span class="author">'. get_comment( $comment_id )->comment_author .'</span>';
                    $rating         = intval( get_comment_meta( $comment_id, 'rating', true ) );

                    if ( $rating && wc_review_ratings_enabled() ) {
                        $rating_content = wc_get_rating_html( $rating );
                    } else {
                        $rating_content = '';
                    } 

					$caption = '<div class="header-comment">' . $rating_content . $author . '</div><div class="title-comment">'. $content .'</div>';

                    if (is_array($image_post_ids) || is_object($image_post_ids)) {
                        foreach ($image_post_ids as $image_post_id) {
                            if (! wc_is_valid_url($image_post_id)) {
                                $image_data = wp_get_attachment_metadata( $image_post_id );
                                $alt        = get_post_meta($image_post_id, '_wp_attachment_image_alt', true);
                                $image_alt  = $alt ? $alt : $product_title;

                                $width 		= !empty($image_data['width']) ? $image_data['width'] : '';;
								$height 	= !empty($image_data['height']) ? $image_data['height']: '';

                                $img_src = apply_filters('woocommerce_photo_reviews_thumbnail_photo', wp_get_attachment_thumb_url($image_post_id), $image_post_id, $comment);

                                $img_src_open = apply_filters('woocommerce_photo_reviews_large_photo', wp_get_attachment_thumb_url($image_post_id), $image_post_id, $comment);

                                $outputs_content .= '<li class="review-item"><a class="review-link" href="'. esc_url($img_src_open) .'" data-width="'. esc_attr($width) .'" data-height="'. esc_attr($height) .'"><div class="caption">'. trim($caption) .'</div><img class="review-images"
	                                     src="' . esc_url($img_src) .'" alt="'. apply_filters('woocommerce_photo_reviews_image_alt', $image_alt, $image_post_id, $comment) .'"/></a></li>';
                                $i++;
                            }
                        }
                    }
                }

                $outputs_content .= '</ul>';
                $outputs .= '<div class="toogle-img-review-wrapper"><a  data-bs-toggle="collapse" href="#image-review-collapse" class="toogle-img-review"> '. $i. esc_html__(' Images from customers', 'themename') .'</a></div>';

                $outputs .= $outputs_content;

                $outputs .= '</div>';
            }

            if ($i === 0) {
                return;
            }

            echo trim($outputs);
        }

        public function share_box_html()
        {
            if( !themename_xptheme_get_config('enable_code_share',false) || !themename_xptheme_get_config('enable_product_social_share', false) ) return;

            $image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            themename_custom_share_code( get_the_title(), get_permalink(), $image );
        }

        public function class_single_product($classes)
        {
            global $product;

            if( !is_product() ) return $classes;
            
            $attachment_ids = $product->get_gallery_image_ids();
            $count = count($attachment_ids);

            $sidebar_configs    = themename_xptheme_get_woocommerce_layout_configs();
            $images_layout      = ( !empty($sidebar_configs['thumbnail']) ) ? $sidebar_configs['thumbnail'] : 'horizontal';
            $images_position    = ( !empty($sidebar_configs['position']) ) ? $sidebar_configs['position'] : 'position';

            $classes[] = 'style-'.$images_layout;
            $classes[] = $images_position;

            $active_stick       = '';

            if (isset($images_layout)) {
                if (isset($count) && $images_layout == 'stick' && ($count > 0)) {
                    $active_stick = ' active-stick';
                }
            } 

            $classes[] = $active_stick;

            return $classes;
        }

        public function class_body_single_product( $classes ) {
            if( !is_product() ) return $classes;

            $product = wc_get_product( get_the_id() );

            if( !is_object($product) ) return $classes;

            $cart_style = themename_get_mobile_form_cart_style();

            if ($product->get_type() == 'external') {
                $cart_style = 'default';
            }

            $classes[] = 'form-cart-'. $cart_style;

            return $classes;
        }


        public function get_tabs_style_product($tabs_layout)
        {
            if (is_singular('product')) {
                $tabs_style       = themename_xptheme_get_config('style_single_tabs_style', 'tabs');

                if (isset($_GET['tabs_product'])) {
                    $tabs_layout = $_GET['tabs_product'];
                } else {
                    $tabs_layout = $tabs_style;
                }

                return $tabs_layout;
            }
        }

        public function the_product_single_time_countdown()
        {
            global $product;

            $style_countdown   = themename_xptheme_get_config('enable_product_countdown', false);

            if (isset($_GET['countdown'])) {
                $countdown = $_GET['countdown'];
            } else {
                $countdown = $style_countdown;
            }

            if (!$countdown || !$product->is_on_sale()) {
                return '';
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

            <div class="xptheme-time-wrapper">
                <div
                    class="time xptheme-time <?php echo ( themename_xptheme_get_config('enable_text_time_coutdown', false) ) ? 'label-coutdown' : '';?>">
                    <div class="times-countdown">
                        <div class="title-end-times">
                            <div class="date-title"><?php esc_html_e('Deal ends in: ', 'themename'); ?></div>
                        </div>
                        <div class="xptheme-countdown"
                            data-id="<?php echo esc_attr($_id); ?>-<?php echo esc_attr($product->get_id()); ?>"
                            id="countdown-<?php echo esc_attr($_id); ?>-<?php echo esc_attr($product->get_id()); ?>"
                            data-countdown="countdown"
                            data-date="<?php echo date('m', $time_sale).'-'.date('d', $time_sale).'-'.date('Y', $time_sale).'-'. date('H', $time_sale) . '-' . date('i', $time_sale) . '-' .  date('s', $time_sale) ; ?>"
                            data-days="<?php echo esc_attr($days); ?>" data-hours="<?php echo esc_attr($hours); ?>"
                            data-mins="<?php echo esc_attr($mins); ?>" data-secs="<?php echo esc_attr($secs); ?>">
                        </div>
                    </div>

                </div>

            </div>
            <?php endif; ?>
            <?php
        }

        public function render_product_nav($post, $position)
        {
            if ($post) {
                $product = wc_get_product($post->ID);
                $img = '';
                if (has_post_thumbnail($post)) {
                    $img = get_the_post_thumbnail($post, 'woocommerce_gallery_thumbnail');
                }
                $link = get_permalink($post);

                $left_content = ($position == 'left') ? "<a class='img-link' href=". esc_url($link) .">". trim($img). "</a>" :'';
                $right_content = ($position == 'right') ? "<a class='img-link' href=". esc_url($link) .">". trim($img). "</a>" :'';
                echo "<div class='". esc_attr($position) ." psnav'>";

                echo trim($left_content);
                echo "<div class='product_single_nav_inner single_nav'>
	                    <a href=". esc_url($link) .">
	                        <span class='name-pr'>". esc_html($post->post_title) ."</span>
	                    </a>
	                </div>";
                echo trim($right_content);
                echo "</div>";
            }
        }

        public function the_sticky_menu_bar()
        {
            global $post;

            $menu_bar   =  apply_filters('themename_woo_product_menu_bar', 10, 2);

            if (!$menu_bar) {
                return;
            }



            $img = '';
            if (has_post_thumbnail($post)) {
                $img = get_the_post_thumbnail($post, array(50, 50));
            } ?>

            <div id="sticky-menu-bar">
                <div class="container">
                    <div class="row">
                        <div class="menu-bar-left col-lg-7">
                            <div class="media">
                                <div class="media-left media-top pull-left">
                                    <?php echo trim($img); ?>
                                </div>
                                <div class="media-body">
                                    <?php
                                        do_action('themename_sticky_menu_bar_product_summary'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="menu-bar-right product col-lg-5">
                            <?php
                                    do_action('themename_sticky_menu_bar_product_price_cart'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        }

        public function the_product_single_one_page()
        {
            $menu_bar   =  apply_filters('themename_woo_product_menu_bar', 10, 2);

            if (isset($menu_bar) && $menu_bar) {
                wp_enqueue_script('jquery-onepagenav'); 
            }
        }

        public function the_sticky_menu_bar_custom_add_to_cart()
        {
            global $product;

            if (!$product->is_in_stock()) {
                echo wc_get_stock_html($product);
            } else {
                ?>
                <button id="sticky-custom-add-to-cart" type="button"><?php echo wp_strip_all_tags($product->single_add_to_cart_text()); ?></button>
                <?php
            }
        }

        public function body_class_single_one_page($classes)
        {
            $menu_bar   =  apply_filters('themename_woo_product_menu_bar', 10, 2);

            if (isset($menu_bar) && $menu_bar && is_product()) {
                $classes[] = 'tb-menu-bar';
            }
            return $classes;
        }

        public function before_add_to_cart_form()
        {
            global $product;

            $class = 'shop-now';

            if (intval(themename_xptheme_get_config('enable_buy_now', false)) && $product->get_type() !== 'external') {
                $class .= ' has-buy-now';
            }

            if( themename_xptheme_get_config('enable_ajax_single_add_to_cart', false) ) {
                $class .= ' ajax-single-cart';
            }

            if (class_exists('YITH_WCWL')) {
                $class .= ' has-wishlist';
            } ?>

            <div id="shop-now" class="<?php echo esc_attr($class); ?>">

            <?php
        }

        public function close_after_add_to_cart_form()
        {
            echo '</div>';
        }

        public function get_related_products_args($args)
        {
            $args['posts_per_page'] = themename_xptheme_get_config('number_product_releated', 5); // 4 related products

            return $args;
        }

        public function get_featured_image_id($product, $video_id, $host)
        {
            $thumbnail_id = $product->get_meta('_themename_video_image_url');
            return $thumbnail_id;
        }

        /**
         * @param WC_Product $product
         */
        public function get_featured_video_args($product)
        {
            $video_url  = $product->get_meta('_themename_video_url');
            $video_args = array();

            if (! empty($video_url)) {
                list($host, $video_id) = explode(':', themename_video_type_by_url($video_url));

                $video_args = array(
                    'video_id'      => $video_id,
                    'host'          => $host,
                    'thumbnail_id' => $this->get_featured_image_id($product, $video_id, $host)
                );
            }

            return $video_args;
        }

        public function get_video_audio_content_last()
        {
            if (themename_xptheme_get_config('video_position', 'last') === 'first') {
                return;
            }

            $html = $this->get_video_audio_content();

            echo trim($html);
        }

        public function get_video_audio_content_first()
        {
            if (themename_xptheme_get_config('video_position', 'last') === 'last') {
                return;
            }

            $html = $this->get_video_audio_content();

            echo trim($html);
        }

        public function get_video_audio_content()
        {
            global $product;

            $video_args = $this->get_featured_video_args($product);

            if (empty(array_filter($video_args))) {
                return '';
            }

            $html = '';
            if (! empty($video_args)) {
                ob_start();
                wc_get_template('single-product/template_video.php', $video_args);
                $html = ob_get_contents();
                ob_end_clean();
                $this->counter ++;
            }

            return $html;
        }

        public function remove_review_tab($tabs)
        {
            if (!themename_xptheme_get_config('enable_product_review_tab', true) && isset($tabs['reviews'])) {
                unset($tabs['reviews']);
            }
            return $tabs;
        }


        public function enable_zoom_image()
        {
            $active = themename_xptheme_get_config('enable_zoom_image', true);

            if (isset($_GET['enable_zoom_image'])) {
                $active = $_GET['enable_zoom_image'];
            }

            return $active;
        }

        public function remove_support_zoom_image()
        {
            $active = $this->enable_zoom_image();

            return (bool) $active;
        }

        public function get_photo_reviews_thumbnail_size($image_src, $image_post_id)
        {
            $img_src     = wp_get_attachment_image_src($image_post_id, 'themename_photo_reviews_thumbnail_image');

            return $img_src[0];
        }

        public function get_photo_reviews_large_size($image_src, $image_post_id)
        {
            $img_src     = wp_get_attachment_image_src($image_post_id, 'full');

            return $img_src[0];
        }

        public function photo_reviews_reduce_array($reduce)
        {
            array_push($reduce, 'themename_photo_reviews_thumbnail_image');
            return $reduce;
        }

        public function mobile_add_add_to_cart_button_content()
        {
            if (themename_catalog_mode_active()) {
                return;
            }

            if (themename_get_mobile_form_cart_style() === 'default') {
                return;
            }

            global $product; ?>
            <div id="mobile-close-infor"><i class="tb-icon tb-icon-close-01"></i></div>
            <div class="mobile-infor-wrapper">
                <div class="d-flex">
                    <div class="me-3">
                        <?php echo trim($product->get_image('woocommerce_gallery_thumbnail')); ?>
                    </div>
                    <div class="media-body">
                        <div class="infor-body">
                            <?php echo '<p class="price">'. trim($product->get_price_html()) . '</p>'; ?>
                            <?php echo wc_get_stock_html($product); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        public function mobile_add_before_add_to_cart_button()
        {
            if (themename_catalog_mode_active()) {
                return;
            }

            if (themename_get_mobile_form_cart_style() === 'default') {
                return;
            }
            
            global $product;
             
            if ($product->get_type() !== 'simple') {
                return;
            }
 
            $this->mobile_add_add_to_cart_button_content();
        }

        public function mobile_add_before_variations_form()
        {
            if (themename_catalog_mode_active()) {
                return;
            }

            if (themename_get_mobile_form_cart_style() === 'default') {
                return;
            }

            $this->mobile_add_add_to_cart_button_content();
        }
        
        public function mobile_before_grouped_product_list()
        {
            if (themename_catalog_mode_active()) {
                return;
            }

            if (themename_get_mobile_form_cart_style() === 'default') {
                return;
            }

            global $product;
             
            if ($product->get_type() !== 'grouped') {
                return;
            }

            $this->mobile_add_add_to_cart_button_content();
        }

        public function mobile_add_btn_after_add_to_cart_form()
        {
            if (themename_catalog_mode_active()) {
                return;
            }

            if (themename_get_mobile_form_cart_style() === 'default') {
                return;
            }

            global $product;

            if ($product->get_type() == 'external') {
                return;
            }

            $class = '';
            if (themename_xptheme_get_config('enable_buy_now', false)) {
                $class .= ' has-buy-now';
            } ?>
            <div id="mobile-close-infor-wrapper"></div>
            <div class="mobile-btn-cart-click <?php echo esc_attr($class); ?>">
                <div id="xptheme-click-addtocart"><?php esc_html_e('Add to cart', 'themename') ?></div>
                <?php if (themename_xptheme_get_config('enable_buy_now', false)) : ?>
                <div id="xptheme-click-buy-now"><?php esc_html_e('Buy Now', 'themename') ?></div>
                <?php endif; ?>
            </div>
            <?php
        }

        public function mobile_add_before_add_to_cart_form()
        {
            if (themename_catalog_mode_active()) {
                return;
            }

            if (themename_get_mobile_form_cart_style() === 'default') {
                return;
            }

            global $product;
            if (!$product->is_type('variable')) {
                return;
            }

            $attributes = $product->get_variation_attributes();
            $selected_attributes 	= $product->get_default_attributes();
            if (sizeof($attributes) === 0) {
                return;
            }

            $default_attributes = $names = array();

            foreach ($attributes as $key => $value) {
                array_push($names, wc_attribute_label($key));

                if (isset($selected_attributes[$key]) && !empty($selected_attributes[$key])) {
                    $default = get_term_by('slug', $selected_attributes[$key], $key)->name;
                } else {
                    $default = esc_html__('Choose an option ', 'themename');
                }

                array_push($default_attributes, $default);
            } ?>
            <div class="mobile-attribute-list">
                <div class="list-wrapper">
                    <div class="name">
                        <?php echo esc_html(implode(', ', $names)); ?>
                    </div>
                    <div class="value">
                        <?php echo esc_html(implode('/ ', $default_attributes)); ?>
                    </div>
                </div>
                <div id="attribute-open"><i class="tb-icon tb-icon-angle-right"></i></div>
            </div>
            <?php
        }

        public static function custom_field_detail_product() {
            global $product;

            $product_type = $product->get_type();

            if (!in_array($product_type, array('simple', 'variable', 'variation'))) {
                return;
            }
    
            $btn_ajax_value = '0';
            if ( 'yes' !== get_option('woocommerce_cart_redirect_after_add') && 'yes' === get_option('woocommerce_enable_ajax_add_to_cart') && themename_xptheme_get_config('enable_ajax_single_add_to_cart', false) ) {
                $btn_ajax_value = '1';
            } 
               
            echo '<div class="themename-custom-fields d-none">';
            echo '<input type="hidden" name="themename-enable-addtocart-ajax" value="' . esc_attr($btn_ajax_value) . '" />';
            echo '<input type="hidden" name="data-product_id" value="' . esc_attr($product->get_id()) . '" />';
            echo '<input type="hidden" name="data-type" value="' . esc_attr($product_type) . '" />';
            
            echo '</div>';
        }
    }
endif;

if (!function_exists('themename_single_wooCommerce')) {
    function themename_single_wooCommerce()
    {
        return Themename_Single_WooCommerce::getInstance();
    }
    themename_single_wooCommerce();
}