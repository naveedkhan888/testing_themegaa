<?php

if (! function_exists('themename_tbay_category')) {
    function themename_tbay_category($post)
    {
        // format
        $post_format = get_post_format();
        echo '<span class="category "> ';
        $cat = wp_get_post_categories($post->ID);
        $k   = count($cat);
        foreach ($cat as $c) {
            $categories = get_category($c);
            $k -= 1;
            if ($k == 0) {
                echo '<a href="' . esc_url(get_category_link($categories->term_id)) . '" class="categories-name"><i class="fa fa-bar-chart"></i>' . esc_html($categories->name) . '</a>';
            } else {
                echo '<a href="' . esc_url(get_category_link($categories->term_id)) . '" class="categories-name"><i class="fa fa-bar-chart"></i>' . esc_html($categories->name) . ', </a>';
            }
        }
        echo '</span>';
    }
}




if (! function_exists('themename_tbay_full_top_meta')) {
    function themename_tbay_full_top_meta($post)
    {
        // format
        $post_format = get_post_format();
        $header_class = $post_format ? '' : 'border-left';
        echo '<header class="entry-header-top ' . esc_attr($header_class) . '">';
        if (!is_single()) {
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        }
        // details
        $id = get_the_author_meta('ID');
        echo '<span class="entry-profile"><span class="col"><span class="entry-author-link"><strong>' . esc_html__('By:', 'themename') . '</strong><span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url($id)) . '" rel="author">' . get_the_author() . '</a></span></span><span class="entry-date"><strong>'. esc_html__('Posted: ', 'themename') .'</strong>' . esc_html(get_the_date('M jS, Y')) . '</span></span></span>';
        // comments
        echo '<span class="entry-categories"><strong>'. esc_html__('In:', 'themename') .'</strong> ';
        $cat = wp_get_post_categories($post->ID);
        $k   = count($cat);
        foreach ($cat as $c) {
            $categories = get_category($c);
            $k -= 1;
            if ($k == 0) {
                echo '<a href="' . esc_url(get_category_link($categories->term_id)) . '" class="categories-name">' . esc_html($categories->name) . '</a>';
            } else {
                echo '<a href="' . esc_url(get_category_link($categories->term_id)) . '" class="categories-name">' . esc_html($categories->name) . ', </a>';
            }
        }
        echo '</span>';
        if (! is_search()) {
            if (! post_password_required() && (comments_open() || get_comments_number())) {
                echo '<span class="entry-comments-link">';
                comments_popup_link('0', '1', '%');
                echo '</span>';
            }
        }
        echo '</header>';
    }
}

if (! function_exists('themename_tbay_post_tags')) {
    function themename_tbay_post_tags()
    {
        $posttags = get_the_tags();
        if ($posttags) {
            echo '<div class="tagcloud"><span class="meta-title">'.esc_html__('Tags: ', 'themename').'</span>';
            $size = count($posttags);
            $space = '';
            $i = 0;
            foreach ($posttags as $tag) {
                echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="tag-item">';
                if (++$i === $size) {
                    $space ='';
                }
                echo trim($tag->name).trim($space);
                echo '</a>';
            }
            echo '</div>';
        }
    }
    add_action('themename_tbay_post_tag_socials', 'themename_tbay_post_tags', 10);
}



if (! function_exists('themename_tbay_post_info_author')) {
    function themename_tbay_post_info_author()
    {

        if(!themename_tbay_get_config('show_blog_author_info', false)) {
            echo '<div class="not-author-info"></div>';
            return;
        }

        global $authordata;
        if ( ! is_object( $authordata ) ) {
            echo '<div class="not-author-info"></div>';
            return;
        }

        if ( themename_redux_framework_activated() ) {
            ?>
        <div class="author-info">
            <div class="avarta">
                <?php echo get_avatar($authordata->ID, 90); ?>
            </div>
            <div class="author-meta">
                <div class="content">
                    <h4 class="name"><?php echo get_the_author(); ?></h4>
                    <p><?php the_author_meta('description', $authordata->ID) ?></p>
                </div>
                <?php
                    printf(
                '<a href="%1$s" title="%2$s" rel="author" class="author-link" >%3$s</a>',
                esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ),
                        /* translators: %s: Author's display name. */
                        esc_attr(get_the_author()),
                esc_html__('All Author Posts', 'themename')
            ); ?>
            </div>
        </div>
        <?php
        }
    }
    add_action('themename_tbay_post_bottom', 'themename_tbay_post_info_author', 20);
}

if (! function_exists('themename_tbay_post_share_box')) {
    function themename_tbay_post_share_box()
    {
        if ( themename_tbay_get_config('enable_code_share',false) && themename_tbay_get_config('show_blog_social_share', true) ) {
            ?>
            <div class="tbay-post-share">
                <span> <?php esc_html_e('Share:', 'themename') ?> </span>
                <?php   
                    $image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                    themename_custom_share_code( get_the_title(), get_permalink(), $image );
                ?>
            </div>
            <?php
        } 
    }
    add_action('themename_tbay_post_tag_socials', 'themename_tbay_post_share_box', 15);
}

