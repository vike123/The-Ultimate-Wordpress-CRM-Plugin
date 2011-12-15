<?php
//Register Account Types Custom Taxonomy
add_action( 'init', 'uwpcrm_register_taxonomy_account_type' );

function uwpcrm_register_taxonomy_account_type() {

    $labels = array( 
        'name' => _x( 'Account Types', 'account type' ),
        'singular_name' => _x( 'Account Type', 'account type' ),
        'search_items' => _x( 'Search Account Types', 'account type' ),
        'popular_items' => _x( 'Popular Account Types', 'account type' ),
        'all_items' => _x( 'All Account Types', 'account type' ),
        'parent_item' => _x( 'Parent Account Type', 'account type' ),
        'parent_item_colon' => _x( 'Parent Account Type:', 'account type' ),
        'edit_item' => _x( 'Edit Account Type', 'account type' ),
        'update_item' => _x( 'Update Account Type', 'account type' ),
        'add_new_item' => _x( 'Add New Account Type', 'account type' ),
        'new_item_name' => _x( 'New Account Type Name', 'account type' ),
        'separate_items_with_commas' => _x( 'Separate account types with commas', 'account type' ),
        'add_or_remove_items' => _x( 'Add or remove account types', 'account type' ),
        'choose_from_most_used' => _x( 'Choose from the most used account types', 'account type' ),
        'menu_name' => _x( 'Account Types', 'account type' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true,

        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'account_type', array('account'), $args );
    
}

//Register our Account CPT
add_action( 'init', 'uwpcrm_register_cpt_account' );

function uwpcrm_register_cpt_account() {

    $labels = array( 
        'name' => _x( 'Accounts', 'account' ),
        'singular_name' => _x( 'Account', 'account' ),
        'add_new' => _x( 'Add New', 'account' ),
        'add_new_item' => _x( 'Add New Account', 'account' ),
        'edit_item' => _x( 'Edit Account', 'account' ),
        'new_item' => _x( 'New Account', 'account' ),
        'view_item' => _x( 'View Account', 'account' ),
        'search_items' => _x( 'Search Accounts', 'account' ),
        'not_found' => _x( 'No accounts found', 'account' ),
        'not_found_in_trash' => _x( 'No accounts found in Trash', 'account' ),
        'parent_item_colon' => _x( 'Parent Account:', 'account' ),
        'menu_name' => _x( 'Accounts', 'account' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Used to store account information',
        'supports' => array( 'title', 'page-attributes' ),
        'taxonomies' => array( 'account_type' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'uwpcrm-options',
        
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'account', $args );
}

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