<?php
if ( is_single() ) {
    get_template_part('post-formats/content', get_post_format());
} else {
    get_template_part('post-formats/content-archive');
}