<?php if (! defined('THEMENAME_THEME_DIR')) {
    exit('No direct script access allowed');
}

if (! function_exists('themename_tbay_body_classes')) {
    function themename_tbay_body_classes($classes)
    {
        global $post;
        if (is_page() && is_object($post)) {
            $class = get_post_meta($post->ID, 'tbay_page_extra_class', true);
            if (!empty($class)) {
                $classes[] = trim($class);
            }
        }

        if (themename_tbay_get_config('preload')) {
            $classes[] = 'tb-loader';
        }

        if (themename_tbay_is_home_page()) {
            $classes[] = 'tb-home';
        }
          
        if (!themename_redux_framework_activated()) {
            $classes[] = 'tb-default';
        }

        $menu_mobile_search 	= themename_tbay_get_config('menu_mobile_search', true);
        if ($menu_mobile_search) {
            $classes[] = 'tbay-search-mb';
        }

        if( themename_checkout_optimized() ) {
            $classes[] = 'tb-checkout-optimized';
        }

        if( !themename_tbay_get_config('always_display_logo', true) ) {
            $classes[] = 'hdmb-hdlogo';
        } 
           

        return $classes;
    }
    add_filter('body_class', 'themename_tbay_body_classes');
}

if (! function_exists('themename_tbay_get_shortcode_regex')) {
    function themename_tbay_get_shortcode_regex($tagregexp = '')
    {
        // WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
        // Also, see shortcode_unautop() and shortcode.js.
        return
            '\\['                                // Opening bracket
            . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
            . "($tagregexp)"                     // 2: Shortcode name
            . '(?![\\w-])'                       // Not followed by word cthemenamecter or hyphen
            . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
            . '[^\\]\\/]*'                   // Not a closing bracket or forward slash
            . '(?:'
            . '\\/(?!\\])'               // A forward slash not followed by a closing bracket
            . '[^\\]\\/]*'               // Not a closing bracket or forward slash
            . ')*?'
            . ')'
            . '(?:'
            . '(\\/)'                        // 4: Self closing tag ...
            . '\\]'                          // ... and closing bracket
            . '|'
            . '\\]'                          // Closing bracket
            . '(?:'
            . '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
            . '[^\\[]*+'             // Not an opening bracket
            . '(?:'
            . '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
            . '[^\\[]*+'         // Not an opening bracket
            . ')*+'
            . ')'
            . '\\[\\/\\2\\]'             // Closing shortcode tag
            . ')?'
            . ')'
            . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
    }
}

if (! function_exists('themename_tbay_tagregexp')) {
    function themename_tbay_tagregexp()
    {
        return apply_filters('themename_tbay_custom_tagregexp', 'video|audio|playlist|video-playlist|embed|themename_tbay_media');
    }
}


if (! function_exists('themename_tbay_text_line')) {
    function themename_tbay_text_line($str)
    {
        return trim(preg_replace("/('|\"|\r?\n)/", '', $str));
    }
}

if ( !function_exists('themename_tbay_get_theme') ) {
	function themename_tbay_get_theme() {
		$kin_default = 'v1';  
		if( !empty($_GET['product_layout_style']) ) return $_GET['product_layout_style'];

		if( !empty(themename_tbay_get_global_config('product_layout_style',$kin_default)) ) {
		   return themename_tbay_get_global_config('product_layout_style',$kin_default);
		} else {
		   return $kin_default;
		}
	}
}


if (!function_exists('themename_tbay_get_header_layouts')) {
    function themename_tbay_get_header_layouts()
    {
        $headers = array( 'header_default' => esc_html__('Default', 'themename'));
        $args = array(
            'posts_per_page'   => -1,
            'offset'           => 0,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'post_type'        => 'tbay_custom_post', 
            'post_status'      => 'publish',
            'suppress_filters' => true,
            'meta_key'     => 'tbay_block_type',
            'meta_value'   => 'type_header',
            'meta_query'   => [
                'relation' => 'OR',
                [
                    'key'     => 'tbay_block_type',
                    'value'   => 'type_header',
                    'compare' => '==',
                    'type'    => 'post',
                ],
            ],
        );
        $posts = get_posts($args);
        foreach ($posts as $post) {
            $headers[$post->post_name] = $post->post_title;
        }
        return $headers;
    }
} 

if(!function_exists('themename_header_located_on_slider')) {
	function themename_header_located_on_slider() {
		$active  =   ( isset($_GET['header_located_on_slider']) ) ? $_GET['header_located_on_slider'] : themename_tbay_get_config('header_located_on_slider', false);
		
		$class = '';
		if($active) {
			$class = "header-on-slider";
		}
		
		return $class;
	}
}

if (!function_exists('themename_tbay_get_header_layout')) {
    function themename_tbay_get_header_layout()
    {
        if (is_page()) {
            global $post;
            $header = '';
            if (is_object($post) && isset($post->ID)) {
                $header = get_post_meta($post->ID, 'tbay_page_header_type', true);
                if ($header == 'global' ||  $header == '') {
                    return themename_tbay_get_config('header_type', 'header_default');
                }
            }
            return $header;
        } else if( class_exists( 'WooCommerce' ) && is_shop() ) {
			return themename_tbay_woo_get_header_layout( wc_get_page_id( 'shop' ) );
		} else if( class_exists( 'WooCommerce' ) && is_cart() ) {
			return themename_tbay_woo_get_header_layout( wc_get_page_id( 'cart' ) );
		} else if( class_exists( 'WooCommerce' ) && is_checkout() ) {
			return themename_tbay_woo_get_header_layout( wc_get_page_id( 'checkout' ) );
		}
        return themename_tbay_get_config('header_type', 'header_default');
    }
    add_filter('themename_tbay_get_header_layout', 'themename_tbay_get_header_layout');
}

if ( !function_exists('themename_tbay_woo_get_header_layout') ) {
	function themename_tbay_woo_get_header_layout( $page_id ) {
		$header = get_post_meta( $page_id, 'tbay_page_header_type', true );

		if ( $header == 'global' ||  $header == '') {
			return themename_tbay_get_config('header_type', 'header_default');
		} else {
			return $header;
		}
	}
}

if (!function_exists('themename_tbay_get_ids_custom_block')) {
    function themename_tbay_get_ids_custom_block()
    {
        $args = array(
            'posts_per_page'   => -1,
            'offset'           => 0,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'post_type'        => 'tbay_custom_post', 
            'post_status'      => 'publish',
            'suppress_filters' => true,
            'meta_key'     => 'tbay_block_type',
            'meta_value'   => 'custom',
            'meta_query'   => [
                'relation' => 'OR',
                [
                    'key'     => 'tbay_block_type',
                    'value'   => 'custom',
                    'compare' => '==',
                    'type'    => 'post',
                ],
            ],
        );
        $posts = get_posts($args);
        foreach ($posts as $post) {
            $custom[$post->ID] = $post->post_title;
        }
        return $custom;
    }
}

if (!function_exists('themename_tbay_get_footer_layouts')) {
    function themename_tbay_get_footer_layouts()
    {
        $footers = array( 'footer_default' => esc_html__('Default', 'themename'));
        $args = array(
            'posts_per_page'   => -1,
            'offset'           => 0,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'post_type'        => 'tbay_custom_post', 
            'post_status'      => 'publish',
            'suppress_filters' => true,
            'meta_key'     => 'tbay_block_type',
            'meta_value'   => 'type_footer',
            'meta_query'   => [
                'relation' => 'OR',
                [
                    'key'     => 'tbay_block_type',
                    'value'   => 'type_footer',
                    'compare' => '==',
                    'type'    => 'post',
                ],
            ],
        );
        $posts = get_posts($args);
        foreach ($posts as $post) {
            $footers[$post->post_name] = $post->post_title;
        }
        return $footers;
    }
}

if (!function_exists('themename_tbay_get_footer_layout')) {
    function themename_tbay_get_footer_layout()
    {
        if (is_page()) {
            global $post;
            $footer = '';
            if (is_object($post) && isset($post->ID)) {
                $footer = get_post_meta($post->ID, 'tbay_page_footer_type', true);
                if ($footer == 'global' ||  $footer == '') {
                    return themename_tbay_get_config('footer_type', 'footer_default');
                }
            }
            return $footer;
        } else if( class_exists( 'WooCommerce' ) && is_shop() ) {
			return themename_tbay_woo_get_footer_layout( wc_get_page_id( 'shop' ) );
		} else if( class_exists( 'WooCommerce' ) && is_cart() ) {
			return themename_tbay_woo_get_footer_layout( wc_get_page_id( 'cart' ) );
		} else if( class_exists( 'WooCommerce' ) && is_checkout() ) {
			return themename_tbay_woo_get_footer_layout( wc_get_page_id( 'checkout' ) );
		}
        return themename_tbay_get_config('footer_type', 'footer_default');
    }
    add_filter('themename_tbay_get_footer_layout', 'themename_tbay_get_footer_layout');
}

