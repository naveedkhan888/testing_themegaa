<?php
/**
 * Templates Name: Elementor
 * Widget: Product Flash Sales
 */

extract($settings);

$this->settings_layout();

$this->add_render_attribute('wrapper', 'class', [ $this->deal_end_class() ]);
?>

<div <?php $this->print_render_attribute_string('wrapper'); ?>>
    <?php
        if (!empty($heading_title) || !empty($heading_subtitle) || (isset($end_date) && !empty($end_date))) {
            ?>
            <div class="top-flash-sale-wrapper">
                <?php $this->render_element_heading();
            if (isset($end_date) && !empty($end_date)) {
                themename_xptheme_countdown_flash_sale($end_date, $date_title, $date_title_ended, true);
            } 
            
            if( $readmore_position === 'top' ) {
                $this->render_btn_readmore();
            }
            
            ?>
            </div>
            <?php
        }
    ?>

    <?php $this->render_content_main(); ?>

</div>