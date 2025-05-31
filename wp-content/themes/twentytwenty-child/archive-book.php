<?php

$paged = max( 1, get_query_var('paged'), get_query_var('page') );

get_header();

?>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title"><?php _e('Books Library', 'fooz'); ?></h1>
                <p><?php _e('Browse through our collection of books.', 'fooz'); ?></p>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title"><?php _e('Latest Release', 'fooz'); ?></h1>
                    <?php echo do_shortcode('[recent_book]'); ?>
            </div>
        </div>
    </div>


<?php 
if (have_posts()) : ?>
    <div class="container">
        <div class="row gutters-4">
            <?php 
            while (have_posts()) : the_post(); 
                get_template_part('template-parts/books', 'loops');
             endwhile; 
             ?>
        </div>

        <?php 
        get_template_part('template-parts/pagination', null, array('paged' => $paged));
        ?>

    </div>

<?php else : ?>
    <div class="container">
        <p><?php _e('No books found.', 'textdomain'); ?></p>
    </div>
<?php endif;

wp_reset_postdata();


get_footer();
?>
