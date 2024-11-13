<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Themename_Elementor_Addons
{
    public function __construct()
    {
        $this->include_control_customize_widgets();
        $this->include_render_customize_widgets();

        add_action('elementor/elements/categories_registered', array( $this, 'add_category' ));

        add_action('elementor/widgets/register', array( $this, 'include_widgets' ));

        add_action('wp', [ $this, 'regeister_scripts_frontend' ]);

        // frontend
        // Register widget scripts
        add_action('elementor/frontend/after_register_scripts', [ $this, 'frontend_after_register_scripts' ]);
        add_action('elementor/frontend/after_enqueue_scripts', [ $this, 'frontend_after_enqueue_scripts' ]);

        add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_editor_icons'], 99);

        // editor
        add_action('elementor/editor/after_register_scripts', [ $this, 'editor_after_register_scripts' ]);
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'editor_after_enqueue_scripts']);

    
        add_action('widgets_init', array( $this, 'register_wp_widgets' ));
    }

    public function editor_after_register_scripts()
    {
        if (themename_is_remove_scripts()) {
            return;
        }

        $suffix = (themename_tbay_get_config('minified_js', false)) ? '.min' : THEMENAME_MIN_JS;
        // /*slick jquery*/
        wp_register_script('slick', THEMENAME_SCRIPTS . '/slick' . $suffix . '.js', array(), '1.0.0', true);
        wp_register_script('themename-custom-slick', THEMENAME_SCRIPTS . '/custom-slick' . $suffix . '.js', array( ), THEMENAME_THEME_VERSION, true);

        wp_register_script('themename-script', THEMENAME_SCRIPTS . '/functions' . $suffix . '.js', array(), THEMENAME_THEME_VERSION, true);
    
        wp_register_script('popper', THEMENAME_SCRIPTS . '/popper' . $suffix . '.js', array( ), '1.12.9', true);
        wp_register_script('bootstrap', THEMENAME_SCRIPTS . '/bootstrap' . $suffix . '.js', array( 'popper' ), '5.3', true);
          
        // Add before after image
        wp_register_script( 'before-after-image', THEMENAME_SCRIPTS . '/cndk.beforeafter' . $suffix . '.js', array('themename-script' ), '0.0.2', true ); 
        wp_register_style( 'before-after-image', THEMENAME_STYLES . '/cndk.beforeafter.css', array(), '0.0.2' );
          
        // Add before after image
        wp_register_script( 'isotope', THEMENAME_SCRIPTS . '/isotope.pkgd' . $suffix . '.js', array('themename-script' ), '3.0.6', true ); 

        /*Treeview menu*/
        wp_register_script('jquery-treeview', THEMENAME_SCRIPTS . '/jquery.treeview' . $suffix . '.js', array( ), '1.4.0', true);

        wp_enqueue_script('waypoints', THEMENAME_SCRIPTS . '/jquery.waypoints' . $suffix . '.js', array(), '4.0.0', true);
       
        // Add js Sumoselect version 3.0.2
        wp_register_style('sumoselect', THEMENAME_STYLES . '/sumoselect.css', array(), '1.0.0', 'all');
        wp_register_script('jquery-sumoselect', THEMENAME_SCRIPTS . '/jquery.sumoselect' . $suffix . '.js', array(), '3.0.2', true);
    }

    public function frontend_after_enqueue_scripts()
    {
    }

    public function editor_after_enqueue_scripts()
    {
    }

    public function enqueue_editor_icons()
    {
        wp_enqueue_style('font-awesome', THEMENAME_STYLES . '/font-awesome.css', array(), '5.10.2');
        wp_enqueue_style('simple-line-icons', THEMENAME_STYLES . '/simple-line-icons.css', array(), '2.4.0');
        wp_enqueue_style('themename-font-tbay-custom', THEMENAME_STYLES . '/font-tbay-custom.css', array(), '1.0.0');
        wp_enqueue_style('material-design-iconic-font', THEMENAME_STYLES . '/material-design-iconic-font.css', array(), '2.2.0');

        if (themename_elementor_is_edit_mode() || themename_elementor_preview_page() || themename_elementor_preview_mode()) {
            wp_enqueue_style('themename-elementor-editor', THEMENAME_STYLES . '/elementor-editor.css', array(), THEMENAME_THEME_VERSION);
        }
    }


    /**
     * @internal Used as a callback
     */
    public function frontend_after_register_scripts()
    {
        $this->editor_after_register_scripts();
    }


    public function register_wp_widgets()
    {
    }

    public function regeister_scripts_frontend()
    {
    }


    public function add_category( $elements_manager )
    {
        $elements_manager->add_category(
            'themename-elements',
            array(
                'title' => esc_html__('Themename Elements', 'themename'),
                'icon'  => 'fa fa-plug',
            )
        );
    }

    /**
     * @param $widgets_manager Elementor\Widgets_Manager
     */
    public function include_widgets($widgets_manager)
    {
        $this->include_abstract_widgets($widgets_manager);
        $this->include_general_widgets($widgets_manager);
        $this->include_header_widgets($widgets_manager);
        $this->include_woocommerce_widgets($widgets_manager);

        $this->include_customize_basic_widgets($widgets_manager);
    }

    /**
     * Widgets General Theme
     */
    public function include_customize_basic_widgets($widgets_manager)
    {
        $widgets = array(
            'shortcode',
        );

        $widgets = apply_filters('themename_customize_basic_elements_array', $widgets);
 
        foreach ($widgets as $file) {
            $control   = THEMENAME_ELEMENTOR .'/elements/customize/widgets/' . $file . '.php';
            if (file_exists($control)) {
                require_once $control;
            }
        }
    }


    /**
     * Widgets General Theme
     */
    public function include_general_widgets($widgets_manager)
    {
        $elements = themename_elementor_general_widgets();

        foreach ($elements as $file) {
            $path   = THEMENAME_ELEMENTOR .'/elements/general/' . $file . '.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }

    /**
     * Widgets WooComerce Theme
     */
    public function include_woocommerce_widgets($widgets_manager)
    {
        if (!themename_woocommerce_activated()) {
            return;
        }

        $woo_elements = themename_elementor_woocommerce_widgets();

        foreach ($woo_elements as $file) {
            $path   = THEMENAME_ELEMENTOR .'/elements/woocommerce/' . $file . '.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }

    /**
     * Widgets Header Theme
     */
    public function include_header_widgets($widgets_manager)
    {
        $elements = themename_elementor_header_widgets();

        foreach ($elements as $file) {
            $path   = THEMENAME_ELEMENTOR .'/elements/header/' . $file . '.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }


    /**
     * Widgets Abstract Theme
     */
    public function include_abstract_widgets($widgets_manager)
    {
        $abstracts = array(
            'image',
            'base',
            'responsive',
            'carousel',
        );

        $abstracts = apply_filters('themename_abstract_elements_array', $abstracts);

        foreach ($abstracts as $file) {
            $path   = THEMENAME_ELEMENTOR .'/abstract/' . $file . '.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }

    public function include_control_customize_widgets()
    {
        $widgets = array(
            'sticky-header',
            'column',
            'button',
            'image',
            'icon-box',
            'accordion',
            'settings-layout',
            'global-typography',
            'global-colors',
        );

        if( themename_tbay_get_theme() === 'bicycle' ) {
            array_push($widgets, 'heading');
        }

        $widgets = apply_filters('themename_customize_elements_array', $widgets);
 
        foreach ($widgets as $file) {
            $control   = THEMENAME_ELEMENTOR .'/elements/customize/controls/' . $file . '.php';
            if (file_exists($control)) {
                require_once $control;
            }
        }
    }

    public function include_render_customize_widgets()
    {
        $widgets = array(
            'sticky-header',
        );

        $widgets = apply_filters('themename_customize_elements_array', $widgets);
 
        foreach ($widgets as $file) {
            $render    = THEMENAME_ELEMENTOR .'/elements/customize/render/' . $file . '.php';
            if (file_exists($render)) {
                require_once $render;
            }
        }
    }
}

new Themename_Elementor_Addons();