if ( !function_exists('themename_tbay_woo_get_footer_layout') ) {
	function themename_tbay_woo_get_footer_layout( $page_id ) {
		$footer = get_post_meta( $page_id, 'tbay_page_footer_type', true );

		if ( $footer == 'global' ||  $footer == '') {
			return themename_tbay_get_config('footer_type', 'footer_default');
		} else {
			return $footer;
		}
	}
}

if (!function_exists('themename_tbay_blog_content_class')) {
    function themename_tbay_blog_content_class($class)
    {
        $page = 'archive';
        if (is_singular('post')) {
            $page = 'single';
        }
        if (themename_tbay_get_config('blog_'.$page.'_fullwidth')) {
            return 'container-fluid';
        }
        return $class;
    }
}
add_filter('themename_tbay_blog_content_class', 'themename_tbay_blog_content_class', 1, 1);

// layout class for woo page
if (!function_exists('themename_tbay_post_content_class')) {
    function themename_tbay_post_content_class($class)
    {
        $page = 'archive';
        if (is_singular('post')) {
            $page = 'single';

            if (!isset($_GET['blog_'.$page.'_layout'])) {
                $class .= ' '.themename_tbay_get_config('blog_'.$page.'_layout');
            } else {
                $class .= ' '.$_GET['blog_'.$page.'_layout'];
            }
        } else {
            if (!isset($_GET['blog_'.$page.'_layout'])) {
                $class .= ' '.themename_tbay_get_config('blog_'.$page.'_layout');
            } else {
                $class .= ' '.$_GET['blog_'.$page.'_layout'];
            }
        }
        return $class;
    }
}
add_filter('themename_tbay_post_content_class', 'themename_tbay_post_content_class');


if (!function_exists('themename_tbay_get_page_layout_configs')) {
    function themename_tbay_get_page_layout_configs()
    {
        global $post;
        if (isset($post->ID)) {
            $left = get_post_meta($post->ID, 'tbay_page_left_sidebar', true);
            $right = get_post_meta($post->ID, 'tbay_page_right_sidebar', true);

            switch (get_post_meta($post->ID, 'tbay_page_layout', true)) {
                case 'left-main':
                    $configs['sidebar'] = array( 'id' => $left, 'class' => 'col-12 col-lg-3'  );
                    $configs['main'] 	= array( 'class' => 'col-12 col-lg-9' );
                    break;
                case 'main-right':
                    $configs['sidebar'] = array( 'id' => $right,  'class' => 'col-12 col-lg-3' );
                    $configs['main'] 	= array( 'class' => 'col-12 col-lg-9' );
                    break;
                case 'main':
                    $configs['main'] = array( 'class' => 'col-12' );
                    break;
                default:
                    $configs['main'] = array( 'class' => 'col-12' );
                    break;
            }

            return $configs;
        }
    }
}

if (! function_exists('themename_tbay_get_first_url_from_string')) {
    function themename_tbay_get_first_url_from_string($string)
    {
        $pattern = "/^\b(?:(?:https?|ftp):\/\/)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
        preg_match($pattern, $string, $link);

        return (! empty($link[0])) ? $link[0] : false;
    }
}

/*Check in home page*/
if (!function_exists('themename_tbay_is_home_page')) {
    function themename_tbay_is_home_page()
    {
        $is_home = false;

        if (is_home() || is_front_page() || is_page('home-1') || is_page('home-2') || is_page('home-3') || is_page('home-4') || is_page('home-5') || is_page('home-6') || is_page('home-7')) {
            $is_home = true;
        }

        return $is_home;
    }
}

if (!function_exists('themename_tbay_get_link_attributes')) {
    function themename_tbay_get_link_attributes($string)
    {
        preg_match('/<a href="(.*?)">/i', $string, $atts);

        return (! empty($atts[1])) ? $atts[1] : '';
    }
}

if (!function_exists('themename_tbay_post_media')) {
    function themename_tbay_post_media($content)
    {
        $is_video = (get_post_format() == 'video') ? true : false;
        $media = themename_tbay_get_first_url_from_string($content);
        if (! empty($media)) {
            global $wp_embed;
            $content = do_shortcode($wp_embed->run_shortcode('[embed]' . $media . '[/embed]'));
        } else {
            $pattern = themename_tbay_get_shortcode_regex(themename_tbay_tagregexp());
            preg_match('/' . $pattern . '/s', $content, $media);
            if (! empty($media[2])) {
                if ($media[2] == 'embed') {
                    global $wp_embed;
                    $content = do_shortcode($wp_embed->run_shortcode($media[0]));
                } else {
                    $content = do_shortcode($media[0]);
                }
            }
        }
        if (! empty($media)) {
            $output = '<div class="entry-media">';
            $output .= ($is_video) ? '<div class="pro-fluid"><div class="pro-fluid-inner">' : '';
            $output .= $content;
            $output .= ($is_video) ? '</div></div>' : '';
            $output .= '</div>';

            return $output;
        }

        return false;
    }
}

if (!function_exists('themename_tbay_post_gallery')) {
    function themename_tbay_post_gallery($content)
    {
        $pattern = themename_tbay_get_shortcode_regex('gallery');
        preg_match('/' . $pattern . '/s', $content, $media);
        if (! empty($media[2])) {
            return '<div class="entry-gallery">' . do_shortcode($media[0]) . '<hr class="pro-clear" /></div>';
        }

        return false;
    }
}

if (!function_exists('themename_tbay_random_key')) {
    function themename_tbay_random_key($length = 5)
    {
        $cthemenamecters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $return = '';
        for ($i = 0; $i < $length; $i++) {
            $return .= $cthemenamecters[rand(0, strlen($cthemenamecters) - 1)];
        }
        return $return;
    }
}

if (!function_exists('themename_tbay_substring')) {
    function themename_tbay_substring($string, $limit, $afterlimit = '[...]')
    {
        if (empty($string)) {
            return $string;
        }
        $string = explode(' ', strip_tags($string), $limit);

        if (count($string) >= $limit) {
            array_pop($string);
            $string = implode(" ", $string) .' '. $afterlimit;
        } else {
            $string = implode(" ", $string);
        }
        $string = preg_replace('`[[^]]*]`', '', $string);
        return strip_shortcodes($string);
    }
}

if (!function_exists('themename_tbay_subschars')) {
    function themename_tbay_subschars($string, $limit, $afterlimit='...')
    {
        if (strlen($string) > $limit) {
            $string = substr($string, 0, $limit);
        } else {
            $afterlimit = '';
        }
        return $string . $afterlimit;
    }
}


/*Themename get template parts*/
if (!function_exists('themename_tbay_get_page_templates_parts')) {
    function themename_tbay_get_page_templates_parts($slug = 'logo', $name = null)
    {
        return get_template_part('page-templates/parts/'.$slug.'', $name);
    }
}

/*testimonials*/
if (!function_exists('themename_tbay_get_testimonials_layouts')) {
    function themename_tbay_get_testimonials_layouts()
    {
        $testimonials = array();
        $files = glob(get_template_directory() . '/vc_templates/testimonial/testimonial.php');
        if (!empty($files)) {
            foreach ($files as $file) {
                $testi = str_replace("testimonial", '', str_replace('.php', '', basename($file)));
                $testimonials[$testi] = $testi;
            }
        }

        return $testimonials;
    }
}

/*Blog*/
if (!function_exists('themename_tbay_get_blog_layouts')) {
    function themename_tbay_get_blog_layouts()
    {
        $blogs = array(
            esc_html__('Grid', 'themename') => 'grid',
            esc_html__('Vertical', 'themename') => 'vertical',
        );
        $files = glob(get_template_directory() . '/vc_templates/post/carousel/_single_*.php');
        if (!empty($files)) {
            foreach ($files as $file) {
                $str = str_replace("_single_", '', str_replace('.php', '', basename($file)));
                $blogs[$str] = $str;
            }
        }

        return $blogs;
    }
}

