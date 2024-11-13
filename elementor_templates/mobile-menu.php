<?php
/**
 * Templates Name: Elementor
 * Widget: Menu Mobile
 */

$settings = $this->get_active_settings();

extract($settings);
?>
<div <?php $this->print_render_attribute_string('wrapper'); ?>>
    <?php 
        if( !empty($general_icon['value']) ) {
            $icon = '<i class="mobile-menu-icon '. $general_icon['value'] .'"></i>';
        }

        if( !empty( $general_title ) ) {
            $title = '<'. $general_title_tag .'  class="mobile-menu-title">';
            $title .= $general_title;
            $title .= '</'. $general_title_tag .'>';
        }
 
    ?>
    <a href="javascript:void(0)" class="btn-elementor-menu-mobile mmenu-open">
        <?php 
            if(!empty($icon) && $icon_align === 'left') {
                echo trim($icon);
            }

            if(!empty($title)) {
                echo trim($title);
            }

            if(!empty($icon) && $icon_align === 'right') {
                echo trim($icon);
            }
        ?>
    </a>
</div>