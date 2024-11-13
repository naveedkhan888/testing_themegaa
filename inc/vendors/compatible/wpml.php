<?php

if (! function_exists('themename_add_language_to_menu_storage_key')) {
    function themename_add_language_to_menu_storage_key( $storage_key )
    {
      global $sitepress;

      return $storage_key . '-' . $sitepress->get_current_language();
    }
}
add_filter( 'themename_menu_storage_key', 'themename_add_language_to_menu_storage_key', 10, 1 );