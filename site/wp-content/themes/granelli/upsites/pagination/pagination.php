<?php

function US_pagination_nav($loop, $paged, $maxpages)
{
  if (is_singular())
    return;

  /** Stop execution if there's only 1 page */
  if ($loop->max_num_pages <= 1)
    return;

  //$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
  $max   = intval($maxpages);

  /** Add current page to the array */
  if ($paged >= 1)
    $links[] = $paged;

  /** Add the pages around the current page to the array */
  if ($paged >= 3) {
    $links[] = $paged - 1;
    $links[] = $paged - 2;
  }

  if (($paged + 2) <= $max) {
    $links[] = $paged + 2;
    $links[] = $paged + 1;
  }

  echo '<nav class="pag">' . "\n";

  /** Previous Post Link */
  if (get_previous_posts_link()) {
    printf('<a href="%s" class="prev"><svg class="icon"><use xlink:href="' . get_template_directory_uri() . '/assets/img/icons.svg#arrow"></use></svg> Anterior</a>' . "\n", get_previous_posts_page_link());
  } else {
    printf('<a href="#" class="prev"><svg class="icon"><use xlink:href="' . get_template_directory_uri() . '/assets/img/icons.svg#arrow"></use></svg> Anterior</a>' . "\n", get_previous_posts_page_link());
  }
  echo '<div>' . "\n";
  /** Link to first page, plus ellipses if necessary */
  if (!in_array(1, $links)) {
    $class = 1 == $paged ? ' class="act"' : '';

    printf('<a%s href="%s">%s</a>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

    if (!in_array(2, $links))
      echo '<span>…</span>';
  }

  /** Link to current page, plus 2 pages in either direction if necessary */
  sort($links);
  foreach ((array) $links as $link) {
    $class = $paged == $link ? ' class="act"' : '';
    printf('<a%s href="%s">%s</a>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
  }

  /** Link to last page, plus ellipses if necessary */
  if (!in_array($max, $links)) {
    if (!in_array($max - 1, $links))
      echo '<span>…</span>' . "\n";

    $class = $paged == $max ? ' class="act"' : '';
    printf('<a%s href="%s">%s</a>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
  }
  echo '</div>' . "\n";
  /** Next Post Link */
  if (get_next_posts_link()) {
    printf('<a href="%s" class="next">Próximo <svg class="icon"><use xlink:href="' . get_template_directory_uri() . '/assets/img/icons.svg#arrow"></use></svg></a>' . "\n", get_next_posts_page_link());
  } else {
    printf('<a href="#" class="next">Próximo <svg class="icon"><use xlink:href="' . get_template_directory_uri() . '/assets/img/icons.svg#arrow"></use></svg></a>' . "\n", get_next_posts_page_link());
  }
  echo '</nav>' . "\n";
}
