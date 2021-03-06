<?php
/**
 * Affiliate Registration Form
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Affiliates
 * @version 1.0.5
 */

/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<div class="yith-wcaf yith-wcaf-registration-form woocommerce">

	<?php
	if( function_exists( 'wc_print_notices' ) ){
		wc_print_notices();
	}
	?>

	<?php if( ! is_user_logged_in() ): ?>

		<?php if( 'yes' == $show_login_form ): ?>
			<div class="u-columns col2-set" id="customer_login">
		<?php endif; ?>

			<?php if( 'yes' == $show_login_form ): ?>
				<div class="u-column1 col-1">

					<h2><?php _e( 'Login', 'woocommerce' ); ?></h2>

					<form class="woocomerce-form woocommerce-form-login login" method="post">

						<?php do_action( 'woocommerce_login_form_start' ); ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<label for="username"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
							<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
						</p>
						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
							<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" />
						</p>

						<?php do_action( 'woocommerce_login_form' ); ?>

						<p class="form-row">
							<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
							<input type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>" />
							<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
								<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php _e( 'Remember me', 'woocommerce' ); ?></span>
							</label>
						</p>
						<p class="woocommerce-LostPassword lost_password">
							<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
						</p>

						<?php do_action( 'woocommerce_login_form_end' ); ?>

					</form>

				</div>
			<?php endif; ?>

			<?php if( 'yes' == $show_login_form ): ?>
				<div class="u-column2 col-2">
			<?php endif; ?>


				<h2><?php _e( 'Register', 'yith-woocommerce-affiliates' ); ?></h2>

				<form method="post" class="register">

					<?php do_action( 'woocommerce_register_form_start' ); ?>

                    <?php do_action( 'yith_wcaf_register_form_start' ); ?>

                    <?php if ( 'yes' == $show_name_field ) : ?>

                        <p class="form-row form-row-wide">
                            <label for="reg_first_name"><?php _e( 'First name', 'yith-woocommerce-affiliates' ); ?></label>
                            <input type="text" class="input-text" name="first_name" id="reg_first_name" value="<?php if ( ! empty( $_POST['first_name'] ) ) echo esc_attr( $_POST['first_name'] ); ?>" />
                        </p>

                    <?php endif; ?>

                    <?php if ( 'yes' == $show_surname_field ) : ?>

                        <p class="form-row form-row-wide">
                            <label for="reg_last_name"><?php _e( 'Last name', 'yith-woocommerce-affiliates' ); ?></label>
                            <input type="text" class="input-text" name="last_name" id="reg_last_name" value="<?php if ( ! empty( $_POST['last_name'] ) ) echo esc_attr( $_POST['last_name'] ); ?>" />
                        </p>

                    <?php endif; ?>

                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                        <p class="form-row form-row-wide">
                            <label for="reg_username"><?php _e( 'Username', 'yith-woocommerce-affiliates' ); ?> <span class="required">*</span></label>
                            <input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
                        </p>

                    <?php endif; ?>

                    <p class="form-row form-row-wide">
                        <label for="reg_email"><?php _e( 'Email address', 'yith-woocommerce-affiliates' ); ?> <span class="required">*</span></label>
                        <input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
                    </p>

                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                        <p class="form-row form-row-wide">
                            <label for="reg_password"><?php _e( 'Password', 'yith-woocommerce-affiliates' ); ?> <span class="required">*</span></label>
                            <input type="password" class="input-text" name="password" id="reg_password" />
                        </p>

                    <?php endif; ?>

                    <?php if( apply_filters( 'yith_wcaf_payment_email_required', true ) ): ?>
                    <p class="form-row form-row-wide">
                        <label for="payment_email"><?php _e( 'Payment email address', 'yith-woocommerce-affiliates' ); ?> <span class="required">*</span></label>
                        <input type="email" class="input-text" name="payment_email" id="payment_email" value="<?php if ( ! empty( $_POST['payment_email'] ) ) echo esc_attr( $_POST['payment_email'] ); ?>" />
                    </p>
                    <?php endif; ?>

                    <!-- Spam Trap -->
                    <div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'yith-woocommerce-affiliates' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

                    <?php do_action( 'yith_wcaf_register_form' ); ?>
                    <?php do_action( 'woocommerce_register_form' ); ?>

                    <p class="form-row">
                        <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                        <?php wp_nonce_field( 'yith-wcaf-register-affiliate', 'register_affiliate', false ); ?>

                        <input type="submit" class="button" name="register" value="<?php _e( 'Register', 'yith-woocommerce-affiliates' ); ?>" />
                    </p>

                    <?php do_action( 'woocommerce_register_form_end' ); ?>

                </form>

			<?php if( 'yes' == $show_login_form ): ?>
				</div>
			<?php endif; ?>

		<?php if( 'yes' == $show_login_form ): ?>
			</div>
		<?php endif; ?>

	<?php elseif( ! YITH_WCAF_Affiliate_Handler()->is_user_affiliate() ): ?>
		<p>
			<?php echo apply_filters( 'yith_wcaf_registration_form_become_affiliate_text', __( 'You\'re just one step away from becoming an affiliate!', 'yith-woocommerce-affiliates'  ) );?>
		</p>
		<?php $become_an_affiliate_text = apply_filters( 'yith_wcaf_become_affiliate_button_text', __( 'Become an affiliate', 'yith-woocommerce-affiliates' ) ); ?>
		<a class="btn button" href="<?php echo esc_url( add_query_arg( 'become_an_affiliate', true ) ) ?>"><?php echo $become_an_affiliate_text?></a>
	<?php

	elseif( YITH_WCAF_Affiliate_Handler()->is_user_enabled_affiliate() ):
		echo apply_filters( 'yith_wcaf_registration_form_already_affiliate_text', __( 'You have already affiliated with us. Thank you!', 'yith-woocommerce-affiliates'  ) );
	elseif( YITH_WCAF_Affiliate_Handler()->is_user_affiliate() ):
		echo apply_filters( 'yith_wcaf_registration_form_affiliate_disabled_text', __( 'Your request has been registered and it is awaiting administrators approval!', 'yith-woocommerce-affiliates'  ) );
	endif;

	?>

</div>