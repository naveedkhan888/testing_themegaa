<?php
/**
 *
 * Search form.
 * @since 1.0.0
 * @version 1.0.0
 *
 */
?>
<div class="search-form">
	<form action="<?php echo esc_url(home_url('/')); ?>" method="get">
		<div class="input-group">
			<input type="text" placeholder="<?php esc_attr_e('Search ...', 'themename'); ?>" name="s" class="form-control"/>
				<span class="input-group-btn">
					<button type="submit" class="btn">
						<i class="xp-icon xp-icon-search"></i>
					</button>
				</span>
		</div>
	</form>
</div>