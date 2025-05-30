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