if (! function_exists('themename_tbay_post_format_link_helper')) {
    function themename_tbay_post_format_link_helper($content = null, $title = null, $post = null)
    {
        if (! $content) {
            $post = get_post($post);
            $title = $post->post_title;
            $content = $post->post_content;
        }
        $link = themename_tbay_get_first_url_from_string($content);
        if (! empty($link)) {
            $title = '<a href="' . esc_url($link) . '" rel="bookmark">' . $title . '</a>';
            $content = str_replace($link, '', $content);
        } else {
            $pattern = '/^\<a[^>](.*?)>(.*?)<\/a>/i';
            preg_match($pattern, $content, $link);
            if (! empty($link[0]) && ! empty($link[2])) {
                $title = $link[0];
                $content = str_replace($link[0], '', $content);
            } elseif (! empty($link[0]) && ! empty($link[1])) {
                $atts = shortcode_parse_atts($link[1]);
                $target = (! empty($atts['target'])) ? $atts['target'] : '_self';
                $title = (! empty($atts['title'])) ? $atts['title'] : $title;
                $title = '<a href="' . esc_url($atts['href']) . '" rel="bookmark" target="' . $target . '">' . $title . '</a>';
                $content = str_replace($link[0], '', $content);
            } else {
                $title = '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $title . '</a>';
            }
        }
        $out['title'] = '<h2 class="entry-title">' . $title . '</h2>';
        $out['content'] = $content;

        return $out;
    }
}


if (! function_exists('themename_tbay_breadcrumbs')) {
    function themename_tbay_breadcrumbs()
    {
        $delimiter = '';
        $home = esc_html__('Home', 'themename');
        $before = '<li class="active">';
        $after = '</li>';
        $title = '';
        if (!is_front_page() || is_paged()) {
            echo '<ol class="breadcrumb">';

            global $post;
            $homeLink = esc_url(home_url());
            echo '<li><a href="' . esc_url($homeLink) . '" class="active">' . esc_html($home) . '</a> ' . esc_html($delimiter) . '</li> ';

            if (is_home()) {
                echo trim($before) . esc_html__('blog', 'themename') . trim($after);
            }

            if (is_category()) {
                global $wp_query;
                $cat_obj = $wp_query->get_queried_object();
                $thisCat = $cat_obj->term_id;
                $thisCat = get_category($thisCat);
                $parentCat = get_category($thisCat->parent);
                if ($thisCat->parent != 0) {
                    echo(get_category_parents($parentCat, true, ' ' . $delimiter . ' '));
                }
                echo trim($before) . esc_html__('blog', 'themename') . trim($after);
            } elseif (is_day()) {
                echo '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li> ' . esc_html($delimiter) . ' ';
                echo '<li><a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . get_the_time('F') . '</a></li> ' . esc_html($delimiter) . ' ';
                echo trim($before) . get_the_time('d') . trim($after);
            } elseif (is_month()) {
                echo '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li> ' . esc_html($delimiter) . ' ';
                echo trim($before) . get_the_time('F') . trim($after);
            } elseif (is_year()) {
                echo trim($before) . get_the_time('Y') . trim($after);
            } elseif (is_single()  && !is_attachment()) {
                if (get_post_type() != 'post') {
                    $delimiter = '';
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;

                    if( get_post_type() === 'tb_portfolio' ) {
                        echo '<li><a href="' . esc_url(get_permalink(themename_tbay_get_config('page_portfolio'))) .'">' . esc_html($post_type->labels->singular_name) . '</a></li> ' . esc_html($delimiter) . ' ';
                    } else if( !empty($slug['slug']) ) {
                        echo '<li><a href="' . esc_url($homeLink) . '/' . $slug['slug'] . '/">' . esc_html($post_type->labels->singular_name) . '</a></li> ' . esc_html($delimiter) . ' ';
                    }

                    // echo '<li><a href="' . esc_url($homeLink) . '/' . $slug['slug'] . '/">' . esc_html($post_type->labels->singular_name) . '</a></li> ' . esc_html($delimiter) . ' ';

                } else {
                    $delimiter = '';
                    $cat = get_the_category();
                    if( !empty( $cat[0] ) ) {
                        echo '<li>'.get_category_parents($cat[0]->term_id, true, ' ' . $delimiter . ' ').'</li>';
                    }
                }
            } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
                $post_type = get_post_type_object(get_post_type());
                if (is_object($post_type)) {
                    echo trim($before) . esc_html($post_type->labels->singular_name) . trim($after);
                }
            } elseif (is_attachment()) {
                $parent = get_post($post->post_parent);
                $cat = get_the_category($parent->ID);
                if (isset($cat) && !empty($cat)) {
                    $cat_id = $cat[0];
                    echo get_category_parents($cat_id, true, ' ' . $delimiter . ' ');
                }
                echo '<li><a href="' . esc_url(get_permalink($parent->ID)) . '">' . esc_html($parent->post_title) . '</a></li> ' . esc_html($delimiter) . ' ';
                echo trim($before) . get_the_title() . trim($after);
            } elseif (is_page() && !$post->post_parent) {
        
                if( get_post_meta($post->ID, 'tbay_page_hide_title', true) ) {
                    echo trim($before) . get_the_title() . $after;
                } else {
                    echo trim($before) . esc_html__('Page', 'themename') . trim($after);
                }

            } elseif (is_page() && $post->post_parent) {
                $parent_id  = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_post($parent_id);
                    $breadcrumbs[] = '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . get_the_title($page->ID) . '</a></li>';
                    $parent_id  = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach ($breadcrumbs as $crumb) {
                    echo trim($crumb) . ' ' . trim($delimiter) . ' ';
                }

                if( get_post_meta($post->ID, 'tbay_page_hide_title', true) ) {
                    echo trim($before) . get_the_title() . $after;
                } else {
                    echo trim($before) . esc_html__('Page', 'themename') . trim($after);
                }

            } elseif (is_search()) {
                echo trim($before) . esc_html__('Search', 'themename') . trim($after);
            } elseif (is_tag()) {
                echo trim($before) . esc_html__('Tags', 'themename') . trim($after);
            } elseif (is_author()) {
                echo trim($before) . esc_html__('Author', 'themename'). trim($after);
            } elseif (is_404()) {
                echo trim($before) . esc_html__('Error 404', 'themename') . trim($after);
            }

            echo '</ol>';
        }
    }
}

