<?php
if (! defined('ABSPATH') || !themename_woocommerce_activated()) {
    exit;
}

if (! class_exists('Themename_Cart')) :


    class Themename_Cart
    {
        public static $instance;

        public static function getInstance()
        {
            if (! isset(self::$instance) && ! (self::$instance instanceof Themename_Cart)) {
                self::$instance = new Themename_Cart();
            }

            return self::$instance;
        }

        /**
         * Setup class.
         *
         * @since 1.0
         *
         */
        public function __construct()
        {
            add_action( 'wp_footer', array( $this, 'add_to_cart_modal_html'), 20 );

            add_filter('themename_cart_position', array( $this, 'woocommerce_cart_position'), 10, 1);

            add_filter('body_class', array( $this, 'body_classes_cart_postion' ), 40, 1);

            /*Mobile add to cart message html*/
            add_filter('wc_add_to_cart_message_html', array( $this, 'add_to_cart_message_html_mobile'), 10, 1);

            /*Show Add to Cart on mobile*/
            add_filter('themename_show_cart_mobile', array( $this, 'show_cart_mobile'), 10, 1);
            add_filter('body_class', array( $this, 'body_classes_show_cart_mobile'), 10, 1);

            /*Show Free Shipping*/
            add_action('woocommerce_widget_shopping_cart_before_buttons', array( $this, 'subtotal_free_shipping'), 20);
            add_action('woocommerce_cart_contents', array( $this, 'subtotal_free_shipping_in_cart'), 20);

        }

        public function add_to_cart_modal_html()
        {
            if (is_account_page() || is_checkout() || (function_exists('is_vendor_dashboard') && is_vendor_dashboard())) {
                return;   
            } ?>

            <div id="xptheme-cart-popup" class="toast-container position-fixed bottom-0 start-50 m-3 translate-middle-x">
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="1500"> 
                    <div class="d-flex toast-body">
                    </div>
                </div>
            </div>  
		    <?php
        }

        public function woocommerce_cart_position()
        {
            if ( apply_filters('themename_check_cart_position_is_mobile', wp_is_mobile()) ) {
                return 'right';
            }

            $position_array = array("popup", "left", "right", "no-popup");

            $position = themename_xptheme_get_config('woo_mini_cart_position', 'popup');

            $position = (isset($_GET['ajax_cart'])) ? $_GET['ajax_cart'] : $position;

            $position =  (!in_array($position, $position_array)) ? themename_xptheme_get_config('woo_mini_cart_position', 'popup') : $position;

            return $position;
        }


        public function body_classes_cart_postion($classes)
        {
            $position = apply_filters('themename_cart_position', 10, 2);

            $class = (isset($_GET['ajax_cart'])) ? 'ajax_cart_'.$_GET['ajax_cart'] : 'ajax_cart_'.$position;

            $classes[] = trim($class);

            return $classes;
        }


        public function add_to_cart_message_html_mobile($message)
        {
            if (isset($_REQUEST['themename_buy_now']) && $_REQUEST['themename_buy_now'] == true) {
                return __return_empty_string();
            }

            if (wp_is_mobile() && ! intval(themename_xptheme_get_config('enable_buy_now', false))) {
                return __return_empty_string();
            } else {
                return $message;
            }
        }

        public function show_cart_mobile()
        {
            $active = themename_xptheme_get_config('enable_add_cart_mobile', false);

            $active = (isset($_GET['add_cart_mobile'])) ? $_GET['add_cart_mobile'] : $active;

            return $active;
        }

        public function body_classes_show_cart_mobile($classes)
        {
            $class = '';
            $active = apply_filters('themename_show_cart_mobile', 10, 2);
            if (isset($active) && $active) {
                $class = 'xp-addtocart-mb';
            }

            $classes[] = trim($class);

            return $classes;
        }

        public function subtotal_free_shipping_in_cart() {
            $content = $this->subtotal_free_shipping(true);
            if ($content !== '') {
                echo '<div class="xptheme-no-border"><div class="xptheme-subtotal_free_shipping">' . ($content) . '</div></div>';
            }
        }

        public function subtotal_free_shipping( $return = false ) {
            if ( WC()->cart->is_empty() || !themename_xptheme_get_config('show_cart_free_shipping', false) ) {
				return;
			}

			// Get Free Shipping Methods for Rest of the World Zone & populate array $min_amounts
			$default_zone = new WC_Shipping_Zone( 0 );

			$default_methods = $default_zone->get_shipping_methods();
			foreach ( $default_methods as $key => $value ) {
				if ( $value->id === "free_shipping" ) {
					if ( $value->min_amount > 0 ) {
						$min_amounts[] = $value->min_amount;
					}
				}
			}

            
            $shipping_country = WC()->customer->get_shipping_country();

            $free_shipping_min = themename_get_free_shipping_minimum($shipping_country);

            if( !is_null( $free_shipping_min ) ){
                $min_amounts[] = $free_shipping_min;
            }

			// Find lowest min_amount
			if ( isset( $min_amounts ) ) {
				if ( is_array( $min_amounts ) && $min_amounts ) {
					$min_amount = min( $min_amounts );
					// Get Cart Subtotal inc. Tax excl. Shipping
					$current = WC()->cart->subtotal;
                    foreach ( WC()->cart->get_coupons() as $code => $coupon ) :
                        if(!$coupon->enable_free_shipping()) {
                            $current -= $coupon->get_amount();
                        }
                    endforeach;
					// If Subtotal < Min Amount Echo Notice
					// and add "Continue Shopping" button
					if ( $current > 0 ) {
                        $spend = 0;
                        $content = ''; 
                        
						if ( $current < $min_amount ) {
                            $spend = intval($min_amount) - intval($current); 
                            $per = (intval($current)/intval($min_amount))*100;
                            
                            $content .= '<div class="xptheme-total-condition-wrap">';
                            
                            $content .= '<div class="xptheme-total-condition" data-per="' . esc_attr($per) . '">' .
                                '<span class="xptheme-total-condition-hint">' . esc_attr($per) . '%</span>' .
                                '<div class="xptheme-subtotal-condition">' . esc_attr($per) . '%</div>' .
                            '</div>';
                            
                            $allowed_html = array(
                                'strong' => array(),
                                'a' => array(
                                    'class' => array(),
                                    'href' => array(),
                                    'title' => array()
                                ),
                                'span' => array(
                                    'class' => array()
                                ),
                                'br' => array()
                            );
                            
                            $content .= '<div class="xptheme-total-condition-desc">' .
                            sprintf(
                                wp_kses(__('Spend %s more to reach <strong>FREE SHIPPING!</strong> <br /><span class="hide-in-cart">to add more products to your cart and receive free shipping for order %s.</span>', 'themename'), $allowed_html),
                                wc_price($spend),
                                wc_price($min_amount)
                            ) . 
                            '</div>';
                            
                            $content .= '</div>';
						} else {
                            $content .= '<div class="xptheme-total-condition-wrap">';
                            $content .= '<div class="xptheme-total-condition-desc">';
                            $content .= sprintf(
                                esc_html__("Congratulations! You get free shipping with your order greater %s.", 'themename'),
                                wc_price($min_amount)
                            );
                            $content .= '</div>';
                            $content .= '</div>';
						}

                        if (!$return) {
                            echo trim($content); 
                            
                            return;
                        } else {
                            return $content;
                        }

					}
				}
			}
            
        }
    }
endif;


if (!function_exists('themename_cart')) {
    function themename_cart()
    {
        return Themename_Cart::getInstance();
    }
    themename_cart();
}
