<?php 
/**
 * Templates Name: Elementor
 * Widget: Before After Image Slider
 */
$this->settings_layout();
extract($settings);

$this->add_render_attribute(
    'wrapper',
    [
        'data-settings' => wp_json_encode([
			'mode' => $settings_mode,
			'showText' => ( $settings_showText === 'yes' ) ? true : false,
            'beforeText' => $settings_beforeText,
            'beforeTextPosition' => $settings_beforeTextPosition,
            'afterText' => $settings_afterText,
            'afterTextPosition' => $settings_afterTextPosition,
            'seperatorWidth' => $settings_seperatorWidth,
            'seperatorOpacity' => $settings_seperatorOpacity,
            'theme' => $settings_theme,
            'autoSliding' => ( $settings_autoSliding === 'yes' ) ? true : false,
            'autoSlidingStopOnHover' => ( $settings_autoSlidingStopOnHover === 'yes' ) ? true : false,
            'hoverEffect' => ( $settings_hoverEffect === 'yes' ) ? true : false,
            'enterAnimation' => ( $settings_enterAnimation === 'yes' ) ? true : false,
        ]),
    ]
);

?>

<div <?php $this->print_render_attribute_string('wrapper'); ?>>
    <?php $this->render_item_content(); ?>
</div>