// Number of blog per row
if (!function_exists('themename_tbay_blog_loop_columns')) {
    function themename_tbay_blog_loop_columns($number)
    {
        $sidebar_configs = themename_tbay_get_blog_layout_configs();

        $columns 	= themename_tbay_get_config('blog_columns');

        if (isset($_GET['blog_columns']) && is_numeric($_GET['blog_columns'])) {
            $value = $_GET['blog_columns'];
        } elseif (empty($columns) && isset($sidebar_configs['columns'])) {
            $value = 	$sidebar_configs['columns'];
        } else {
            $value = $columns;
        }

        if (in_array($value, array(1, 2, 3, 4, 5, 6))) {
            $number = $value;
        }
        return $number;
    }
}
add_filter('loop_blog_columns', 'themename_tbay_blog_loop_columns');

/*Check style blog image full*/
if (!function_exists('themename_tbay_blog_image_sizes_full')) {
    function themename_tbay_blog_image_sizes_full()
    {
        $style = false;
        $sidebar_configs = themename_tbay_get_blog_layout_configs();

        if (!is_singular('post')) {
            if (isset($sidebar_configs['image_sizes']) && $sidebar_configs['image_sizes'] == 'full') :
                   $style = true;
            endif;
        }

        return  $style;
    }
}


// Number of post per page
if (!function_exists('themename_tbay_loop_post_per_page')) {
    function themename_tbay_loop_post_per_page($number)
    {
        if (isset($_GET['posts_per_page']) && is_numeric($_GET['posts_per_page'])) {
            $value = $_GET['posts_per_page'];
        } else {
            $value = get_option('posts_per_page');
        }

        if (is_numeric($value) && $value) {
            $number = absint($value);
        }
        
        return $number;
    }
    add_filter('loop_post_per_page', 'themename_tbay_loop_post_per_page');
}

if (!function_exists('themename_tbay_posts_per_page')) {
    function themename_tbay_posts_per_page($wp_query)
    {
        if (is_admin() || ! $wp_query->is_main_query()) {
            return;
        }

        $value = apply_filters('loop_post_per_page', 6);

        if (isset($value) && is_category()) {
            $wp_query->query_vars['posts_per_page'] = $value;
        }
        return $wp_query;
    }
    add_action('pre_get_posts', 'themename_tbay_posts_per_page');
}

/*Post Views*/
if (!function_exists('themename_set_post_views')) {
    function themename_set_post_views($postID)
    {
        $count_key = 'themename_post_views_count';
        $count 		 = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            $count = 1;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '1');
        } else {
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
}

if (!function_exists('themename_track_post_views')) {
    function themename_track_post_views($post_id)
    {
        if (!is_single()) {
            return;
        }
        if (empty($post_id)) {
            global $post;
            $post_id = $post->ID;
        }
        themename_set_post_views($post_id);
    }
    add_action('wp_head', 'themename_track_post_views');
}

if (!function_exists('themename_get_post_views')) {
    function themename_get_post_views($postID, $text = '')
    {
        $count_key = 'themename_post_views_count';
        $count = get_post_meta($postID, $count_key, true);

        if ($count == '') {
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0";
        }
        return $count.$text;
    }
}

/*Get Preloader*/
if (! function_exists('themename_get_select_preloader')) {
    add_action('wp_body_open', 'themename_get_select_preloader', 10);
    function themename_get_select_preloader()
    {
        $enable_preload = themename_tbay_get_global_config('preload', false);

        if (!$enable_preload) {
            return;
        }

        $preloader 	= themename_tbay_get_global_config('select_preloader', 'loader1');
        $media 		= themename_tbay_get_global_config('media-preloader');
        
        if (isset($preloader)) {
            switch ($preloader) {
                case 'loader1':
                    ?>
<div class="item-loader">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
<?php
                    break;

                case 'loader2':
                    ?>
<div class="item-loader">
    <div class="tbay-loader tbay-loader-two">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<?php
                    break;
                case 'loader3':
                    ?>
<div class="item-loader">
    <div class="tbay-loader tbay-loader-three">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<?php
                    break;
                case 'loader4':
                    ?>
<div class="item-loader">
    <div class="tbay-loader tbay-loader-four"> <span class="spinner-cube spinner-cube1"></span> <span
            class="spinner-cube spinner-cube2"></span> <span class="spinner-cube spinner-cube3"></span> <span
            class="spinner-cube spinner-cube4"></span> <span class="spinner-cube spinner-cube5"></span> <span
            class="spinner-cube spinner-cube6"></span> <span class="spinner-cube spinner-cube7"></span> <span
            class="spinner-cube spinner-cube8"></span> <span class="spinner-cube spinner-cube9"></span> </div>
</div>
<?php
                    break;
                case 'loader5':
                    ?>
<div class="item-loader">
    <div class="tbay-loader tbay-loader-five"> <span class="spinner-cube-1 spinner-cube"></span> <span
            class="spinner-cube-2 spinner-cube"></span> <span class="spinner-cube-4 spinner-cube"></span> <span
            class="spinner-cube-3 spinner-cube"></span> </div>
</div>
<?php
                    break;
                case 'loader6':
                    ?>
<div class="item-loader">
    <div class="tbay-loader tbay-loader-six"> <span class=" spinner-cube-1 spinner-cube"></span> <span
            class=" spinner-cube-2 spinner-cube"></span> </div>
</div>
<?php
                    break;

                case 'custom_image':
                    ?>
<div class="item-loader loader-img">
    <?php if (isset($media['url']) && !empty($media['url'])): ?>
    <img alt="<?php echo (!empty($media['alt'])) ? esc_attr($media['alt']) : ''; ?>"
        src="<?php echo esc_url($media['url']); ?>">
    <?php endif; ?>
</div>
<?php
                    break;
                    
                default:
                    ?>
<div class="item-loader">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
<?php
                    break;
            }
        }
    }
}

if (!function_exists('themename_gallery_atts')) {
    add_filter('shortcode_atts_gallery', 'themename_gallery_atts', 10, 3);
    
    /* Change attributes of wp gallery to modify image sizes for your needs */
    function themename_gallery_atts($output, $pairs, $atts)
    {
        if (isset($atts['columns']) && $atts['columns'] == 1) {
            //if gallery has one column, use large size
            $output['size'] = 'full';
        } elseif (isset($atts['columns']) && $atts['columns'] >= 2 && $atts['columns'] <= 4) {
            //if gallery has between two and four columns, use medium size
            $output['size'] = 'full';
        } else {
            //if gallery has more than four columns, use thumbnail size
            $output['size'] = 'full';
        }
    
        return $output;
    }
}

if (!function_exists('themename_get_custom_menu')) {

    
    /* Change attributes of wp gallery to modify image sizes for your needs */
    function themename_get_custom_menu($menu_id)
    {
        $_id = themename_tbay_random_key();

        $args = array(
            'menu'              => $menu_id,
            'container_class'   => 'nav',
            'menu_class'        => 'menu',
            'fallback_cb'       => '',
            'before'            => '',
            'after'             => '',
            'echo'              => true,
            'menu_id'           => 'menu-'.$menu_id.'-'.$_id
        );

        $output = wp_nav_menu($args);

    
        return $output;
    }
}

/*Set excerpt show enable default*/
if (! function_exists('themename_tbay_edit_post_show_excerpt')) {
    function themename_tbay_edit_post_show_excerpt()
    {
        $user = wp_get_current_user();
        $unchecked = get_user_meta($user->ID, 'metaboxhidden_post', true);
        if (is_array($unchecked)) {
            $key = array_search('postexcerpt', $unchecked);
            if (false !== $key) {
                array_splice($unchecked, $key, 1);
                update_user_meta($user->ID, 'metaboxhidden_post', $unchecked);
            }
        }
    }
    add_action('admin_init', 'themename_tbay_edit_post_show_excerpt', 10);
}

if (! function_exists('themename_texttrim')) {
    function themename_texttrim($str)
    {
        return trim(preg_replace("/('|\"|\r?\n)/", '', $str));
    }
}

/*Get query*/
if (!function_exists('themename_tbay_get_boolean_query_var')) {
    function themename_tbay_get_boolean_query_var($config)
    {
        $active = themename_tbay_get_config($config, true);

        $active = (isset($_GET[$config])) ? $_GET[$config] : $active;

        return (boolean)$active;
    }
}

if (!function_exists('themename_tbay_archive_blog_size_image')) {
    function themename_tbay_archive_blog_size_image()
    {
        $blog_size = themename_tbay_get_config('blog_image_sizes', 'medium');

        $blog_size = (isset($_GET['blog_image_sizes'])) ? $_GET['blog_image_sizes'] : $blog_size;

        return $blog_size;
    }
}
add_filter('themename_archive_blog_size_image', 'themename_tbay_archive_blog_size_image');


