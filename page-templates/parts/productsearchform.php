<?php if (themename_xptheme_get_config('show_searchform')): ?>

	<?php
        $_id = themename_xptheme_random_key();

        $autocomplete_search 	=  themename_xptheme_get_config('autocomplete_search', true);

        $enable_image 	=  themename_xptheme_get_config('show_search_product_image', true);
        $enable_price 	=  themename_xptheme_get_config('show_search_product_price', true);
        $search_type 	=  themename_xptheme_get_config('search_type', 'product');
        $number 		=  themename_xptheme_get_config('search_max_number_results', 5);
        $minchars 		=  themename_xptheme_get_config('search_min_chars', 3);

        $search_text_categories 		=  themename_xptheme_get_config('search_text_categories', esc_html__('All categories', 'themename'));
        $search_placeholder 			=  themename_xptheme_get_config('search_placeholder', esc_html__('I&rsquo;m shopping for...', 'themename'));
        $button_search 				=  themename_xptheme_get_config('button_search', 'all');
        $button_search_text 		=  themename_xptheme_get_config('button_search_text', 'Search');
        $button_search_icon 		=  themename_xptheme_get_config('button_search_icon', 'xp-icon xp-icon-magnifier');


        $show_count 					= themename_xptheme_get_config('search_count_categories', false);

        $class_active_ajax = ($autocomplete_search) ? 'themename-ajax-search' : '';
    ?>

	<?php $_id = themename_xptheme_random_key(); ?>
	<div class="xptheme-search-form">
		    <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="searchform <?php echo esc_attr($class_active_ajax); ?>" data-thumbnail="<?php echo esc_attr($enable_image); ?>" data-appendto=".search-results-<?php echo esc_attr($_id); ?>" data-price="<?php echo esc_attr($enable_price); ?>" data-minChars="<?php echo esc_attr($minchars) ?>" data-post-type="<?php echo esc_attr($search_type) ?>" data-count="<?php echo esc_attr($number); ?>">
			<div class="form-group">
				<div class="input-group">
					<?php if (themename_xptheme_get_config('search_category')): ?>
						<?php
                            wp_enqueue_style('sumoselect');
                            wp_enqueue_script('jquery-sumoselect');
                        ?>
						<div class="select-category input-group-addon">
							<?php if (class_exists('WooCommerce') && themename_xptheme_get_config('search_type') == 'product') :
                                $args = array(
                                    'show_option_none'   => $search_text_categories,
                                    'show_count' => $show_count,
                                    'hierarchical' => true,
                                    'id' => 'product-cat-'.$_id,
                                    'show_uncategorized' => 0
                                );
                            ?> 
							<?php wc_product_dropdown_categories($args); ?>
							<?php elseif (themename_xptheme_get_config('search_type') == 'post'):
                                $args = array(
                                    'show_option_all' => $search_text_categories,
                                    'show_count' => 1,
                                    'hierarchical' => true,
                                    'show_uncategorized' => 0,
                                    'name' => 'category',
                                    'id' => 'blog-cat-'.$_id,
                                    'class' => 'postform dropdown_product_cat',
                                );
                            ?>
								<?php wp_dropdown_categories($args); ?>
							<?php endif; ?>
                            
                            <div class="select-category-border"></div>
					  	</div>
				  	<?php endif; ?>
				  		<input data-style="right" type="text" placeholder="<?php echo esc_attr($search_placeholder); ?>" name="s" required oninvalid="this.setCustomValidity('<?php esc_attr_e('Enter at least 2 cthemenamecters', 'themename'); ?>')" oninput="setCustomValidity('')" class="xptheme-search form-control input-sm"/>

						<div class="search-results-wrapper">
							<div class="themename-search-results search-results-<?php echo esc_attr($_id); ?>" data-ajaxsearch="<?php echo esc_attr($autocomplete_search) ?>" data-price="<?php echo esc_attr($enable_price); ?>"></div>
						</div>
						<div class="button-group input-group-addon">
							<button type="submit" class="button-search btn btn-sm <?php echo esc_attr($button_search); ?>">
								<?php if (isset($button_search) && $button_search != 'text') : ?>
									<i class="<?php echo esc_attr($button_search_icon); ?>"></i>
								<?php endif; ?>
								<?php if (isset($button_search) && $button_search != 'icon') : ?>
								<span class="text"><?php echo trim($button_search_text); ?></span>
								<?php endif; ?>
							</button>
						</div>

						<input type="hidden" name="post_type" value="<?php echo esc_attr(themename_xptheme_get_config('search_type')); ?>" class="post_type" />
				</div>
				
			</div>
		</form>

	</div>

<?php endif; ?>