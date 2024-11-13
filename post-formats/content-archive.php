<?php
/**
 *
 * The default template for displaying content archive
 * @since 1.0
 * @version 1.2.0
 *
 */
$date 						= themename_tbay_get_boolean_query_var('enable_date');
$author 					= themename_tbay_get_boolean_query_var('enable_author');
$categories 				= themename_tbay_get_boolean_query_var('enable_categories');
$short_descriptions 		= themename_tbay_get_boolean_query_var('enable_short_descriptions');
$read_more 					= themename_tbay_get_boolean_query_var('enable_readmore');
$comment					= themename_tbay_get_boolean_query_var('enable_comment');
$comment_text				= themename_tbay_get_boolean_query_var('enable_comment_text');

$layout_blog   			= apply_filters('themename_archive_layout_blog', 10, 2);

$class_main = $class_left = '';
?>


<div  class="post clearfix <?php echo esc_attr($layout_blog); ?>">
    <article id="post-archive-<?php the_ID(); ?>" <?php post_class($class_main); ?>>
        <?php
            if (has_post_thumbnail()) {
                ?>
                <figure class="entry-thumb <?php echo esc_attr($class_left); ?> <?php echo(!has_post_thumbnail() ? 'no-thumb' : ''); ?>">
                    <?php themename_tbay_post_thumbnail(); ?>
                </figure>
            <?php } ?>
        <div class="entry-content <?php echo esc_attr($class_left); ?> <?php echo (!has_post_thumbnail()) ? 'no-thumb' : ''; ?>">

            <div class="entry-header">		

                <?php if (get_the_category_list() && $categories == 1): ?>
                        <div class="entry-category no-thumb"><?php themename_the_post_category_full() ?></div>
                <?php endif; ?>

                
                <?php if ($author): ?>
                    <div class="entry-author">
                        <i class="tb-icon tb-icon-profile"></i>
                        <span><?php esc_html_e('By ', 'themename'); ?></span> <?php echo get_the_author_posts_link(); ?>
                    </div>
                <?php endif ?>
                

                <?php themename_post_archive_the_title(); ?>

                <?php themename_post_meta(array( 
                    'author'     => 0,
                    'date'     => $date, 
                    'tags'     => 0,
                    'comments' 		=> $comment, 
                    'comments_text' 		=> $comment_text,
                    'edit'     => 0, 
                )); ?>


                <?php if ($short_descriptions) : ?>
                    <?php themename_post_archive_the_short_description(); ?>
                <?php endif; ?>

                <?php if ($read_more) : ?>
                    <?php themename_post_archive_the_read_more(); ?>
                <?php endif; ?>

            </div>

        </div>
    </article>
</div>