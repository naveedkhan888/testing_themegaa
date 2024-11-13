<?php

if (! function_exists('lasa_add_language_to_menu_storage_key')) {
    function lasa_add_language_to_menu_storage_key( $storage_key )
    {
      global $sitepress;

      return $storage_key . '-' . $sitepress->get_current_language();
    }
}
add_filter( 'lasa_menu_storage_key', 'lasa_add_language_to_menu_storage_key', 10, 1 );