if (!function_exists('themename_tbay_archive_layout_blog')) {
    function themename_tbay_archive_layout_blog()
    {
        $layout_blog = themename_tbay_get_config('layout_blog', 'post-style-1');

        $layout_blog = (isset($_GET['layout_blog'])) ? $_GET['layout_blog'] : $layout_blog;

        return $layout_blog;
    }
}
add_filter('themename_archive_layout_blog', 'themename_tbay_archive_layout_blog');

if (!function_exists('themename_tbay_categories_blog_type')) {
    function themename_tbay_categories_blog_type()
    {
        $type = themename_tbay_get_config('categories_type', 'type-1');

        $type = (isset($_GET['categories_type'])) ? $_GET['categories_type'] : $type;

        return $type;
    }
}


// cart Postion
if (!function_exists('themename_tbay_header_mobile_position')) {
    function themename_tbay_header_mobile_position()
    {
        $position = themename_tbay_get_config('header_mobile', 'v1');

        $position = (isset($_GET['header_mobile'])) ? $_GET['header_mobile'] : $position;

        return $position;
    }
    add_filter('themename_header_mobile_position', 'themename_tbay_header_mobile_position');
}

if (!function_exists('themename_tbay_offcanvas_smart_menu')) {
    function themename_tbay_offcanvas_smart_menu()
    {
        themename_tbay_get_page_templates_parts('device/offcanvas-smartmenu');
    }
    add_action('themename_before_theme_header', 'themename_tbay_offcanvas_smart_menu', 10);
}

if (!function_exists('themename_tbay_the_topbar_mobile')) {
    function themename_tbay_the_topbar_mobile()
    {
        if (!themename_tbay_get_config('mobile_header', true)) {
            return;
        }

        $position = apply_filters('themename_header_mobile_position', 10, 2);

        themename_tbay_get_page_templates_parts('device/topbar-mobile', $position);
    }
    add_action('themename_before_theme_header', 'themename_tbay_the_topbar_mobile', 20);
}

if (!function_exists('themename_tbay_footer_mobile')) {
    function themename_tbay_footer_mobile()
    {
        if (themename_active_mobile_footer_icon()) {
            themename_tbay_get_page_templates_parts('device/footer-mobile');
        }
    }
    add_action('themename_before_theme_header', 'themename_tbay_footer_mobile', 40);
}

if ( ! function_exists( 'themename_product_ajax_search_sku' ) ) {
	function themename_product_ajax_search_sku( $where ) {
        if ( !themename_redux_framework_activated() ) return $where;

		if ( ! empty( $_REQUEST['query'] ) ) {
			$s = sanitize_text_field( $_REQUEST['query'] );

            return themename_sku_search_query( $where, $s );
		}

		return $where;
	}
}

if (!function_exists('themename_tbay_autocomplete_suggestions')) {
    add_action('wp_ajax_themename_autocomplete_search', 'themename_tbay_autocomplete_suggestions');
    add_action('wp_ajax_nopriv_themename_autocomplete_search', 'themename_tbay_autocomplete_suggestions');
    function themename_tbay_autocomplete_suggestions()
    {
        check_ajax_referer( 'themename-search-nonce', 'security' );

        $args = array(
            'post_status'         => 'publish',
            'orderby'         	  => 'relevance',
            'posts_per_page'      => -1,
            'ignore_sticky_posts' => 1,
            'suppress_filters'    => false,
        );

        if (! empty($_REQUEST['query'])) {
            $search_keyword = $_REQUEST['query'];
            $args['s'] = sanitize_text_field($search_keyword);
        }


        if (! empty($_REQUEST['post_type'])) {
            $post_type = strip_tags($_REQUEST['post_type']);
        }

        if ( class_exists('WooCommerce') && isset($_REQUEST['post_type']) && $_REQUEST['post_type'] === 'product' ) {
            $args['meta_query'] = WC()->query->get_meta_query();
            $args['tax_query'] 	= WC()->query->get_tax_query();

            if ( apply_filters( 'themename_search_query_in', themename_tbay_get_config('search_query_in', 'title') === 'all' ) ) {
                add_filter( 'posts_search', 'themename_product_ajax_search_sku', 9 );
            } else {
                add_filter('posts_search', 'themename_product_search_title', 20, 2);
            }
        }

        if (! empty($_REQUEST['number'])) {
            $number 	= (int) $_REQUEST['number'];
        }

        if (isset($_REQUEST['post_type']) && $_REQUEST['post_type'] != 'all') {
            $args['post_type'] = $_REQUEST['post_type'];
        }


        if ( $post_type == 'product' && themename_woocommerce_activated() ) {
            
            $product_visibility_term_ids = wc_get_product_visibility_term_ids();
            $args['tax_query']['relation'] = 'AND';

            $args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => $product_visibility_term_ids['exclude-from-search'],
                'operator' => 'NOT IN',
            ); 
            
            if ( ! empty( $_REQUEST['product_cat'] ) ) {
                $args['tax_query'][] = array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => strip_tags( $_REQUEST['product_cat'] ),
                );
            }
        }


        $results = new WP_Query($args);

        $suggestions = array();

        $count = $results->post_count;

        $view_all = (($count - $number) > 0) ? true : false;
        $index = 0;
        if ($results->have_posts()) {
            if ($post_type == 'product') {
                $factory = new WC_Product_Factory();
            }


            while ($results->have_posts()) {
                if ($index == $number) {
                    break;
                }

                $results->the_post();

                if ($count == 1) {
                    $result_text = esc_html__('result found with', 'themename');
                } else {
                    $result_text = esc_html__('results found with', 'themename');
                }

                if ($post_type == 'product') {
                    $product = $factory->get_product(get_the_ID());
                    $_subtitle = ( !empty(get_post_meta( get_the_ID(), '_subtitle', true )) ) ? get_post_meta( get_the_ID(), '_subtitle', true ) : '';
                    $suggestions[] = array(
                        'value' => get_the_title(),
                        'subtitle' => $_subtitle,
                        'sku' => ( themename_tbay_get_config('search_query_in', 'title') === 'all' && themename_tbay_get_config('search_sku_ajax', false) && $product->get_sku() ) ? esc_html__( 'SKU:', 'themename' ) . ' ' . $product->get_sku() : '',
                        'link' => get_the_permalink(),
                        'price' => $product->get_price_html(),
                        'image' => $product->get_image(),
                        'result' => '<span class="count">'.$count.' </span> '. $result_text .' <span class="keywork">"'. esc_html($search_keyword).'"</span>',
                        'view_all' => $view_all,
                    );


                } else {
                    $suggestions[] = array(
                        'value' => get_the_title(),
                        'link' => get_the_permalink(),
                        'image' => get_the_post_thumbnail( get_the_ID(), 'medium', ''),
                        'result' => '<span class="count">'.$count.' </span> '. $result_text .' <span class="keywork">"'. esc_html($search_keyword).'"</span>',
                        'view_all' => $view_all,
                    );
                }


                $index++;
            }

            wp_reset_postdata();
        } else {
            $suggestions[] = array(
                'value' => ($post_type == 'product') ? esc_html__('No products found.', 'themename') : esc_html__('No posts...', 'themename'),
                'no_found' => true,
                'link' => '',
                'view_all' => $view_all,
            );
        }

        echo json_encode(array(
            'suggestions' => $suggestions
        ));

        die();
    }
}

if (!function_exists('themename_add_cssclass')) {
    function themename_add_cssclass($add, $class)
    {
        $class = empty($class) ? $add : $class .= ' ' . $add;
        return $class;
    }
}

/*Fix woocomce don't active*/
if (!function_exists('themename_tbay_get_variation_swatchs')) {
    function themename_tbay_get_variation_swatchs()
    {
        $swatchs = array( '' => esc_html__('None', 'themename'));

        if ( !themename_woocommerce_activated() ) {
            return $swatchs;
        }

        // Array of defined attribute taxonomies.
        $attribute_taxonomies = wc_get_attribute_taxonomies();

        if (! empty($attribute_taxonomies)) {
            foreach ($attribute_taxonomies as $key => $tax) {
                $attribute_taxonomy_name = wc_attribute_taxonomy_name($tax->attribute_name);
                $label                   = $tax->attribute_label ? $tax->attribute_label : $tax->attribute_name;

                $swatchs[$attribute_taxonomy_name] = $label;
            }
        }

        return $swatchs;
    }
}

