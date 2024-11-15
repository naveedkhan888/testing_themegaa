<?php

require_once(get_parent_theme_file_path(THEMENAME_INC . '/merlin-data/elementor.php'));

class Themename_Merlin_Config
{

    public function __construct()
    {
        $this->init();
        add_action('merlin_import_files', [ $this, 'import_files' ]);
        add_action('merlin_after_all_import', [ $this, 'after_import_setup' ], 10, 1);
        add_filter('merlin_generate_child_functions_php', [ $this, 'render_child_functions_php' ], 10, 2);
        add_filter('merlin_generate_child_style_css', [ $this, 'render_child_style_css' ], 10, 5);

        remove_action('init', 'xptheme_import_init', 50);
    }

    private function init()
    {
        $wizard = new Merlin(
            $config = array(
                'directory'          => 'inc/merlin',
                // Location / directory where Merlin WP is placed in your theme.
                'merlin_url'         => 'xptheme_import',
                // The wp-admin page slug where Merlin WP loads.
                'parent_slug'        => 'themes.php',
                // The wp-admin parent page slug for the admin menu item.
                'capability'         => 'manage_options',
                // The capability required for this menu to be displayed to the user.
                'dev_mode'           => true,
                // Enable development mode for testing.
                'plugins_step'       => false,
                'license_step'       => false,
                // EDD license activation step.
                'license_required'   => false,
                // Require the license activation step.
                'license_help_url'   => '',
                // URL for the 'license-tooltip'.
                'edd_remote_api_url' => '',
                // EDD_Theme_Updater_Admin remote_api_url.
                'edd_item_name'      => '',
                // EDD_Theme_Updater_Admin item_name.
                'edd_theme_slug'     => '',
                // EDD_Theme_Updater_Admin item_slug.
            ),
            $strings = array(
                'admin-menu'          => esc_html__('Theme Setup', 'themename'),

                /* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
                'title%s%s%s%s'       => esc_html__('%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'themename'),
                'return-to-dashboard' => esc_html__('Return to the dashboard', 'themename'),
                'ignore'              => esc_html__('Disable this wizard', 'themename'),

                'btn-skip'                 => esc_html__('Skip', 'themename'),
                'btn-next'                 => esc_html__('Next', 'themename'),
                'btn-start'                => esc_html__('Start', 'themename'),
                'btn-no'                   => esc_html__('Cancel', 'themename'),
                'btn-plugins-install'      => esc_html__('Install', 'themename'),
                'btn-child-install'        => esc_html__('Install', 'themename'),
                'btn-content-install'      => esc_html__('Install', 'themename'),
                'btn-import'               => esc_html__('Import', 'themename'),
                'btn-license-activate'     => esc_html__('Activate', 'themename'),
                'btn-license-skip'         => esc_html__('Later', 'themename'),

                /* translators: Theme Name */
                'license-header%s'         => esc_html__('Activate %s', 'themename'),
                /* translators: Theme Name */
                'license-header-success%s' => esc_html__('%s is Activated', 'themename'),
                /* translators: Theme Name */
                'license%s'                => esc_html__('Enter your license key to enable remote updates and theme support.', 'themename'),
                'license-label'            => esc_html__('License key', 'themename'),
                'license-success%s'        => esc_html__('The theme is already registered, so you can go to the next step!', 'themename'),
                'license-json-success%s'   => esc_html__('Your theme is activated! Remote updates and theme support are enabled.', 'themename'),
                'license-tooltip'          => esc_html__('Need help?', 'themename'),

                /* translators: Theme Name */
                'welcome-header%s'         => esc_html__('Welcome to %s', 'themename'),
                'welcome-header-success%s' => esc_html__('Hi. Welcome back', 'themename'),
                'welcome%s'                => esc_html__('This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'themename'),
                'welcome-success%s'        => esc_html__('You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'themename'),

                'child-header'         => esc_html__('Install Child Theme', 'themename'),
                'child-header-success' => esc_html__('You\'re good to go!', 'themename'),
                'child'                => esc_html__('Let\'s build & activate a child theme so you may easily make theme changes.', 'themename'),
                'child-success%s'      => esc_html__('Your child theme has already been installed and is now activated, if it wasn\'t already.', 'themename'),
                'child-action-link'    => esc_html__('Learn about child themes', 'themename'),
                'child-json-success%s' => esc_html__('Awesome. Your child theme has already been installed and is now activated.', 'themename'),
                'child-json-already%s' => esc_html__('Awesome. Your child theme has been created and is now activated.', 'themename'),

                'plugins-header'         => esc_html__('Install Plugins', 'themename'),
                'plugins-header-success' => esc_html__('You\'re up to speed!', 'themename'),
                'plugins'                => esc_html__('Let\'s install some essential WordPress plugins to get your site up to speed.', 'themename'),
                'plugins-success%s'      => esc_html__('The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'themename'),
                'plugins-action-link'    => esc_html__('Advanced', 'themename'),

                'import-header'      => esc_html__('Import Content', 'themename'),
                'import'             => esc_html__('Let\'s import content to your website, to help you get familiar with the theme.', 'themename'),
                'import-action-link' => esc_html__('Advanced', 'themename'),

                'ready-header'      => esc_html__('All done. Have fun!', 'themename'),

                /* translators: Theme Author */
                'ready%s'           => esc_html__('Your theme has been all set up. Enjoy your new theme by %s.', 'themename'),
                'ready-action-link' => esc_html__('Extras', 'themename'),
                'ready-big-button'  => esc_html__('View your website', 'themename'),
                'ready-link-1'      => sprintf('<a href="%1$s" target="_blank">%2$s</a>', 'https://tickets.xperttheme.com/', esc_html__('Ticket System', 'themename')),
                'ready-link-2'      => sprintf('<a href="%1$s">%2$s</a>', 'https://xperttheme-docs.gitbook.io/themename/', esc_html__('Documentation', 'themename')),
                'ready-link-3'      => sprintf('<a href="%1$s">%2$s</a>', 'https://www.youtube.com/c/xperttheme/', esc_html__('Video Tutorials', 'themename')),
                'ready-link-4'      => sprintf('<a href="%1$s">%2$s</a>', 'https://forums.xperttheme.com/', esc_html__('Forums', 'themename')),
            )
        );
    }

    public function render_child_functions_php($output, $slug)
    {
        $slug_no_hyphens = strtolower(preg_replace('#[^a-zA-Z]#', '', $slug));
        $output = "<?php
	/**
	 * @version    1.0
	 * @package    {$slug_no_hyphens}
	 * @author     Xperttheme Team <support@xperttheme.com>
	 * @copyright  Copyright (C) 2024 Xperttheme.com. All Rights Reserved.
	 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
	 *
	 * Websites: https://xperttheme.com
	 */
  function {$slug_no_hyphens}_child_enqueue_styles() {
    wp_enqueue_style( '{$slug}-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( '{$slug}-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( '{$slug}-style' ),
        wp_get_theme()->get('Version')
    );
  }

  	add_action(  'wp_enqueue_scripts', '{$slug_no_hyphens}_child_enqueue_styles', 10000 );\n
	";
  
        // Let's remove the tabs so that it displays nicely.
        $output = trim(preg_replace('/\t+/', '', $output));
  
        // Filterable return.
        return $output;
    }
  
    public function render_child_style_css($output, $slug, $parent, $author, $version)
    {
        $render_output = "/**
* Theme Name: {$parent} Child
* Description: This is a child theme for {$parent}
* Author: Xperttheme
* Author URI: https://xperttheme.com/
* Version: {$version}
* Template: {$slug}
*/\n

/*  [ Add your custom css below ]
- - - - - - - - - - - - - - - - - - - - */";

        return $render_output;
    }

    public function after_import_setup($selected_import)
    {
        $_imports = $this->import_files();
        $selected_import = $_imports[ $selected_import ];
        $check_oneclick  = get_option('themename_check_oneclick', []);

        // setup Home page
        $home = get_page_by_path($selected_import['home']);
        if ($home) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $home->ID);
        }

        if (count($check_oneclick) <= 0) {
            $this->setup_mailchimp();
        }
        
        if (! isset($check_oneclick[ $selected_import['home'] ]) || apply_filters('themename_reset_import_rev_sliders', false)) {
            $check_oneclick[ $selected_import['home'] ] = true;
            $this->import_revslider($selected_import['rev_sliders']);
            update_option('themename_check_oneclick', $check_oneclick);
        }

        $this->setup_options_after_import();
        $this->set_demo_menus();
    }

    private function import_revslider($revsliders)
    {
        if (class_exists('RevSliderAdmin')) {
            require_once ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php';
            require_once ABSPATH . '/wp-admin/includes/class-wp-filesystem-direct.php';
            $my_filesystem = new WP_Filesystem_Direct(array());

            $revslider = new RevSlider();
            foreach ($revsliders as $slider) {
                $pathSlider = trailingslashit((wp_upload_dir())['path']) . basename($slider);
                if ($this->download_revslider($my_filesystem, $slider, $pathSlider)) {
                    $_FILES['import_file']['error']    = UPLOAD_ERR_OK;
                    $_FILES['import_file']['tmp_name'] = $pathSlider;
                    $revslider->importSliderFromPost(true, 'none');
                }
            }
        }
    }

    /**
     * @param $filesystem WP_Filesystem_Direct
     *
     * @return bool
     */
    private function download_revslider($filesystem, $slider, $pathSlider)
    {
        return $filesystem->copy($slider, $pathSlider, true);
    }

    private function setup_mailchimp()
    {
        $mailchimp = get_posts(
            array(
                'post_type'   => 'mc4wp-form',
                'post_status' => 'publish',
                'numberposts' => 1,
            )
        );

        if ( $mailchimp ) {
            update_option('mc4wp_default_form_id', $mailchimp[0]->ID);
        }
    }
  
    public function setup_options_after_import()
    {

        add_action( 'init', function () {
            $query_posts = new WP_Query( array(
                'post_type' => 'product',
            ));
            
            while ( $query_posts->have_posts() ) {
                $query_posts->the_post();
                wp_update_post( $post );
            }
            wp_reset_postdata();
        });

        if ( did_action( 'elementor/loaded' ) ) {
            $cpt_support = ['xptheme_custom_post', 'post', 'page', 'product'];
            update_option('elementor_cpt_support', $cpt_support);

            update_option('elementor_disable_color_schemes', 'yes');
            update_option('elementor_disable_typography_schemes', 'yes');
            update_option('elementor_container_width', '1440');
            update_option('elementor_viewport_lg', '1356');
            update_option('elementor_space_between_widgets', '0');
            update_option('elementor_load_fa4_shim', 'yes');
            update_option( 'elementor_global_image_lightbox', '0' );
            update_option('elementor_css_print_method', 'external');
        }
        
        $this->update_option_woocommerce();
        
        $this->update_option_yith_wcwl();
        $this->update_option_yith_compare();
        $this->update_option_yith_brands();
        $this->update_option_woof();

        /**Vendor**/
        $this->update_option_dokan();
        $this->update_option_mvx();
        $this->update_option_wcfm();
        $this->update_option_wcvendors();

        // Update terms count nav menu.
		$this->update_terms_nav_menu();
    }

    private function update_option_woocommerce()
    {
        if (!class_exists('WooCommerce')) {
            return;
        }

        $shop 		= get_page_by_path('shop');
        $cart 		= get_page_by_path('cart');
        $checkout 	= get_page_by_path('checkout');
        $myaccount 	= get_page_by_path('my-account');
        $terms 		= get_page_by_path('terms-of-use');
        if ($shop) {
            update_option('woocommerce_shop_page_id', $shop->ID);
        }
        
        if ($cart) {
            update_option('woocommerce_cart_page_id', $cart->ID);
        }
        
        if ($checkout) {
            update_option('woocommerce_checkout_page_id', $checkout->ID);
        }
        
        if ($myaccount) {
            update_option('woocommerce_myaccount_page_id', $myaccount->ID);
        }
        
        if ($terms) {
            update_option('woocommerce_terms_page_id', $terms->ID);
        }

        update_option( 'woocommerce_enable_signup_and_login_from_checkout', 'yes'  );
		update_option( 'woocommerce_enable_myaccount_registration', 'yes'  );
		update_option( 'woocommerce_registration_generate_username', 'no'  );
		update_option( 'woocommerce_registration_generate_password', 'no'  );
    }

    private function update_option_yith_wcwl()
    {
        if (!class_exists('YITH_WCWL')) {
            return;
        }

        /**YITH Wishlist**/
        update_option('yith_wcwl_button_position', 'shortcode');
        update_option('yith_wcwl_price_show', 'yes');
        update_option('yith_wcwl_stock_show', 'yes');
        update_option('yith_wcwl_add_to_cart_show', 'yes');
        update_option('yith_wcwl_show_remove', 'no');
        update_option('yith_wcwl_repeat_remove_button', 'yes');
        update_option('yith_wcwl_enable_share', 'no');
        update_option('yith_wcwl_wishlist_title', '');

        update_option( 'yith_wcwl_add_to_wishlist_text', 'Add to wishlist' ); 
        update_option( 'yith_wcwl_browse_wishlist_text', 'View Wishlist' ); 

        /**Fix wishlist 3.0**/ 
		update_option('yith_wcwl_add_to_wishlist_icon', 'custom');
		update_option('yith_wcwl_added_to_wishlist_icon', 'custom');
        update_option( 'yith_wcwl_show_on_loop', 'no'  );
    }

    private function update_option_yith_compare()
    {
        if (!class_exists('YITH_Woocompare')) {
            return;
        }

        /**YITH Compare**/
        update_option('yith_woocompare_compare_button_in_products_list', 'no');
        update_option('yith_woocompare_compare_button_in_product_page', 'no');
    }

    private function update_option_yith_brands()
    {
        if (!class_exists('YITH_WCBR')) {
            return;
        }

        /**YITH Brands**/
        update_option('yith_wcbr_single_product_brands_content', 'name');
    }

    private function update_option_woof() {
        if (!class_exists('WOOF')) {
            return;
        }

        /**WOOF**/
        $settings = get_option('woof_settings');

        /**Price**/
        $settings['by_price']['show'] = '3';
        $settings['by_price']['title_text'] = esc_html__('Price', 'themename');

        /**Categories**/
        $settings['tax']['product_cat'] = '1';
        $settings['tax_type']['product_cat'] = 'radio';
        $settings['show_title_label']['product_cat'] = '1';
        $settings['custom_tax_label']['product_cat'] = esc_html__('Categories', 'themename');

        /**Size**/
        $settings['tax']['pa_size'] = '0';
        $settings['tax_type']['pa_size'] = 'label';
        $settings['show_title_label']['pa_size'] = '1';
        $settings['custom_tax_label']['pa_size'] = esc_html__('Product Size', 'themename');

        /**Color**/
        $settings['tax']['pa_color'] = '1';
        $settings['show_title_label']['pa_color'] = '1';
        $settings['custom_tax_label']['pa_color'] = esc_html__('Product Color', 'themename');

        /**Tag**/
        $settings['tax']['product_tag'] = '1';
        $settings['tax_type']['product_tag'] = 'label';
        $settings['show_title_label']['product_tag'] = '1';
        $settings['custom_tax_label']['product_tag'] = esc_html__('Product Tags', 'themename');

        
        $settings['by_onsales']['show'] = '0';
        $settings['color']['show'] = '1';

        $settings['icheck_skin'] = 'none';

        /*Fix page search when product_cat emty*/
        $settings['by_text']['show'] = '0';
        unset($settings['activated_extensions']['3']);
        unset($settings['activated_extensions']['4']);

        /**Brand**/
        if (class_exists('YITH_WCBR')) {
            $settings['tax']['yith_product_brand'] = '1';
            $settings['tax_type']['yith_product_brand'] = 'label';
            $settings['show_title_label']['yith_product_brand'] = '1';
            $settings['custom_tax_label']['yith_product_brand'] = esc_html__('Brands', 'themename');
        }

        update_option('woof_settings', $settings);


        update_option('woof_set_automatically', '0');
        update_option('woof_show_count', '1');
        update_option('woof_sort_terms_checked', '0');
    }

    private function update_option_dokan()
    {
        if (!class_exists('WeDevs_Dokan')) {
            return;
        }

        $dashboard = get_page_by_path('dashboard');
        $settings  = get_option('dokan_pages');
        if ($dashboard) {
            $settings['dashboard'] = $dashboard->ID;
            update_option('dokan_pages', $settings);
        }
    }

    private function update_option_mvx()
    {
        if (!class_exists('MVX')) {
            return;
        }

        $settings_name = get_option('mvx_general_settings_name', array());
        $settings_name['sold_by_catalog'] = 1;
        $settings_name['is_sellerreview'] = 1;
        $settings_name['is_singleproductmultiseller'] = 1;
        $settings_name['is_policy_on'] = 1;
        $settings_name['is_vendor_shipping_on'] = 1;
        update_option('mvx_general_settings_name', $settings_name);
        
        $vendor_name = get_option('mvx_vendor_general_settings_name', array());
        $dashboard = get_page_by_path('vendor-dashboard');
        $vendor_name['mvx_vendor'] = $dashboard->ID;
        update_option('mvx_vendor_general_settings_name', $vendor_name);
        
        
        $capabilities = get_option('mvx_capabilities_product_settings_name', array());
        $capabilities['is_submit_coupon'] = 1;
        $capabilities['is_published_coupon'] = 1;
        update_option('mvx_capabilities_product_settings_name', $capabilities);
    }

    private function update_option_wcfm()
    {
        if (!class_exists('WCFMmp')) {
            return;
        }

        $theme_color 		= '#fcb800';
        $theme_color_hover 	= '#e2a500';
        $theme_star 		= '#ffce01';
        $body_bg 			= '#f5f5f5';
        
        /**Dashboard**/
        $wcfm_options['quick_access_disabled'] = $wcfm_options['float_button_disabled'] = 'yes';
        
        /**Modules**/
        $wcfm_options = get_option('wcfm_options', array());
        $wcfm_options['module_options']['product_mulivendor'] = 'yes';
        
        /**Marketplace Settings**/
        $wcfm_marketplace_options = get_option('wcfm_marketplace_options', array());
        $wcfm_marketplace_options['store_ppp'] = 8;
        update_option('wcfm_marketplace_options', $wcfm_marketplace_options);
        
        /**Vendor Registration**/
        update_option('wcfmvm_hide_become_vendor', '');
        update_option('wcfmvm_required_approval', 'yes');
        
        /**Store Style**/
        $wcfm_store_color_settings = get_option('wcfm_store_color_settings');
        $wcfm_store_color_settings['header_icon'] = $theme_color;
        $wcfm_store_color_settings['tabs_active_text'] = $theme_color;
        $wcfm_store_color_settings['ctore_card_highlight'] = $theme_color;
        $wcfm_store_color_settings['button_bg'] = $theme_color;
        $wcfm_store_color_settings['button_active_bg'] = $theme_color;
        $wcfm_store_color_settings['start_rating'] = $theme_star;
        update_option('wcfm_store_color_settings', $wcfm_store_color_settings);
        
        /**Dashboard Style**/
        $wcfm_options['wc_frontend_manager_base_highlight_color_settings'] = $theme_color;
        $wcfm_options['wc_frontend_manager_secondary_font_color_settings'] = $theme_color;
        $wcfm_options['wc_frontend_manager_menu_icon_active_bg_color_settings'] = $theme_color;
        
        
        update_option('wcfm_options', $wcfm_options);
        
        /**Registration Form Fields**/
        $registration = get_option('wcfmvm_registration_static_fields');
        $registration['first_name'] = $registration['terms'] = $registration['phone'] = $registration['last_name'] = $registration['user_name'] = $registration['address'] = 'yes';
        
        $terms_page = get_page_by_path('terms-of-use');
        $registration['terms_page'] = $terms_page->ID;
        
        update_option('wcfmvm_registration_static_fields', $registration);

        /**Membership**/
        $wcfm_membership_options = get_option('wcfm_membership_options', array());
        $wcfm_membership_options['membership_reject_rules']['required_approval'] = 'yes';
        $wcfm_membership_options['membership_color_settings']['wcfmvm_progress_bar_color_settings'] = $theme_color;
        $wcfm_membership_options['membership_color_settings']['wcfmvm_membership_table_head_title_bg_color_settings'] = $theme_color;
        $wcfm_membership_options['membership_color_settings']['wcfmvm_membership_table_head_bg_color_settings'] = $body_bg;
        $wcfm_membership_options['membership_color_settings']['wcfmvm_membership_table_head_price_color_settings'] = '#000000';
        $wcfm_membership_options['membership_color_settings']['wcfmvm_membership_table_head_price_desc_color_settings'] = '#999999';
        $wcfm_membership_options['membership_color_settings']['wcfmvm_membership_table_bg_heighlighter_color_settings'] = '#f5f5f5';
        $wcfm_membership_options['membership_color_settings']['wcfmvm_membership_table_button_bg_color_settings'] = $theme_color;
        $wcfm_membership_options['membership_color_settings']['wcfmvm_membership_table_button_bg_hover_color_settings'] = $theme_color_hover;
        $wcfm_membership_options['membership_color_settings']['wcfmvm_membership_preview_plan_color_settings'] = $theme_color;
        $wcfm_membership_options['membership_color_settings']['wcfmvm_membership_preview_plan_text_color_settings'] = '#ffffff';

        $membership_page = get_page_by_path('vendor-membership');
        $wcfm_membership_options['membership_type_settings']['wcfm_custom_plan_page']  = $membership_page->ID;

        update_option('wcfm_membership_options', $wcfm_membership_options);
    }
    private function update_option_wcvendors()
    {
        if (!class_exists('WC_Vendors')) {
            return;
        }

        update_option('wcvendors_vendor_allow_registration', 'yes');
    }

    public function set_demo_menus()
    {
        $main_menu       	= get_term_by('name', 'Main Menu', 'nav_menu');

        set_theme_mod(
            'nav_menu_locations',
            array(
                'primary'  		=> $main_menu->term_id,
                'mobile-menu' 	=> $main_menu->term_id,
            )
        );
    }

	/**
	 * Update imported terms count.
	 */ 
	public function update_terms_nav_menu() {
        $update_taxonomy = 'nav_menu';
        $get_terms_args = array(
                'taxonomy' => $update_taxonomy,
                'fields' => 'ids',
                'hide_empty' => false,
                );
        
        $update_terms = get_terms($get_terms_args);
        wp_update_term_count_now($update_terms, $update_taxonomy);
	}

    public function import_files_type_demo()
    {
        $prefix = '';

        if (class_exists('WC_Vendors')) {
            $prefix = 'wcvendors';
        }

        if (class_exists('WCFMmp')) {
            $prefix = 'wcfm';
        }

        if (class_exists('MVX')) {
            $prefix = 'mvx';
        }

        if (class_exists('WeDevs_Dokan')) {
            $prefix = 'dokan';
        }

        return $prefix;
    }

    public function import_files()
    {
        $data = new Themename_Merlin_Elementor;

        $demo_1 	            = $data->import_files_demo_1();
        $demo_2 	            = $data->import_files_demo_2();
        $demo_3 	            = $data->import_files_demo_3();
        $demo_4 	            = $data->import_files_demo_4();
        $demo_5                 = $data->import_files_demo_5();
        $demo_6                 = $data->import_files_demo_6();
        $demo_7                 = $data->import_files_demo_7();
        $demo_8                 = $data->import_files_demo_8();
        $demo_rtl 	            = $data->import_files_rtl();

        return array_merge($demo_1, $demo_2,$demo_7, $demo_8, $demo_3, $demo_4, $demo_5, $demo_6, $demo_rtl);
    }
}

return new Themename_Merlin_Config();
