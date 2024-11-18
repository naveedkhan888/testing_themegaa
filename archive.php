<?php
get_header();

$sidebar_configs = themename_xptheme_get_blog_layout_configs();
$blog_archive_layout =  (isset($_GET['blog_archive_layout']))  ? $_GET['blog_archive_layout'] : themename_xptheme_get_config('blog_archive_layout', 'main-right');
if (isset($sidebar_configs['sidebar'])) {
    $sidebar_id = $sidebar_configs['sidebar']['id'];
    if (!is_active_sidebar($sidebar_id)) {
        $class_main = 'container';
    }
}
$class_row = ($blog_archive_layout === 'main-right') ? 'xp-column-reverse xp-custom-blog' : 'xp-custom-blog';

themename_xptheme_render_breadcrumbs();

$class_main = apply_filters('themename_xptheme_post_content_class', 'container');


$blog_columns = apply_filters('loop_blog_columns', 1);

$columns	= $blog_columns;
if (isset($blog_columns) && $blog_columns >= 3) {
    $screen_desktop 		= 3;
    $screen_desktopsmall 	= 2;
    $screen_tablet 			= 1;
} else {
    $screen_desktop 		= $blog_columns;
    $screen_desktopsmall 	= $blog_columns;
    $screen_tablet 			= 1;
}

$screen_mobile 				= 1;

$data_responsive = ' data-xlgdesktop='. esc_attr($columns) .'';

$data_responsive .= ' data-desktop='. esc_attr($screen_desktop) .'';

$data_responsive .= ' data-desktopsmall='. esc_attr($screen_desktopsmall) .'';

$data_responsive .= ' data-tablet='. esc_attr($screen_tablet) .'';

$data_responsive .= ' data-mobile='. esc_attr($screen_mobile) .'';


$main_class = $sidebar_configs['main']['class'];

if ( !themename_redux_framework_activated() ) {
    $sidebar_id = 'sidebar-default';
    
    if (isset($sidebar_configs['sidebar'])  && is_active_sidebar($sidebar_id)) {
        $main_class .= ' col-xl-9';
    } else {
        $main_class .= ' col-xl-12';
    }
}
?>

	
<?php
    the_archive_description('<header class="page-header"><div class="container"><div class="taxonomy-description">', '</div></div></header>');
?>
<!-- .page-header -->
<section id="main-container" class="main-content <?php echo esc_attr($class_main); ?>">

	<?php do_action('themename_post_template_main_container_before'); ?>

	<div class="row <?php echo esc_attr($class_row); ?>">
		
		<?php if (isset($sidebar_configs['sidebar'])  && is_active_sidebar($sidebar_id)) : ?>
			<div class="<?php echo esc_attr($sidebar_configs['sidebar']['class']) ;?>">
			  	<aside class="sidebar" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
			   		<?php dynamic_sidebar($sidebar_id); ?>
			  	</aside>
			</div>
		<?php endif; ?>

		<div id="main-content" class="<?php echo esc_attr($main_class); ?>">
			<div id="main" class="site-main layout-blog">

				<?php do_action('themename_post_template_main_content_before'); ?>

				<div class="row grid" <?php echo trim($data_responsive); ?>>
					<?php if (have_posts()) : ?>

						<?php
                        // Start the Loop.
                        while (have_posts()) : the_post();

                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            ?>
						
                            <?php get_template_part('post-formats/content-archive'); ?>

							<?php
                        // End the loop.
                        endwhile;
                    // If no content, include the "No posts found" template.
                    else :
                        get_template_part('post-formats/content/content', 'none');

                    endif;
                    ?>
				</div>
				<?php
                    // Previous/next page navigation.
                    themename_xptheme_paging_nav();
                ?>
				<?php do_action('themename_post_template_main_content_after'); ?>

			</div><!-- .site-main -->
		</div><!-- .content-area -->
		
	</div>

	<?php do_action('themename_post_template_main_container_after'); ?>
</section>
<?php get_footer(); ?>
