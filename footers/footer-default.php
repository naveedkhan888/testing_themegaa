<?php

    $copyright 	= themename_xptheme_get_config('copyright_text', '');

?>

<?php if (is_active_sidebar('footer')) : ?>
	<div class="footer">
		<div class="container">
			<div class="row">
				<?php dynamic_sidebar('footer'); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if (!empty($copyright)) : ?>
	<div class="xptheme-copyright">
		<div class="container">
			<div class="copyright-content">
				<div class="text-copyright text-center">
				
					<?php echo trim($copyright); ?>

				</div> 
			</div>
		</div>
	</div>

<?php else: ?>
	<div class="xptheme-copyright">
		<div class="container">
			<div class="copyright-content">
				<div class="text-copyright text-center">
				<?php
                    $allowed_html_array = array( 
							'a' => array(
								'class' => array(),
								'href'  => array(),
							) 
						);
                        echo wp_kses(__('Copyright &copy; 2024 - themename. All Rights Reserved. <br/> Powered by <a href="//xperttheme.com" class="theme-color">XpertTheme</a>', 'themename'), $allowed_html_array
					);
                    
                ?>

				</div> 
			</div>
		</div>
	</div>

<?php endif; ?>	 