<?php
	$product_item 	= isset($product_item) ? $product_item : 'list';
	$skin 			= themename_tbay_get_theme();
?>
<ul class="tbay-w-products-list">
	<?php while ($loop->have_posts()) : $loop->the_post(); global $product; ?>
		<?php 
			$post_object = get_post( get_the_ID() );
			setup_postdata( $GLOBALS['post'] =& $post_object );
			
			wc_get_template_part('item-product/skins/'.$skin.'/'.$product_item); 
		?>
	<?php endwhile; ?>

	<?php wp_reset_postdata(); ?>
</ul>