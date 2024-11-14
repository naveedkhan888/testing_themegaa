<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Themename
 * @since Themename 1.0
 */
/*

*Template Name: 404 Page
*/
get_header();
$image = themename_xptheme_get_config('img_404');
if (isset($image['url']) && !empty($image['url'])) {
    $image = $image['url'];
} else {
    $image = THEMENAME_IMAGES . '/img-404.png';
}
?>

<section id="main-container" class="container inner page-404">
	<div id="main-content" class="main-page">
		<div class="row">

			<div class="col-xl-1"></div>
			<div class="col-xl-10">
				<div class="error-wrapper">
				<div class="themename-img-404">
					<img src="<?php echo esc_url($image); ?>" alt="<?php esc_attr_e('Img 404', 'themename'); ?>">
				</div>

				<section class="error-404">
					<h3 class="top-title-404"><?php esc_html_e('Oops!', 'themename') ?></h3>
					<h1 class="title-404"><?php esc_html_e('Page Not Found', 'themename') ?></h1>

					<div class="themename-content-404">
						<p class="sub-title"><?php esc_html_e( 'We’re very sorry but the page you are looking for doesn’t exist or has been moved.', 'themename') ?>
						</p>
						<a href="<?php echo esc_url(home_url()) ?>" class="back"><?php esc_html_e('Back to Home', 'themename'); ?><i class="tb-icon tb-icon-arrow-right"></i></a>
					</div>
				</section><!-- .error-404 -->
				</div>
			</div>
			<div class="col-xl-1"></div>
		</div>
	</div>
</section>

<?php get_footer(); ?>