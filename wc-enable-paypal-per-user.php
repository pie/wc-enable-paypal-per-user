<?php
/*
Plugin Name: WooCommerc PayPal: Enable PayPal per User
Plugin URI:  #
Description: Enables an admin to toggle specific users to be able to pay using paypal
Version: 0.1
Author: The team at PIE
Author URI: http://pie.co.de
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

/* PIE\WCEnablePaypalPerUser is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version.

PIE\WCEnablePaypalPerUser is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with PIE\WCEnablePaypalPerUser. If not, see https://www.gnu.org/licenses/gpl-3.0.en.html */

namespace PIE\WCEnablePaypalPerUser;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add template to display a checkbox to enable/disable paypal on the user
 * profile page
 *
 * @param \WP_User $user
 */
function add_user_paypal_field( $user ) {
	require_once 'templates/user-paypal-field.php';
}
add_action( 'edit_user_profile', __NAMESPACE__ . '\add_user_paypal_field' );

/**
 * Save paypal option when the user profile is updated
 *
 * @param  int $user_id
 * @return bool
 */
function save_user_paypal_option( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	} else {
		if ( isset( $_POST['enable_paypal'] ) ) {
			update_user_meta( $user_id, 'enable_paypal', $_POST['enable_paypal'] );
		}
	}

	return true;
}
add_action( 'edit_user_profile_update', __NAMESPACE__ . '\save_user_paypal_option' );

/**
 * Allow paypal payment gateway if user has been allowed access
 *
 * @param  array $available_gateways
 * @return mixed
 */
function enable_paypal_for_user( $available_gateways ) {
	$user = get_current_user_id();
	if ( isset( $available_gateways['paypal'] ) && 'yes' !== get_user_meta( $user, 'enable_paypal', true ) ) {
		unset( $available_gateways['paypal'] );
	}
	if ( isset( $available_gateways['ppcp-gateway'] ) && 'yes' !== get_user_meta( $user, 'enable_paypal', true ) ) {
		unset( $available_gateways['ppcp-gateway'] );
	}

	return $available_gateways;
}
add_filter( 'woocommerce_available_payment_gateways', __NAMESPACE__ . '\enable_paypal_for_user' );
