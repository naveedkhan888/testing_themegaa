<?php
/**
 * Templates Name: Elementor
 * Widget: Wishlist
 */
$this->add_render_attribute('wrapper', 'class', ['top-wishlist', 'header-icon']);

extract($settings);

if (! class_exists('YITH_WCWL')) {
    return;
}

?>
<div <?php $this->print_render_attribute_string('wrapper'); ?>>
    <?php $this->render_item_wishlist() ?>
</div>
