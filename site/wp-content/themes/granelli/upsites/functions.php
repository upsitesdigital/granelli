<?php
/* url da pasta upsites no thema */
$upsites = get_template_directory() . '/upsites/';

/** 
 * After theme setup hook actions
 */
add_action('after_setup_theme', function () {

  add_theme_support('widgets');
  add_theme_support('woocommerce');
  add_theme_support('wc-product-gallery-zoom');
  add_theme_support('wc-product-gallery-lightbox');
  add_theme_support('wc-product-gallery-slider');
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_image_size( 'products-item', 260, 194, true );

  // This theme uses wp_nav_menu() in two locations.
  register_nav_menus(
    array(
      'menu' => __('Top Menu', 'upsites'),
      'menufooter' => __('Footer Menu', 'upsites'),
      'menudown' => __('Downloads Menu', 'upsites'),
    )
  );
  add_theme_support(
    'custom-logo',
    array(
      'height'      => 197,
      'width'       => 50,
      'flex-height' => true,
      'flex-width'  => true,
    )
  );
});


/** 
 * Load theme assets
 */
add_action('wp_enqueue_scripts', function () {
  $assets_src = get_template_directory_uri() . '/assets';
  $version = wp_get_theme()->get('Version');

  // Load theme style
  if (strpos(get_bloginfo('url'), 'local.wp4') !== false or strpos(get_bloginfo('url'), 'localhost') !== false) {
    wp_enqueue_style('theme', "{$assets_src}/css/main.css", [], $version, 'all');
  } else {
    wp_enqueue_style('theme', "{$assets_src}/css/main.min.css", [], $version, 'all');
  }

  // Load theme 
  wp_enqueue_script('tinymce', "https://cdn.tiny.cloud/1/pkjk4nez3sknaetrjy6514ddhy3e9405qmcthvbe3lw5khfq/tinymce/6/tinymce.min.js", ['jquery'], $version, true);
  wp_enqueue_script('mask', "https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.8/jquery.mask.min.js", ['jquery'], $version, true);
  if (strpos(get_bloginfo('url'), 'local.wp4') !== false or strpos(get_bloginfo('url'), 'localhost') !== false) {
    wp_enqueue_script('theme', "{$assets_src}/js/bundle.js", ['jquery'], $version, true);
  } else {
    wp_enqueue_script('theme', "{$assets_src}/js/bundle.min.js", ['jquery'], $version, true);
  }
  wp_localize_script('theme', 'usAjax', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'nonce'       => wp_create_nonce('nonce')
  ));
  wp_enqueue_script('theme');
}, 999, 1);

add_action('admin_enqueue_scripts', function () {
  $assets_src = get_template_directory_uri() . '/assets';
  $version = wp_get_theme()->get('Version');

  wp_enqueue_style('admincss', "{$assets_src}/css/admin.css", [], $version, 'all');

  wp_enqueue_script('admin', "{$assets_src}/js/admin.js", ['jquery'], $version, true);
  wp_localize_script('admin', 'usAjax', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'nonce'       => wp_create_nonce('nonce')
  ));
  wp_enqueue_script('admin');
});


/** 
 * Category
 */
function US_term_list($ID, $cat)
{
  //echo $cat;
  $term_list = wp_get_post_terms($ID, $cat, ['fields' => 'all']);
  $primary_term_bkp = $term_list[0]->name;
  $primary_term = '';

  foreach ($term_list as $term) {
    if (get_post_meta($ID, '_yoast_wpseo_primary_' . $cat, true) == $term->term_id) {
      $primary_term = $term->name;
    }
  }
  $primary_term = ($primary_term !== '') ? $primary_term : $primary_term_bkp;
  return '<em>' . $primary_term . '</em>';
}

