<?php
global $product;


do_action('themename_woocommerce_before_product_block_grid');

$flash_sales 	= isset($flash_sales) ? $flash_sales : false;
$end_date 		= isset($end_date) ? $end_date : '';

$countdown_title 		= isset($countdown_title) ? $countdown_title : '';

$countdown 		= isset($countdown) ? $countdown : false;
$class = array();
$class_flash_sale = themename_xptheme_class_flash_sale($flash_sales);
array_push($class, $class_flash_sale);


?>
<div <?php themename_xptheme_product_class($class); ?> data-product-id="<?php echo esc_attr($product->get_id()); ?>">
    <?php do_action( 'themename_content_product_item_before' ); ?>
	<?php
        /**
         * Hook: woocommerce_before_shop_loop_item.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         */
        do_action('woocommerce_before_shop_loop_item');
    ?>
	<div class="product-content">
		
		<div class="block-inner">
			<figure class="image <?php themename_product_block_image_class(); ?>">
				<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>" class="product-image">
					<?php
                        /**
                        * woocommerce_before_shop_loop_item_title hook
                        *
                        * @hooked woocommerce_template_loop_product_thumbnail - 10
                        */
                        do_action('woocommerce_before_shop_loop_item_title');
                    ?>
				</a>
				
				<?php
                    /**
                    * themename_xptheme_after_shop_loop_item_title hook
                    *
                    */
                    do_action('themename_xptheme_after_shop_loop_item_title');
                ?>
			
			<?php themename_xptheme_item_deal_ended_flash_sale($flash_sales, $end_date); ?>
			</figure>

            <?php themename_woo_product_time_countdown($countdown, $countdown_title); ?>
            
			<div class="group-buttons">	
				<?php
                    /**
                    * themename_woocommerce_group_buttons hook
                    *
                    * @hooked themename_the_yith_wishlist - 20
                    * @hooked themename_the_yith_compare - 30
                    * @hooked themename_the_quick_view - 40
                    */
                    do_action('themename_woocommerce_group_buttons', $product->get_id());
                ?>
		    </div>
		</div>
		
		<?php
            /**
            * xptheme_woocommerce_before_content_product hook
            *
            * @hooked woocommerce_show_product_loop_sale_flash - 10
            */
            do_action('xptheme_woocommerce_before_content_product');
        ?>
		
		
		<div class="caption">
            <?php
                /**
                * themename_woo_show_brands hook
                *
                * @hooked the_brands_the_name - 10
                */
                do_action('themename_woo_show_brands');
            ?>
			<?php
                do_action('themename_woo_before_shop_loop_item_caption');
            ?>

            <?php themename_the_product_name(); ?>

            <?php
                /**
                * themename_after_title_xptheme_subtitle hook
                *
                * @hooked themename_woo_get_subtitle - 0
                */
                do_action('themename_after_title_xptheme_subtitle');
            ?>
            
			<?php
                /**
                * woocommerce_after_shop_loop_item_title hook
                *
                * @hooked woocommerce_template_loop_price - 10
                */
                do_action('woocommerce_after_shop_loop_item_title');
            ?>

			
			<div class="group-content">
                <?php
                    /**
                    * themename_woocommerce_loop_item_rating hook
                    *
                    * @hooked woocommerce_template_loop_rating - 10
                    */
                    do_action('themename_woocommerce_loop_item_rating');
                ?>
            </div>

            <?php
                do_action('themename_xptheme_variable_product');
            ?>	

            <?php themename_xptheme_stock_flash_sale($flash_sales); ?>
			
			<?php
                do_action('themename_woo_after_shop_loop_item_caption');
            ?>
		</div>

		
		<?php
            do_action('themename_woocommerce_after_product_block_grid');
        ?>
    </div>
    
	<?php
        /**
        * Hook: woocommerce_after_shop_loop_item.
        */
        do_action('woocommerce_after_shop_loop_item');
    ?>
</div>
