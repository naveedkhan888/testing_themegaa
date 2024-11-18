<?php

if (! function_exists('themename_elementor_icon_control_simple_line_icons')) {
    add_action('elementor/icons_manager/additional_tabs', 'themename_elementor_icon_control_simple_line_icons');
    function themename_elementor_icon_control_simple_line_icons($tabs)
    {
        $tabs['simple-line-icons'] = [
            'name'          => 'simple-line-icons',
            'label'         => esc_html__('Simple Line Icons', 'themename'),
            'prefix'        => 'icon-',
            'displayPrefix' => 'sim-icon',
            'labelIcon'     => 'fa fa-font-awesome',
            'ver'           => '2.4.0',
            'fetchJson'     => get_template_directory_uri() . '/inc/vendors/elementor/icons/json/simple-line-icons.json',
            'native'        => true,
        ];

        return $tabs;
    }
}

if (! function_exists('themename_elementor_icon_control_material_design_iconic')) {
    add_action('elementor/icons_manager/additional_tabs', 'themename_elementor_icon_control_material_design_iconic');
    function themename_elementor_icon_control_material_design_iconic($tabs)
    {
        $tabs['material-design-iconic'] = [
            'name'          => 'material-design-iconic',
            'label'         => esc_html__('Material Design Iconic', 'themename'),
            'prefix'        => 'zmdi-',
            'displayPrefix' => 'zmdi',
            'labelIcon'     => 'fa fa-font-awesome',
            'ver'           => '2.2.0',
            'fetchJson'     => get_template_directory_uri() . '/inc/vendors/elementor/icons/json/material-design-iconic.json',
            'native'        => true,
        ];

        return $tabs;
    }
}


if (! function_exists('themename_elementor_icon_control_xptheme_custom')) {
    add_action('elementor/icons_manager/additional_tabs', 'themename_elementor_icon_control_xptheme_custom', 10);
    function themename_elementor_icon_control_xptheme_custom($tabs)
    {
        $tabs['xptheme-custom'] = [
            'name'          => 'xptheme-custom',
            'label'         => esc_html__('Xperttheme Custom', 'themename'),
            'prefix'        => 'xp-icon-',
            'displayPrefix' => 'xp-icon',
            'labelIcon'     => 'fa fa-font-awesome',
            'ver'           => '1.0.0',
            'fetchJson'     => get_template_directory_uri() . '/inc/vendors/elementor/icons/json/xptheme-custom.json',
            'native'        => true,
        ];

        return $tabs;
    }
}
