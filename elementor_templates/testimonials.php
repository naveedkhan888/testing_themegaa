<?php
/**
 * Templates Name: Elementor
 * Widget: Testimonials
 */
extract($settings);
if ( (empty($testimonials) && empty($testimonials_style4) ) || (!is_array($testimonials) && !is_array($testimonials_style4)) ) {
    return;
}

$this->add_render_attribute('item', 'class', 'item');
$this->add_render_attribute('wrapper', 'class', $layout_style);
$this->settings_layout();

if($layout_style == 'style4') {
    $testimonials = $testimonials_style4;
}
?>

<div <?php $this->print_render_attribute_string('wrapper'); ?>>

    <?php $this->render_element_heading(); ?>

    <div <?php $this->print_render_attribute_string('row'); ?>>
        <?php foreach ($testimonials as $item) : ?>
            <div <?php $this->print_render_attribute_string('item'); ?>>
                <?php 

                    switch ($layout_style) {
                        case 'style1':
                            $this->render_item_style1($item);
                            break;

                        case 'style2':
                            $this->render_item_style2($item);
                            break;

                        case 'style3':
                            $this->render_item_style3($item);
                            break;

                        case 'style4':
                            $this->render_item_style4($item);
                            break;
                        
                        default:
                            $this->render_item_style1($item);
                            break;
                    }
                ?>
            </div>

        <?php endforeach; ?>
    </div>
</div>