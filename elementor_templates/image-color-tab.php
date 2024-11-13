<?php
/**
 * Templates Name: Elementor
 * Widget: Image Color Tab
 */
extract($settings);
if (empty($tabs) || !is_array($tabs)) {
    return;
}

$this->add_render_attribute('item', 'class', 'item');
$this->add_render_attribute('row', 'class', 'image-color-tab-wrapper');
$this->add_render_attribute('content', 'class', ['content-wrapper', 'active-color-1']);
$this->settings_layout();
?>

<div <?php $this->print_render_attribute_string('wrapper'); ?>>

    <div <?php $this->print_render_attribute_string('row'); ?>>
        <div <?php $this->print_render_attribute_string('content'); ?>>
            <?php  
                $this->render_tabs_content($tabs, $this->get_id());
                $this->render_tabs_title($tabs, $this->get_id());

                $this->render_list_color();
            ?>
        </div>
    </div>
</div>