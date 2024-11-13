<?php
global $product;


do_action('lasa_woocommerce_before_product_block_grid');

$flash_sales 	= isset($flash_sales) ? $flash_sales : false;
$end_date 		= isset($end_date) ? $end_date : '';

$countdown_title 		= isset($countdown_title) ? $countdown_title : '';

$countdown 		= isset($countdown) ? $countdown : false;
$class = array();
$class_flash_sale = lasa_tbay_class_flash_sale($flash_sales);
array_push($class, $class_flash_sale);


?>
<div <?php lasa_tbay_product_class($class); ?> data-product-id="<?php echo esc_attr($product->get_id()); ?>">
    <?php do_action( 'lasa_content_product_item_before' ); ?>
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
			<figure class="image <?php lasa_product_block_image_class(); ?>">
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
                    * lasa_tbay_after_shop_loop_item_title hook
                    *
                    */
                    do_action('lasa_tbay_after_shop_loop_item_title');
                ?>
			
			<?php lasa_tbay_item_deal_ended_flash_sale($flash_sales, $end_date); ?>
			</figure>

            <?php lasa_woo_product_time_countdown($countdown, $countdown_title); ?>
            
			<div class="group-buttons">	
				<?php
                    /**
                    * lasa_woocommerce_group_buttons hook
                    *
                    * @hooked lasa_the_yith_wishlist - 20
                    * @hooked lasa_the_yith_compare - 30
                    * @hooked lasa_the_quick_view - 40
                    */
                    do_action('lasa_woocommerce_group_buttons', $product->get_id());
                ?>
		    </div>

		</div>
		
		<?php
            /**
            * tbay_woocommerce_before_content_product hook
            *
            * @hooked woocommerce_show_product_loop_sale_flash - 10
            */
            do_action('tbay_woocommerce_before_content_product');
        ?>
		
		
		<div class="caption">
            <div class="group-add-to-cart">
				<?php 
					/**
					* lasa_woocommerce_group_add_to_cart hook
					*
					* @hooked woocommerce_template_loop_add_to_cart - 10
					*/
					do_action( 'lasa_woocommerce_group_add_to_cart', $product->get_id() );
				?>
			</div>

            <?php
                /**
                * lasa_woo_show_brands hook
                *
                * @hooked the_brands_the_name - 10
                */
                do_action('lasa_woo_show_brands');
            ?>
			<?php
                do_action('lasa_woo_before_shop_loop_item_caption');
            ?>

            <?php lasa_the_product_name(); ?>

            <?php
                /**
                * lasa_after_title_tbay_subtitle hook
                *
                * @hooked lasa_woo_get_subtitle - 0
                */
                do_action('lasa_after_title_tbay_subtitle');
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
                    * lasa_woocommerce_loop_item_rating hook
                    *
                    * @hooked woocommerce_template_loop_rating - 10
                    */
                    do_action('lasa_woocommerce_loop_item_rating');
                ?>
            </div>

            <?php
                do_action('lasa_tbay_variable_product');
            ?>	

            <?php lasa_tbay_stock_flash_sale($flash_sales); ?>
			
			<?php
                do_action('lasa_woo_after_shop_loop_item_caption');
            ?>
		</div>

		
		<?php
            do_action('lasa_woocommerce_after_product_block_grid');
        ?>
    </div>
    
	<?php
        /**
        * Hook: woocommerce_after_shop_loop_item.
        */
        do_action('woocommerce_after_shop_loop_item');
    ?>
</div>
