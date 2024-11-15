<?php
/**
 * Templates Name: Elementor
 * Widget: Product Categories Tabs
 */

extract($settings);

$this->settings_layout();

$random_id = themename_xptheme_random_key();

if( $ajax_tabs === 'yes' ) {
    $this->add_render_attribute('wrapper', 'class', 'ajax-active'); 
}
?>
<div <?php $this->print_render_attribute_string('wrapper'); ?>>
    <div class="wrapper-heading-tab">
        <?php
            $this->render_element_heading();
            $this->render_tabs_title($categories_tabs, $random_id);
        ?>
    </div>
    <?php
        $this->render_product_tabs_content($categories_tabs, $random_id);
        $this->render_item_button();
    ?>
</div>