<?php
/**
 * Template for the paypal field added to the user profile edit page
 */
$selected = get_user_meta( $user->ID, 'enable_paypal', true );
?>
<h3><?php _e( 'Enable PayPal', 'paypal-switcher' ); ?></h3>

<table class="form-table">
	<tr>
		<th><label for="enable_paypal"><?php _e( 'Enable PayPal', 'paypal-switcher' ); ?></label></th>
		<td>
			<select id="enable_paypal" name="enable_paypal">
				<option value="yes" <?php if( $selected == 'yes' ) { echo 'selected'; } ?>>Yes</option>
				<option value="no" <?php if ( $selected !== 'yes' ) { echo 'selected'; } ?>>No</option>
			</select>
		</td>
	</tr>
</table>