<?php
/**
 * WP Mail related hooks
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Change the email address that WordPress sends from
 *
 * @param string $email Email address.
 * @return string $email Modified email address.
 */
function wp_mail_from( $email ) {
	if ( THEME_SETTINGS['domain'] && is_string( THEME_SETTINGS['domain'] ) ) {
		$email = 'no-reply@' . THEME_SETTINGS['domain'];
	}
	return $email;
} // end wp_mail_from


/**
 * Change the name that WordPress sends from
 *
 * @param string $name Name.
 * @return string $name Modified name.
 */
function wp_mail_from_name( $name ) {
	if ( THEME_SETTINGS['domain'] && is_string( THEME_SETTINGS['domain'] ) ) {
		$name = THEME_SETTINGS['domain'];
	}
	return $name;
} // end wp_mail_from_name


/**
 * Modify WP default new user notification message
 * --> remove login page link
 *
 * @TODO - This should be renamed to something more descriptive, like wp_registration_maiL_remove_login_link
 *
 * @param array $email    Email.
 * @return array $email   Modified email.
 */
function wp_new_user_notification_email( $email ) {

	if ( isset( $email['message'] ) && ! empty( $email['message'] ) ) {
		$message          = $email['message'];
		$modified_message = preg_replace( '/http.*$/', '', $message ); // remove last url from message (login page link).
		$email['message'] = $modified_message;
	}

	return $email;
} // end wp_new_user_notification_email
