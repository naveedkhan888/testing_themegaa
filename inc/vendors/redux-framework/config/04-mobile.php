<?php
/**
 * Redux Framework checkbox config.
 * For full documentation, please visit: http://devs.redux.io/
 *
 * @package Redux Framework
 */

defined( 'ABSPATH' ) || exit;

/** Mobile Settings **/
Redux::set_section(
	$opt_name,
	array(
        'icon' => 'zmdi zmdi-smartphone-iphone',
        'title' => esc_html__('Mobile', 'themename'),
	)
);


// Mobile Header settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Header', 'themename'),
        'fields' => array(
            array(
                'id' => 'mobile_header',
                'type' => 'switch',
                'title' => esc_html__('Enable Mobile Header', 'themename'),
                'subtitle'  => esc_html__('Only off when use Header Elementor Pro on mobile ', 'themename'),
                'default' => true
            ),
            array(
                'id' => 'mobile-logo',
                'type' => 'media',
                'required' => array('mobile_header','=', true),
                'title' => esc_html__('Upload Logo', 'themename'),
                'subtitle' => esc_html__('Image File (.png or .gif)', 'themename'),
            ),
            array(
                'id'        => 'logo_img_width_mobile',
                'type'      => 'slider',
                'required' => array('mobile_header','=', true),
                'title'     => esc_html__('Logo maximum width (px)', 'themename'),
                "default"   => 100,
                "min"       => 50,
                "step"      => 1,
                "max"       => 600,
            ),
            array(
                'id'             => 'logo_mobile_padding',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'required' => array('mobile_header','=', true),
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => esc_html__('Logo Padding', 'themename'),
                'desc'           => esc_html__('Add more spacing around logo.', 'themename'),
                'default'            => array(
                    'padding-top'     => '',
                    'padding-right'   => '',
                    'padding-bottom'  => '',
                    'padding-left'    => '',
                    'units'          => 'px',
                ),
            ),
            array(
                'id'        => 'always_display_logo',
                'type'      => 'switch',
                'required' => array('mobile_header','=', true),
                'title'     => esc_html__('Always Display Logo', 'themename'),
                'subtitle'      => esc_html__('Logo displays on all pages (page title is disabled)', 'themename'),
                'default'   => false
            ),
           
            array(
                'id'        => 'menu_mobile_search',
                'type'      => 'switch',
                'required'  => array('mobile_header','=', true),
                'title'     => esc_html__('Always Display Search', 'themename'),
                'subtitle'  => esc_html__('Search displays on all pages', 'themename'),
                'class' =>   'xptheme-search-mb-all-page',
                'default'   => false
            ),
            
            array(
                'id'        => 'hidden_header_el_pro_mobile',
                'type'      => 'switch',
                'title'     => esc_html__('Hide Header Elementor Pro', 'themename'),
                'subtitle'  => esc_html__('Hide Header Elementor Pro on mobile', 'themename'),
                'default'   => true
            ),
        )
	)
);


