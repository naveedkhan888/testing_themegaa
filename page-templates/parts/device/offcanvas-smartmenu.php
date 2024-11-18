<?php
    $location = 'mobile-menu';
    $xptheme_location  = '';
    if (has_nav_menu($location)) {
        $xptheme_location = $location;
    }

    
    $mmenu_langue           = themename_xptheme_get_config('enable_mmenu_langue', false);
    $mmenu_currency         = themename_xptheme_get_config('enable_mmenu_currency', false);

    $menu_mobile_select    =  themename_xptheme_get_config('menu_mobile_select');
?>
  
<div id="xptheme-mobile-smartmenu" data-title="<?php esc_attr_e('Menu', 'themename'); ?>" class="xptheme-mmenu d-xl-none"> 

    <div class="xptheme-offcanvas-body">
        
        <div id="mmenu-close">
            <button type="button" class="btn btn-toggle-canvas" data-toggle="offcanvas">
                <i class="xp-icon xp-icon-close-01"></i>
            </button>
        </div>

        <?php 
        if ( empty($menu_mobile_select) ) {
            if( !empty($theme_locations) ) {
                $theme_locations = get_nav_menu_locations();
                $menu_obj = get_term( $theme_locations[$xptheme_location], 'nav_menu' );
                $menu_name = themename_get_transliterate($menu_obj->name);
            } else {
                $menu_name = '';
            }

        } else {
            $menu_obj = wp_get_nav_menu_object($menu_mobile_select);
            $menu_name = themename_get_transliterate($menu_obj->slug);
        }
        ?>
        <nav id="xptheme-mobile-menu-navbar" class="menu navbar navbar-offcanvas navbar-static" data-id="menu-<?php echo esc_attr($menu_name); ?>" >
            <?php

                $args = array(
                    'fallback_cb' => '',
                );

                if (empty($menu_mobile_select)) {
                    $args['theme_location']     = $xptheme_location;
                } else {
                    $args['menu']               = $menu_mobile_select;
                }

                $args['container_id']       =   'main-mobile-menu-mmenu'; 
                $args['menu_id']            =   'main-mobile-menu-mmenu-wrapper';
                $args['items_wrap']         =   '<ul id="%1$s" class="%2$s" data-id="'. $menu_name .'">%3$s</ul>';

                if( class_exists('Themename_Megamenu_Walker') ) {
                    $args['walker']             =   new Themename_Megamenu_Walker();
                } else { 
                    $args['walker']             =   new Walker_Nav_Menu();
                }

                wp_nav_menu($args);


            ?>
        </nav>


    </div>
    <?php if ($mmenu_langue || $mmenu_currency) {
                ?>
         <div id="mm-xptheme-bottom">  
    
            <div class="mm-bottom-track-wrapper">

                <?php
                    ?>
                    <div class="mm-bottom-langue-currency ">
                        <?php if ($mmenu_langue): ?>
                            <div class="mm-bottom-langue">
                                <?php do_action('themename_xptheme_header_custom_language'); ?>
                            </div>
                        <?php endif; ?>
                
                        <?php if ($mmenu_currency && class_exists('WooCommerce') && class_exists('WOOCS')): ?>
                            <div class="mm-bottom-currency">
                                <div class="xptheme-currency">
                                <?php echo do_shortcode('[woocs txt_type="desc"]'); ?> 
                                </div>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                    <?php
                ?>
            </div>


        </div>
        <?php
            }
    ?>
   
</div>