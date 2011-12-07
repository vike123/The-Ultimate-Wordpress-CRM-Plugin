<?php
/***************************
* Setup our Custom Post Types
* and Taxonomies
***************************/

//Register Account Types Custom Taxonomy
add_action( 'init', 'vtp_register_taxonomy_account_type' );

function vtp_register_taxonomy_account_type() {

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
add_action( 'init', 'vtp_register_cpt_account' );

function vtp_register_cpt_account() {

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
        'show_in_menu' => true,
        
        
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

//Register Service Types Custom Taxonomy
add_action( 'init', 'vtp_register_taxonomy_service_type' );

function vtp_register_taxonomy_service_type() {

    $labels = array( 
        'name' => _x( 'Service Types', 'service type' ),
        'singular_name' => _x( 'Service Type', 'service type' ),
        'search_items' => _x( 'Search service Types', 'service type' ),
        'popular_items' => _x( 'Popular service Types', 'service type' ),
        'all_items' => _x( 'All service Types', 'service type' ),
        'parent_item' => _x( 'Parent service Type', 'service type' ),
        'parent_item_colon' => _x( 'Parent service Type:', 'service type' ),
        'edit_item' => _x( 'Edit service Type', 'service type' ),
        'update_item' => _x( 'Update service Type', 'service type' ),
        'add_new_item' => _x( 'Add New service Type', 'service type' ),
        'new_item_name' => _x( 'New service Type Name', 'service type' ),
        'separate_items_with_commas' => _x( 'Separate service types with commas', 'service type' ),
        'add_or_remove_items' => _x( 'Add or remove service types', 'service type' ),
        'choose_from_most_used' => _x( 'Choose from the most used service types', 'service type' ),
        'menu_name' => _x( 'Service Types', 'service type' ),
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

    register_taxonomy( 'service_type', array('service'), $args );
    
}

//Register our service CPT
add_action( 'init', 'vtp_register_cpt_service' );

function vtp_register_cpt_service() {

    $labels = array( 
        'name' => _x( 'Services', 'service' ),
        'singular_name' => _x( 'Service', 'service' ),
        'add_new' => _x( 'Add New', 'service' ),
        'add_new_item' => _x( 'Add New service', 'service' ),
        'edit_item' => _x( 'Edit service', 'service' ),
        'new_item' => _x( 'New service', 'service' ),
        'view_item' => _x( 'View service', 'service' ),
        'search_items' => _x( 'Search services', 'service' ),
        'not_found' => _x( 'No services found', 'service' ),
        'not_found_in_trash' => _x( 'No services found in Trash', 'service' ),
        'parent_item_colon' => _x( 'Parent service:', 'service' ),
        'menu_name' => _x( 'Services', 'service' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Used to store service information',
        'supports' => array( 'title', 'page-attributes' ),
        'taxonomies' => array( 'service_type' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'service', $args );
}