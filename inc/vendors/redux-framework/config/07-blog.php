<?php
/**
 * Redux Framework checkbox config.
 * For full documentation, please visit: http://devs.redux.io/
 *
 * @package Redux Framework
 */

defined( 'ABSPATH' ) || exit;

$columns            = themename_settings_columns();
$blog_image_size    = themename_settings_blog_image_size();

/** Blog Settings **/
Redux::set_section(
	$opt_name,
	array(
        'icon' => 'zmdi zmdi-border-color',
        'title' => esc_html__('Blog', 'themename'),
	)
);


// Settings Title Blog
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Breadcrumb Blog', 'themename'),
        'fields' => array(
            array(
                'id' => 'show_blog_breadcrumb',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumb', 'themename'),
                'default' => 1
            ),
            array(
				'id'       => 'blog_breadcrumb_text_alignment',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Text Alignment', 'themename' ),
				'options'  => array(
					'left' => esc_html__('Text Left', 'themename'),
					'center' => esc_html__('Text Center', 'themename'),
					'right' => esc_html__('Text Right', 'themename'),
				),
				'default'  => 'left',
			),
            array(
                'id' => 'blog_breadcrumb_layout',
                'required' => array('show_blog_breadcrumb','=',1),
                'type' => 'image_select',
                'class'     => 'image-two',
                'compiler' => true,
                'title' => esc_html__('Select Breadcrumb Blog Layout', 'themename'),
                'options' => array(
                    'image' => array(
                        'title' => esc_html__('Background Image', 'themename'),
                        'img'   => THEMENAME_ASSETS_IMAGES . '/breadcrumbs/image.jpg'
                    ),
                    'color' => array(
                        'title' => esc_html__('Background color', 'themename'),
                        'img'   => THEMENAME_ASSETS_IMAGES . '/breadcrumbs/color.jpg'
                    ),
                    'text'=> array(
                        'title' => esc_html__('Text Only', 'themename'),
                        'img'   => THEMENAME_ASSETS_IMAGES . '/breadcrumbs/text_only.jpg'
                    ),
                ),
                'default' => 'color'
            ),
            array(
                'title' => esc_html__('Breadcrumb Background Color', 'themename'),
                'id' => 'blog_breadcrumb_layout_color',
                'type' => 'color',
                'default' => '#f7f7f7',
                'transparent' => false,
                'required' => array('blog_breadcrumb_layout','=','color'),
            ),
            array(
                'id' => 'blog_breadcrumb_layout_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumb Background Image', 'themename'),
                'subtitle' => esc_html__('Image File (.png or .jpg)', 'themename'),
                'default'  => array(
                    'url'=> THEMENAME_IMAGES .'/breadcrumbs-blog.jpg'
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
        'title' => esc_html__('Blog Article', 'themename'),
        'fields' => array(
            array(
                'id' => 'blog_archive_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Blog Layout', 'themename'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Articles', 'themename'),
                        'img' => THEMENAME_ASSETS_IMAGES . '/blog_archives/blog_no_sidebar.jpg'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Articles - Left Sidebar', 'themename'),
                        'img' => THEMENAME_ASSETS_IMAGES . '/blog_archives/blog_left_sidebar.jpg'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Articles - Right Sidebar', 'themename'),
                        'img' => THEMENAME_ASSETS_IMAGES . '/blog_archives/blog_right_sidebar.jpg'
                    ),
                ),
                'default' => 'main-right'
            ),
            array(
                'id'        => 'blog_archive_sidebar',
                'type'      => 'select',
                'data'      => 'sidebars',
                'title'     => esc_html__('Blog Archive Sidebar', 'themename'),
                'default'   => 'blog-archive-sidebar',
                'required'  => array('blog_archive_layout','!=','main'),
            ),
            array(
                'id' => 'blog_columns',
                'type' => 'select',
                'title' => esc_html__('Post Column', 'themename'),
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
                'title' => esc_html__('Layout Blog', 'themename'),
                'options' => array(
                    'post-style-1' =>  esc_html__('Post Grid', 'themename'),
                    'post-style-2' =>  esc_html__('Post List', 'themename'),
                ),
                'default' => 'post-style-1'
            ),
            array(
                'id' => 'blog_image_sizes',
                'type' => 'select',
                'title' => esc_html__('Post Image Size', 'themename'),
                'options' => $blog_image_size,
                'default' => 'full'
            ),
            array(
                'id' => 'enable_date',
                'type' => 'switch',
                'title' => esc_html__('Date', 'themename'),
                'default' => true
            ),
            array(
                'id' => 'enable_author',
                'type' => 'switch',
                'title' => esc_html__('Author', 'themename'),
                'default' => false
            ),
            array(
                'id' => 'enable_categories',
                'type' => 'switch',
                'title' => esc_html__('Categories', 'themename'),
                'default' => true
            ),
            array(
                'id' => 'enable_comment',
                'type' => 'switch',
                'title' => esc_html__('Comment', 'themename'),
                'default' => true
            ),
            array(
                'id' => 'enable_comment_text',
                'type' => 'switch',
                'title' => esc_html__('Comment Text', 'themename'),
                'required' => array('enable_comment', '=', true),
                'default' => true
            ),
            array(
                'id' => 'enable_short_descriptions',
                'type' => 'switch',
                'title' => esc_html__('Short descriptions', 'themename'),
                'default' => false
            ),
            array(
                'id' => 'enable_readmore',
                'type' => 'switch',
                'title' => esc_html__('Read More', 'themename'),
                'default' => false
            ),
            array(
                'id' => 'text_readmore',
                'type' => 'text',
                'title' => esc_html__('Button "Read more" Custom Text', 'themename'),
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
        'title' => esc_html__('Single Blog', 'themename'),
        'fields' => array(
            array(
                'id' => 'blog_single_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Blog Single Layout', 'themename'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Only', 'themename'),
                        'img' => THEMENAME_ASSETS_IMAGES . '/single _post/main.jpg'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left - Main Sidebar', 'themename'),
                        'img' => THEMENAME_ASSETS_IMAGES . '/single _post/left_sidebar.jpg'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main - Right Sidebar', 'themename'),
                        'img' => THEMENAME_ASSETS_IMAGES . '/single _post/right_sidebar.jpg'
                    ),
                ),
                'default' => 'main-right'
            ),
            array(
                'id'        => 'blog_single_sidebar',
                'type'      => 'select',
                'data'      => 'sidebars',
                'title'     => esc_html__('Single Blog Sidebar', 'themename'),
                'default'   => 'blog-single-sidebar',
                'required' => array('blog_single_layout','!=','main'),
            ),
            array(
                'id' => 'show_blog_social_share',
                'type' => 'switch',
                'title' => esc_html__('Show Social Share', 'themename'),
                'default' => 1
            ),
            array(
                'id' => 'show_blog_author_info',
                'type' => 'switch',
                'title' => esc_html__('Show Author Info', 'themename'),
                'default' => false
            ),
            array(
                'id' => 'show_blog_related',
                'type' => 'switch',
                'title' => esc_html__('Show Related Posts', 'themename'),
                'default' => 1
            ),
            array(
                'id' => 'number_blog_releated',
                'type' => 'slider',
                'title' => esc_html__('Number of Related Posts', 'themename'),
                'required' => array('show_blog_related', '=', '1'),
                'default' => 4,
                'min' => 1,
                'step' => 1,
                'max' => 20,
            ),
            array(
                'id' => 'releated_blog_columns',
                'type' => 'select',
                'title' => esc_html__('Columns of Related Posts', 'themename'),
                'required' => array('show_blog_related', '=', '1'),
                'options' => $columns,
                'default' => 2
            ),
        )
	)
);