<?php 
    if ( has_nav_menu( 'primary' ) ) {
        $xptheme_location = 'primary';
        $locations  = get_nav_menu_locations();
        $menu_id    = $locations[ $xptheme_location ] ;
        $menu_obj   = wp_get_nav_menu_object( $menu_id );
        $menu_name  = themename_get_transliterate($menu_obj->slug);
    } else {
        $xptheme_location = $menu_name = '';
    }
?>
<nav data-duration="400" class="hidden-xs hidden-sm xptheme-megamenu slide animate navbar xptheme-horizontal-default" data-id="'. $menu_name .'">
<?php
    $args = array(
        'theme_location' => 'primary',
        'menu_class' => 'nav navbar-nav megamenu menu',
        'fallback_cb' => '',
        'menu_id' => 'primary-menu', 
    );

    $args['walker']             =   new Themename_Megamenu_Walker();

    wp_nav_menu($args);
?>
</nav>