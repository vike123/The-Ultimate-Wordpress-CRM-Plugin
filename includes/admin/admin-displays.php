<?php
/***************************
* Customise Admin Area Views
***************************/


/**
	Accounts Post Type Listing
**/

//Define Columns
function uwpcrm_edit_account_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'Account',
		'url' => 'Website',
		'email' => 'Email',
		'account_manager' => 'Account Manager'
	);
	
	return $columns;
} 

add_filter( 'manage_edit-account_columns', 'uwpcrm_edit_account_columns' );

//Define contents
function uwpcrm_manage_custom_columns( $column ) {
	global $post;
	
	switch ( $column ) {
		case 'url' :
			$url = get_post_meta( $post->ID, '_uwpcrm_url', true );
			if ( empty( $url ) ) :
				echo 'Not Entered';
			else :
				if ( ! preg_match( '~^(?:f|ht)tps?://~i', $url ) ) $url = 'http://' . $url;
				echo '<a href="' . $url . '" target="_blank">' . $url . '</a>';
			endif;	
			
		break;
		
		case 'email' :
			$email = get_post_meta( $post->ID, '_uwpcrm_email', true );
			if ( empty( $email ) )
				echo 'Not Entered';
			else
				echo '<a href="mailto:' . $email . '">' . $email . '</a>';
		break;
		
		case 'account_manager' :
			$account_manager = get_post_meta( $post->ID, '_uwpcrm_account_manager', true );
			$account_manager = get_userdata( $account_manager );
			
			if ( empty( $account_manager ) )
				echo 'Not entered';
			else
				echo $account_manager->display_name;
			break;
	}	
}

add_action( 'manage_account_posts_custom_column', 'uwpcrm_manage_custom_columns' );

//Make Columns Sortable
function uwpcrm_account_sortable_columns( $columns ) {
	$columns['account_manager'] = 'account_manager';
	
	return $columns;
}

add_filter( 'manage_edit-account_sortable_columns', 'uwpcrm_account_sortable_columns' );

//Only run on edit page in the admin area
function uwpcrm_edit_account_load() {
	add_filter( 'request', 'uwpcrm_sort_accounts' );
}

//Actually do the sorting
function uwpcrm_sort_accounts( $vars ) {
	if ( isset( $vars['post_type'] ) && 'account' == $vars['post_type'] ) :
		if ( isset( $vars['orderby'] ) && 'account_manager' == $vars['orderby'] ) {
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => '_uwpcrm_account_manager',
					'orderby' => 'meta_value'
				)
			);
		}
	endif;
	
	return $vars;
} 

add_action( 'load-edit.php', 'uwpcrm_edit_account_load' );