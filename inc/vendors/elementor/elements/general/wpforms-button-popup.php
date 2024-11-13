<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_WPForms_Button_Popup')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Themename_Elementor_WPForms_Button_Popup extends Themename_Elementor_Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'tbay-wpforms-button-popup';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('Themename WPForms Button Popup', 'themename');
    }

 
    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-button';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */

    protected function register_controls()
    {
        $this->start_controls_section(
            'general_content_section',
            [
                'label' => esc_html__('General', 'themename'),
            ]
        );

        $this->add_control(
            'button_title',
            [
                'label' => esc_html__('Title', 'themename'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'separator' => 'before',
            ]
        );

        $forms = $this->get_forms();

        if( empty( $forms ) ) {
            $this->add_control(
                'form_id',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('<strong>There are no forms in your site.</strong><br>Go to the <a href="%s" target="_blank">Forms screen</a> to create one.', 'themename'), admin_url('admin.php?page=wpforms-overview')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            ); 
        } else {
            $this->add_control(
                'form_id',
                [
                    'label' => esc_html__('Wpforms Select', 'themename'),
                    'type' => Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => $forms,
                    'default' => 0,
                ]
            );     
        }



		$this->add_control(
			'test_form_notice',
			[
				'show_label'      => false,
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf(
					wp_kses( /* translators: %s - WPForms documentation link. */
						__( '<b>Heads up!</b> Don\'t forget to test your form. <a href="%s" target="_blank" rel="noopener noreferrer">Check out our complete guide!</a>', 'themename' ),
						[
							'b'  => [],
							'br' => [],
							'a'  => [
								'href'   => [],
								'rel'    => [],
								'target' => [],
							],
						]
					),
					'https://wpforms.com/docs/how-to-properly-test-your-wordpress-forms-before-launching-checklist/'
				),
				'condition'       => [
					'form_id!' => '0',
				],
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

        $this->end_controls_section();

        
		$this->start_controls_section(
			'section_display',
			[
				'label'     => esc_html__( 'Display Options', 'themename' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'form_id!' => '0',
				],
			]
		);

		$this->add_control(
			'display_form_name',
			[
				'label'        => esc_html__( 'Form Name', 'themename' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'themename' ),
				'label_off'    => esc_html__( 'Hide', 'themename' ),
				'return_value' => 'yes',
				'condition'    => [
					'form_id!' => '0',
				],
			]
		);

		$this->add_control(
			'display_form_description',
			[
				'label'        => esc_html__( 'Form Description', 'themename' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'themename' ),
				'label_off'    => esc_html__( 'Hide', 'themename' ),
				'separator'    => 'after',
				'return_value' => 'yes',
				'condition'    => [
					'form_id!' => '0',
				],
			]
		);

		$this->end_controls_section();

        $this->register_controls_general_style();
    }
    
    protected function register_controls_general_style()
    {
        $this->start_controls_section(
            'section_general_style',
            [
                'label' => esc_html__('General', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'general_text_typography',
                'selector' => '{{WRAPPER}} .wpforms-button-popup > a',
            ]
        );

        $this->add_responsive_control(
            'general_text_align',
            [
                'label' => esc_html__('Align', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'themename'),
                        'icon' => 'fa fa-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'themename'),
                        'icon' => 'fa fa-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'themename'),
                        'icon' => 'fa fa-align-right'
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-button-popup'  => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'general_text_padding',
            [
                'label'      => esc_html__('Padding', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-button-popup > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'general_text_margin',
            [
                'label'      => esc_html__('Margin', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-button-popup > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('general_tabs');

        $this->start_controls_tab(
            'general_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'general_text_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-button-popup > a span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'general_text_bg_color',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-button-popup > a' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .wpforms-button-popup > a:after' => 'border-color: {{VALUE}};',
                ],
            ]
        );



        $this->end_controls_tab();

        $this->start_controls_tab(
            'general_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'general_text_color_hover',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-button-popup > a:hover span' => 'Color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'general_bg_color_hover',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-button-popup > a:hover' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .wpforms-button-popup > a:hover:after' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Get forms list.
     *
     * @since 1.6.2
     *
     * @returns array Array of forms.
     */
    public function get_forms() {

        static $forms_list = [];

        if ( empty( $forms_list ) ) {
            $forms = wpforms()->form->get();

            if ( ! empty( $forms ) ) {
                $forms_list[0] = esc_html__( 'Select a form', 'themename' );
                foreach ( $forms as $form ) {
                    $forms_list[ $form->ID ] = mb_strlen( $form->post_title ) > 100 ? mb_substr( $form->post_title, 0, 97 ) . '...' : $form->post_title;
                }
            }
        }

        return $forms_list;
    }

    /**
	 * Render shortcode.
	 *
	 * @since 1.6.2
	 */
	public function render_shortcode() {

		return sprintf(
			'[wpforms id="%1$d" title="%2$s" description="%3$s"]',
			absint( $this->get_settings_for_display( 'form_id' ) ),
			sanitize_key( $this->get_settings_for_display( 'display_form_name' ) === 'yes' ? 'true' : 'false' ),
			sanitize_key( $this->get_settings_for_display( 'display_form_description' ) === 'yes' ? 'true' : 'false' )
		);
	}

    public function render_item() {
        $button_title = $this->get_settings_for_display( 'button_title' );

        if( empty($button_title) ) return;
        ?>
        <div class="wpforms-button-popup">
            <a href="#tbay-content-wpforms-popup" class="btn show-all popup-button-open">
                <span><?php echo trim($button_title);  ?></span>
            </a>
        </div>

        <div id="tbay-content-wpforms-popup" class="tbay-popup-content popup-wpforms-popup zoom-anim-dialog mfp-hide">
            <div class="content">
                <?php echo do_shortcode( $this->render_shortcode() ); ?>
            </div>
        </div>
        <?php
        
    }
}
$widgets_manager->register(new Themename_Elementor_WPForms_Button_Popup());