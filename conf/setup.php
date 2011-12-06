<?php
//Bring the magic!

require_once UWPCRM_ROOT . '/includes/post-types.php';

//Add Plugin Top Level Menu
function uwpcrm_setup_menus() {
	add_menu_page( __( 'Ultimate WP CRM', 'uwpcrm' ), __( 'WP CRM', 'uwpcrm' ), 'manage_options', 'uwpcrm-options', 'uwpcrm_admin_options' );
	//Add the sub panels @TODO MAKE IT WORK!
	add_submenu_page( 'uwpcrm-options', __( 'Account Types', 'uwpcrm' ), __(' Account Types', 'uwpcrm' ), 'manage_options', 'edit-tags.php?taxonomy=uwpcrm_account_type' );
	add_submenu_page( 'uwpcrm-options', __( 'Settings', 'uwpcrm' ), __( 'Settings', 'uwpcrm' ), 'manage_options', 'uwpcrm-settings', 'uwpcrm_admin_options' );
}

add_action( 'admin_menu', 'uwpcrm_setup_menus' );

// highlight the proper top level menu because Wordpress doesn't let us do this already!
function uwpcrm_tax_menu_correction( $parent_file ) {
	global $current_screen;
	$taxonomy = $current_screen->taxonomy;
	if ( strstr($taxonomy, 'uwpcrm') )
		$parent_file = 'uwpcrm-options';
	return $parent_file;
}

//add_action( 'parent_file', 'uwpcrm_tax_menu_correction' );

//Add the options page
function uwpcrm_admin_options() {

	global $uwpcrm_options;
	
	//Loads of work here to do was just working out what I might want to show and how!
	ob_start(); ?>
	
	<div class="wrap">
		<h2><?php echo _e( 'CRM Plugin Options', 'uwpcrm' );?></h2>
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

//Add Settings Group
function uwpcrm_register_settings() {
	register_setting( 'uwpcrm_settings_group', 'uwpcrm_settings' );
}

add_action( 'admin_init', 'uwpcrm_register_settings');