if (! function_exists('themename_tbay_get_title_bottom')) {
    function themename_tbay_get_title_bottom()
    {
        global $post;
        
        $title_bottom = '';

        if (is_home() && !is_front_page()) {
            $title_bottom = esc_html__('Blog', 'themename');
        }

        if (is_category()) {
            $title_bottom = single_cat_title('', false);
        } elseif (is_tag()) {
            $title_bottom = get_the_archive_title();
        } elseif (is_archive()) {
            $title_bottom = get_the_archive_title();
        } elseif (is_search()) {
            $title_bottom = esc_html__('Search results for "', 'themename')  . get_search_query();
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            $title_bottom = esc_html__('Articles posted by "', 'themename') . esc_html($userdata->display_name);
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());
            if (is_object($post_type)) {
                $title_bottom = $post_type->labels->singular_name;
            }
        } elseif ((is_page() && $post->post_parent) || (is_page() && !$post->post_parent) || is_attachment() ) {
            
            if ( !empty(get_the_title()) ) {
                $title_bottom = get_the_title();
            }
            
        } elseif ( is_single() ) {
            $title_bottom = '';
        }

        return $title_bottom;
    }
}

if (! function_exists('themename_tbay_render_breadcrumbs')) {
    function themename_tbay_render_breadcrumbs()
    {
        if( themename_checkout_optimized() || is_attachment() ) return;
        
        global $post;
        $show = true;
        $hide_title = false;
        $img_url = '';
        $style = array();

        $breadcrumbs_layout = themename_tbay_get_config('blog_breadcrumb_layout', 'image');

        if (isset($post->ID) && !empty(get_post_meta($post->ID, 'tbay_page_breadcrumbs_layout', true))) {
            $breadcrumbs_layout = get_post_meta($post->ID, 'tbay_page_breadcrumbs_layout', true);
        }

        if (isset($post->ID) && !empty(get_post_meta($post->ID, 'tbay_page_hide_title', true))) {
            $hide_title = get_post_meta($post->ID, 'tbay_page_hide_title', true);
        }

        if (isset($_GET['breadcrumbs_layout'])) {
            $breadcrumbs_layout = $_GET['breadcrumbs_layout'];
        }

        $title_bottom = themename_tbay_get_title_bottom();

        switch ($breadcrumbs_layout) {
        case 'image':
            $breadcrumbs_class = ' breadcrumbs-image';
            break;

        case 'color':
            $breadcrumbs_class = ' breadcrumbs-color';
            break;

        case 'text':
            $breadcrumbs_class = ' breadcrumbs-text';
            break;

        default: 
            $breadcrumbs_class  = ' breadcrumbs-image';
        } 

       
        if (is_singular('post') || is_category() || is_home() || is_tag() || is_author() || is_day() || is_month() || is_year()  || is_search() || is_singular('tb_portfolio') ) {
            
            $breadcrumb_layout_img = themename_tbay_get_config('blog_breadcrumb_layout_image');
            $breadcrumb_layout_color = themename_tbay_get_config('blog_breadcrumb_layout_color');

            $style = array();
            if ($breadcrumb_layout_color && $breadcrumbs_layout ==='color'  ) {
                $style[] = 'background-color:'.$breadcrumb_layout_color;
            }

            if (isset($breadcrumb_layout_img['url']) && !empty($breadcrumb_layout_img['url']) && $breadcrumbs_layout ==='image') {
                $img_url = $breadcrumb_layout_img['url'];
            }
        }

        $nav = '';


        if ($breadcrumbs_layout !== 'image') {
            if (!themename_tbay_is_home_page()) {
                $breadcrumbs_class .= ' active-nav-right';
            }
            if ( !themename_tbay_is_home_page() && isset($post->ID) && !empty(get_the_title($post->ID) && is_page())) {
                $title_bottom 		= get_the_title($post->ID);
                $breadcrumbs_class .= ' show-title';
            }
            if (is_category() || is_author()) {
                $breadcrumbs_class .= ' show-title';
            }
            if (is_archive()) {
                $breadcrumbs_class .= ' blog';
            }
        }

        if (class_exists('WooCommerce') && (is_edit_account_page() || is_add_payment_method_page() || is_lost_password_page() || is_account_page() || is_view_order_page()) || ( is_page() && $hide_title ) ) {
            $breadcrumbs_class = trim(str_replace('show-title', 'not-show-title', $breadcrumbs_class));
        } 
        $estyle = !empty($style)? ' style="'.implode(";", $style).'"':"";
        
        if ( !themename_redux_framework_activated() ) {
            if (!$hide_title && !themename_tbay_is_home_page() && !empty($title_bottom)) {
                echo '<div class="title-not-breadcrumbs"><div class="container"><h1 class="page-title">'.trim($title_bottom) . '</h1></div></div>';
            }
            return '';
        } 

        if (is_page() && is_object($post)) {
            $show = get_post_meta($post->ID, 'tbay_page_show_breadcrumb', true);

            
            $breadcrumbs_class .= ' '.get_post_meta($post->ID, 'tbay_page_breadcrumbs_text_alignment', true);
            
            if ( isset($show) ) {
                if( !$show ) {
                    if (!$hide_title && !themename_tbay_is_home_page() && !empty($title_bottom)) {
                        echo '<div class="title-not-breadcrumbs"><div class="container"><h1 class="page-title">'. trim($title_bottom) . '</h1></div></div>';
                    }
                    return '';
                } else {

                    $bgimage = get_post_meta($post->ID, 'tbay_page_breadcrumb_image', true);
                    $bgcolor = get_post_meta($post->ID, 'tbay_page_breadcrumb_color', true);
                    if ($bgcolor && $breadcrumbs_layout ==='color') {
                        $style[] = 'background-color:'.$bgcolor;
                    }

                    if ($bgimage  && $breadcrumbs_layout ==='image') {
                        $img_url = wp_get_attachment_url( $bgimage );
                    }
        
                    $estyle = !empty($style)? ' style="'.implode(";", $style).'"':"";
         
                    if ($breadcrumbs_layout !== 'image') {
                        echo '<section id="tbay-breadcrumb" '. trim($estyle).' class="tbay-breadcrumb '.esc_attr($breadcrumbs_class).'"><div class="container"><div class="breadscrumb-inner" >';
                        themename_tbay_breadcrumbs() ;
                        echo ''. trim($nav) . '</div></div></section>'; 

                        if (!$hide_title && !themename_tbay_is_home_page() && !empty($title_bottom)) {
                            echo '<div class="title-not-breadcrumbs"><div class="container"><h1 class="page-title">'. trim($title_bottom) . '</h1></div></div>'; 
                        }
                        return '';
                    } else {
                        echo '<section id="tbay-breadcrumb" '. trim($estyle).' class="tbay-breadcrumb '.esc_attr($breadcrumbs_class).'"><img src="'. esc_url($img_url) .'" class="breadcrumb-img" alt="'. esc_attr__('breadcrumb', 'themename') .'"><div class="container"><div class="breadscrumb-inner"><h1 class="page-title">'. trim($title_bottom) .'</h1>';
                        themename_tbay_breadcrumbs() ;
                        echo ''. trim($nav) .'</div></div></section>';
                    }

                }
            } 
            
        } else { 
            $show = themename_tbay_get_config('show_blog_breadcrumb', false);

            $breadcrumbs_class .= ' '.themename_tbay_get_config('blog_breadcrumb_text_alignment', true);
            if ($show || !empty($title_bottom)) {
                echo '<section id="tbay-breadcrumb-blog" '. trim($estyle).' class="tbay-breadcrumb '.esc_attr($breadcrumbs_class).'">'; 

                if( !empty($img_url) ) {
                    echo '<img src="' . esc_url($img_url) . '" class="breadcrumb-img" alt="' . esc_attr__('breadcrumb', 'themename') . '">';
                }

                echo '<div class="container"><div class="breadscrumb-inner" >';

                if ($breadcrumbs_layout === 'image') {
                    echo '<h1 class="page-title">'. trim($title_bottom) .'</h1>';
                }
                
                if ( $show ) {
                    themename_tbay_breadcrumbs();
                } 
                
                echo ''. trim($nav) .'</div></div></section>';
                 
                if ($breadcrumbs_layout !== 'image' && !empty($title_bottom) ) {
                    echo '<section id="tbay-breadscrumb-title"><div class="container"><h1 class="page-title">'. trim($title_bottom) .'</h1></div></section>';
                }
            } 
            

        }
    }
}

