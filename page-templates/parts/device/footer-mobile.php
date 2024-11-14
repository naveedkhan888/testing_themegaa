<?php
    if( themename_checkout_optimized() ) return;
    /**
     * themename_before_topbar_mobile hook
     */
    do_action('themename_before_footer_mobile');
    $mobile_footer_slides = themename_xptheme_get_config('mobile_footer_slides');
?>



<?php
    if ($mobile_footer_slides && !empty($mobile_footer_slides)) {
        ?>
            <div class="footer-device-mobile d-xl-none clearfix">
            <?php
                /**
                * themename_before_footer_mobile hook
                */
                do_action('themename_before_footer_mobile');

        /**
        * Hook: themename_footer_mobile_content.
        *
        * @hooked themename_the_custom_list_menu_icon - 10
        */

        do_action('themename_footer_mobile_content');

        /**
        * themename_after_footer_mobile hook
        */
        do_action('themename_after_footer_mobile'); ?>
            </div>
        <?php
    }
?>

