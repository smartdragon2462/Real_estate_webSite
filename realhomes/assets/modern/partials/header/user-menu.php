<?php
$enable_user_nav = get_option( 'theme_enable_user_nav' );

if ( ! empty( $enable_user_nav ) && 'true' === $enable_user_nav ) {

	$theme_login_url = inspiry_get_login_register_url(); // login and register page URL

	if ( is_user_logged_in() ) {
		?>
		<div class="rh_menu__user_profile">
			<?php
			// Get user information.
			$current_user  = wp_get_current_user();
			$user_email    = $current_user->user_email;
			$user_gravatar = inspiry_get_gravatar( $user_email, '150' );
			?>
			<img class="user-icon" src="<?php echo esc_url( $user_gravatar ); ?>" alt="<?php echo esc_attr( $current_user->display_name ) ?>">
			<?php
			// modal login.
			get_template_part( 'assets/modern/partials/header/modal' );
			?>
		</div><!-- /.rh_menu__user_profile -->
		<?php
	} elseif ( empty( $theme_login_url ) && ( ! is_page_template( 'templates/login-register.php' ) ) && ( ! is_user_logged_in() ) ) {
		?>
		<div class="rh_menu__user_profile">
			<?php
			include INSPIRY_THEME_DIR . '/images/icons/icon-profile.svg';
			// modal login.
			get_template_part( 'assets/modern/partials/header/modal' );
			?>
		</div><!-- /.rh_menu__user_profile -->
		<?php
	} elseif ( ! empty( $theme_login_url ) && ( ! is_user_logged_in() ) ) {
		?>
		<a class="rh_menu__user_profile" href="<?php echo esc_url( $theme_login_url ); ?>">
			<?php include INSPIRY_THEME_DIR . '/images/icons/icon-profile.svg'; ?>
		</a><!-- /.rh_menu__user_profile -->
		<?php
	}

}
