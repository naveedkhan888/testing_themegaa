<?php
if ( !themename_woocommerce_activated() ) return;

if( ! function_exists( 'themename_login_form' ) ) {
	function themename_login_form( $echo = true, $action = false, $message = false, $hidden = false, $redirect = false, $popup = false ) {
		ob_start();
		
		?>
			<form method="post" class="login woocommerce-form woocommerce-form-login <?php if ( $hidden ) echo 'hidden-form'; ?>" <?php echo ( ! empty( $action ) ) ? 'action="' . esc_url( $action ) . '"' : ''; ?> <?php if ( $hidden ) echo 'style="display:none;"'; ?>>

				<?php do_action( 'woocommerce_login_form_start' ); ?>

				<?php echo true == $message ? wpautop( wptexturize( $message ) ) : ''; ?>

				<p class="form-row form-row-first">
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" placeholder="<?php echo esc_attr_e('Username or email address', 'themename')  ?>" autocomplete="username"  value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" required aria-required="true" />
				</p>
				<p class="form-row form-row-last">
					<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" placeholder="<?php echo esc_attr_e('Password', 'themename')  ?>" autocomplete="current-password" required aria-required="true" />
				</p>
                <div class="clear"></div>

				<?php do_action( 'woocommerce_login_form' ); ?>

				<div class="login-form-footer">
					<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'themename' ); ?></span>
                    </label>
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="woocommerce-LostPassword lost_password"><?php esc_html_e( 'Lost password?', 'themename' ); ?></a>
				</div>

				<p class="form-row">
					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<?php if ( $redirect ): ?>
						<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ); ?>" />
					<?php endif ?>
					<button type="submit" class="woocommerce-button button woocommerce-form-login__submit<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="login" value="<?php esc_attr_e( 'Log in', 'themename' ); ?>"><?php esc_html_e( 'Log in', 'themename' ); ?></button>
				</p>

                <div class="clear"></div>

				<?php 
					if( $popup ) {
						do_action( 'themename_woo_login_form_end' );
					}
				?>

				<?php do_action( 'woocommerce_login_form_end' ); ?>

			</form>

		<?php

		if( $echo ) {
			echo ob_get_clean();
		} else {
			return ob_get_clean();
		}
	}
}


// **********************************************************************// 
// Modal login form
// **********************************************************************// 
if( ! function_exists( 'themename_modal_login_form' ) ) {
	function themename_modal_login_form() { 
		if( ! themename_woocommerce_activated() || is_user_logged_in() || is_account_page() ) return;

		$page_id         = get_option( 'woocommerce_myaccount_page_id' );
		$redirect_url    = apply_filters( 'themename_my_account_side_login_form_redirect', get_permalink( $page_id ) );

		$class_content 	 = ( themename_nextend_social_login_activated() ) ? 'social-login' : ''; 
        ?>
        <div id="custom-login-wrapper" class="modal fade <?php echo esc_attr($class_content); ?>" role="dialog">
            <div class="modal-dialog"> 
                <!-- Modal content-->
                <div class="modal-content woocommerce-account">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="xp-icon xp-icon-close-01"></i></button>
                    <div class="form-header">
                        <h5 class="form-title" ><?php esc_html_e('Sign in', 'themename'); ?></h5>
                    </div>
                    <div class="modal-body">
						<?php themename_login_form( true, $redirect_url, false, true, $redirect_url, true  ); ?>
                    </div>
                </div> 
            </div>
        </div>
        <?php
	}

	add_action( 'wp_footer', 'themename_modal_login_form', 160 );
}

if( ! function_exists( 'themename_modal_create_account_login_form' ) ) {
	add_action( 'themename_woo_login_form_end', 'themename_modal_create_account_login_form', 5 );
	function themename_modal_create_account_login_form( ) { 
		if( ! themename_woocommerce_activated() || is_user_logged_in() ) return;

		$page_id         = get_option( 'woocommerce_myaccount_page_id' );
        $account_link 	 = get_permalink( $page_id );
		?>
		<div class="create-account-question">
			<a href="<?php echo esc_url($account_link); ?>" class="btn btn-style-link btn-color-primary create-account-button"><?php esc_html_e('Create an account', 'themename'); ?></a>
		</div>
		<?php
	}
}