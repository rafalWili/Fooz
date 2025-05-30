<?php
function fooz_enqueue_assets() {
    //loads the parent theme stylesheet
    wp_enqueue_style( 'twentytwenty-style', get_template_directory_uri() . '/style.css' );

    wp_enqueue_style( 'bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', array(), '4.5.2' );
    // loads the child theme stylesheet
    // with a dependency on the parent theme stylesheet
    // potencially to override parent styles (one way to do it - task 1) 
    wp_enqueue_style( 'fooz-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'twentytwenty-style' ),
        wp_get_theme()->get('Version')
    );
     if ( is_post_type_archive('book') || is_tax('genre') ) {
        wp_enqueue_style( 'book-archive-style', get_stylesheet_directory_uri() . '/assets/css/books-archive.css' );
    }
     if ( is_singular('book') ) {
        wp_enqueue_style( 'book-archive-style', get_stylesheet_directory_uri() . '/assets/css/book-single.css' );
    }

    // scripts
    wp_enqueue_script( 'popper-js', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js', array('jquery'), '1.16.1', true );
    wp_enqueue_script( 'bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery', 'popper-js'), '4.5.2', true );
        wp_enqueue_script(
        'fooz-custom-js', 
        get_stylesheet_directory_uri() . '/assets/js/scripts.js', 
        array('jquery','bootstrap-js'), 
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
        'has_archive' => 'library',
        'rewrite' => array( 'slug' => 'library', 'with_front' => false ),
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


//Aditionaly Import books from file books.json 
function fooz_import_books_once() {
    if ( ! current_user_can('manage_options') ) {
        return; 
    }
    
    //  import only once 
    if ( get_option('fooz_books_imported') ) {
        return;
    }
    
    $books_json_path = get_stylesheet_directory() . '/assets/utils/books.json';

    if ( ! file_exists($books_json_path) ) {
        error_log('Books JSON file not found!');
        return;
    }

    $json_content = file_get_contents($books_json_path);
    $books_array = json_decode($json_content, true);
    if ( empty($books_array) || ! isset($books_array['books']) ) {
        error_log('Books JSON is empty or malformed');
        return;
    }

    foreach ($books_array['books'] as $category_data) {
        $genre_name = $category_data['category'];

        $term = term_exists($genre_name, 'genre');
        if (!$term) {
            $term = wp_insert_term($genre_name, 'genre');
            if (is_wp_error($term)) {
                error_log('Failed to create genre term: ' . $genre_name);
                continue;
            }
            $term_id = $term['term_id'];
        } else {
            $term_id = $term['term_id'];
        }

        // Add books to the custom post type 'book'

        foreach ($category_data['items'] as $book) {
            // check if the book already exists
            $existing = get_page_by_title($book['title'], OBJECT, 'book');
            if ($existing) {
                continue;
            }

            $postarr = [
                'post_title'   => wp_strip_all_tags($book['title']),
                'post_content' => $book['excerpt'],
                'post_type'    => 'book',
                'post_status'  => 'publish',
                'post_excerpt' => $book['excerpt'],
                'post_date'    => date('Y-m-d H:i:s', strtotime($book['date'] . '-01-01')),
            ];

            $post_id = wp_insert_post($postarr);

            if (!is_wp_error($post_id)) {
                wp_set_object_terms($post_id, (int)$term_id, 'genre');

                if (!empty($book['coverUrl'])) {
                    fooz_set_featured_image_from_url($post_id, $book['coverUrl']);
                }
            }
        }
    }

    update_option('fooz_books_imported', 1); // set end of the import 
}

function fooz_set_featured_image_from_url($post_id, $image_url) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    $tmp = download_url($image_url);
    if (is_wp_error($tmp)) {
        return false;
    }

    $file_array = [
        'name' => basename($image_url),
        'tmp_name' => $tmp,
    ];

    $attachment_id = media_handle_sideload($file_array, $post_id);

    if (is_wp_error($attachment_id)) {
        @unlink($file_array['tmp_name']);
        return false;
    }

    set_post_thumbnail($post_id, $attachment_id);
    return true;
}

// admin hook to trigger the import function
add_action('admin_init', 'fooz_import_books_once');

// set  query vars for the book archive pagination
add_action('pre_get_posts', function($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_post_type_archive('book')  || is_tax('genre')) {
        $query->set('posts_per_page', 5);
    }
});