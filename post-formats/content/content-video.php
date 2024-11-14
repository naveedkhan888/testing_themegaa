<?php
/**
 *
 * The default template for displaying content
 * @since 1.0
 * @version 1.2.0
 *
 */
$class_main = $class_left = '';

$videolink =  get_post_meta(get_the_ID(), 'xptheme_post_video_link', true);

if (!(isset($videolink) && $videolink)) {
    $content = apply_filters('the_content', get_the_content());
    $video = false;

    // Only get video from the content if a playlist isn't present.
    if (false === strpos($content, 'wp-playlist-script')) {
        $video = get_media_embedded_in_content($content, array( 'video', 'object', 'embed', 'iframe' ));
    }
}

?>
<div class="entry-single">
  <article id="post-<?php the_ID(); ?>" <?php post_class($class_main); ?>>
	<?php echo themename_xptheme_post_media(get_the_excerpt()); ?>
    <?php $class_image = ($videolink) ? 'post-preview' : ''; ?>
        <?php
            if ($videolink || has_post_thumbnail()) {
                ?>
                    <div class="content-image <?php echo esc_attr($class_image); ?>">
                        <?php if ($videolink) : ?>
                            <div class="video-thumb video-responsive"><?php echo wp_oembed_get($videolink); ?></div>
                        <?php elseif (has_post_thumbnail()) : ?>
                            <?php themename_xptheme_post_thumbnail(); ?>
                        <?php endif; ?>
                    </div>
                <?php
            }
        ?>

        <?php if (get_the_category_list()): ?>
                <div class="entry-category"><?php themename_the_post_category_full() ?></div>
        <?php endif; ?>
        
        <?php if (get_the_title()) {
                ?>
                    <h1 class="entry-title">
                        <?php the_title(); ?>
                    </h1>
                <?php
            } ?>

        <div class="entry-header">
            <?php themename_post_meta(array(
                'date'     		=> 1,
                'author'   		=> 1,
                'comments' 		=> 1,
                'comments_text' => 1,
                'tags'     		=> 0,
                'edit'     		=> 0,
            )); ?>
            
        </div>
        
        <div class="post-excerpt entry-content">

            <?php the_content(esc_html__('Continue Reading', 'themename')); ?>

            <div class="themename-tag-socials-box"><?php do_action('themename_xptheme_post_tag_socials') ?></div>

            <?php do_action('themename_xptheme_post_bottom') ?>
            
        </div><!-- /entry-content -->

        <?php
            wp_link_pages(array(
                'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'themename') . '</span>',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
                'pagelink'    => '<span class="screen-reader-text">' . esc_html__('Page', 'themename') . ' </span>%',
                'separator'   => '<span class="screen-reader-text">, </span>',
            ));
        ?>  
		
</article>
</div>