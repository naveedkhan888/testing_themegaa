<?php
$style           = isset($style) ? $style : 'post-style-1';
$thumbsize       = isset($thumbnail_size_size) ? $thumbnail_size_size : 'full';
$show_title      = themename_switcher_to_boolean($show_title); ;
$show_category   = themename_switcher_to_boolean($show_category);
$show_author     =  themename_switcher_to_boolean($show_author);
$show_date       =  themename_switcher_to_boolean($show_date);
$show_comments   =  themename_switcher_to_boolean($show_comments);
$show_comments_text   =  themename_switcher_to_boolean($show_comments_text);
$post_title_tag       = isset($post_title_tag) ? $post_title_tag : 'h3';
$show_excerpt    =  themename_switcher_to_boolean($show_excerpt);
$excerpt_length  = isset($excerpt_length) ? $excerpt_length : 15;
$show_read_more  =  themename_switcher_to_boolean($show_read_more);
$read_more_text  = isset($read_more_text) ? $read_more_text : esc_html__('Continue Reading', 'themename');


$text_domain               = esc_html__(' comments', 'themename');
if (get_comments_number() == 1) {
    $text_domain = esc_html__(' comment', 'themename');
}

?>
<article class="post item-post <?php echo esc_attr($style); ?>">   
    <?php
        if (has_post_thumbnail()) {
            ?>
            <figure class="entry-thumb <?php echo(!has_post_thumbnail() ? 'no-thumb' : ''); ?>">
                <a href="<?php the_permalink(); ?>"  class="entry-image">
                <?php
                    if (themename_elementor_activated()) {
                        the_post_thumbnail($thumbsize);
                    } else {
                        the_post_thumbnail();
                    }
                ?>
                </a> 
            </figure>
            <?php
        } ?>
    
    
    <div class="entry-header">

        <?php if (get_the_category_list() && $show_category == 1): ?>
                <div class="entry-category no-thumb"><?php themename_the_post_category_full() ?></div>
        <?php endif; ?>

        
        <?php if ($show_author): ?>
            <div class="entry-author">
                <i class="tb-icon tb-icon-profile"></i>
                <span><?php esc_html_e('By ', 'themename'); ?></span> <?php echo get_the_author_posts_link(); ?>
            </div>
        <?php endif ?>
        

        <?php if ($show_title && get_the_title()) : ?>
            <<?php echo trim($post_title_tag); ?> class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </<?php echo trim($post_title_tag); ?>>
        <?php endif; ?>


        <?php themename_post_meta(array(
            'author'     => 0,
            'date'     => $show_date,
            'tags'     => 0,
            'comments' 		=> $show_comments,
            'comments_text' 		=> $show_comments_text,
            'edit'     => 0,
        )); ?>

        <?php do_action('themename_blog_before_meta_list'); ?>

        <?php if ($show_excerpt) : ?>
            <div class="entry-description"><?php echo themename_tbay_substring(get_the_excerpt(), $excerpt_length, '...'); ?></div>
        <?php endif; ?>

        <?php 
            if ($show_read_more) {
                themename_post_archive_the_read_more($read_more_text);
            } 
        ?>

        <?php do_action('themename_blog_after_meta_list'); ?>
    </div>
</article>
