<?php
global $product;

$product_style = isset($product_style) ? $product_style : '';

?>
<div class="product-block product <?php echo esc_attr($product_style); ?> <?php themename_is_product_variable_sale(); ?>" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
    <?php do_action( 'themename_content_product_item_before' ); ?>
	<div class="product-content">
		<?php
            /**
            * Hook: woocommerce_before_shop_loop_item.
            *
            * @hooked woocommerce_template_loop_product_link_open - 10
            */
            do_action('woocommerce_before_shop_loop_item');
        ?>
		<div class="block-inner">
			<figure class="image ">
				<a href="<?php echo esc_url($product->get_permalink()); ?>">
					<?php echo trim($product->get_image()); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped?>
				</a>
			</figure>
			<?php
                /**
                * xptheme_woocommerce_before_content_product hook
                *
                * @hooked woocommerce_show_product_loop_sale_flash - 10
                */
                do_action('xptheme_woocommerce_before_content_product');
            ?>
		</div>
		<div class="caption">
			<?php themename_the_product_name(); ?>
			<?php
                /**
                * themename_after_title_xptheme_subtitle hook
                *
                * @hooked themename_woo_get_subtitle - 0
                */
                do_action('themename_after_title_xptheme_subtitle');
            ?>

			<?php do_action('woocommerce_after_shop_loop_item_vertical_title'); ?>
			
			
			<?php
                /**
                * Hook: woocommerce_after_shop_loop_item.
                */
                do_action('woocommerce_after_shop_loop_item');
            ?>
		</div>
    </div>
</div>
