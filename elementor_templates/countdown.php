<?php
/**
 * Templates Name: Elementor
 * Widget: Countdown
 */

$this->settings_layout();
extract($settings);

if( $custom_labels !== 'yes' ) {
    $label_days = esc_html__( 'Days', 'themename' );
    $label_hours = esc_html__( 'Hours', 'themename' );
    $label_minutes = esc_html__( 'Minutes', 'themename' );
    $label_seconds = esc_html__( 'Seconds', 'themename' );
}


$label_days = '<span class="label">'. $label_days .'</span>';
$label_hours = '<span class="label">'. $label_hours .'</span>';
$label_minutes = '<span class="label">'. $label_minutes .'</span>';
$label_seconds = '<span class="label">'. $label_seconds .'</span>';

$time_sale = strtotime($due_date);

$this->add_render_attribute(
    'wrapper',
    [
        'data-settings' => wp_json_encode([
			'show_days' => ( $show_days === 'yes' ) ? true : false, 
			'show_hours' => ( $show_hours === 'yes' ) ? true : false,
			'show_minutes' => ( $show_minutes === 'yes' ) ? true : false,
			'show_seconds' => ( $show_seconds === 'yes' ) ? true : false,
			'custom_separator' => $custom_separator,
        ]),
    ]
);

$show_labels_class = ( $show_labels === 'yes' ) ? 'label-coutdown' : '';
?> 
<div <?php $this->print_render_attribute_string('wrapper'); ?>>
    <div class="time <?php echo esc_attr($show_labels_class);?>">
        <div class="tbay-countdown tbay-el-countdown" data-time="timmer"
                data-date="<?php echo date('m', $time_sale).'-'.date('d', $time_sale).'-'.date('Y', $time_sale).'-'. date('H', $time_sale) . '-' . date('i', $time_sale) . '-' .  date('s', $time_sale) ; ?>" data-days="<?php echo esc_attr($label_days); ?>" data-hours="<?php echo esc_attr($label_hours); ?>" data-mins="<?php echo esc_attr($label_minutes); ?>" data-secs="<?php echo esc_attr($label_seconds); ?>" >
        </div>
    </div>
</div>