if (!function_exists('themename_tbay_get_custom_tab_layouts')) {
    function themename_tbay_get_custom_tab_layouts()
    {
        $tabs = array( '' => 'None');

        if (!themename_woocommerce_activated()) {
            return $tabs;
        }
        $args = array(
      'posts_per_page'   => -1,
      'offset'           => 0,
      'orderby'          => 'date',
      'order'            => 'DESC',
      'post_type'        => 'tbay_customtab',
      'post_status'      => 'publish',
      'suppress_filters' => true,
    );
        $posts = get_posts($args);
        foreach ($posts as $post) {
            $tabs[$post->post_name] = $post->post_title;
        }
        return $tabs;
    }
}

/*Get title mobile in top bar mobile*/
if (! function_exists('themename_tbay_get_title_mobile')) {
    function themename_tbay_get_title_mobile($title)
    {
        $delimiter = ' / ';

        if (is_search()) {
            $title = esc_html__('Search results for', 'themename') . ' "' . get_search_query() . '"';
        } elseif (is_tag()) {
            $title = esc_html__('Posts tagged "', 'themename'). single_tag_title('', false) . '"';
        } elseif (is_category()) {
            $title = single_cat_title('', false);
        } elseif (is_archive()) {
            $title = get_the_archive_title();
        } elseif (is_404()) {
            $title = esc_html__('Error 404', 'themename');
        } elseif (is_category()) {
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
            if ($thisCat->parent != 0) {
                echo(get_category_parents($parentCat, true, ' ' . $delimiter . ' '));
            }
            $title = single_cat_title('', false);
        } elseif (is_day()) {
            $title = get_the_time('d');
        } elseif (is_month()) {
            $title = get_the_time('F');
        } elseif (is_year()) {
            $title = get_the_time('Y');
        } elseif (is_single()  && !is_attachment()) {
            $title = get_the_title();
        } else {
            $title = get_the_title();
        }

        return $title;
    }
    add_filter('themename_get_filter_title_mobile', 'themename_tbay_get_title_mobile');
}


if (! function_exists('themename_tbay_get_cookie')) {
    function themename_tbay_get_cookie($name = '')
    {
        $check = (isset($_COOKIE[$name]) && !empty($_COOKIE[$name])) ? (boolean)$_COOKIE[$name] : false;
        return $check;
    }
}

if (! function_exists('themename_tbay_active_newsletter_sidebar')) {
    function themename_tbay_active_newsletter_sidebar()
    {
        $active = false;

        $cookie = themename_tbay_get_cookie('hiddenmodal');

        if (!$cookie && is_active_sidebar('newsletter-popup')) {
            $active = true;
        }

        return $active;
    }
}

if (! function_exists('themename_yith_compare_header')) {
    function themename_yith_compare_header()
    {
        if (class_exists('YITH_Woocompare')) { ?>
<?php
                global $yith_woocompare;
            ?>
<div class="yith-compare-header product">
    <a href="<?php echo esc_url($yith_woocompare->obj->view_table_url()); ?>" class="compare added">
        <i class="tb-icon tb-icon-sync"></i>
        <?php apply_filters('themename_get_text_compare', ''); ?>
    </a>
</div>
<?php }
    }
}

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
if (! function_exists('themename_pingback_header')) {
    function themename_pingback_header()
    {
        if (is_singular() && pings_open()) {
            echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
        }
    }
    add_action('wp_head', 'themename_pingback_header', 30);
}


if (! function_exists('themename_tbay_check_data_responsive')) {
    function themename_tbay_check_data_responsive($columns,$desktop, $desktopsmall, $tablet, $landscape_mobile, $mobile)
    {
        $data_array = array();

        $data_array['desktop']          =      isset($desktop) ? $desktop : $columns;
        $data_array['desktopsmall']     =      isset($desktopsmall) ? $desktopsmall : 3;
        $data_array['tablet']           =      isset($tablet) ? $tablet : 3;
        $data_array['landscape']        =      isset($landscape_mobile) ? $landscape_mobile : 3;
        $data_array['mobile']           =      isset($mobile) ? $mobile : 2;

        return $data_array;
    }
}

if (! function_exists('themename_tbay_check_data_responsive_carousel')) {
    function themename_tbay_check_data_responsive_carousel($columns, $desktop, $desktopsmall, $tablet, $landscape_mobile, $mobile)
    {
        $data_responsive = themename_tbay_check_data_responsive($columns,$desktop, $desktopsmall, $tablet, $landscape_mobile, $mobile);

        $datas = " data-items=\"". $columns ."\"";
        $datas .= " data-desktopslick=\"". $data_responsive['desktop'] ."\"";
        $datas .= " data-desktopsmallslick=\"". $data_responsive['desktopsmall'] ."\"";
        $datas .= " data-tabletslick=\"". $data_responsive['tablet'] ."\"";
        $datas .= " data-landscapeslick=\"". $data_responsive['landscape'] ."\"";
        $datas .= " data-mobileslick=\"". $data_responsive['mobile'] ."\"";

        return $datas;
    }
}


if (! function_exists('themename_tbay_check_data_responsive_grid')) {
    function themename_tbay_check_data_responsive_grid($columns, $desktop, $desktopsmall, $tablet, $landscape_mobile, $mobile)
    {
        $data_responsive = themename_tbay_check_data_responsive($columns, $desktop, $desktopsmall, $tablet, $landscape_mobile, $mobile);

        $datas  = "";
        $datas .= " data-xlgdesktop=\"" . esc_attr($columns) ."\"";
        $datas .= " data-desktop=\"" . esc_attr($data_responsive['desktop']) ."\"";
        $datas .= " data-desktopsmall=\"" . esc_attr($data_responsive['desktopsmall']) ."\"";
        $datas .= " data-tablet=\"" . esc_attr($data_responsive['tablet']) ."\"";
        $datas .= " data-landscape=\"" . esc_attr($data_responsive['landscape']) ."\"";
        $datas .= " data-mobile=\"" . esc_attr($data_responsive['mobile']) ."\"";

        return $datas;
    }
}

if (! function_exists('themename_tbay_check_data_carousel')) {
    function themename_tbay_check_data_carousel($rows, $nav_type, $pagi_type, $loop_type, $auto_type, $autospeed_type, $disable_mobile)
    {
        $data_array = array();

        $data_array['rows']				= isset($rows) ? $rows : 1;
        $data_array['nav'] 				= ($nav_type == 'yes') ? true : false;
        $data_array['pagination'] 		= ($pagi_type == 'yes') ? true : false;
        $data_array['loop'] 			= ($loop_type == 'yes') ? true : false;
        $data_array['auto'] 			= ($auto_type == 'yes') ? true : false;
        $data_array['autospeed'] 		= (!empty($autospeed_type)) ? $autospeed_type : 500;
        $data_array['disable_mobile'] 	= ($disable_mobile == 'yes') ? true : false;

        return $data_array;
    }
}

if (! function_exists('themename_tbay_data_carousel')) {
    function themename_tbay_data_carousel($rows, $nav_type, $pagi_type, $loop_type, $auto_type, $autospeed_type, $disable_mobile)
    {
        $data_array = themename_tbay_check_data_carousel($rows, $nav_type, $pagi_type, $loop_type, $auto_type, $autospeed_type, $disable_mobile);

        $datas  = " data-carousel=\"owl\"";
        $datas .= " data-rows=\"" . esc_attr($data_array['rows']) ."\"";
        $datas .= " data-nav=\"" . esc_attr($data_array['nav']) ."\"";
        $datas .= " data-pagination=\"" . esc_attr($data_array['pagination']) ."\"";
        $datas .= " data-loop=\"" . esc_attr($data_array['loop']) ."\"";
        $datas .= " data-auto=\"" . esc_attr($data_array['auto']) ."\"";

        if ($data_array['auto'] == 'yes') {
            $datas .= " data-autospeed=\"" . esc_attr($data_array['autospeed']) ."\"";
        }

        $datas .= " data-unslick=\"" . esc_attr($data_array['disable_mobile']) ."\"";

        return $datas;
    }
}

if (!function_exists('themename_get_template_product')) {
    function themename_get_template_product()
    {
        $output = array(
			'inner' => esc_html__('Inner' ,'themename'), 
			'vertical' => esc_html__('Vertical' ,'themename'), 
		);

        return $output;
    }
    add_filter('themename_get_template_product', 'themename_get_template_product', 10, 1);
}