// Mobile Footer settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Footer', 'themename'),
        'fields' => array(
            array(
                'id' => 'mobile_footer',
                'type' => 'switch',
                'title' => esc_html__('Enable Desktop Footer', 'themename'),
                'default' => false
            ),
            array(
                'id' => 'mobile_back_to_top',
                'type' => 'switch',
                'title' => esc_html__('Enable "Back to Top" Button', 'themename'),
                'default' => false
            ),
            array(
                'id' => 'mobile_footer_icon',
                'type' => 'switch',
                'title' => esc_html__('Enable Mobile Footer', 'themename'),
                'default' => true
            ),
            array(
                'id'          => 'mobile_footer_slides',
                'type'        => 'slides',
                'title'       => esc_html__('Config List Menu Icon', 'themename'),
                'subtitle' => esc_html__('Enter icon name of fonts: ', 'themename') . '<a href="//fontawesome.com/icons?m=free/" target="_blank">Awesome</a> , <a href="//fonts.xperttheme.com/simple-line-icons//" target="_blank">Simple Line Icons</a>, <a href="//fonts.xperttheme.com/material-design-iconic/" target="_blank">Material Design Iconic</a></br></br><b>'. esc_html__('List default URLs:', 'themename') . '</b></br></br><span class="des-label">'. esc_html__('Home page:', 'themename') .'</span><b class="df-url">{{home}}</b></br><span class="des-label">'. esc_html__('Shop page:', 'themename') .'</span><b class="df-url">{{shop}}</b></br><span class="des-label">'. esc_html__('My account page:', 'themename') .'</span><b class="df-url">{{account}}</b></br><span class="des-label">'. esc_html__('Cart page:', 'themename') .'</span><b class="df-url">{{cart}}</b></br><span class="des-label">'. esc_html__('Checkout page:', 'themename') .'</span><b class="df-url">{{checkout}}</b></br><span class="des-label">'. esc_html__('Wishlist page:', 'themename') .'</span><b class="df-url">{{wishlist}}</b></br></br>'. esc_html__('Watch video tutorial: ', 'themename') . '<a href="//youtu.be/d7b6dIzV-YI/" target="_blank">here</a>',
                'class' =>   'xptheme-redux-slides',
                'show' => array(
                    'title' => true,
                    'description' => true,
                    'url' => true,
                ),
                'content_title' => esc_html__('Menu', 'themename'),
                'required' => array('mobile_footer_icon','=', true),
                'placeholder'   => array(
                    'title'      => esc_html__('Title', 'themename'),
                    'description' => esc_html__('Enter icon name', 'themename'),
                    'url'       => esc_html__('Link', 'themename'),
                ),
            ),
        )
	)
);


// Mobile Search settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Search', 'themename'),
        'fields' => array(
            array(
                'id'=>'mobile_search_type',
                'type' => 'button_set',
                'title' => esc_html__('Search Result', 'themename'),
                'options' => array(
                    'post' => esc_html__('Post', 'themename'),
                    'product' => esc_html__('Product', 'themename')
                ),
                'default' => 'product'
            ),
            array(
                'id' => 'mobile_autocomplete_search',
                'type' => 'switch',
                'title' => esc_html__('Auto-complete Search?', 'themename'),
                'default' => 1
            ),
            array(
                'id'       => 'mobile_search_placeholder',
                'type'     => 'text',
                'title'    => esc_html__('Placeholder', 'themename'),
                'default'  => esc_html__('Search in 20.000+ products...', 'themename'),
            ),
            array(
                'id' => 'mobile_enable_search_category',
                'type' => 'switch',
                'title' => esc_html__('Enable Search in Categories', 'themename'),
                'default' => true
            ),
            array(
                'id' => 'mobile_show_search_product_subtitle',
                'type' => 'switch',
                'title' => esc_html__('Show Subtitle of Search Result', 'themename'),
                'required' => array(array('mobile_autocomplete_search', '=', '1'), array('mobile_search_type', '=', 'product')),
                'default' => false
            ), 
            array(
                'id' => 'mobile_show_search_product_image',
                'type' => 'switch',
                'title' => esc_html__('Show Image of Search Result', 'themename'),
                'required' => array('mobile_autocomplete_search', '=', '1'),
                'default' => 1
            ),
            array(
                'id' => 'mobile_show_search_product_price',
                'type' => 'switch',
                'title' => esc_html__('Show Price of Search Result', 'themename'),
                'required' => array(array('mobile_autocomplete_search', '=', '1'), array('mobile_search_type', '=', 'product')),
                'default' => true
            ),
            array(
                'id' => 'mobile_search_min_chars',
                'type'  => 'slider',
                'required' => array('mobile_autocomplete_search', '=', '1'),
                'title' => esc_html__('Search Minimum Characters', 'themename'),
                'default' => 2,
                'min'   => 1,
                'step'  => 1,
                'max'   => 6,
            ),
            array(
                'id' => 'mobile_search_max_number_results',
                'type'  => 'slider',
                'required' => array('mobile_autocomplete_search', '=', '1'),
                'title' => esc_html__('Number of Search Results', 'themename'),
                'desc'  => esc_html__('Max number of results show in Mobile', 'themename'),
                'default' => 5,
                'min'   => 2,
                'step'  => 1,
                'max'   => 20,
            ),
        )
	)
);


