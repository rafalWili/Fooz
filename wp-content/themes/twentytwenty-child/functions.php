<?php
function fooz_enqueue_styles() {
    //loads the parent theme stylesheet
    wp_enqueue_style( 'twentytwenty-style', get_template_directory_uri() . '/style.css' );

    // loads the child theme stylesheet
    // with a dependency on the parent theme stylesheet
    wp_enqueue_style( 'fooz-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'twentytwenty-style' ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'fooz_enqueue_styles' );