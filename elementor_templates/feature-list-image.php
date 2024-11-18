<?php
/**
 * Templates Name: Elementor
 * Widget: Feature List Image
 */
extract($settings);
$this->add_render_attribute('item', 'class', 'item');
?>

<div <?php $this->print_render_attribute_string('wrapper'); ?>>
    <div class="feature-list-img-wrapper">
        <?php  
            if( !empty($feature_list_image['id']) ) {
                echo '<div class="feature-image xp-effect effect-'. esc_attr($style_feature_item_image_effects) .'">'. wp_get_attachment_image($feature_list_image['id'], 'full') .'</div>';
            }
        ?>
        <div class="list-items" > 
            <?php foreach ($settings['custom_image_list_feature'] as $index => $item) {
                    $type = $item['item_type'];
                    $item_setting_key = $this->get_repeater_setting_key('type', 'custom_image_list_feature', $index);
                    $this->add_render_attribute($item_setting_key, [
                        'class' => [ 'item', 'item-'.$type ],
                    ]); ?>
                    <div <?php $this->print_render_attribute_string($item_setting_key); ?>>
                        <?php $this->render_item_content($item); ?>
                    </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>