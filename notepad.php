<?php
define( 'UWPCRM_ROOT', dirname( __FILE__ ) );

/***************************
* Includes
***************************/

require_once UWPCRM_ROOT . '/includes/scripts.php'; //To enqueue all JS and CSS used
require_once UWPCRM_ROOT . '/includes/config.php'; //Plugin Config

require_once UWPCRM_ROOT . '/includes/admin/admin-options.php'; //Admin Page
require_once UWPCRM_ROOT . '/includes/admin/admin-displays.php'; //Admin Page
require_once UWPCRM_ROOT . '/includes/admin/meta-boxes/meta-box-usage.php'; //Defines our CPT Meta Boxes

require_once UWPCRM_ROOT . '/includes/functions/post-types.php'; //Sets up Custom post types and taxonomies
require_once UWPCRM_ROOT . '/includes/functions/users.php'; //Sets user profile fields

/***************************
* Plugin Setup
***************************/

global $uwpcrm_db_version;
$uwpcrm_db_version = '1.0';

//On Plugin activation create the SQL Tables and add DB Version to Options Table
function uwpcrm_install() {
	
	
/* JUST PLAYING IGNORE
	global $wpdb, $uwpcrm_db_version;
	
	$table_name = $wpdb->prefix . 'uwpcrm_accounts';
	
	$sql = "CREATE TABLE  $table_name  (id int(11) NOT NULL AUTO_INCREMENT, time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL, name tinytext NOT NULL, text text NOT NULL, PRIMARY KEY (id) );";
	
	$wpdb->query( $sql );
		
	add_option( 'uwpcrm_db_version', $uwpcrm_db_version );
*/
	//We use this in our setup to create terms!
	add_option( 'uwpcrm_initial_setup', '1' );
}

register_activation_hook( __FILE__, 'uwpcrm_install' );

//Initialise our original data into the Plugin DB Tables and run any data scripts
function uwpcrm_install_data() {
	
/* JUST PLAYING IGNORE
	global $wpdb;
	$table_name = $wpdb->prefix . 'uwpcrm_accounts';

	$welcome_name = 'Mr. Wordpress';
	$welcome_text = 'Congrats, you just made your first plugin write to DB!';
	
	$rows_affected = $wpdb->insert( $table_name, array( 
		'time' => current_time( 'mysql' ),
		'name' => $welcome_name,
		'text' => $welcome_text 
		) 
	);
*/
}

register_activation_hook( __FILE__, 'uwpcrm_install_data' );

//Set up our Custom Default Terms only does something if setup option is flagged in the options table
function uwpcrm_setup_terms() {
    
    if ( get_option( 'uwpcrm_initial_setup') ) :
	    
	    if ( ! term_exists( 'Customer', 'account_type' ) ) {
			wp_insert_term( 'Customer',	'account_type' );
		}
		
		if ( ! term_exists( 'Reseller', 'account_type' ) ) {
			wp_insert_term( 'Reseller', 'account_type' );
		}
		delete_option( 'uwpcrm_initial_setup' );
	endif;	
}

add_action( 'init', 'uwpcrm_setup_terms', 11 );

//On Plugin Deactivation Drop the tables and remove option reference.
function uwpcrm_uninstall() {

/* JUST PLAYING IGNORE
	global $wpdb;
	$table_name = $wpdb->prefix . 'uwpcrm_accounts';
	
	$sql = "DROP TABLE IF EXISTS $table_name;";
	$wpdb->query( $sql );
	
	delete_option( 'uwpcrm_db_version' );
*/
}

register_deactivation_hook( __FILE__, 'uwpcrm_uninstall' );
