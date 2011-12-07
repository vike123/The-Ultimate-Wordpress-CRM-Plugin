<?php
//Adds additional fields to the user profiles

add_action( 'show_user_profile', 'vtp_extra_profile_fields' );
add_action( 'edit_user_profile', 'vtp_extra_profile_fields' );

function vtp_extra_profile_fields( $user ) {
	?>
	
	<h3>Profile Information</h3>
	
	<table class="form-table">
		<tr>
			<th><label for="account">Account</label></th>
			<td>
			<?php 
			$args = array(
				'post_type' => 'account',
				'post_status' => 'publish'
			);
			$accounts = get_posts( $args ); ?>
			
			<select name="account" id="account">
				<?php foreach ( $accounts as $account ) { ?>
					<option value="<?php echo $account->ID;?>" <?php selected( (int)get_user_meta( $user->ID, 'account', true) == $account->ID );?>><?php echo $account->post_title;?></option>
				<?php } ?>
			
			</select> 
			
			</td>
		</tr>
	</table>
	
	<?php
}

//Saves the additional Field Information

add_action( 'personal_options_update', 'vtp_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'vtp_save_extra_profile_fields' );

function vtp_save_extra_profile_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) )
		return false;
		
	update_user_meta( $user_id, 'account', $_POST[ 'account' ] );
} 

//Update the contact methods

function vtp_extended_contact_info($user_contactmethods) {  

	$user_contactmethods = array(
		'telephone' => 'Telephone',
		'mobilephone' => 'Mobile Phone',
		);  

	return $user_contactmethods;
}  

add_filter('user_contactmethods', 'vtp_extended_contact_info');	