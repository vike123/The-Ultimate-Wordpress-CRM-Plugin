<?php
//Register Service Types Custom Taxonomy
add_action( 'init', 'uwpcrm_register_taxonomy_service_type' );

function uwpcrm_register_taxonomy_service_type() {

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
add_action( 'init', 'uwpcrm_register_cpt_service' );

function uwpcrm_register_cpt_service() {

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

    register_post_type( 'service', $args );
}