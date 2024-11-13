<?php

    $copyright 	= lasa_tbay_get_config('copyright_text', '');

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
	<div class="tbay-copyright">
		<div class="container">
			<div class="copyright-content">
				<div class="text-copyright text-center">
				
					<?php echo trim($copyright); ?>

				</div> 
			</div>
		</div>
	</div>

<?php else: ?>
	<div class="tbay-copyright">
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
                        echo wp_kses(__('Copyright &copy; 2024 - lasa. All Rights Reserved. <br/> Powered by <a href="//thembay.com" class="theme-color">ThemBay</a>', 'lasa'), $allowed_html_array
					);
                    
                ?>

				</div> 
			</div>
		</div>
	</div>

<?php endif; ?>	 