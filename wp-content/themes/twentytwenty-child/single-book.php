<?php
get_header();

if (have_posts()) : while (have_posts()) : the_post();
    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
    $categories = get_the_term_list(get_the_ID(), 'genre', '', ', ', '');
    $date = get_the_date();

    $genre_prefix =  (is_array($categories) ? 'Genres' : 'Genre');
    $genre_names = 'Brak'; // wartość domyślna

    $terms = wp_get_post_terms(get_the_ID(), 'genre');
    if (! empty($terms) && ! is_wp_error($terms)) {
        $names = wp_list_pluck($terms, 'name');
        $genre_names = implode(', ', $names);
    }
    ?>

<!-- Banner -->
<div class="book-banner text-white d-flex align-items-center" style="background-color: #333; height: 25vh;">
    <div class="container">
        <h1 class="mb-0"><?php the_title(); ?></h1>
    </div>
</div>

<!-- Content -->
<div class="container my-5">
    <div class="row book--row">
        <!-- Thumbnail -->
        <div class="col-md-4 mb-4">
            <div class="book--thumbnail">
                <?php if ($thumbnail_url): ?>
                <img src="<?php echo esc_url($thumbnail_url); ?>"
                    class="img-fluid rounded shadow-sm"
                    alt="<?php the_title_attribute(); ?>">
                <?php else: ?>
                <div class="bg-secondary text-white text-center py-5 rounded">Brak okładki</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Content -->
        <div class="col-md-8">
            <p class="text-muted mb-1">
                <strong><?php echo $genre_prefix; ?>: </strong>
                <?php echo $genre_names ?: 'Brak kategorii'; ?>
            </p>
            <p class="text-muted"><strong>Published:</strong>
                <?php echo esc_html($date); ?>
            </p>

            <div class="mt-4">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</div>

<?php
endwhile; endif;

get_footer();
?>