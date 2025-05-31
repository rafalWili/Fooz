<?php
$paged = max(1, get_query_var('paged'), get_query_var('page'));
get_header();
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title">
                <?php single_term_title(); ?>
            </h1>
            <p><?php echo category_description(); ?></p>
        </div>
    </div>
</div>

<?php if (have_posts()) : ?>
<div class="container">
    <div class="row gutters-4">
        <?php while (have_posts()) : the_post();
            get_template_part('template-parts/books', 'loops');
        endwhile; ?>
    </div>

    <?php
        get_template_part('template-parts/pagination', null, array('paged' => $paged));
    ?>
</div>

<?php else : ?>
<div class="container">
    <p><?php _e('No books found in this genre.', 'textdomain'); ?>
    </p>
</div>
<?php endif;

wp_reset_postdata();
get_footer();
?>