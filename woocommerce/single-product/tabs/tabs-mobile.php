<?php
/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters('woocommerce_product_tabs', array());

if (! empty($product_tabs)) : ?>
	<div class="tabs-sidebar"></div>

	<div class="woocommerce-tabs-sidebar clearfix">
		<ul class="tabs-sidebar" role="tablist">
			<?php foreach ($product_tabs as $key => $product_tab) : ?>
				<li class="<?php echo esc_attr($key); ?>_tab" id="xptheme-wc-tab-<?php echo esc_attr($key); ?>" role="tab" aria-controls="tab-<?php echo esc_attr($key); ?>">
					<a data-tabid="tab-<?php echo esc_attr($key); ?>" href="#tab-<?php echo esc_attr($key); ?>"><?php echo apply_filters('woocommerce_product_' . esc_html($key) . '_tab_title', esc_html($product_tab['title']), $key); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php foreach ($product_tabs as $key => $product_tab) : ?>
			<div class="wc-tab-sidebar" id="tab-<?php echo esc_attr($key); ?>" role="tabpanel" aria-labelledby="xptheme-wc-tab-<?php echo esc_attr($key); ?>">
				<div class="tab-head">
					<?php if (isset($product_tab['title'])) : ?>
						<div class="title"><?php echo trim($product_tab['title']); ?></div>
					<?php endif; ?>

					<a class="close-tab" href="#"><i class="xp-icon xp-icon-close-01"></i></a>
				</div>
				<div class="tab-content">
					<?php if (isset($product_tab['callback'])) {
    call_user_func($product_tab['callback'], $key, $product_tab);
} ?>
				</div>

			</div>
		<?php endforeach; ?>

		<?php do_action('woocommerce_product_after_tabs'); ?>
		<div id="tab-sidebar-close"></div>

	</div>


<?php endif; ?>
