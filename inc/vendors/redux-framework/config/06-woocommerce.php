<?php
/**
 * Redux Framework checkbox config.
 * For full documentation, please visit: http://devs.redux.io/
 *
 * @package Redux Framework
 */

defined( 'ABSPATH' ) || exit;

$columns            = lasa_settings_columns();
$aspect_ratio       = lasa_settings_aspect_ratio();

/** WooCommerce Settings **/
Redux::set_section(
	$opt_name,
	array(
        'icon' => 'zmdi zmdi-shopping-cart',
        'title' => esc_html__('WooCommerce Theme', 'lasa'),
        'fields' => array(
            array(
                'id' => 'product_layout_style',
                'type' => 'image_select',
                'title' => esc_html__('Product Styles', 'lasa'),
                'options'   => lasa_tbay_product_styles(),
                'default' => 'v1'
            ),
            array(
                'title'    => esc_html__('Label Sale Format', 'lasa'),
                'id'       => 'sale_tags',
                'type'     => 'radio',
                'options'  => array(
                    'Sale' => esc_html__('Sale', 'lasa'),
                    'Save {percent-diff}%' => esc_html__('Save {percent-diff}% (e.g "Save 50%")', 'lasa'),
                    'Save {symbol}{price-diff}' => esc_html__('Save {symbol}{price-diff} (e.g "Save $50")', 'lasa'),
                    'custom' => esc_html__('Custom Format (e.g -50%, -$50)', 'lasa')
                ),
                'default' => 'custom'
            ),
            array(
                'id'        => 'sale_tag_custom',
                'type'      => 'text',
                'title'     => esc_html__('Custom Format', 'lasa'),
                'desc'      => '{price-diff} '.esc_html__('inserts the dollar amount off.', 'lasa'). '</br>'.
                               '{percent-diff} '.esc_html__('inserts the percent reduction (rounded).', 'lasa'). '</br>'.
                               '{symbol} '.esc_html__('inserts the Default currency symbol.', 'lasa'),
                'required'  => array('sale_tags','=', 'custom'),
                'default'   => '-{percent-diff}%'
            ),
            array(
                'id' => 'enable_label_featured',
                'type' => 'switch',
                'title' => esc_html__('Enable "Featured" Label', 'lasa'),
                'default' => true
            ),
            array(
                'id'        => 'custom_label_featured',
                'type'      => 'text',
                'title'     => esc_html__('"Featured Label" Custom Text', 'lasa'),
                'required'  => array('enable_label_featured','=', true),
                'default'   => esc_html__('Featured', 'lasa')
            ),
            array(
                'id' => 'enable_brand',
                'type' => 'switch',
                'title' => esc_html__('Enable Brand Name', 'lasa'),
                'subtitle' => esc_html__('Enable/Disable YITH brand name on HomePage and Shop Page', 'lasa'),
                'default' => false
            ),
            array(
                'id' => 'enable_hide_sub_title_product',
                'type' => 'switch',
                'title' => esc_html__('Hide sub title product', 'lasa'),
                'default' => false
            ),

            array(
                'id' => 'enable_text_time_coutdown',
                'type' => 'switch',
                'title' => esc_html__('Enable the text of Time Countdown', 'lasa'),
                'default' => true
            ),
            
            array(
                'id'   => 'opt-divide',
                'class' => 'big-divide',
                'type' => 'divide'
            ),
            array(
                'id' => 'product_display_image_mode',
                'type' => 'image_select',
                'title' => esc_html__('Product Image Display Mode', 'lasa'),
                'options' => array(
                    'one' => array(
                        'title' => esc_html__('Single Image', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/image_mode/single-image.png'
                    ),
                    'two' => array(
                        'title' => esc_html__('Double Images (Hover)', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/image_mode/display-hover.gif'
                    ),
                                                                        
                ),
                'default' => 'two'
            ),
            array(
                'id' => 'enable_quickview',
                'type' => 'switch',
                'title' => esc_html__('Enable Quick View', 'lasa'),
                'default' => 1
            ),
            array(
                'id' => 'enable_woocommerce_catalog_mode',
                'type' => 'switch',
                'title' => esc_html__('Show WooCommerce Catalog Mode', 'lasa'),
                'default' => false
            ),
            array(
                'id' => 'enable_woocommerce_quantity_mode',
                'type' => 'switch',
                'title' => esc_html__('Enable WooCommerce Quantity Mode', 'lasa'),
                'subtitle' => esc_html__('Enable/Disable show quantity on Home Page and Shop Page', 'lasa'),
                'default' => false
            ),
            array(
                'id' => 'enable_variation_swatch',
                'type' => 'switch',
                'title' => esc_html__('Enable Product Variation Swatch', 'lasa'),
                'subtitle' => esc_html__('Enable/Disable Product Variation Swatch on HomePage and Shop page', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'variation_swatch',
                'type' => 'select',
                'title' => esc_html__('Product Attribute', 'lasa'),
                'required' => array('enable_variation_swatch','=',1),
                'options' => lasa_tbay_get_variation_swatchs(),
                'default' => 'pa_size'
            ),
        )
	)
);

// woocommerce Search settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Search Products', 'lasa'),
        'fields' => array(
            array(
                'id' => 'search_query_in',
                'type' => 'button_set',
                'title' => esc_html__('Search Query', 'lasa'),
                'options' => array(
                    'title' => esc_html__('Only Title', 'lasa'), 
                    'all' => esc_html__('All (Title, Content, Sku)', 'lasa'), 
                ),
                'default' => 'title'
            ),
            array(
                'id' => 'search_sku_ajax',
                'type' => 'switch',
                'title' => esc_html__('Show SKU on AJAX results', 'lasa'),
                'required' => array('search_query_in','=', 'all'),
                'default' => true
            ),
        )
	)
);

// woocommerce Cart settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Cart', 'lasa'),
        'fields' => array(
            array(
				'id'       => 'section-mini-cart',
				'type'     => 'section',
				'title'    => esc_html__( 'Section Mini-Cart', 'lasa' ),
				'indent'   => true,
			),
            array(
                'id' => 'show_cart_free_shipping',
                'type' => 'switch',
                'title' => esc_html__('Enable Free Shipping on Cart and Mini-Cart', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'show_mini_cart_qty',
                'type' => 'switch',
                'title' => esc_html__('Enable Quantity on Mini-Cart', 'lasa'),
                'default' => true
            ), 
             array(
                'id' => 'woo_mini_cart_position',
                'type' => 'select',
                'title' => esc_html__('Mini-Cart Position', 'lasa'),
                'options' => array(
                    'left'       => esc_html__('Left', 'lasa'),
                    'right'      => esc_html__('Right', 'lasa'),
                    'popup'      => esc_html__('Popup', 'lasa'),
                    'no-popup'   => esc_html__('None Popup', 'lasa')
                ),
                'default' => 'popup'
            ),
            array(
				'id'     => 'section-mini-cart-end',
				'type'   => 'section',
				'indent' => false,
			),
            array(
				'id'       => 'section-page-cart',
				'type'     => 'section',
				'title'    => esc_html__( 'Section Page Cart', 'lasa' ),
				'indent'   => true,
			),
            array(
                'id' => 'ajax_update_quantity',
                'type' => 'switch',
                'title' => esc_html__('Quantity Ajax Auto-update', 'lasa'),
                'subtitle' => esc_html__('Enable/Disable quantity ajax auto-update on page Cart', 'lasa'),
                'default' => true
            ),
            array(
				'id'     => 'section-page-cart-end',
				'type'   => 'section',
				'indent' => false,
			),
        )
	)
);

