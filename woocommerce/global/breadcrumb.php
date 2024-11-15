<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if (! defined('ABSPATH')) {
    exit;
}

if (! empty($breadcrumb)) {
    echo trim($wrap_before);

    $end = '' ;
    foreach ($breadcrumb as $key => $crumb) {
        echo trim($before);

        if (! empty($crumb[1]) && sizeof($breadcrumb) !== $key + 1) {
            echo '<li><a href="' . esc_url($crumb[1]) . '">' . esc_html($crumb[0]) . '</a></li>';
        } else {
            if (!is_product()) {
                echo '<li>'.esc_html($crumb[0]).'</li>';
            }
        }

        echo trim($after);

        $end = esc_html($crumb[0]);
    }

    echo trim($wrap_after);
}
