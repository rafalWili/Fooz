 <?php    
      $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'medium'); 
      $genre_names = 'Brak'; // wartość domyślna

        $terms = wp_get_post_terms( get_the_ID(), 'genre' );
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            $names = wp_list_pluck( $terms, 'name' );
            $genre_names = implode( ', ', $names );
        }
        ?>
    


 <div class="col-md-4 mb-4 booksCard--column" onclick="location.href='<?php the_permalink(); ?>';">
                    <div class="card h-100 booksCard--item">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="booksCard--item-image">
                                <img loading="lazy" src="<?php echo esc_url($featured_img_url); ?>" alt="<?php the_title(); ?>" class="card-img-top booksCard--image">
                            </div>                            
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h2 class="card-title booksCard--title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <p class="card-text"><?php echo esc_html( $genre_names ); ?></p>
                             <?php echo get_the_date(); ?><br>

                        </div>
                    </div>
                </div>