// woocommerce Breadcrumb settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Breadcrumb Shop', 'lasa'),
        'fields' => array(
            array(
                'id' => 'show_product_breadcrumb',
                'type' => 'switch',
                'title' => esc_html__('Enable Breadcrumb', 'lasa'),
                'default' => true
            ),
            array(
				'id'       => 'product_breadcrumb_text_alignment',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Text Alignment', 'lasa' ),
				'options'  => array(
					'left' => esc_html__('Text Left', 'lasa'),
					'center' => esc_html__('Text Center', 'lasa'),
					'right' => esc_html__('Text Right', 'lasa'),
				),
				'default'  => 'center',
			),
            array(
                'id' => 'product_breadcrumb_layout',
                'type' => 'image_select',
                'class'     => 'image-two',
                'compiler' => true,
                'title' => esc_html__('Breadcrumb Layout', 'lasa'),
                'required' => array('show_product_breadcrumb','=',1),
                'options' => array(
                    'image' => array(
                        'title' => esc_html__('Background Image', 'lasa'),
                        'img'   => LASA_ASSETS_IMAGES . '/breadcrumbs/image.jpg'
                    ),
                    'color' => array(
                        'title' => esc_html__('Background color', 'lasa'),
                        'img'   => LASA_ASSETS_IMAGES . '/breadcrumbs/color.jpg'
                    ),
                    'text'=> array(
                        'title' => esc_html__('Text Only', 'lasa'),
                        'img'   => LASA_ASSETS_IMAGES . '/breadcrumbs/text_only.jpg'
                    ),
                ),
                'default' => 'color'
            ),
            array(
                'title' => esc_html__('Breadcrumb Background Color', 'lasa'),
                'subtitle' => '<em>'.esc_html__('The Breadcrumb background color of the site.', 'lasa').'</em>',
                'id' => 'woo_breadcrumb_color',
                'required' => array('product_breadcrumb_layout','=',array('default','color')),
                'type' => 'color',
                'default' => '#f7f7f7',
                'transparent' => false,
            ),
            array(
                'id' => 'woo_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumb Background', 'lasa'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your Breadcrumb.', 'lasa'),
                'required' => array('product_breadcrumb_layout','=','image'),
                'default'  => array(
                    'url'=> LASA_IMAGES .'/breadcrumbs-woo.jpg'
                ),
            ),
        )
	)
);


