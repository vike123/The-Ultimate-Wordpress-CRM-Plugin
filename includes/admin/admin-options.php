<?php
/***************************
* Admin area options page
***************************/

//Setup the options page
function uwpcrm_admin_options() {

	global $uwpcrm_options;
	
	ob_start(); ?>
	
	<div class="wrap">
		<h2>Customer/Reseller Portal Options</h2>
		<p>This page sets the options for our portal.</p>
		
		<form method="post" action="options.php">
			
			<?php settings_fields( 'uwpcrm_settings_group' ); ?>
			
			<h4>Enable</h4>
			<p>
				<label class="description" for="uwpcrm_settings[enable]">Enable</label>
				<input id="uwpcrm_settings[enable]" name="uwpcrm_settings[enable]" type="checkbox" value="1" <?php checked( '1', $uwpcrm_options[ 'enable' ] );?>/>
			</p>
			
			<h4>Twitter Information</h4>
			<p>
				<label class="description" for="uwpcrm_settings[twitter_url]">Enter your Twitter URL</label>
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
	add_options_page( 'Customer/Reseller Portal Options', 'WP CRM', 'manage_options', 'uwpcrm-options', 'uwpcrm_admin_options' );
}

add_action( 'admin_menu', 'uwpcrm_add_options_menu' );

function uwpcrm_register_settings() {
	register_setting( 'uwpcrm_settings_group', 'uwpcrm_settings' );
}

add_action( 'admin_init', 'uwpcrm_register_settings');