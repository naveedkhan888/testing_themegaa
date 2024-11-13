<?php
/**
 * Templates Name: Elementor
 * Widget: Image Tab
 */
extract($settings);
if (empty($tabs) || !is_array($tabs)) {
    return;
}

$this->add_render_attribute('item', 'class', 'item');
$this->add_render_attribute('row', 'class', 'tab-image-wrapper');
$this->settings_layout();
?>

<div <?php $this->print_render_attribute_string('wrapper'); ?>>

    <?php $this->render_element_heading(); ?>

    <div <?php $this->print_render_attribute_string('row'); ?>>

        <?php  
            $this->render_tabs_content($tabs, $this->get_id());
            $this->render_tabs_title($tabs, $this->get_id());
        ?>
    </div>
</div>