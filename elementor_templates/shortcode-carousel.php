<?php
/**
 * Templates Name: Elementor
 * Widget: Shortcode Carousel
 */
extract($settings);
if ( empty($list_shortcode)  ) {
    return;
}

$this->add_render_attribute('item', 'class', 'item');
$this->settings_layout();
?>
<div <?php $this->print_render_attribute_string('wrapper'); ?>>
    <div <?php $this->print_render_attribute_string('row'); ?>>
        <?php foreach ($list_shortcode as $item) : ?>
            <div <?php $this->print_render_attribute_string('item'); ?>>
                <?php 
                    $shortcode = do_shortcode( shortcode_unautop( $item['shortcode'] ) );
                ?>
                <div class="elementor-shortcode"><?php echo trim($shortcode); ?></div>
            </div>

        <?php endforeach; ?>
    </div>
</div>