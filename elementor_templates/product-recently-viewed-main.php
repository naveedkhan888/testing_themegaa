<?php
/**
 * Templates Name: Elementor
 * Widget: Product Recently Viewed Main
 */

extract($settings);

if (isset($limit) && !((bool) $limit)) {
    return;
}

$this->settings_layout();

$this->add_render_attribute('wrapper', 'class', ['product-recently-viewed-main']);
?>

<div <?php $this->print_render_attribute_string('wrapper'); ?>>

    <?php $this->render_element_heading(); ?>

    
	<?php $this->render_content_main(); ?>    

</div>