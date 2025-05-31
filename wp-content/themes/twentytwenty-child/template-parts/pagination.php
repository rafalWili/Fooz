<?php
global $wp_query;
$paged = max(1, get_query_var('paged'), get_query_var('page'));

$base = str_replace(999999999, '%#%', get_pagenum_link(999999999));
$format = '';

$pagination_links = paginate_links(array(
    'base'      => $base,
    'format'    => $format,
    'total'     => $wp_query->max_num_pages,
    'current'   => $paged,
    'mid_size'  => 2,
    'prev_text' => __('«', 'textdomain'),
    'next_text' => __('»', 'textdomain'),
    'type'      => 'array',
));

if ($pagination_links) :
    ?>
<nav
    aria-label="<?php esc_attr_e('Page navigation', 'textdomain'); ?>">
    <ul class="pagination my-5 justify-content-center">
        <?php
            foreach ($pagination_links as $link) {
                $active = strpos($link, 'current') !== false ? ' active' : '';
                $link = str_replace('page-numbers', 'page-link', $link);
                echo '<li class="page-item' . $active . '">' . $link . '</li>';
            }
    ?>
    </ul>
</nav>
<?php endif; ?>