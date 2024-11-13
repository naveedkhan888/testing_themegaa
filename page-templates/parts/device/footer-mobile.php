<?php
    if( lasa_checkout_optimized() ) return;
    /**
     * lasa_before_topbar_mobile hook
     */
    do_action('lasa_before_footer_mobile');
    $mobile_footer_slides = lasa_tbay_get_config('mobile_footer_slides');
?>



<?php
    if ($mobile_footer_slides && !empty($mobile_footer_slides)) {
        ?>
            <div class="footer-device-mobile d-xl-none clearfix">
            <?php
                /**
                * lasa_before_footer_mobile hook
                */
                do_action('lasa_before_footer_mobile');

        /**
        * Hook: lasa_footer_mobile_content.
        *
        * @hooked lasa_the_custom_list_menu_icon - 10
        */

        do_action('lasa_footer_mobile_content');

        /**
        * lasa_after_footer_mobile hook
        */
        do_action('lasa_after_footer_mobile'); ?>
            </div>
        <?php
    }
?>

