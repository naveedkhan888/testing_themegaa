<?php
/**
 *
 * The default template for displaying content
 * @since 1.0
 * @version 1.2.0
 *
 */
$class_main = $class_left = '';

$audiolink =  get_post_meta(get_the_ID(), 'tbay_post_audio_link', true);

if (isset($audiolink) && $audiolink) {
} else {
    $content = apply_filters('the_content', get_the_content());
    $audio = false;
    // Only get audio from the content if a playlist isn't present.
    if (false === strpos($content, 'wp-playlist-script')) {
        $audio = get_media_embedded_in_content($content, array( 'audio' ));
    }
}

?>
<div class="entry-single">
    <article id="post-<?php the_ID(); ?>" <?php post_class($class_main); ?>>
        <?php if ($audiolink) : ?>
            <div class="audio-wrap audio-responsive"><?php echo wp_oembed_get($audiolink); ?></div>
        <?php elseif (has_post_thumbnail()) : ?>
            <?php lasa_tbay_post_thumbnail(); ?>
        <?php endif; ?>

        <?php if (get_the_category_list()): ?>
            <div class="entry-category"><?php lasa_the_post_category_full() ?></div>
        <?php endif; ?>

        <?php if (get_the_title()) {
            ?>
                <h1 class="entry-title">
                    <?php the_title(); ?>
                </h1>
            <?php
        } ?>

        <div class="entry-header">
            <?php lasa_post_meta(array(
                'date'     		=> 1,
                'author'   		=> 1,
                'comments' 		=> 1,
                'comments_text' => 1,
                'tags'     		=> 0,
                'edit'     		=> 0,
            )); ?>
            
        </div>


        <div class="post-excerpt entry-content">
                

            <?php the_content(esc_html__('Continue Reading', 'lasa')); ?>

            <div class="lasa-tag-socials-box"><?php do_action('lasa_tbay_post_tag_socials') ?></div>

            <?php do_action('lasa_tbay_post_bottom') ?>
            
        </div><!-- /entry-content -->

        <?php
            wp_link_pages(array(
                'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'lasa') . '</span>',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
                'pagelink'    => '<span class="screen-reader-text">' . esc_html__('Page', 'lasa') . ' </span>%',
                'separator'   => '<span class="screen-reader-text">, </span>',
            ));
        ?>
    </article>
</div>