if (! function_exists('themename_tbay_paging_nav')) {
    function themename_tbay_paging_nav()
    {
        global $wp_query, $wp_rewrite;

        if ($wp_query->max_num_pages < 2) {
            return;
        }

        $paged        = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
        $pagenum_link = html_entity_decode(get_pagenum_link());
        $query_args   = array();
        $url_parts    = explode('?', $pagenum_link);

        if (isset($url_parts[1])) {
            wp_parse_str($url_parts[1], $query_args);
        }

        $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
        $pagenum_link = trailingslashit($pagenum_link) . '%_%';

        $format  = $wp_rewrite->using_index_permalinks() && ! strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged') : '?paged=%#%';

        // Set up paginated links.
        $links = paginate_links(array(
            'base'     => $pagenum_link,
            'format'   => $format,
            'total'    => $wp_query->max_num_pages,
            'current'  => $paged,
            'mid_size' => 1,
            'add_args' => array_map('urlencode', $query_args),
            'prev_text' => '<i class="tb-icon tb-icon-arrow-left"></i>',
            'next_text' => '<i class="tb-icon tb-icon-arrow-right"></i>'
        ));

        if ($links) :

        ?>
		<nav class="navigation paging-navigation">
			<h5 class="screen-reader-text hidden"><?php esc_html_e('Posts navigation', 'themename'); ?></h5>
			<div class="tbay-pagination">
				<?php echo trim($links); ?>
			</div><!-- .pagination -->
		</nav><!-- .navigation -->
		<?php
        endif;
    }
}


if (! function_exists('themename_tbay_post_nav')) {
    function themename_tbay_post_nav()
    {
        // Don't print empty markup if there's nowhere to navigate.
        $previous = (is_attachment()) ? get_post(get_post()->post_parent) : get_adjacent_post(false, '', true);
        $next     = get_adjacent_post(false, '', false);

        if (! $next && ! $previous) {
            return;
        }
        $prevPost   = get_previous_post();
        $nextPost   = get_next_post();
        

        $cat_prevPost = $cat_nextPost = '';
        if (is_object($prevPost)) {
            $prevthumbnail = get_the_post_thumbnail($prevPost->ID, 'themename_avatar_post_carousel');
            $cat_prevPost = ( !empty(get_the_category($prevPost->ID)[0]->name) ) ? get_the_category($prevPost->ID)[0]->name : '';  
        }
        if (is_object($nextPost)) {
            $nextthumbnail = get_the_post_thumbnail($nextPost->ID, 'themename_avatar_post_carousel');
            $cat_nextPost =  (!empty(get_the_category($nextPost->ID)[0]->name)) ? get_the_category($nextPost->ID)[0]->name : '';  
        } 
        
        ?>
		<nav class="navigation post-navigation">
			<h3 class="screen-reader-text"><?php esc_html_e('Post navigation', 'themename'); ?></h3>
			<div class="nav-links clearfix">
				<?php
                if (is_attachment()) :
                    previous_post_link('%link', '<div class="col-lg-6"><span class="meta-nav">'. esc_html__('Published In', 'themename').'</span></div>'); else :
                    if (isset($prevthumbnail)) {
                        previous_post_link('%link', '<div class="media"><div class="wrapper-title-meta media-body">'.'<span class="meta-nav nav-previous">'. $cat_prevPost.'</span><span class="post-title">%title</span></div></div>');
                    }
        if (isset($nextthumbnail)) {  
            next_post_link('%link', '<div class="media"><div class="wrapper-title-meta media-body">'.'<span class="meta-nav nav-next">' . $cat_nextPost.'</span><span class="post-title">%title</span></div></div>');
        }
        endif; ?>
			</div><!-- .nav-links --> 
		</nav><!-- .navigation -->
		<?php
    }
}
 
