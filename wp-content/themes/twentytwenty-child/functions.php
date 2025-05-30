<?php
function fooz_enqueue_assets() {
    //loads the parent theme stylesheet
    wp_enqueue_style( 'twentytwenty-style', get_template_directory_uri() . '/style.css' );

    // loads the child theme stylesheet
    // with a dependency on the parent theme stylesheet
    // potencially to override parent styles (one way to do it - task 1) 
    wp_enqueue_style( 'fooz-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'twentytwenty-style' ),
        wp_get_theme()->get('Version')
    );

        wp_enqueue_script(
        'fooz-custom-js', 
        get_stylesheet_directory_uri() . '/assets/js/scripts.js', 
        array('jquery'), 
        '1.0.0', 
        true // Load in the footer
    );
}
add_action( 'wp_enqueue_scripts', 'fooz_enqueue_assets' );

# Task 2: Load js file in the footer - fooz_enqueue_assets -> wp_enqueue_script

# Task 3 CPT - Register a custom post type called "Book"

function fooz_register_book_cpt() {
    $labels = array(
        'name'               => _x( 'Books', 'post type general name', 'fooz' ),
        'singular_name'      => _x( 'Book', 'post type singular name', 'fooz' ),
        'menu_name'          => _x( 'Books', 'admin menu', 'fooz' ),
        'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'fooz' ),
        'add_new'            => _x( 'Add New', 'book', 'fooz' ),
        'add_new_item'       => __( 'Add New Book', 'fooz' ),
        'new_item'           => __( 'New Book', 'fooz' ),
        'edit_item'          => __( 'Edit Book', 'fooz' ),
        'view_item'          => __( 'View Book', 'fooz' ),
        'all_items'          => __( 'All Books', 'fooz' ),
        'search_items'       => __( 'Search Books', 'fooz' ),
        'parent_item_colon'  => __( 'Parent Books:', 'fooz' ),
        'not_found'          => __( 'No books found.', 'fooz' ),
        'not_found_in_trash' => __( 'No books found in Trash.', 'fooz' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'library' ),
        'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),

    );

    register_post_type( "book", $args );
}

    add_action('init', 'fooz_register_book_cpt');

    function fooz_register_book_taxonomy() {
    $labels = array(
        'name'              => _x( 'Genre', 'taxonomy general name', 'fooz' ),
        'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'fooz' ),
        'search_items'      => __( 'Search Genres', 'fooz' ),
        'all_items'         => __( 'All Genres', 'fooz' ),
        'parent_item'       => __( 'Parent Genre', 'fooz' ),
        'parent_item_colon' => __( 'Parent Genre:', 'fooz' ),
        'edit_item'         => __( 'Edit Genre', 'fooz' ),
        'update_item'       => __( 'Update Genre', 'fooz' ),
        'add_new_item'      => __( 'Add New Genre', 'fooz' ),
        'new_item_name'     => __( 'New Genre Name', 'fooz' ),
        'menu_name'         => __( 'Genre', 'fooz' ),
    );

    $args = array(
        'hierarchical'      => true, 
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'book-genre' ), // slug w URL-u
    );

    register_taxonomy( 'genre', array( 'book' ), $args );
}
add_action( 'init', 'fooz_register_book_taxonomy' );



