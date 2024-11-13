<?php
/**
 * Templates Name: Elementor
 * Widget: Store Notice
 */
extract($settings);
if (empty($tabs) || !is_array($tabs)) {
    return;
}
?>
<div <?php $this->print_render_attribute_string('wrapper'); ?>>
    <?php  
        $this->render_tabs_content($tabs);
    ?>
</div>