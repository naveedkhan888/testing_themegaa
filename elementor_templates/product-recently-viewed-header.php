<?php
/**
 * Templates Name: Elementor
 * Widget: Product Recently Viewed Header
 */
extract($settings);

if (isset($limit) && !((bool) $limit)) {
    return;
}

$this->add_render_attribute(
    'wrapper',
    [
        'data-wrapper' => wp_json_encode([
            'layout' => 'header'
        ]), 
        'data-column' => $header_column,
    ]
);

$this->settings_layout();

$this->add_render_attribute('wrapper', 'class', [ 'product-recently-viewed-header' ]);
?>

<div <?php $this->print_render_attribute_string('wrapper'); ?>>

    <?php $this->render_element_heading(); ?>

    <?php $this->render_content_main(); ?>    

</div>