// woocommerce Breadcrumb settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Breadcrumb Single Product', 'lasa'),
        'fields' => array(
            array(
                'id' => 'show_single_product_breadcrumb',
                'type' => 'switch',
                'title' => esc_html__('Enable Breadcrumb', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'show_product_nav',
                'type' => 'switch', 
                'title' => esc_html__('Enable Product Navigator', 'lasa'),
                'required' => array('show_single_product_breadcrumb','=',1),
                'default' => true
            ),    
            array(
				'id'       => 'single_product_breadcrumb_text_alignment',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Text Alignment', 'lasa' ),
				'options'  => array(
					'left' => esc_html__('Text Left', 'lasa'),
					'center' => esc_html__('Text Center', 'lasa'),
					'right' => esc_html__('Text Right', 'lasa'),
				),
				'default'  => 'center',
			),
            array(
                'id' => 'single_product_breadcrumb_layout',
                'type' => 'image_select',
                'class'     => 'image-two',
                'compiler' => true,
                'title' => esc_html__('Breadcrumb Layout', 'lasa'),
                'required' => array('show_single_product_breadcrumb','=',1),
                'options' => array(
                    'image' => array(
                        'title' => esc_html__('Background Image', 'lasa'),
                        'img'   => LASA_ASSETS_IMAGES . '/breadcrumbs/image.jpg'
                    ),
                    'color' => array(
                        'title' => esc_html__('Background color', 'lasa'),
                        'img'   => LASA_ASSETS_IMAGES . '/breadcrumbs/color.jpg'
                    ),
                    'text'=> array(
                        'title' => esc_html__('Text Only', 'lasa'),
                        'img'   => LASA_ASSETS_IMAGES . '/breadcrumbs/text_only.jpg'
                    ),
                ),
                'default' => 'color'
            ),
            array(
                'title' => esc_html__('Breadcrumb Background Color', 'lasa'),
                'subtitle' => '<em>'.esc_html__('The Breadcrumb background color of the site.', 'lasa').'</em>',
                'id' => 'woo_single_breadcrumb_color',
                'required' => array('single_product_breadcrumb_layout','=',array('default','color')),
                'type' => 'color',
                'default' => '#f7f7f7',
                'transparent' => false,
            ),
            array(
                'id' => 'woo_single_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumb Background', 'lasa'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your Breadcrumb.', 'lasa'),
                'required' => array('single_product_breadcrumb_layout','=','image'),
                'default'  => array(
                    'url'=> LASA_IMAGES .'/breadcrumbs-woo.jpg'
                ),
            ),
        )
	)
);