function US_paging_nav($posts, $paged, $maxpages)
{

  /** Stop execution if there's only 1 page */
  if ($posts->max_num_pages <= 1)
    return;

  //$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
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

  echo '<div class="paginations">' . "\n";

  /** Previous Post Link */
  if (get_previous_posts_link()) {
    printf('<a rel="prev" href="%s" class="prev">Anterior</a>' . "\n", get_previous_posts_page_link());
  } else {
    printf('<a href="#" rel="prev" class="prev">Anterior</a>' . "\n", get_previous_posts_page_link());
  }

  /** Link to first page, plus ellipses if necessary */
  if (!in_array(1, $links)) {
    $class = 1 == $paged ? ' class="current"' : '';

    printf('<a%s href="%s">%s</a>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

    if (!in_array(2, $links))
      echo '<span>…</span>';
  }

  /** Link to current page, plus 2 pages in either direction if necessary */
  sort($links);
  foreach ((array) $links as $link) {
    $class = $paged == $link ? ' class="current"' : '';
    printf('<a%s href="%s">%s</a>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
  }

  /** Link to last page, plus ellipses if necessary */
  if (!in_array($max, $links)) {
    if (!in_array($max - 1, $links))
      echo '<span>…</span>' . "\n";

    $class = $paged == $max ? ' class="current"' : '';
    printf('<a%s href="%s">%s</a>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
  }

  /** Next Post Link */
  if (get_next_posts_link('next', $posts->max_num_pages)) {
    printf('<a rel="next" href="%s" class="next">Próximo</a>' . "\n", get_next_posts_page_link());
  } else {
    printf('<a href="#" rel="next" class="next">Próximo</a>' . "\n", get_next_posts_page_link());
  }
  echo '</div>' . "\n";
}

add_action( 'init', 'blockusers_init' );

function blockusers_init() {
    if ( is_admin() && ! current_user_can( 'administrator' ) && 
       ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_redirect( home_url() );
        exit;
    }
}

function get_subcat() {
  $category_id = $_POST["category_id"];
  $args = array(
    'child_of' => $category_id,
    'taxonomy' => 'category',
    'hide_empty' => 0,
    'hierarchical' => true,
    'depth'  => 1,
    'parent' => $category_id
  );

   if ( isset($category_id) ) {
    $has_children = get_categories($args);
    if ( $has_children ) {
      echo '<option value="">Selecione a subcategoria</option>';
      foreach ($has_children as $category) {
        echo '<option value="'.$category->cat_ID.'">' . $category->cat_name . '</option>';
      }
    } else {
      echo '<option value="">Nenhuma subcategoria!</option>';
    }
    die();    
   }
}
add_action('wp_ajax_get_subcat', 'get_subcat');
add_action('wp_ajax_nopriv_get_subcat', 'get_subcat');


function US_column_btn_publish($column)
{
  $column['US_column_btn_publish'] = __('Publicar', 'upsites');
  return $column;
}
add_filter('manage_post_posts_columns', 'US_column_btn_publish');
function views_US_column_btn_publish($name)
{
  global $post;
  switch ($name) {
    case 'US_column_btn_publish':
      if ( get_post_status( $post->ID ) == 'publish' ) {
        echo '<a data-post-id="' . $post->ID . '" data-status="draft" href="#" class="US_publish button button-primary button-large">Despublicar</a>';
      } else {
        echo '<a data-post-id="' . $post->ID . '" data-status="publish" href="#" class="US_publish button button-primary button-large">Publicar</a>';
      }
      break;
  }
}
add_action('manage_post_posts_custom_column',  'views_US_column_btn_publish');

function change_status() {
  $post_id = $_POST["post_id"];
  $status = $_POST["status"];
  $my_post = array(
    'post_status'   => $status,
    'ID'            => $post_id,
  );
  $post_id = wp_update_post($my_post);
  echo $post_id;
}
add_action('wp_ajax_change_status', 'change_status');

function US_column_btn_edit($column)
{
  $column['US_column_btn_edit'] = __('Editar', 'upsites');
  return $column;
}
add_filter('manage_post_posts_columns', 'US_column_btn_edit');
function views_US_column_btn_edit($name)
{
  global $post;
  switch ($name) {
    case 'US_column_btn_edit':
      echo '<a target="_blank" data-post-id="' . $post->ID . '" href="' . get_post_permalink($post->ID) . '" class="button button-large">Visualizar</a>';
      break;
  }
}
add_action('manage_post_posts_custom_column',  'views_US_column_btn_edit');




/*function add_recaptcha_to_wp_login_form( $content )
{
	ob_start();
	echo do_shortcode('[bws_google_captcha]');
	$output = ob_get_contents();
	ob_end_clean();
	
	$output = $content.$output;
	
    return $output;
}
add_filter( 'login_form_middle', 'add_recaptcha_to_wp_login_form' );*/



function US_login_fail( $username ) {
  $referrer = $_SERVER['HTTP_REFERER']; 
  if ( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) && strstr( $referrer,'/login/' ) ) {
    $referrer = esc_url( remove_query_arg( 'login', $referrer ) );
    wp_redirect( $referrer . '?login=failed' );
    exit;
  }
}
add_action( 'wp_login_failed', 'US_login_fail' );

add_action( 'authenticate', 'check_username_password', 1, 3);
function check_username_password( $login, $username, $password ) {
  $referrer = $_SERVER['HTTP_REFERER'];
  if( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) && strstr( $referrer,'/login/' ) ) { 
      if( $username == "" || $password == "" ){
          wp_redirect( home_url( '/login/' ) . "?login=empty" );
          exit;
      }
  }
}

add_filter( 'show_admin_bar', '__return_false' );

/* CUSTOMIZER_REPEATER_VERSION */
define('CUSTOMIZER_REPEATER_VERSION', '1.1.0');
require $upsites . 'customizer-repeater/inc/customizer.php';

/* US_SET_POST_VIEWS */
define('US_SET_POST_VIEWS', '1.1.0');
require $upsites . 'post-views/post-views.php';

/* US_CUSTOMIZER_CONTROLS */
define('US_CUSTOMIZER_CONTROLS', '1.1.0');
require $upsites . 'customizer-controls/customizer-controls.php';

/* US_CUSTOMIZER_REGISTER */
define('US_CUSTOMIZER_REGISTER', '1.1.0');
require $upsites . 'customizer-register/customizer-register.php';

/* US_COMMENTS */
define('US_COMMENTS', '1.1.0');
require $upsites . 'comments/comments.php';

/* US_PAGINATION */
define('US_PAGINATION', '1.1.0');
require $upsites . 'pagination/pagination.php';

add_filter( 'cron_schedules', function ( $schedules ) {
  $schedules['per_minute'] = array(
      'interval' => 240,
      'display' => __( 'One Minute' )
  );
  return $schedules;
} );

// Add function to register event to wp
add_action( 'wp', 'register_daily_post_delete_event');
function register_daily_post_delete_event() {
    // Make sure this event hasn't been scheduled
    if( !wp_next_scheduled( 'expired_post_delete' ) ) {
        // Schedule the event hourly
        wp_schedule_event( time(), 'hourly', 'expired_post_delete' );
    }
}

function get_exired_posts_to_delete()
{

    // Set our query arguments
    $args = [
        'fields'         => 'ids', // Only get post ID's to improve performance
        'post_type'      => 'find',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'date_query' => array(
          array(
            'column' => 'post_modified_gmt',
            'before' => '1 month ago',
          ),
          array(
            'column' => 'post_modified_gmt',
            'after'  => '2 month ago',
          ),
        ),
    ];
    $q = get_posts( $args );

    // Check if we have posts to delete, if not, return false
    if ( !$q )
        return false;

    // OK, we have posts to delete, lets delete them
    foreach ( $q as $id )
        wp_delete_post( $id );
}
add_action( 'expired_post_delete', 'get_exired_posts_to_delete' );