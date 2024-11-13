<?php

    wp_enqueue_script('slick');
    wp_enqueue_script('themename-custom-slick');
    
    $relate_count = themename_tbay_get_config('number_blog_releated', 2);
    $relate_columns = themename_tbay_get_config('releated_blog_columns', 2);
    $terms = get_the_terms(get_the_ID(), 'category');
    $termids =array();
    $nav_type = 'yes';
    $pagi_type = 'no';
    if ($terms) {
        foreach ($terms as $term) {
            $termids[] = $term->term_id;
        }
    }

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $relate_count,
        'post__not_in' => array( get_the_ID() ),
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'category',
                'field' => 'id',
                'terms' => $termids,
                'operator' => 'IN'
            )
        )
    );

    $relates = new WP_Query($args);


    if ($relates->have_posts()):
    
?>
    <div class="tbay-addon tbay-addon-blog relate-blog">
        <h4 class="tbay-addon-title">
            <span><?php esc_html_e('Related posts', 'themename'); ?></span>
        </h4>

        <div class="tbay-addon-content">
            <?php $class_column = 12/$relate_columns; ?>
            <?php

                $nav_type   = ($nav_type == 'yes') ? 'true' : 'false';
                $pagi_type  = ($pagi_type == 'yes') ? 'true' : 'false';

                $navleft    = apply_filters('themename_slick_prev', '<i class="tb-icon tb-icon-arrow-left-2"></i>');
                $navright   = apply_filters('themename_slick_next', '<i class="tb-icon tb-icon-arrow-right-2"></i>');

            ?>
            <div class="owl-carousel rows-1" data-carousel="owl" data-navleft="<?php echo esc_attr($navleft); ?>" data-navright="<?php echo esc_attr($navright); ?>" data-items="<?php echo esc_attr($relate_columns); ?>" data-nav="<?php echo esc_attr($nav_type); ?>" data-pagination="<?php echo esc_attr($pagi_type); ?>" data-desktopslick="<?php echo esc_attr($relate_columns); ?>" data-desktopsmallslick="<?php echo esc_attr($relate_columns); ?>" data-tabletslick="2" data-landscapeslick="2" data-mobileslick="1">
            <?php
                while ($relates->have_posts()) : $relates->the_post();
                    ?>
                    <div class="item">
                        <?php get_template_part('post-formats/content-archive'); ?>
                    </div>
                    <?php
                endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
        
    </div>
<?php endif; ?>