if (!function_exists('themename_redux_framework_activated')) {
    function themename_redux_framework_activated()
    {
        return class_exists('Redux_Framework_Plugin');
    }
}

if (!function_exists('themename_wpxperttheme_core_activated')) {
    function themename_wpxperttheme_core_activated()
    {
        return class_exists('WPxpertthemeClass');
    }
}

if (!function_exists('themename_elementor_activated')) {
    function themename_elementor_activated()
    {
        return class_exists( '\Elementor\Plugin' );
    }
}


if (!function_exists('themename_nextend_social_login_activated')) {
    function themename_nextend_social_login_activated()
    {
        return class_exists('NextendSocialLogin');
    }
}

if (!function_exists('themename_elementor_pro_activated')) {
    function themename_elementor_pro_activated()
    {
        return function_exists('elementor_pro_load_plugin');
    }
}

if (!function_exists('themename_wpml_is_activated')) {
    function themename_wpml_is_activated() {
        return class_exists('SitePress');
    }
}

if (! function_exists('themename_elementor_is_edit_mode')) {
    function themename_elementor_is_edit_mode()
    {
        return Elementor\Plugin::$instance->editor->is_edit_mode();
    }
}

if (! function_exists('themename_elementor_preview_page')) {
    function themename_elementor_preview_page()
    {
        return isset($_GET['preview_id']);
    }
}

if (! function_exists('themename_elementor_preview_mode')) {
    function themename_elementor_preview_mode()
    {
        return Elementor\Plugin::$instance->preview->is_preview_mode();
    }
}

if (!function_exists('themename_woocommerce_activated')) {
    function themename_woocommerce_activated()
    {
        return class_exists('WooCommerce');
    }
}

if (!function_exists('themename_is_woo_variation_swatches_pro')) {
    function themename_is_woo_variation_swatches_pro()
    {
        return class_exists('Woo_Variation_Swatches_Pro') ? true : false;
    }
}

if (!function_exists('themename_is_ajax_popup_quick')) {
    function themename_is_ajax_popup_quick()
    {
        $active = true;

        if (themename_is_woo_variation_swatches_pro()) {
            $active = false;
        }

        return $active;
    }
}

if (!function_exists('themename_is_meta_box')) {
    function themename_is_meta_box() {
        return class_exists( 'RWMB_Loader' ) ? true : false;
    }
}