// WooCommerce Archive settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Shop', 'lasa'),
        'fields' => array(
            array(
                'id' => 'product_archive_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Shop Layout', 'lasa'),
                'options' => array(
                    'shop-left' => array(
                        'title' => esc_html__('Left Sidebar', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/product_archives/shop_left_sidebar.jpg'
                    ),
                    'shop-right' => array(
                        'title' => esc_html__('Right Sidebar', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/product_archives/shop_right_sidebar.jpg'
                    ),
                    'full-width' => array(
                        'title' => esc_html__('No Sidebar', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/product_archives/shop_no_sidebar.jpg'
                    ),
                ),
                'default' => 'shop-left'
            ),
            array(
                'id' => 'product_archive_sidebar',
                'type' => 'select',
                'title' => esc_html__('Archive Sidebar', 'lasa'),
                'data'      => 'sidebars',
                'default' => 'product-archive'
            ),
            array(
                'id' => 'enable_display_mode',
                'type' => 'switch',
                'title' => esc_html__('Enable Products Display Mode', 'lasa'),
                'subtitle' => esc_html__('Enable/Disable Display Mode', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'product_display_mode',
                'type' => 'button_set',
                'title' => esc_html__('Products Display Mode', 'lasa'),
                'required' => array('enable_display_mode','=',1),
                'options' => array(
                    'grid' => esc_html__('Grid', 'lasa'),
                    'list' => esc_html__('List', 'lasa')
                ),
                'default' => 'grid'
            ),
            array(
                'id' => 'title_product_archives',
                'type' => 'switch',
                'title' => esc_html__('Show Title of Categories', 'lasa'),
                'default' => false
            ),
            array(
                'id' => 'pro_des_image_product_archives',
                'type' => 'switch',
                'title' => esc_html__('Show Description, Image of Categories', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'number_products_per_page',
                'type' => 'slider',
                'title' => esc_html__('Number of Products Per Page', 'lasa'),
                'default' => 12,
                'min' => 1,
                'step' => 1,
                'max' => 100,
            ),
            array(
                'id' => 'product_columns',
                'type' => 'select',
                'title' => esc_html__('Product Columns', 'lasa'),
                'options' => $columns,
                'default' => 3
            ),
        )
	)
);


// WooCommerce Single Product settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Single Product', 'lasa'),
        'fields' => array(
            array(
                'id' => 'product_single_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Select Single Product Layout', 'lasa'),
                'options' => array(
                    'horizontal-bottom' => array(
                        'title' => esc_html__('Image Horizontal Bottom', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/product_single/product_horizontal_bottom.jpg'
                    ),
                    'horizontal-top' => array(
                        'title' => esc_html__('Image Horizontal Top', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/product_single/product_horizontal_top.jpg'
                    ),
                    'vertical-left' => array(
                        'title' => esc_html__('Image Vertical Left', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/product_single/product_vertical_left.jpg'
                    ),
                    'vertical-right' => array(
                        'title' => esc_html__('Image Vertical Right', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/product_single/product_vertical_right.jpg'
                    ),
                    'stick' => array(
                        'title' => esc_html__('Image Stick', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/product_single/image_sticky.jpg'
                    ),
                    'gallery' => array(
                        'title' => esc_html__('Image gallery', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/product_single/image_gallery.jpg'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left - Main Sidebar', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/product_single/left_main_sidebar.jpg'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main - Right Sidebar', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/product_single/main_right_sidebar.jpg'
                    ),
                ),
                'default' => 'horizontal-bottom'
            ),
            array(
                'id' => 'product_single_sidebar',
                'type' => 'select',
                'required' => array('product_single_layout','=',array('left-main','main-right')),
                'title' => esc_html__('Single Product Sidebar', 'lasa'),
                'data'      => 'sidebars',
                'default' => 'product-single'
            ),
        )
	)
);


// WooCommerce Single Product Advanced Options settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Single Product Advanced Options', 'lasa'),
        'fields' => array(
            array(
                'id' => 'enable_ajax_single_add_to_cart',
                'type' => 'switch',
                'title' => esc_html__('Enable/Disable Ajax add to cart', 'lasa'),
                'default' => false
            ),
            array(
                'id' => 'single_stock_style',
                'type' => 'button_set',
                'title' => esc_html__('Style Stock', 'lasa'),
                'options' => array(
                    'style1'          => esc_html__( 'Style 1', 'lasa' ),
                    'style2'          => esc_html__( 'Style 2', 'lasa' ),
                ),
                'default' => 'style1'
            ),
            array(
                'id' => 'enable_total_sales',
                'type' => 'switch',
                'title' => esc_html__('Enable Total Sales', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'enable_buy_now',
                'type' => 'switch',
                'title' => esc_html__('Enable Buy Now', 'lasa'),
                'default' => false
            ),
            array(
                'id' => 'redirect_buy_now',
                'required' => array('enable_buy_now','=',true),
                'type' => 'button_set',
                'title' => esc_html__('Redirect to page after Buy Now', 'lasa'),
                'options' => array(
                        'cart'          => 'Page Cart',
                        'checkout'      => 'Page CheckOut',
                ),
                'default' => 'cart'
            ),
            array(
                'id'   => 'opt-divide',
                'class' => 'big-divide',
                'type' => 'divide'
            ),
            array(
                'id' => 'style_single_tabs_style',
                'type' => 'button_set',
                'title' => esc_html__('Tab Mode', 'lasa'),
                'options' => array(
                        'fulltext'          => 'Full Text',
                        'tabs'          => 'Tabs',
                        'accordion'        => 'Accordion',
                ),
                'default' => 'fulltext'
            ),
            array(
                'id'   => 'opt-divide',
                'class' => 'big-divide',
                'type' => 'divide'
            ),
            array(
                'id'   => 'opt-divide',
                'class' => 'big-divide',
                'type' => 'divide'
            ),  
            array(
                'id'   => 'opt-divide',
                'class' => 'big-divide',
                'type' => 'divide'
            ),
            array(
                'id' => 'enable_sticky_menu_bar',
                'type' => 'switch',
                'title' => esc_html__('Sticky Menu Bar', 'lasa'),
                'subtitle' => esc_html__('Enable/disable Sticky Menu Bar', 'lasa'),
                'default' => false
            ),
            array(
                'id' => 'enable_zoom_image',
                'type' => 'switch',
                'title' => esc_html__('Zoom inner image', 'lasa'),
                'subtitle' => esc_html__('Enable/disable Zoom inner Image', 'lasa'),
                'default' => false
            ),
            array(
                'id'   => 'opt-divide',
                'class' => 'big-divide',
                'type' => 'divide'
            ),
            array(
                'id' => 'video_aspect_ratio',
                'type' => 'select',
                'title' => esc_html__('Featured Video Aspect Ratio', 'lasa'),
                'subtitle' => esc_html__('Choose the aspect ratio for your video', 'lasa'),
                'options' => $aspect_ratio,
                'default' => '16_9'
            ),
            array(
                'id'      => 'video_position',
                'title'    => esc_html__('Featured Video Position', 'lasa'),
                'type'    => 'select',
                'default' => 'last',
                'options' => array(
                    'last' => esc_html__('The last product gallery', 'lasa'),
                    'first' => esc_html__('The first product gallery', 'lasa'),
                ),
            ),
            array(
                'id'   => 'opt-divide',
                'class' => 'big-divide',
                'type' => 'divide'
            ),
            array(
                'id' => 'enable_collapse_product_details_tab',
                'type' => 'switch',
                'title' => esc_html__('Collapse Product Details Tab', 'lasa'),
                'subtitle' => esc_html__('Enable/disable Collapse Product Details Tab', 'lasa'),
                'default' => false
            ),
            array(
                'id'        => 'maximum_height_collapse',
                'type'      => 'slider',
                'title'     => esc_html__('Maximum Height Collapse', 'lasa'),
                'subtitle'  => esc_html__('Maximum Height Collapse Product Details Tab', 'lasa'),
                'required'  => array('enable_collapse_product_details_tab','=', true),
                'default'   => 300,
                'min'       => 50,
                'step'      => 10,
                'max'       => 1000,
            ),
            array(
                'id' => 'enable_product_social_share',
                'type' => 'switch',
                'title' => esc_html__('Social Share', 'lasa'),
                'subtitle' => esc_html__('Enable/disable Social Share', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'enable_product_review_tab',
                'type' => 'switch',
                'title' => esc_html__('Product Review Tab', 'lasa'),
                'subtitle' => esc_html__('Enable/disable Review Tab', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'enable_product_releated',
                'type' => 'switch',
                'title' => esc_html__('Products Releated', 'lasa'),
                'subtitle' => esc_html__('Enable/disable Products Releated', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'enable_product_upsells',
                'type' => 'switch',
                'title' => esc_html__('Products upsells', 'lasa'),
                'subtitle' => esc_html__('Enable/disable Products upsells', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'enable_product_countdown',
                'type' => 'switch',
                'title' => esc_html__('Display Countdown time ', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'number_product_thumbnail',
                'type'  => 'slider',
                'title' => esc_html__('Number Images Thumbnail to show', 'lasa'),
                'default' => 4,
                'min'   => 2,
                'step'  => 1,
                'max'   => 12,
            ),
            array(
                'id' => 'number_product_releated',
                'type' => 'slider',
                'title' => esc_html__('Number of related products to show', 'lasa'),
                'default' => 8,
                'min' => 1,
                'step' => 1,
                'max' => 20,
            ),
            array(
                'id' => 'releated_product_columns',
                'type' => 'select',
                'title' => esc_html__('Releated Products Columns', 'lasa'),
                'options' => $columns,
                'default' => 4
            ),
            array(
                'id'       => 'html_before_add_to_cart_btn',
                'type'     => 'textarea',
                'title'    => esc_html__( 'HTML Before Add To Cart button (Global)', 'lasa' ),
                'desc' =>   sprintf( wp_kses( __('Enter HTML and shortcodes that will show before Add To Cart button.  You can see more HTML display position on the image <a target="_blank" href="%1$s">here</a>.', 'lasa' ),  array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '//docs.thembay.com/puca/src/img/hook-single-product.jpg' ), 
            ),
            array(
                'id'       => 'html_after_add_to_cart_btn',
                'type'     => 'textarea',
                'title'    => esc_html__( 'HTML After Add To Cart button (Global)', 'lasa' ),
                'desc' =>   sprintf( wp_kses( __('Enter HTML and shortcodes that will show after Add To Cart button.  You can see more HTML display position on the image <a target="_blank" href="%1$s">here</a>.', 'lasa' ),  array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '//docs.thembay.com/puca/src/img/hook-single-product.jpg' ), 
            ),
            array(
                'id'       => 'html_before_inner_product_summary',
                'type'     => 'textarea',
                'title'    => esc_html__('HTML Before Inner Product Summary (Global)', 'lasa'),
                'desc' =>   sprintf( wp_kses( __('Enter HTML and shortcodes that will show before title product.  You can see more HTML display position on the image <a target="_blank" href="%1$s">here</a>.', 'lasa' ),  array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '//docs.thembay.com/puca/src/img/hook-single-product.jpg' ), 

            ),
            array(
                'id'       => 'html_after_inner_product_summary',
                'type'     => 'textarea',
                'title'    => esc_html__('HTML After Inner Product Summary (Global)', 'lasa'),
                'desc' =>   sprintf( wp_kses( __('Enter HTML and shortcodes that will show after social product.  You can see more HTML display position on the image <a target="_blank" href="%1$s">here</a>.', 'lasa' ),  array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '//docs.thembay.com/puca/src/img/hook-single-product.jpg' ), 
            ),
            array(
                'id'       => 'html_before_product_summary',
                'type'     => 'textarea',
                'title'    => esc_html__('HTML Before Product Summary (Global)', 'lasa'),
                'desc' =>   sprintf( wp_kses( __('Enter HTML and shortcodes that will show before content product.  You can see more HTML display position on the image <a target="_blank" href="%1$s">here</a>.', 'lasa' ),  array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '//docs.thembay.com/puca/src/img/hook-single-product.jpg' ), 
            ),
            array(
                'id'       => 'html_after_product_summary',
                'type'     => 'textarea',
                'title'    => esc_html__('HTML After Product Summary (Global)', 'lasa'),
                'desc' =>   sprintf( wp_kses( __('Enter HTML and shortcodes that will show after related products.  You can see more HTML display position on the image <a target="_blank" href="%1$s">here</a>.', 'lasa' ),  array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '//docs.thembay.com/puca/src/img/hook-single-product.jpg' ), 
            ),
        )
	)
);

// WooCommerce Single Product Advanced Options settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('WooCommerce Open', 'lasa'),
        'fields' => array(
            array(
				'id'       => 'section_size_guide_start',
				'type'     => 'section',
				'title'    => esc_html__( 'Section Size Guide - Single Product Page (Global)', 'lasa' ),
				'indent'   => true,
			),
            array(
                'id'        => 'single_size_guide_title',
                'type'      => 'text',
                'title'     => esc_html__('Title', 'lasa'),
                'default'   => esc_html__('Size Guide', 'lasa')
            ),
            array(
                'id'        => 'single_size_guide_icon',
                'type'      => 'text',
                'title'     => esc_html__('Icon', 'lasa'),
                'subtitle'  => sprintf(__('Get class name icon name of <a href="%s" target="_blank">Tbay Icon</a>', 'lasa'), home_url( '/tbay-list-icons')),
                'default'   => 'tb-icon tb-icon-size-guide'
            ),
            array(
                'id'       => 'single_size_guide',
                'type'     => 'textarea',
                'title'    => esc_html__('ShortCode', 'lasa'),
            ),
			array(
				'id'     => 'section_size_guide_end',
				'type'   => 'section',
				'indent' => false,
			),

            array(
				'id'       => 'section_delivery_return_start',
				'type'     => 'section',
				'title'    => esc_html__( 'Section Delivery & Return - Single Product Page (Global)', 'lasa' ),
				'indent'   => true,
			),
            array(
                'id'        => 'single_delivery_return_title',
                'type'      => 'text',
                'title'     => esc_html__('Title', 'lasa'),
                'default'   => esc_html__('Delivery Return', 'lasa')
            ),
            array(
                'id'        => 'single_delivery_return_icon',
                'type'      => 'text',
                'title'     => esc_html__('Icon', 'lasa'),
                'subtitle'  => sprintf(__('Get class name icon name of <a href="%s" target="_blank">Tbay Icon</a>', 'lasa'), home_url( '/tbay-list-icons')),
                'default'   => 'tb-icon tb-icon-return-box'
            ),
            array(
                'id'       => 'single_delivery_return',
                'type'     => 'textarea',
                'title'    => esc_html__('ShortCode', 'lasa'),
            ),
			array(
				'id'     => 'section_delivery_return_end',
				'type'   => 'section',
				'indent' => false,
			),
            array(
				'id'       => 'section_aska_question_start',
				'type'     => 'section',
				'title'    => esc_html__( 'Section Ask a Question - Single Product Page (Global)', 'lasa' ),
				'indent'   => true,
			),
            array(
                'id'        => 'single_aska_question_title',
                'type'      => 'text',
                'title'     => esc_html__('Title', 'lasa'),
                'default'   => esc_html__('Ask a Question', 'lasa')
            ),
            array(
                'id'        => 'single_aska_question_icon',
                'type'      => 'text',
                'title'     => esc_html__('Icon', 'lasa'),
                'subtitle'  => sprintf(__('Get class name icon name of <a href="%s" target="_blank">Tbay Icon</a>', 'lasa'), home_url( '/tbay-list-icons')),
                'default'   => 'tb-icon tb-icon-help'
            ),
            array(
                'id'       => 'single_aska_question',
                'type'     => 'textarea',
                'title'    => esc_html__('ShortCode', 'lasa'),
            ),
			array(
				'id'     => 'section_aska_question_end',
				'type'   => 'section',
				'indent' => false,
			),
        )
    )
);


// woocommerce Other Page settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Other page', 'lasa'),
        'fields' => array(
            array(
                'id' => 'show_woocommerce_password_strength',
                'type' => 'switch',
                'title' => esc_html__('Show Password Strength Meter', 'lasa'),
                'subtitle' => esc_html__('Enable or disable in page My Account', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'show_checkout_image',
                'type' => 'switch',
                'title' => esc_html__('Show Image Product', 'lasa'),
                'subtitle'  => esc_html__('Enable or disable "Image Product" in page Checkout', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'show_checkout_quantity',
                'type' => 'switch',
                'title' => esc_html__('Show Quantity Product', 'lasa'),
                'subtitle'  => esc_html__('Enable or disable "Quantity Product" on Review Order on page Checkout', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'show_checkout_optimized',
                'type' => 'switch',
                'title' => esc_html__('Checkout Optimized', 'lasa'),
                'subtitle'  => esc_html__('Remove "Header" and "Footer" in page Checkout', 'lasa'),
                'default' => false
            ),
            array(
                'id' => 'checkout_logo',
                'type' => 'media',
                'required' => array('show_checkout_optimized','=', true),
                'title' => esc_html__('Upload Logo in page Checkout', 'lasa'),
                'subtitle' => esc_html__('Image File (.png or .gif)', 'lasa'),
            ),
            array(
                'id'        => 'checkout_img_width',
                'type'      => 'slider',
                'required' => array('show_checkout_optimized','=', true),
                'title'     => esc_html__('Logo maximum width (px)', 'lasa'),
                "default"   => 120,
                "min"       => 50,
                "step"      => 1,
                "max"       => 600,
            ),
        )
	)
);

if (!function_exists('lasa_settings_multi_vendor_fields')) {
    function lasa_settings_multi_vendor_fields( $columns )
    {
        $mvx_array = $fields_dokan = array();

        if (class_exists('MVX')) {
            $mvx_array = array(
                'id'        => 'show_vendor_name_mvx',
                'type'      => 'info',
                'title'     => esc_html__('Enable Vendor Name Only WCMP Vendor', 'lasa'),
                'subtitle'  => sprintf(__('Go to the <a href="%s" target="_blank">Setting</a> Enable "Sold by" for WCMP Vendor', 'lasa'), admin_url('admin.php?page=mvx-setting-admin')),
            );
        }

        $fields = array(
            array(
                'id' => 'show_vendor_name',
                'type' => 'switch',
                'title' => esc_html__('Enable Vendor Name', 'lasa'),
                'subtitle' => esc_html__('Enable/Disable Vendor Name on HomePage and Shop page only works for Dokan, WCMP Vendor', 'lasa'),
                'default' => true
            ),
            $mvx_array
        );


        if (class_exists('WeDevs_Dokan')) {
            $fields_dokan = array(
                array(
                    'id'   => 'divide_vendor_1',
                    'class' => 'big-divide',
                    'type' => 'divide'
                ),
                array(
                    'id' => 'show_info_vendor_tab',
                    'type' => 'switch',
                    'title' => esc_html__('Enable Tab Info Vendor Dokan', 'lasa'),
                    'subtitle' => esc_html__('Enable/Disable tab Info Vendor on Product Detail Dokan', 'lasa'),
                    'default' => true
                ),
                array(
                    'id'        => 'show_seller_tab',
                    'type'      => 'info',
                    'title'     => esc_html__('Enable/Disable Tab Products Seller', 'lasa'),
                    'subtitle'  => sprintf(__('Go to the <a href="%s" target="_blank">Setting</a> of each Seller to Enable/Disable this tab of Dokan Vendor.', 'lasa'), home_url('dashboard/settings/store/')),
                ),
                array(
                    'id' => 'seller_tab_per_page',
                    'type' => 'slider',
                    'title' => esc_html__('Dokan Number of Products Seller Tab', 'lasa'),
                    'default' => 4,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                ),
                array(
                    'id' => 'seller_tab_columns',
                    'type' => 'select',
                    'title' => esc_html__('Dokan Product Columns Seller Tab', 'lasa'),
                    'options' => $columns,
                    'default' => 4
                ),
            );
        }
        

        $fields = array_merge($fields, $fields_dokan);

        return $fields;
    }
}

if( lasa_woo_is_active_vendor() ) {
    Redux::set_section(
        $opt_name,
        array(
            'subsection' => true,
            'title' => esc_html__('Multi-vendor', 'lasa'),
            'fields' => lasa_settings_multi_vendor_fields($columns)
        )
    );
}