// Mobile Menu settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Menu Mobile', 'themename'),
        'fields' => array(
            array(
                'id'       => 'menu_mobile_select',
                'type'     => 'select',
                'data'     => 'menus',
                'title'    => esc_html__('Main Menu Mobile', 'themename'),
                'desc'     => esc_html__('Select the menu you want to display.', 'themename'),
                'default' => 69
            ),
            array(
                'id' => 'enable_mmenu_langue',
                'type' => 'switch',
                'title' => esc_html__('Enable Custom Language', 'themename'),
                'desc'  => esc_html__('If you use WPML will appear here', 'themename'),
                'default' => false
            ),
            array(
                'id' => 'enable_mmenu_currency',
                'type' => 'switch',
                'title' => esc_html__('Enable Currency', 'themename'),
                'default' => false
            ),
        )
	)
);


// Mobile WooCommerce settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Mobile WooCommerce', 'themename'),
        'fields' => array(
            array(
                'id' => 'mobile_product_number',
                'type' => 'image_select',
                'title' => esc_html__('Product Column in Shop page', 'themename'),
                'options' => array(
                    'one' => array(
                        'title' => esc_html__('One Column', 'themename'),
                        'img'   => THEMENAME_ASSETS_IMAGES . '/mobile/one_column.jpg'
                    ),
                    'two' => array(
                        'title' => esc_html__('Two Columns', 'themename'),
                        'img'   => THEMENAME_ASSETS_IMAGES . '/mobile/two_columns.jpg'
                    ),
                ),
                'default' => 'two'
            ),
            array(
                'id' => 'enable_add_cart_mobile',
                'type' => 'switch',
                'title' => esc_html__('Show "Add to Cart" Button', 'themename'),
                'subtitle' => esc_html__('On Home and page Shop', 'themename'),
                'default' => false
            ),
            array(
                'id' => 'enable_wishlist_mobile',
                'type' => 'switch',
                'title' => esc_html__('Show "Wishlist" Button', 'themename'),
                'subtitle' => esc_html__('Enable or disable in Home and Shop page', 'themename'),
                'default' => false
            ),
            array(
                'id' => 'enable_one_name_mobile',
                'type' => 'switch',
                'title' => esc_html__('Show Full Product Name', 'themename'),
                'subtitle' => esc_html__('Enable or disable in Home and Shop page', 'themename'),
                'default' => false
            ),
            array(
                'id' => 'mobile_form_cart_style',
                'type' => 'select',
                'title' => esc_html__('Add To Cart Form Type', 'themename'),
                'subtitle' => esc_html__('On Page Single Product', 'themename'),
                'options' => array(
                    'default' => esc_html__('Default', 'themename'),
                    'popup' => esc_html__('Popup', 'themename')
                ),
                'default' => 'popup'
            ),
            array(
                'id' => 'enable_quantity_mobile',
                'type' => 'switch',
                'title' => esc_html__('Show Quantity', 'themename'),
                'subtitle' => esc_html__('On Page Single Product', 'themename'),
                'required' => array('mobile_form_cart_style','=', 'default'),
                'default' => false
            ),
            array(
                'id' => 'enable_tabs_mobile',
                'type' => 'switch',
                'title' => esc_html__('Show Sidebar Tabs', 'themename'),
                'subtitle' => esc_html__('On Page Single Product', 'themename'),
                'default' => true
            ),
        )
	)
);