if (!function_exists('themename_switcher_to_boolean')) {
    function themename_switcher_to_boolean($var)
    {
        if ($var === 'yes') {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('themename_sidebars_array')) {
    function themename_sidebars_array()
    {
        global $wp_registered_sidebars;
        $sidebars = array();

        
        if ( !empty($wp_registered_sidebars) ) {
            foreach ($wp_registered_sidebars as $sidebar) {
                $sidebars[$sidebar['id']] = $sidebar['name'];
            }
        }

        return $sidebars;
    }
}

/**
 * Dont Update the Theme
 *
 * If there is a theme in the repo with the same name, this prevents WP from prompting an update.
 *
 * @since  1.0.0
 * @param  array $r Existing request arguments
 * @param  string $url Request URL
 * @return array Amended request arguments
 */
if (!function_exists('themename_dont_update_theme')) {
    function themename_dont_update_theme($r, $url)
    {
        if (0 !== strpos($url, 'https://api.wordpress.org/themes/update-check/1.1/')) {
            return $r;
        } // Not a theme update request. Bail immediately.
        $themes = json_decode($r['body']['themes']);
        $child = get_option('stylesheet');
        unset($themes->themes->$child);
        $r['body']['themes'] = json_encode($themes);
        return $r;
    }
    add_filter('http_request_args', 'themename_dont_update_theme', 5, 2);
}

if (!function_exists('themename_elements_ready_slick')) {
    function themename_elements_ready_slick()
    {
        $elements = [
            'brands',
            'custom-gallery', 
            'products',
            'posts-grid',
            'our-team',
            'product-category',
            'product-tabs',
            'testimonials',
            'product-categories-tabs',
            'list-categories-product',
            'custom-image-list-categories',
            'custom-image-list-tags',
            'product-recently-viewed',
            'product-flash-sales',
            'product-list-tags',
            'shortcode-carousel',
            'product-count-down',
            'portfolios',
        ];
     
        return $elements;
    }
}

if (!function_exists('themename_elements_ready_isotope')) {
    function themename_elements_ready_isotope()
    {
        $elements = [
            'portfolios',
        ];
     
        return $elements;
    }
}

if (!function_exists('themename_elements_ready_products')) {
    function themename_elements_ready_products()
    {
        $elements = [
            'products',
            'single-product-home',
            'product-category',
            'product-tabs',
            'product-categories-tabs',
        ];
     
        return $elements;
    }
}

if (!function_exists('themename_elements_ajax_tabs')) {
    function themename_elements_ajax_tabs()
    {
        $elements = [ 
            'product-categories-tabs',  
            'product-tabs',
        ];
     
        return $elements;
    }
}


if (!function_exists('themename_tbay_footer_class')) {
    function themename_tbay_footer_class()
    {
        $classes = ['tbay-footer', apply_filters('themename_tbay_get_footer_layout', 'footer_default')];
        
        echo 'class="'. join(' ', apply_filters('themename_tbay_footer_class', $classes)) .'"';
    }
}

if (!function_exists('themename_elements_ready_countdown_timer')) {
    function themename_elements_ready_countdown_timer()
    {
        $array = [
            'product-flash-sales',
            'product-count-down',
            'countdown'
        ];

        return $array;
    }
}

if (!function_exists('themename_elements_ready_nav_menu')) {
    function themename_elements_ready_nav_menu()
    {
        $array = [
            'nav-menu',
        ];

        return $array;
    }
}

if (!function_exists('themename_elements_ready_autocomplete')) {
    function themename_elements_ready_autocomplete()
    {
        $array = [
            'search-form',
            'search-canvas',
        ];

        return $array;
    }
}

if (!function_exists('themename_elements_ready_customfonts')) {
    function themename_elements_ready_customfonts()
    {
        $array = [
            'list-custom-fonts',
        ];

        return $array;
    }
}
 

if (!function_exists('themename_localize_translate')) {
    function themename_localize_translate()
    {
        $themename_hash_transient = get_transient( 'themename-hash-time' );
		if ( false === $themename_hash_transient ) {
			$themename_hash_transient = time();
			set_transient( 'themename-hash-time', $themename_hash_transient );
		}

        global $wp_query;
            
        $config = array( 
            'storage_key'  		=> apply_filters( 'themename_storage_key', 'themename_' . md5( get_current_blog_id() . '_' . get_home_url( get_current_blog_id(), '/' ) . get_template() . $themename_hash_transient ) ),
            'quantity_minus'    => apply_filters('themename_quantity_minus', '<i class="tb-icon tb-icon-minus"></i>'),
            'quantity_plus'     => apply_filters('themename_quantity_plus', '<i class="tb-icon tb-icon-plus"></i>'),
            'ajaxurl'			=> admin_url('admin-ajax.php'),
            'cancel'            => esc_html__('cancel', 'themename'),  
            'close'             => apply_filters('themename_quantity_plus', '<i class="tb-icon tb-icon-close-01"></i>'),
            'show_all_text'     => esc_html__('View all', 'themename'),
            'search'            => esc_html__('Search', 'themename'),
            'wp_searchnonce' 	=> wp_create_nonce('themename-search-nonce'),
            'wp_megamenunonce' 	=> wp_create_nonce('themename-megamenu-nonce'),
            'wp_menuclicknonce' => wp_create_nonce('themename-menuclick-nonce'),
            'wp_templateclicknonce' => wp_create_nonce('themename-templateclick-nonce'),
            'posts'             => json_encode($wp_query->query_vars),
            'mobile'            => wp_is_mobile(),
            'slick_prev'        => apply_filters('themename_slick_prev', '<i class="tb-icon tb-icon-arrow-left-2"></i>'), 
            'slick_next'        => apply_filters('themename_slick_next', '<i class="tb-icon tb-icon-arrow-right-2"></i>'), 
            /*Element ready default callback*/
            'elements_ready'  => array(
                'slick'               => themename_elements_ready_slick(),
                'products'            => themename_elements_ready_products(),
                'ajax_tabs'           => themename_elements_ajax_tabs(), 
                'countdowntimer'      => themename_elements_ready_countdown_timer(),
                'navmenu'        	  => themename_elements_ready_nav_menu(),
                'autocomplete'        => themename_elements_ready_autocomplete(),
                'customfonts'         => themename_elements_ready_customfonts(),
                'isotope'             => themename_elements_ready_isotope(),
            )
        );

        if( themename_elementor_activated() ) {
            $config['combined_css']         = themename_get_elementor_css_print_method();
        }

        if (themename_woocommerce_activated()) {
            $position                       = (wp_is_mobile()) ? 'right' : apply_filters('themename_cart_position', 10, 2);
            $woo_mode                       = themename_tbay_woocommerce_get_display_mode();
            $quantity_mode                  = themename_woocommerce_quantity_mode_active();
            $loader                         = apply_filters('themename_quick_view_loader_gif', THEMENAME_IMAGES . '/ajax-loader-alt.svg');

            $config['popup_cart_icon']      = apply_filters('themename_popup_cart_icon', '<i class="tb-icon tb-icon tb-icon-tick-circle"></i>', 2);
            $config['popup_cart_noti']      = esc_html__('was added to shopping cart.', 'themename');
 
            $config['cart_position']        = $position;
            $config['ajax_update_quantity'] = (bool) themename_tbay_get_config('ajax_update_quantity', false);

            $config['display_mode']         = $woo_mode;
            $config['quantity_mode']        = $quantity_mode;
            $config['loader']               = $loader;

            $config['is_checkout']          =  is_checkout();

            $config['mobile_form_cart_style']     =  themename_get_mobile_form_cart_style();
             
            $config['ajax_popup_quick']     =  apply_filters('themename_ajax_popup_quick', themename_is_ajax_popup_quick());

            $config['wc_ajax_url']          =  WC_AJAX::get_endpoint('%%endpoint%%');
            $config['checkout_url']         =  wc_get_checkout_url();
            $config['i18n_checkout']        =  esc_html__('Checkout', 'themename');

            $config['img_class_container']                  =  '.'.themename_get_gallery_item_class();
            $config['thumbnail_gallery_class_element']      =  '.'.themename_get_thumbnail_gallery_item();

            /** Create Nonce **/
            $config['wp_minicartquantitynonce']         = wp_create_nonce('themename-minicartquantity-nonce');
            $config['wp_productremovenonce']            = wp_create_nonce('themename-productremove-nonce');
            $config['wp_productscategoriestabnonce']    = wp_create_nonce('themename-productscategoriestab-nonce');
            $config['wp_productstabnonce']              = wp_create_nonce('themename-productstab-nonce');
            $config['wp_productslistnonce']             = wp_create_nonce('themename-productslist-nonce');
            $config['wp_productsgridnonce']             = wp_create_nonce('themename-productsgrid-nonce');
            $config['wp_singleaddtocartnonce']          = wp_create_nonce('themename-singleaddtocart-nonce');
            $config['wp_popupvariationnamenonce']       = wp_create_nonce('themename-popupvariationname-nonce');
            $config['wp_wishlistcountnonce']            = wp_create_nonce('themename-wishlistcount-nonce');
            $config['wp_quickviewproductnonce']         = wp_create_nonce('themename-quickviewproduct-nonce');

            $config['collapse_details_tab']     = (bool) themename_tbay_get_config('enable_collapse_product_details_tab', false);
            $config['maximum_height_collapse']  = themename_tbay_get_config('maximum_height_collapse', 300);
            $config['show_more']                = esc_html__('Show More', 'themename');
            $config['show_less']                = esc_html__('Show Less ', 'themename');
        }

        return apply_filters('themename_localize_translate', $config);
    }
}


if (! function_exists('themename_instagram_feed_row_class')) {
    function themename_instagram_feed_row_class($array)
    {
        if (!is_array($array)) {
            return false;
        }
        $result = '';
        foreach ($array as $key => $value) {
            if ($key !== 'tb-atts' && $key !== 'user') {
                $result .= ' '.$key.'='."'$value'";
            }
        }

        echo trim($result);
    }
}

if (!function_exists('themename_sb_instagram_get_user_account_data')) {
    function themename_sb_instagram_get_user_account_data()
    {
        $sbi_options = get_option('sb_instagram_settings', array());
        $connected_accounts = $sbi_options['connected_accounts'];

        $users = array();

        if (empty($connected_accounts)) {
            return '';
        }

        foreach ($connected_accounts as $key => $value) {
            array_push($users, $value['username']);
        }

        return implode(",", $users);
    }
}


if (!function_exists('themename_wc_get_custom_tab_options')) {
    function themename_wc_get_custom_tab_options()
    {
        $tabs = array( '' => esc_html__('No Tab', 'themename'));
        $args = array(
            'posts_per_page'   => -1,
            'offset'           => 0,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'post_type'        => 'tbay_customtab',
            'post_status'      => 'publish',
            'suppress_filters' => true
        );
        $posts = get_posts($args);
        foreach ($posts as $post) {
            $tabs[$post->post_name] = $post->post_title;
        }
        return $tabs;
    }
}

if (!function_exists('themename_register_custom_tab')) {
    function themename_register_custom_tab($types)
    {
        array_push($types, 'customtab');

        return $types;
    }
    add_filter('tbay_elementor_register_post_types', 'themename_register_custom_tab', 10, 1);
}

if (!function_exists('themename_rocket_lazyload_exclude_class')) {
    function themename_rocket_lazyload_exclude_class($attributes)
    {
        $attributes[] = 'class="attachment-yith-woocompare-image size-yith-woocompare-image"';
        $attributes[] = 'class="logo-mobile-img"';
        $attributes[] = 'alt="tab-img-01"';
        $attributes[] = 'alt="tab-img-02"';
        $attributes[] = 'alt="tab-img-03"';
        $attributes[] = 'alt="tab-img-04"';
        $attributes[] = 'alt="tab-img-05"';
        $attributes[] = 'alt="tab-img-06"';

        return $attributes;
    }
    add_filter('rocket_lazyload_excluded_attributes', 'themename_rocket_lazyload_exclude_class');
}

if (! function_exists('themename_is_remove_scripts')) {
    function themename_is_remove_scripts()
    {
        if (function_exists('is_vendor_dashboard') && is_vendor_dashboard() && is_user_logged_in() && (is_user_mvx_vendor(get_current_user_id()) || is_user_mvx_pending_vendor(get_current_user_id()) || is_user_mvx_rejected_vendor(get_current_user_id())) && apply_filters('mvx_vendor_dashboard_exclude_header_footer', true)) {
            return true;
        }

        return false;
    }
}

/**
 * Check is vendor active
 *
 * @return bool
 */
if (! function_exists('themename_woo_is_active_vendor')) {
    function themename_woo_is_active_vendor()
    {
        if (function_exists('dokan_is_store_page')) {
            return true;
        }

        if (class_exists('WCV_Vendors')) {
            return true;
        }

        if (class_exists('MVX')) {
            return true;
        }

        if (function_exists('wcfm_is_store_page')) {
            return true;
        }

        return false;
    }
}

if (!function_exists('themename_catalog_mode_active')) {
    function themename_catalog_mode_active()
    {
        $active = (isset($_GET['catalog_mode'])) ? $_GET['catalog_mode'] : themename_tbay_get_config('enable_woocommerce_catalog_mode', false);

        return $active;
    }
}

if (! function_exists('themename_checkout_optimized')) {
    function themename_checkout_optimized()
    {
        if( !themename_woocommerce_activated() || !is_checkout() ) return false;

        // Check cart has contents.
		if ( WC()->cart->is_empty() && ! is_customize_preview() && apply_filters( 'woocommerce_checkout_redirect_empty_cart', true ) ) {
			return false;
		}
       
        if( ( isset($_GET['checkout_optimized']) && $_GET['checkout_optimized'] ) || themename_tbay_get_config('show_checkout_optimized', false) ) {
            return true; 
        } else {
            return false;
        }
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Logo Checkout
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('themename_the_logo_checkout')) {
    function themename_the_logo_checkout()
    {
        if( !themename_checkout_optimized() ) return;

        $ouput = themename_tbay_get_logo_checkout();
        echo trim($ouput);
    }
    add_action('themename_theme_header_checkout', 'themename_the_logo_checkout', 10);
}

if (! function_exists('themename_tbay_get_logo_checkout')) {
    function themename_tbay_get_logo_checkout()
    {
        $logo 			= themename_tbay_get_config('checkout_logo');

        $output 	= '<div class="checkout-logo">';
        if (isset($logo['url']) && !empty($logo['url'])) {
            $url    	= $logo['url'];
            $output 	.= '<a href="'. esc_url(home_url('/')) .'">';

            if (isset($logo['width']) && !empty($logo['width'])) {
                $output 		.= '<img src="'. esc_url($url) .'" width="'. esc_attr($logo['width']) .'" height="'. esc_attr($logo['height']) .'" alt="'. get_bloginfo('name') .'">';
            } else {
                $output 		.= '<img class="logo-checkout-img" src="'. esc_url($url) .'" alt="'. get_bloginfo('name') .'">';
            } 

                
            $output 		.= '</a>';
        } else {
            $output 		.= '<div class="logo-theme">';
            $output 	.= '<a href="'. esc_url(home_url('/')) .'">';
            $output 	.= '<img class="logo-checkout-img" src="'. esc_url_raw(THEMENAME_IMAGES .'/logo.svg') .'" alt="'. get_bloginfo('name') .'">';
            $output 	.= '</a>';
            $output 		.= '</div>';
        }
        $output 	.= '</div>';
        
        return apply_filters('themename_tbay_get_logo_checkout', $output, 10);
    }
}

if ( ! function_exists( 'themename_clean' ) ) {
	function themename_clean( $var ) {
		if ( is_array( $var ) ) {
			return array_map( 'themename_clean', $var );
		} else {
			return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		}
	}
}

if ( ! function_exists( 'themename_clear_transient' ) ) {
	function themename_clear_transient() {
		delete_transient( 'themename-hash-time' );
	} 
	add_action( 'wp_update_nav_menu_item', 'themename_clear_transient', 11, 1 );
} 

if (! function_exists('themename_nav_menu_get_menu_class')) {
    function themename_nav_menu_get_menu_class($layout)
    { 
 
        $menu_class    = 'elementor-nav-menu menu nav navbar-nav megamenu';

		switch ($layout) {
			case 'vertical':
				$menu_class .= ' flex-column';
				break;

			case 'treeview':
				$menu_class = 'menu navbar-nav';
				break;
			
			default:
				$menu_class .= ' flex-row';
				break;
		}

		return  $menu_class;
    }
}

if (! function_exists('themename_get_transliterate')) {
    function themename_get_transliterate( $slug ) {
        $slug = urldecode($slug);

        if (function_exists('iconv') && defined('ICONV_IMPL') && @strcasecmp(ICONV_IMPL, 'unknown') !== 0) {
            $slug = iconv('UTF-8', 'UTF-8//TRANSLIT//IGNORE', $slug);
        }

        return $slug;
    }
}


if ( ! function_exists( 'themename_wpml_object_id' ) ) {
	function themename_wpml_object_id( $element_id, $element_type = 'post', $return_original_if_missing = false, $language_code = null ) {
		if ( function_exists( 'wpml_object_id_filter' ) ) {
			return wpml_object_id_filter( $element_id, $element_type, $return_original_if_missing, $language_code );
		} elseif ( function_exists( 'icl_object_id' ) ) {
			return icl_object_id( $element_id, $element_type, $return_original_if_missing, $language_code );
		} else {
			return $element_id;
		}
	}
}

if (! function_exists('themename_is_show_woo_catalog_ordering')) {
    function themename_is_show_woo_catalog_ordering() {
        $active = true;

        if( function_exists('dokan_is_store_page') && dokan_is_store_page() ) {
            $active = false;
        }

        return $active;
    }
}


if (! function_exists('themename_elementor_general_widgets')) {
    function themename_elementor_general_widgets() {
        $elements = array(
            'template',
            'heading',
            'brands',
            'banner',
            'before-after-image-slider',
            'posts-grid',
            'list-menu',
            'our-team',
            'testimonials', 
            'testimonials-tab',
            'list-custom-fonts',
            'feature-list',
            'feature-list-image',
            'button',
            'countdown',
            'text-box',
            'menu-vertical',
            'gallery',
            'shortcode-carousel',
            'image-tab',
            'store-notice',
        );

        if( defined('TBAY_PORTFOLIOS') && TBAY_PORTFOLIOS &&  apply_filters( 'wpxperttheme_register_post_types_portfolio', true) ) {
            array_push($elements, 'portfolios');
		}

        $active_theme = themename_tbay_get_theme();

        if( $active_theme === 'bicycle' ) {
            array_push($elements, 'image-color-tab');
        }

        if ( function_exists( 'wpforms' ) ) {
            array_push($elements, 'wpforms-button-popup');
        }

        if (class_exists('MC4WP_MailChimp')) {
            array_push($elements, 'newsletter');
        }

        return apply_filters('themename_general_elements_array', $elements );
    }
}

if (! function_exists('themename_elementor_header_widgets')) {
    function themename_elementor_header_widgets() {
        $elements = array(
            'site-logo',
            'nav-menu',
            'mobile-menu',
            'search-form',
            'canvas-menu-template',
            'search-canvas',
            'search-popup',
        );

        if (themename_woocommerce_activated()) {
            array_push($elements, 'account');
            array_push($elements, 'product-recently-viewed-header');

            if (!themename_catalog_mode_active()) {
                array_push($elements, 'mini-cart');
            }
        }

        if (class_exists('WOOCS_STARTER')) {
            array_push($elements, 'currency');
        }

        if (class_exists('YITH_WCWL')) {
            array_push($elements, 'wishlist');
        }

        if (class_exists('YITH_Woocompare')) {
            array_push($elements, 'compare');
        }

        if (defined('TBAY_ELEMENTOR_DEMO')) {
            array_push($elements, 'custom-language');
        }

        return apply_filters('themename_header_elements_array', $elements );
    }
}

if (! function_exists('themename_elementor_woocommerce_widgets')) {
    function themename_elementor_woocommerce_widgets() {
        $elements = array(
            'products',
            'single-product-home',
            'product-category',
            'product-tabs',
            'woocommerce-tags',
            'custom-image-list-tags',
            'product-categories-tabs',
            'list-categories-product',
            'custom-image-list-categories',
            'product-recently-viewed-main',
            'product-flash-sales',
            'product-count-down',
            'product-list-tags'
        );

        return apply_filters('themename_woocommerce_elements_array', $elements );
    }
}

if (! function_exists('themename_list_controls_effects')) {
    function themename_list_controls_effects() {
        $options = [
            'no'                => 'No Effect',
            'zoom-in-1'         => 'Zoom In 1',
            'zoom-in-2'         => 'Zoom In 2',
            'zoom-out-1'        => 'Zoom Out 1',
            'zoom-out-2'        => 'Zoom Out 2',
            'slide'             => 'Slide',
            'rotate-zoom-out'   => 'Rotate + Zoom Out',
            'blur'              => 'Blur',
            'gray-scale'        => 'Gray Scale',
            'sepia'             => 'Sepia',
            'blur-gray-scale'   => 'Blur + Gray Scale',
            'opacity'           => 'Opacity',
            'flashing'          => 'Flashing',
            'shine'             => 'Shine',
            'circle'            => 'Circle',
        ];

        return $options;
    }
}



if ( !function_exists('themename_tbay_product_styles') ) {
	function themename_tbay_product_styles() {
		$styles = array();

		$styles['v1'] = array(
			'title' => esc_html__( 'Product Style 01', 'themename' ),
			'img'   => THEMENAME_ASSETS_IMAGES . '/product_styles/product-style-01.gif'
		);

		$styles['v2'] = array(
			'title' => esc_html__( 'Product Style 02', 'themename' ),
			'img'   => THEMENAME_ASSETS_IMAGES . '/product_styles/product-style-02.gif'
		);

		$styles['v3'] = array(
			'title' => esc_html__( 'Product Style 03', 'themename' ),
			'img'   => THEMENAME_ASSETS_IMAGES . '/product_styles/product-style-03.gif'
		);

		$styles['v4'] = array(
			'title' => esc_html__( 'Product Style 04', 'themename' ),
			'img'   => THEMENAME_ASSETS_IMAGES . '/product_styles/product-style-04.gif'
		);

		$styles['v5'] = array(
			'title' => esc_html__( 'Product Style 05', 'themename' ),
			'img'   => THEMENAME_ASSETS_IMAGES . '/product_styles/product-style-05.gif'
		);

		$styles['v6'] = array(
			'title' => esc_html__( 'Product Style 06', 'themename' ),
			'img'   => THEMENAME_ASSETS_IMAGES . '/product_styles/product-style-06.gif'
		);

		$styles['v7'] = array(
			'title' => esc_html__( 'Product Style 07', 'themename' ),
			'img'   => THEMENAME_ASSETS_IMAGES . '/product_styles/product-style-07.gif'
		);
		
		return $styles;

	}
}