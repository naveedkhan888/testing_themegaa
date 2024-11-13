<?php
/**
 * Templates Name: Elementor
 * Widget: Feature List
 */
$layout_type = $settings['layout_type'];
$this->settings_layout();
$this->add_render_attribute('row', 'class', ['list-items']);
$this->add_render_attribute('item', 'class', 'item');
?>
<div <?php $this->print_render_attribute_string('wrapper'); ?>>
    <div class="feature-list-wrapper">
        <div <?php $this->print_render_attribute_string('row'); ?> > 
            <?php foreach ($settings['custom_list_feature'] as $index => $item) {
                    $type = $item['item_type'];
                    $item_setting_key = $this->get_repeater_setting_key('type', 'custom_list_feature', $index);
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