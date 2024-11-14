<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Themename
 * @since Themename 1.0
 */


$sidebar = xptheme_get_sidebar_dokan();

if(!isset($sidebar['id']) || empty($sidebar['id'])) return;

?> <div class="xptheme-sidebar-vendor sidebar"><?php dynamic_sidebar( $sidebar['id'] ); ?></div>