if (!function_exists('themename_tbay_pagination')) {
    function themename_tbay_pagination($per_page, $total, $max_num_pages = '')
    {
        global $wp_query, $wp_rewrite; ?>
        <div class="tbay-pagination">
        	<?php
            $prev = esc_html__('Previous', 'themename');
        $next = esc_html__('Next', 'themename');
        $pages = $max_num_pages;
        $args = array('class'=>'pull-left');

        $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
        if (empty($pages)) {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }
        }
        $pagination = array(
                'base' => @add_query_arg('paged', '%#%'),
                'format' => '',
                'total' => $pages,
                'current' => $current,
                'prev_text' => $prev,
                'next_text' => $next,
                'type' => 'array'
            );

        if ($wp_rewrite->using_permalinks()) {
            $pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%/', 'paged');
        }
            
        if (isset($_GET['s'])) {
            $cq = $_GET['s'];
            $sq = str_replace(" ", "+", $cq);
        }
            
        if (!empty($wp_query->query_vars['s'])) {
            $pagination['add_args'] = array( 's' => $sq);
        }
        $paginations = paginate_links($pagination);
        if (!empty($paginations)) {
            echo '<ul class="pagination '. esc_attr($args["class"]) .'">';
            foreach ($paginations as $key => $pg) {
                echo '<li>'. esc_html($pg) .'</li>';
            }
            echo '</ul>';
        } ?>
            
        </div>
    <?php
    }
}

if (!function_exists('themename_tbay_comment_form')) {
    function themename_tbay_comment_form($arg, $class = 'btn-primary btn-outline ')
    {
        global $post;
        if ('open' == $post->comment_status) {
            ob_start();
            comment_form($arg);
            $form = ob_get_clean(); ?>
	      	<div class="commentform reset-button-default">
		    	<?php
                  echo str_replace('id="submit"', 'id="submit"', $form); ?>
	      	</div>
	      	<?php
        }
    }
}

if (!function_exists('themename_tbay_display_header_builder')) {
    function themename_tbay_display_header_builder()
    {
        echo themename_get_display_header_builder();
    }
}

