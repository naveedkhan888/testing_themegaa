<?php
/**
 * Templates Name: Elementor
 * Widget: Mini Cart
 */

if (null === WC()->cart) {
    return;
}
?>
<div <?php $this->print_render_attribute_string('wrapper'); ?>>
    <?php $this->render_woocommerce_mini_cart(); ?>
</div>