<?php 
/**
 * Templates Name: Elementor
 * Widget: List Nav
 */

$available_menus = $this->get_available_menus();

if (!$available_menus) {
	return;
}

$settings = $this->get_active_settings();

extract( $settings );

$menuNav = wp_get_nav_menu_items($menu);

if( empty($menuNav) ) return;

$numItems = count($menuNav);
$i = 0;
$separator = $list_menu_separator;
?>
<div <?php $this->print_render_attribute_string('wrapper'); ?>>

	<?php if( !empty($list_menu_title) ) : ?>
		<div class="list-menu-heading">
			<?php echo '<strong>'.trim($list_menu_title).':</strong>'; ?>
		</div>
	<?php endif; ?>
	<div class="list-menu-wrapper">
		<?php 
			foreach ( $menuNav as $navItem ) { 
				if( ++$i === $numItems ) $separator = '';

				echo '<a href="'. esc_url($navItem->url) .'" title="'. esc_attr($navItem->title) .'">'. trim($navItem->title) .'</a>'.$separator;
			
			}
		?>
	</div>


</div>