if (!function_exists('themename_get_elementor_css_print_method')) {
    function themename_get_elementor_css_print_method()
    {
        if ('internal' !== get_option('elementor_css_print_method')) {
            return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('themename_get_header_id')) {
    function themename_get_header_id()
    {
        $header 	= apply_filters('themename_tbay_get_header_layout', 'default');

        $args = array(
            'name'		 => $header,
            'post_type'   => 'tbay_custom_post',
            'post_status' => 'publish',
            'numberposts' => 1
        );
 
        $posts = get_posts($args);

        return  ( !empty($posts[0]->ID) ) ? $posts[0]->ID : '';
    }
}

if (!function_exists('themename_get_display_header_builder')) {
    function themename_get_display_header_builder()
    {
        $id = themename_get_header_id();
        
        return  themename_get_html_custom_post($id);
    }
}

if (!function_exists('themename_get_footer_id')) {
    function themename_get_footer_id()
    {
        $footer     = apply_filters('themename_tbay_get_footer_layout', 'footer_default');

        $args = array(
            'name'        => $footer,
            'post_type'   => 'tbay_custom_post',
            'post_status' => 'publish',
            'numberposts' => 1
        );

        $posts = get_posts($args);

        return  ( !empty($posts[0]->ID) ) ? $posts[0]->ID : '';
    }
}

if (!function_exists('themename_get_display_footer_builder')) {
    function themename_get_display_footer_builder()
    {
        $id = themename_get_footer_id();
        
        return  themename_get_html_custom_post($id);
    }
}

if( ! function_exists( 'themename_get_html_custom_post' ) ) {
	function themename_get_html_custom_post($id) {
        if( is_null($id) || empty($id) ) return;
        $post = get_post( $id );

        if ( themename_elementor_activated() && Elementor\Plugin::instance()->documents->get( $id )->is_built_with_elementor() ) {
            return Elementor\Plugin::instance()->frontend->get_builder_content_for_display($id);
        } else {
            return do_shortcode($post->post_content);
        }
	}

}

if (!function_exists('themename_tbay_display_footer_builder')) {
    function themename_tbay_display_footer_builder()
    {
        echo themename_get_display_footer_builder();
    }
}

if (!function_exists('themename_tbay_get_random_blog_cat')) {
    function themename_tbay_get_random_blog_cat()
    {
        $post_category = "";
        $categories = get_the_category();

        $number = rand(0, count($categories) - 1);

        if ($categories) {
            $post_category .= '<a href="'.esc_url(get_category_link($categories[$number]->term_id)).'" title="' . esc_attr(sprintf(esc_html__("View all posts in %s", 'themename'), $categories[$number]->name)) . '">'.$categories[$number]->cat_name.'</a>';
        }

        echo trim($post_category);
    }
}

if (!function_exists('themename_tbay_get_id_author_post')) {
    function themename_tbay_get_id_author_post()
    {
        global $post;

        $author_id = $post->post_author;

        if (isset($author_id)) {
            return $author_id;
        }
    }
}


if (! function_exists('themename_active_mobile_footer_icon')) {
    function themename_active_mobile_footer_icon()
    {
        $active = themename_tbay_get_config('mobile_footer_icon', true);

        if ($active) {
            return true;
        } else {
            return false;
        }
    }
}



if (! function_exists('themename_body_class_mobile_footer')) {
    function themename_body_class_mobile_footer($classes)
    {
        $mobile_footer = themename_tbay_get_config('mobile_footer', true);

        if (isset($mobile_footer) && !$mobile_footer) {
            $classes[] = 'mbhd-ft-desktop';
        } else {
            $classes[] = 'mb-ft-desktop';
        } 

        if (!themename_active_mobile_footer_icon()) {
            $classes[] = 'mbhd-ft-icon';
        } else {
            $classes[] = 'mb-ft-icon';
        }

        return $classes;
    }
    add_filter('body_class', 'themename_body_class_mobile_footer', 99);
}

if (!function_exists('themename_tbay_comment_form_fields_open')) {
    function themename_move_comment_field_to_bottom( $fields ) {
        $comment_field = $fields['comment'];
        $comment_cookies = $fields['cookies'];
        unset( $fields['comment'] );
        unset( $fields['cookies'] );

        $fields['comment'] = $comment_field;
        $fields['cookies'] = $comment_cookies;
        
        return $fields;
    }
    add_filter( 'comment_form_fields', 'themename_move_comment_field_to_bottom', 10, 1 );
}


//Add div wrapper author and name in comment form
if (!function_exists('themename_tbay_comment_form_fields_open')) {
    function themename_tbay_comment_form_fields_open()
    {
        echo '<div class="comment-form-fields-wrapper">';
    }
}
if (!function_exists('themename_tbay_comment_form_fields_close')) {
    function themename_tbay_comment_form_fields_close()
    {
        echo '</div>';
    }
}
add_action('comment_form_before_fields', 'themename_tbay_comment_form_fields_open');
add_action('comment_form_after_fields', 'themename_tbay_comment_form_fields_close');

if (!function_exists('themename_the_post_category_full')) {
    function themename_the_post_category_full($has_separator = false)
    {
        $post_category = "";
        $categories = get_the_category();
        $separator = ($has_separator) ?  ',' : '';
        $output = '';
        if ($categories) {
            foreach ($categories as $category) {
                $output .= '<a href="'.esc_url(get_category_link($category->term_id)).'" title="' . esc_attr(sprintf(esc_html__('View all posts in %s', 'themename'), $category->name)) . '">'.$category->cat_name.'</a>'.$separator;
            }
            $post_category = trim($output, $separator);
        }

        echo trim($post_category);
    }
}

//Check active WPML
if (!function_exists('themename_tbay_wpml')) {
    function themename_tbay_wpml()
    {
        if (is_active_sidebar('wpml-sidebar')) {
            dynamic_sidebar('wpml-sidebar');
        }
    }

    add_action('themename_tbay_header_custom_language', 'themename_tbay_wpml', 10);
}

//Config Layout Blog
if (!function_exists('themename_tbay_get_blog_layout_configs')) {
    function themename_tbay_get_blog_layout_configs()
    {
        if (!is_singular('post')) {
            $page = 'blog_archive_sidebar';
        } else {
            $page = 'blog_single_sidebar';
        }

        $sidebar = themename_tbay_get_config($page);



        if (!is_singular('post')) {
            $blog_archive_layout =  (isset($_GET['blog_archive_layout']))  ? $_GET['blog_archive_layout'] : themename_tbay_get_config('blog_archive_layout', 'main-right');

            if (isset($blog_archive_layout)) {
                switch ($blog_archive_layout) {
                    case 'left-main':
                        $configs['sidebar'] = array( 'id' => $sidebar, 'class' => 'col-12 col-xl-3'  );
                        $configs['main'] = array( 'class' => 'col-xl-9' );
                        break;
                    case 'main-right':
                        $configs['sidebar'] = array( 'id' => $sidebar,  'class' => 'col-12 col-xl-3' );
                        $configs['main'] = array( 'class' => 'col-xl-9' );
                        break;
                    case 'main':
                        $configs['main'] = array( 'class' => 'content-full' );
                        break;
                    default:
                        $configs['main'] = array( 'class' => 'content-full' );
                        break;
                   }

                if (($blog_archive_layout === 'left-main' ||  $blog_archive_layout === 'main-right') && (empty($configs['sidebar']['id']) || !is_active_sidebar($configs['sidebar']['id']))) {
                    $configs['main'] = array( 'class' => '' );
                }
            }
        } else {
            $blog_single_layout =	(isset($_GET['blog_single_layout'])) ? $_GET['blog_single_layout']  :  themename_tbay_get_config('blog_single_layout', 'left-main');

            if (isset($blog_single_layout)) {
                switch ($blog_single_layout) {
                        case 'left-main':
                            $configs['sidebar'] = array( 'id' => $sidebar, 'class' => 'col-12 col-xl-3'  );
                            $configs['main'] = array( 'class' => 'col-xl-9' );
                            break;
                        case 'main-right':
                            $configs['sidebar'] = array( 'id' => $sidebar,  'class' => 'col-12 col-xl-3' );
                            $configs['main'] = array( 'class' => 'col-xl-9' );
                            break;
                        case 'main':
                            $configs['main'] = array( 'class' => 'single-full' );
                            break;
                        default:
                            $configs['main'] = array( 'class' => 'single-full' );
                            break; 
                     }

                if (($blog_single_layout === 'left-main' ||  $blog_single_layout === 'main-right') && (empty($configs['sidebar']['id']) || !is_active_sidebar($configs['sidebar']['id']))) {
                    $configs['main'] = array( 'class' => '' );
                }
            }
        }


        return $configs;
    }
}

if (! function_exists('themename_tbay_add_bg_close_canvas_menu')) {
    function themename_tbay_add_bg_close_canvas_menu()
    {
        $sidebar_id = 'canvas-menu';
        if (!is_active_sidebar($sidebar_id)) {
            return;
        } ?>
			<div class="bg-close-canvas-menu"></div>
 			<div class="sidebar-content-wrapper">

				<div class="sidebar-header">
					<a href="javascript:void(0);" class="close-canvas-menu"><?php esc_html_e('Close', 'themename'); ?><i class="tb-icon tb-icon-close-01"></i></a>
				</div>

				<div class="sidebar-content">
					<?php dynamic_sidebar($sidebar_id); ?>
				</div>

			</div>
		<?php
    }
    add_action('wp_footer', 'themename_tbay_add_bg_close_canvas_menu');
}


if (! function_exists('themename_tbay_nav_description')) {
    /**
     * Display descriptions in main navigation.
     *
     * @since Themename 1.0
     *
     * @param string  $item_output The menu item output.
     * @param WP_Post $item        Menu item object.
     * @param int     $depth       Depth of the menu.
     * @param array   $args        wp_nav_menu() arguments.
     * @return string Menu item with possible description.
     */
    function themename_tbay_nav_description($item_output, $item, $depth, $args)
    {
        if ('primary' == $args->theme_location && $item->description) {
            $item_output = str_replace($args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output);
        }

        return $item_output;
    }
    add_filter('walker_nav_menu_start_el', 'themename_tbay_nav_description', 10, 4);
}


if (! function_exists('themename_add_class_wrapper_container')) {
    function themename_add_class_wrapper_container($class_ar)
    {
        $class_ar     = explode(', ', $class_ar);

        $class         = join(' ', $class_ar);

        return $class;
    }
    add_filter('themename_class_wrapper_container', 'themename_add_class_wrapper_container', 10, 1);
}

if (! function_exists('themename_tbay_woocs_redraw_cart')) {
    function themename_tbay_woocs_redraw_cart()
    {
        return 0;
    }
    add_filter('woocs_redraw_cart', 'themename_tbay_woocs_redraw_cart', 10, 1);
}

if( ! function_exists('themename_load_html_dropdowns_action') ) {
	function themename_load_html_dropdowns_action() {
        check_ajax_referer( 'themename-megamenu-nonce', 'security' );

		$response = array(
			'status' => 'error',
			'message' => 'Can\'t load HTML blocks with AJAX',
			'data' => array(),
		);


		if( isset( $_POST['ids'] ) && is_array( $_POST['ids'] ) ) {
			$ids = themename_clean( $_POST['ids'] );
			foreach ($ids as $id) {
				$id = (int) $id;

                $content = themename_get_html_custom_post($id);

				if( ! $content ) continue;

				$response['status'] = 'success';
				$response['message'] = esc_html__( 'At least one HTML block loaded', 'themename' );
				$response['data'][$id] = $content;
			}
		}

		echo json_encode($response);

		die();
	}
	add_action( 'wp_ajax_themename_load_html_dropdowns', 'themename_load_html_dropdowns_action' );
	add_action( 'wp_ajax_nopriv_themename_load_html_dropdowns', 'themename_load_html_dropdowns_action' );
}

if( ! function_exists('themename_load_html_click_action') ) {
	function themename_load_html_click_action() {
        check_ajax_referer( 'themename-menuclick-nonce', 'security' );

		$response = array(
			'status' => 'error',
			'message' => 'Can\'t load HTML blocks with AJAX',
			'data' => array(),
		);
   

		if( ! empty( $_POST['slug'] ) ) {
			$slug 			= themename_clean( $_POST['slug'] );
			$layout 		= themename_clean( $_POST['layout'] );

            $args = [
                'echo'        => false,
                'menu'        => $slug, 
                'container_class' => 'collapse navbar-collapse',
                'menu_id'     => 'menu-' . $slug,
                'walker'      => new Themename_Megamenu_Walker(),
                'fallback_cb' => '__return_empty_string',
                'container'   => '', 
            ];    

			$args['menu_class'] = themename_nav_menu_get_menu_class($layout);


            $content = wp_nav_menu($args);     

            $response['status']     = 'success';
            $response['message']    = esc_html__('At least one HTML Menu Canvas loaded', 'themename');
            $response['data']       = $content;
		}

		echo json_encode($response);

		die();
	}
	add_action( 'wp_ajax_themename_load_html_click', 'themename_load_html_click_action' );
	add_action( 'wp_ajax_nopriv_themename_load_html_click', 'themename_load_html_click_action' );
}


if( ! function_exists('themename_load_html_canvas_template') ) {
	function themename_load_html_canvas_template() {
        check_ajax_referer( 'themename-menuclick-nonce', 'security' );
        
		$response = array(
			'status' => 'error',
			'message' => 'Can\'t load HTML blocks with AJAX',
			'data' => array(),
		);
     

		if( !empty( $_POST['id'] ) ) {
			$template_id = (int) themename_clean( $_POST['id'] );
			$content = themename_get_html_custom_post($template_id);

            $response['status']     = 'success';
            $response['message']    = esc_html__('At least one HTML Template Canvas loaded', 'themename');
            $response['data']       = $content;
		}  

		echo json_encode($response); 

		die();
	}
	add_action( 'wp_ajax_themename_load_html_canvas_template_click', 'themename_load_html_canvas_template' );
	add_action( 'wp_ajax_nopriv_themename_load_html_canvas_template_click', 'themename_load_html_canvas_template' );
}

if ( ! function_exists( 'themename_get_social_html' ) ) {
	function themename_get_social_html($key, $value, $title, $link, $media) {
		if( !$value ) return;

		switch ($key) {
			case 'facebook':
				$output = sprintf(
					'<a class="share-facebook tbay-facebook" title="%s" href="http://www.facebook.com/sharer.php?u=%s&t=%s" target="_blank"><i class="fa fa-facebook"></i></a>',
					esc_attr( $title ),
					urlencode( $link ),
					urlencode( $title )
				);
				break;			
			case 'twitter':
				$output = sprintf(
					'<a class="share-twitter tbay-twitter" href="http://twitter.com/share?text=%s&url=%s" title="%s" target="_blank"><i class="fa fa-twitter"></i></a>',
					esc_attr( $title ),
					urlencode( $link ),
					urlencode( $title )
				);
				break;			
			case 'linkedin':
				$output = sprintf(
					'<a class="share-linkedin tbay-linkedin" href="http://www.linkedin.com/shareArticle?url=%s&title=%s" title="%s" target="_blank"><i class="fa fa-linkedin"></i></a>',
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
				break;			

			case 'pinterest':
				$output = sprintf(
					'<a class="share-pinterest tbay-pinterest" href="http://pinterest.com/pin/create/button?media=%s&url=%s&description=%s" title="%s" target="_blank"><i class="fa fa-pinterest-p"></i></a>',
					urlencode( $media ),
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
				break;			

			case 'whatsapp':
				$output = sprintf(
					'<a class="share-whatsapp tbay-whatsapp" href="https://api.whatsapp.com/send?text=%s" title="%s" target="_blank"><i class="fa fa-whatsapp"></i></a>',
					urlencode( $link ),
					esc_attr( $title )
				);
				break;

			case 'email':
				$output = sprintf(
					'<a class="share-email tbay-email" href="mailto:?subject=%s&body=%s" title="%s" target="_blank"><i class="fa fa-envelope-o"></i></a>',
					esc_html( $title ),
					urlencode( $link ),
					esc_attr( $title )
				);
				break;
			
			default:
				# code...
				break;
		}

		return $output;
	}
}

if ( ! function_exists( 'themename_custom_share_code' ) ) {
	function themename_custom_share_code( $title, $link, $media ) {
		if( !themename_tbay_get_config('enable_code_share', true) ) return; 
		$socials = themename_tbay_get_config('sortable_sharing');

		$socials_html = '';
		foreach ($socials as $key => $value) {
			$socials_html .= themename_get_social_html($key, $value, $title, $link, $media);
		}


		if ( $socials_html ) {
			$socials_html = apply_filters('themename_addons_share_link_socials', $socials_html);
			printf( '<div class="tbay-social-links">%s</div>', $socials_html );
		}

	}
}

if ( ! function_exists( 'themename_get_elementor_post_scripts' ) ) {
    function themename_get_elementor_post_scripts() {
        if( !themename_elementor_activated() ) return;
        
        if ( class_exists( '\Elementor\Plugin' ) ) {
            $elementor = \Elementor\Plugin::instance();
            $elementor->frontend->enqueue_styles();
        }
    
        if ( class_exists( '\ElementorPro\Plugin' ) ) {
            $elementor_pro = \ElementorPro\Plugin::instance();
            $elementor_pro->enqueue_styles();
        }    
        
        if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
            $css_file = new \Elementor\Core\Files\CSS\Post( themename_get_header_id() );
        } elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
            $css_file = new \Elementor\Post_CSS_File( themename_get_header_id() );
        }
    
        $css_file->enqueue();        

        if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
            $css_file = new \Elementor\Core\Files\CSS\Post( themename_get_footer_id() );
        } elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
            $css_file = new \Elementor\Post_CSS_File( themename_get_footer_id() );
        }
    
        $css_file->enqueue();
    }
} 

