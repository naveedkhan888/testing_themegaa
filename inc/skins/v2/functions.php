<?php 

if (!function_exists('lasa_tbay_private_size_image_setup')) {
    function lasa_tbay_private_size_image_setup()
    {
        if (lasa_tbay_get_global_config('config_media', false)) {
            return;
        }

        // Post Thumbnails Size 
        set_post_thumbnail_size(500, 300, true); // Unlimited height, soft crop
        update_option('thumbnail_size_w', 500);
        update_option('thumbnail_size_h', 300);

        update_option('medium_size_w', 555);    
        update_option('medium_size_h', 333);

        update_option('large_size_w', 770);
        update_option('large_size_h', 466); 
    }
    add_action('after_setup_theme', 'lasa_tbay_private_size_image_setup');
}
  
/**
 *  Include Load Google Front
 */

if ( !function_exists('lasa_fonts_url') ) {
	function lasa_fonts_url() {
        /**
         * Load Google Front
         */

        $fonts_url = '';

        /* Translators: If there are clasacters in your language that are not
        * supported by Montserrat, translate this to 'off'. Do not translate
        * into your own language.
        */
        $google_font       = _x('on', 'Poppins font: on or off', 'lasa');

     
        if ('off' !== $google_font) {
            $font_families = array();
     
            if ('off' !== $google_font) {
                $font_families[] = 'Poppins:400,500,600,700';
            }

            $query_args = array(
                'family' => rawurlencode(implode('|', $font_families)),
                'subset' => urlencode('latin,latin-ext'),
                'display' => urlencode('swap'),
            );
            
            $protocol = is_ssl() ? 'https:' : 'http:';
            $fonts_url = add_query_arg($query_args, $protocol .'//fonts.googleapis.com/css');
        }
     
        return esc_url_raw($fonts_url);
		
	}
}

if ( !function_exists('lasa_tbay_fonts_url') ) {
	function lasa_tbay_fonts_url() {  
        $show_typography  = lasa_tbay_get_config('show_typography', false);
        $font_source      = lasa_tbay_get_config('font_source', "1");
        $font_google_code = lasa_tbay_get_config('font_google_code');
        if( !$show_typography ) {
			wp_enqueue_style( 'lasa-theme-fonts', lasa_fonts_url(), array(), false );
		} else if ( $font_source == "2" && !empty($font_google_code) ) {
            wp_enqueue_style('lasa-theme-fonts', $font_google_code, array(), null);
		}
	}
	add_action('wp_enqueue_scripts', 'lasa_tbay_fonts_url');
}
