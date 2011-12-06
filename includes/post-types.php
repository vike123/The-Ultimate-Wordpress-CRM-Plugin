<?php

//Register our Account CPT

function uwpcrm_register_cpt_account() {

    $labels = array( 
        'name' => __( 'Accounts', 'uwpcrm' ),
        'singular_name' => __( 'Account', 'uwpcrm' ),
        'add_new' => __( 'Add New', 'uwpcrm' ),
        'add_new_item' => __( 'Add New Account', 'uwpcrm' ),
        'edit_item' => __( 'Edit Account', 'uwpcrm' ),
        'new_item' => __( 'New Account', 'uwpcrm' ),
        'view_item' => __( 'View Account', 'uwpcrm' ),
        'search_items' => __( 'Search Accounts', 'uwpcrm' ),
        'not_found' => __( 'No accounts found', 'uwpcrm' ),
        'not_found_in_trash' => __( 'No accounts found in Trash', 'uwpcrm' ),
        'parent_item_colon' => __( 'Parent Account:', 'uwpcrm' ),
        'menu_name' => __( 'Accounts', 'uwpcrm' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Used to store account information',
        'supports' => array( 'title', 'page-attributes' ),
        'taxonomies' => array( 'account_type' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => false,
        
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'uwpcrm_account', $args );
}

add_action( 'init', 'uwpcrm_register_cpt_account' );

//Register Account Types Custom Taxonomy

function vtp_register_taxonomy_account_type() {

    $labels = array( 
        'name' => __( 'Account Types', 'uwpcrm' ),
        'singular_name' => __( 'Account Type', 'uwpcrm' ),
        'search_items' => __( 'Search Account Types', 'uwpcrm' ),
        'popular_items' => __( 'Popular Account Types', 'uwpcrm' ),
        'all_items' => __( 'All Account Types', 'uwpcrm' ),
        'parent_item' => __( 'Parent Account Type', 'uwpcrm' ),
        'parent_item_colon' => __( 'Parent Account Type:', 'uwpcrm' ),
        'edit_item' => __( 'Edit Account Type', 'uwpcrm' ),
        'update_item' => __( 'Update Account Type', 'uwpcrm' ),
        'add_new_item' => __( 'Add New Account Type', 'uwpcrm' ),
        'new_item_name' => __( 'New Account Type Name', 'uwpcrm' ),
        'separate_items_with_commas' => __( 'Separate account types with commas', 'uwpcrm' ),
        'add_or_remove_items' => __( 'Add or remove account types', 'account type' ),
        'choose_from_most_used' => __( 'Choose from the most used account types', 'uwpcrm' ),
        'menu_name' => __( 'Account Types', 'uwpcrm' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => false,
        'show_in_nav_menus' => false,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true,

        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'uwpcrm_account_type', array('uwpcrm_account'), $args );
    
}

add_action( 'init', 'vtp_register_taxonomy_account_type' );