if ( !function_exists('themename_tbay_back_to_top') ) {
    function themename_tbay_back_to_top(){
        if (themename_tbay_get_config('back_to_top')) { ?>
            <div class="tbay-to-top">
                <a href="javascript:void(0);" id="back-to-top">
                    <i class="tb-icon tb-icon-arrow-top"></i>
                </a>
            </div>
        <?php
        } 
        ?>
    
        <?php
        if (themename_tbay_get_config('mobile_back_to_top')) { ?>
            <div class="tbay-to-top-mobile tbay-to-top">
    
                <div class="more-to-top">
                    <a href="javascript:void(0);" id="back-to-top-mobile">
                        <i class="tb-icon tb-icon-arrow-top"></i>
                    </a> 
                    
                </div>
            </div>
            
        <?php
        }
    } 
    add_action('elementor/theme/after_do_footer', 'themename_tbay_back_to_top', 10);
    add_action('themename_after_do_footer', 'themename_tbay_back_to_top', 10);
}

if (!function_exists('themename_customize_wp_list_categories')) {
    function themename_customize_wp_list_categories($output, $args)
    { 
        $pattern = '#<li([^>]*)><a([^>]*)>(.*?)<\/a>\s*\(([0-9]*)\)\s*#i';
        $replacement = '<li$1><a$2><span class="cat-name">$3</span> <span class="cat-count">$4</span></a>';
        echo preg_replace( $pattern, $replacement, $output );
    }
    add_filter('wp_list_categories', 'themename_customize_wp_list_categories', 10, 2);
}


if (!function_exists('themename_logout_without_confirm')) {
    add_action('check_admin_referer', 'themename_logout_without_confirm', 10, 2);
    function themename_logout_without_confirm($action, $result)
    {
        /**
         * Allow logout without confirmation
         */
        if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
            $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : home_url();
            $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));
            header("Location: $location");
            die;
        }
    }
}