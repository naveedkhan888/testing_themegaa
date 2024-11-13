<?php
/**
 * Templates Name: Elementor
 * Widget: Portfolios
 */
extract($settings);

$this->add_render_attribute('item', 'class', 'item');
$this->add_render_attribute('row', 'class', ['portfolios-wrapper', 'layout-'.$layout_type]);
$this->settings_layout();
?>

<div <?php $this->print_render_attribute_string('wrapper'); ?>>

    <?php $this->render_element_heading(); ?>

    <?php if( $layout_type === 'filter' ) : ?>
        <?php 
            $this->add_render_attribute('row', 'class', 'pf-isotope');    
        ?>
        <div id="pf-filters" class="pf-button-group button-group">
            <button class="button is-checked" data-filter="*"><?php esc_html_e('Show All', 'themename'); ?></button>
            <?php $this->render_portfolios_filters(); ?>
        </div>

        <div <?php $this->print_render_attribute_string('row'); ?>>
            <?php $this->render_portfolios_content(); ?>
        </div>

    <?php else: ?>
        <div <?php $this->print_render_attribute_string('row'); ?>>
            <?php $this->render_portfolios_content(); ?>
        </div>

    <?php endif; ?>

</div>