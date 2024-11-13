<?php
/**
 * Redux Framework checkbox config.
 * For full documentation, please visit: http://devs.redux.io/
 *
 * @package Redux Framework
 */

defined( 'ABSPATH' ) || exit;

$columns            = lasa_settings_columns();
$blog_image_size    = lasa_settings_blog_image_size();

/** Blog Settings **/
Redux::set_section(
	$opt_name,
	array(
        'icon' => 'zmdi zmdi-border-color',
        'title' => esc_html__('Blog', 'lasa'),
	)
);


// Settings Title Blog
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Breadcrumb Blog', 'lasa'),
        'fields' => array(
            array(
                'id' => 'show_blog_breadcrumb',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumb', 'lasa'),
                'default' => 1
            ),
            array(
				'id'       => 'blog_breadcrumb_text_alignment',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Text Alignment', 'lasa' ),
				'options'  => array(
					'left' => esc_html__('Text Left', 'lasa'),
					'center' => esc_html__('Text Center', 'lasa'),
					'right' => esc_html__('Text Right', 'lasa'),
				),
				'default'  => 'left',
			),
            array(
                'id' => 'blog_breadcrumb_layout',
                'required' => array('show_blog_breadcrumb','=',1),
                'type' => 'image_select',
                'class'     => 'image-two',
                'compiler' => true,
                'title' => esc_html__('Select Breadcrumb Blog Layout', 'lasa'),
                'options' => array(
                    'image' => array(
                        'title' => esc_html__('Background Image', 'lasa'),
                        'img'   => LASA_ASSETS_IMAGES . '/breadcrumbs/image.jpg'
                    ),
                    'color' => array(
                        'title' => esc_html__('Background color', 'lasa'),
                        'img'   => LASA_ASSETS_IMAGES . '/breadcrumbs/color.jpg'
                    ),
                    'text'=> array(
                        'title' => esc_html__('Text Only', 'lasa'),
                        'img'   => LASA_ASSETS_IMAGES . '/breadcrumbs/text_only.jpg'
                    ),
                ),
                'default' => 'color'
            ),
            array(
                'title' => esc_html__('Breadcrumb Background Color', 'lasa'),
                'id' => 'blog_breadcrumb_layout_color',
                'type' => 'color',
                'default' => '#f7f7f7',
                'transparent' => false,
                'required' => array('blog_breadcrumb_layout','=','color'),
            ),
            array(
                'id' => 'blog_breadcrumb_layout_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumb Background Image', 'lasa'),
                'subtitle' => esc_html__('Image File (.png or .jpg)', 'lasa'),
                'default'  => array(
                    'url'=> LASA_IMAGES .'/breadcrumbs-blog.jpg'
                ),
                'required' => array('blog_breadcrumb_layout','=','image'),
            ),
           
        )
	)
);

// Archive Blogs settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Blog Article', 'lasa'),
        'fields' => array(
            array(
                'id' => 'blog_archive_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Blog Layout', 'lasa'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Articles', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/blog_archives/blog_no_sidebar.jpg'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Articles - Left Sidebar', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/blog_archives/blog_left_sidebar.jpg'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Articles - Right Sidebar', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/blog_archives/blog_right_sidebar.jpg'
                    ),
                ),
                'default' => 'main-right'
            ),
            array(
                'id'        => 'blog_archive_sidebar',
                'type'      => 'select',
                'data'      => 'sidebars',
                'title'     => esc_html__('Blog Archive Sidebar', 'lasa'),
                'default'   => 'blog-archive-sidebar',
                'required'  => array('blog_archive_layout','!=','main'),
            ),
            array(
                'id' => 'blog_columns',
                'type' => 'select',
                'title' => esc_html__('Post Column', 'lasa'),
                'options' => $columns,
                'default' => '2'
            ),
            array(
                'id'   => 'opt-divide',
                'class' => 'big-divide',
                'type' => 'divide'
            ),
            array(
                'id' => 'layout_blog',
                'type' => 'select',
                'title' => esc_html__('Layout Blog', 'lasa'),
                'options' => array(
                    'post-style-1' =>  esc_html__('Post Grid', 'lasa'),
                    'post-style-2' =>  esc_html__('Post List', 'lasa'),
                ),
                'default' => 'post-style-1'
            ),
            array(
                'id' => 'blog_image_sizes',
                'type' => 'select',
                'title' => esc_html__('Post Image Size', 'lasa'),
                'options' => $blog_image_size,
                'default' => 'full'
            ),
            array(
                'id' => 'enable_date',
                'type' => 'switch',
                'title' => esc_html__('Date', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'enable_author',
                'type' => 'switch',
                'title' => esc_html__('Author', 'lasa'),
                'default' => false
            ),
            array(
                'id' => 'enable_categories',
                'type' => 'switch',
                'title' => esc_html__('Categories', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'enable_comment',
                'type' => 'switch',
                'title' => esc_html__('Comment', 'lasa'),
                'default' => true
            ),
            array(
                'id' => 'enable_comment_text',
                'type' => 'switch',
                'title' => esc_html__('Comment Text', 'lasa'),
                'required' => array('enable_comment', '=', true),
                'default' => true
            ),
            array(
                'id' => 'enable_short_descriptions',
                'type' => 'switch',
                'title' => esc_html__('Short descriptions', 'lasa'),
                'default' => false
            ),
            array(
                'id' => 'enable_readmore',
                'type' => 'switch',
                'title' => esc_html__('Read More', 'lasa'),
                'default' => false
            ),
            array(
                'id' => 'text_readmore',
                'type' => 'text',
                'title' => esc_html__('Button "Read more" Custom Text', 'lasa'),
                'required' => array('enable_readmore', '=', true),
                'default' => 'Read more',
            ),
        )
	)
);

// Single Blogs settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Single Blog', 'lasa'),
        'fields' => array(
            array(
                'id' => 'blog_single_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Blog Single Layout', 'lasa'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Only', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/single _post/main.jpg'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left - Main Sidebar', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/single _post/left_sidebar.jpg'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main - Right Sidebar', 'lasa'),
                        'img' => LASA_ASSETS_IMAGES . '/single _post/right_sidebar.jpg'
                    ),
                ),
                'default' => 'main-right'
            ),
            array(
                'id'        => 'blog_single_sidebar',
                'type'      => 'select',
                'data'      => 'sidebars',
                'title'     => esc_html__('Single Blog Sidebar', 'lasa'),
                'default'   => 'blog-single-sidebar',
                'required' => array('blog_single_layout','!=','main'),
            ),
            array(
                'id' => 'show_blog_social_share',
                'type' => 'switch',
                'title' => esc_html__('Show Social Share', 'lasa'),
                'default' => 1
            ),
            array(
                'id' => 'show_blog_author_info',
                'type' => 'switch',
                'title' => esc_html__('Show Author Info', 'lasa'),
                'default' => false
            ),
            array(
                'id' => 'show_blog_related',
                'type' => 'switch',
                'title' => esc_html__('Show Related Posts', 'lasa'),
                'default' => 1
            ),
            array(
                'id' => 'number_blog_releated',
                'type' => 'slider',
                'title' => esc_html__('Number of Related Posts', 'lasa'),
                'required' => array('show_blog_related', '=', '1'),
                'default' => 4,
                'min' => 1,
                'step' => 1,
                'max' => 20,
            ),
            array(
                'id' => 'releated_blog_columns',
                'type' => 'select',
                'title' => esc_html__('Columns of Related Posts', 'lasa'),
                'required' => array('show_blog_related', '=', '1'),
                'options' => $columns,
                'default' => 2
            ),
        )
	)
);