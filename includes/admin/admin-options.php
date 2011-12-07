<?php
/***************************
* Admin area options page
***************************/

//Setup the options page
function uwpcrm_admin_options() {

	global $uwpcrm_options;
	
	ob_start(); ?>
	
	<div class="wrap">
		<h2><?php echo _e( 'Customer/Reseller Portal Options', 'uwpcrm' );?></h2>
		<p><?php echo _e( 'This page sets the options for our portal.', 'uwpcrm' );?></p>
		
		<form method="post" action="options.php">
			
			<?php settings_fields( 'uwpcrm_settings_group' ); ?>
			
			<h4><?php echo _e( 'Enable', 'uwpcrm' );?></h4>
			<p>
				<label class="description" for="uwpcrm_settings[enable]"><?php echo _e( 'Enable', 'uwpcrm' );?></label>
				<input id="uwpcrm_settings[enable]" name="uwpcrm_settings[enable]" type="checkbox" value="1" <?php checked( '1', $uwpcrm_options[ 'enable' ] );?>/>
			</p>
			
			<h4><?php echo _e( 'Twitter Information', 'uwpcrm' );?></h4>
			<p>
				<label class="description" for="uwpcrm_settings[twitter_url]"><?php echo _e( 'Enter your Twitter URL', 'uwpcrm' );?></label>
				<input id="uwpcrm_settings[twitter_url]" name="uwpcrm_settings[twitter_url]" type="text" value="<?php echo $uwpcrm_options[ 'twitter_url' ];?>" />
			</p>
			
			<p class="submit">
				<input type="submit" class="button-primary" value="Save Options" />
			</p>
		</form>
	</div>
	
	<?php echo ob_get_clean();
}

//Register the Menu Link
function uwpcrm_add_options_menu() {
	add_options_page( __( 'Customer/Reseller Portal Options', 'uwpcrm' ), __( 'WP CRM', 'uwpcrm' ), 'manage_options', 'uwpcrm-options', 'uwpcrm_admin_options' );
}

add_action( 'admin_menu', 'uwpcrm_add_options_menu' );

function uwpcrm_register_settings() {
	register_setting( 'uwpcrm_settings_group', 'uwpcrm_settings' );
}

add_action( 'admin_init', 'uwpcrm_register_settings');