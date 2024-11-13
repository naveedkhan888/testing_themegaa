<?php

if( themename_checkout_optimized() ) {
	get_template_part('headers/header-checkout'); 
	return;
}

$header 	= apply_filters('themename_tbay_get_header_layout', 'header_default');

$class_header = themename_header_located_on_slider();
?>

<header id="tbay-header" class="tbay_header-template site-header <?php echo esc_attr($class_header) ?> <?php echo ( themename_tbay_get_config('header_disable_border_bottom', false) ) ? 'disable-border-bottom' : ''; ?>">

	<?php if ($header != 'header_default') : ?>	

		<?php themename_tbay_display_header_builder(); ?> 

	<?php else : ?>
	
	<?php get_template_part('headers/header-default'); ?>

	<?php endif; ?>
	<div id="nav-cover"></div>
	<div class="bg-close-canvas-menu"></div>
</header>