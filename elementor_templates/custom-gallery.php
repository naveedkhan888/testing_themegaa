<?php
/**
 * Templates Name: Elementor
 * Widget: Instagram Feed
 */
extract($settings);

$this->settings_layout();
add_action( 'wp_footer', 'themename_photoswipe' );
$this->add_render_attribute('item', 'class', ['gallery-item', $layout_type]);
?>

<div <?php $this->print_render_attribute_string('wrapper'); ?>>
    <?php $this->render_element_heading(); ?>

    <div <?php $this->print_render_attribute_string('row'); ?>>
        <?php foreach ($list_gallery as $item) : ?>

        <?php if( !empty($item['gallery']['url']) ) : ?>
        <div <?php $this->print_render_attribute_string('item'); ?>>
            <?php  
                $image_alt = get_post_meta($item['gallery']['id'], '_wp_attachment_image_alt', TRUE);

                if( empty( $image_alt ) ) {
                    $image_alt = get_the_title($item['gallery']['id']);
                }

                $effect_class = ($gallery_effects !== 'no') ? 'xp-effect effect-'. esc_attr($gallery_effects) : '';
            ?>
            <a class="gallery-link <?php echo esc_attr($effect_class); ?>"
                href="<?php echo esc_url( $item['gallery']['url'] ); ?>"
                data-lightbox-title="<?php echo esc_attr($image_alt); ?>"
                data-text="<?php echo esc_attr( $item['text_gallery'] ); ?>">
                <?php 
                    echo wp_get_attachment_image( $item['gallery']['id'], 'full' );
                ?>
            </a>
        </div>
        <?php endif; ?>

        <?php endforeach; ?>
    </div>
</div>