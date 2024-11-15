<?php

$footer 	= apply_filters('themename_xptheme_get_footer_layout', 'footer_default');

?>

	</div><!-- .site-content -->
	<?php 
		do_action( 'themename_before_do_footer' );
	?>
	<?php if (themename_xptheme_active_newsletter_sidebar()) : ?>
		<div id="newsletter-popup" class="newsletter-popup">
			<?php dynamic_sidebar('newsletter-popup'); ?>
		</div>
	<?php endif; ?>
	
	<?php if( !themename_checkout_optimized() ) : ?>
	<footer id="xptheme-footer" <?php themename_xptheme_footer_class();?>>
		<?php if ($footer != 'footer_default'): ?>
			
			<?php themename_xptheme_display_footer_builder(); ?>

		<?php else: ?> 
			
			<?php get_template_part('footers/footer-default'); ?>
			
		<?php endif; ?>			
	</footer><!-- .site-footer -->
	<?php endif; ?>

	<?php 
		do_action( 'themename_after_do_footer' );
	?>
	
</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>