<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$tax       = get_queried_object()->taxonomy;
$term      = get_queried_object()->slug;
$termID    = get_queried_object()->term_id;
$termName  = get_queried_object()->name;

$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$url_components = parse_url($url);
parse_str($url_components['query'], $params);


?>
  <!-- main -->
  <main>
    <!-- categories -->
    <section class="categories">
      <div class="container container-custom">
        <div class="grid">
          <div class="sidebar">
            <a href="#" class="menu-sidebar">
              <svg class="icon">
                <use xlink:href="<?= get_bloginfo('template_url') ?>/assets/img/icons.svg#arrow"></use>
              </svg>
            </a>
            <h3>
              <svg class="icon">
                <use xlink:href="<?= get_bloginfo('template_url') ?>/assets/img/icons.svg#arrow"></use>
              </svg> Agroindústriais
            </h3>
            <ul>
							<?php 
							$categories = get_categories();
							foreach($categories as $category) {
								$act = $termName == $category->name ? 'act' : '' ;
								echo '<li class="' . $act . '"><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
							}
							?>
            </ul>
          </div>
          <div class="content">
            <div class="filter">
              <div class="item box-search">
								<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
									<div class="box-input">
										<svg class="icon">
											<use xlink:href="<?= get_bloginfo('template_url') ?>/assets/img/icons.svg#search"></use>
										</svg>
										<input type="text" autocomplete="off" class="search-field" placeholder="Busca" value="<?php echo get_search_query(); ?>" name="s" />
									</div>
									<button type="submit" class="btn search-submit">Busca</button>
								</form>
              </div>
              <div class="item box-order">
								<div class="box-select">
									<select name="" class="filter-select">
										<option value="">Selecionar</option>
										<option <?= $params['order'] == 'AZ' ? 'selected' : '' ?> value="AZ">Ordem alfabética</option>
										<option <?= $params['order'] == 'MR' ? 'selected' : '' ?> value="MR">Mais relevantes</option>
										<option <?= $params['order'] == 'PR' ? 'selected' : '' ?> value="PR">Publicados recentemente</option>
										<option <?= $params['order'] == 'MA' ? 'selected' : '' ?> value="MA">Mais Antigos</option>
										<option <?= $params['order'] == 'MAP' ? 'selected' : '' ?> value="MAP">Maior Preço</option>
										<option <?= $params['order'] == 'MEP' ? 'selected' : '' ?> value="MEP">Menor Preço</option>
									</select>
								</div>
              </div>
            </div>
            <!-- products-featured -->
            <div class="products-featured">
              <h2>Ofertas em destaque</h2>
              <div class="slide-products">
								<?php
								$slideargs = array(
									'post_type' 						 => 'post',
									'post_status'            => 'publish',
									'posts_per_page'         => '6',
									'meta_key'      				 => 'destacar_post',
									'meta_value'    				 => '1',
									'no_found_rows'          => true,
									'update_post_term_cache' => false,
									'update_post_meta_cache' => false,
									'cache_results'          => false
								);
								$slideposts = new WP_Query($slideargs);
								while ($slideposts->have_posts()) : $slideposts->the_post();
									get_template_part('template-parts/posts/content', 'blog-slide');
								endwhile;
								wp_reset_postdata();
								?>
              </div>
            </div>
            <!-- end:products-featured -->

            <!-- products-list -->
            <div class="products-list">
              <div class="title">
                <h2>Todas as ofertas</h2>
              </div>
              <div class="grid">
								<?php
								$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
								$postargs = array(
									'post_type' 						 => 'post',
									'paged' 								 => $paged,
									'post_status'            => 'publish',
								);
								if ($term) {
									$postargs['tax_query'] = array(
										array(
											'taxonomy' 	=> $tax,
											'field' 		=> 'slug',
											'terms' 		=> $term,
										)
									);
								}

								if (isset($params['order']) == 'AZ') {
									$postargs['orderby'] = 'title';
    							$postargs['order'] = 'ASC';
								}
								if ($params['order'] == 'MR') {
									$postargs['meta_key'] = 'US_post_views_count';
    							$postargs['orderby']  = 'meta_value_num';
								}
								if ($params['order'] == 'PR') {
    							$postargs['orderby']  = 'date';
    							$postargs['order'] = 'DESC';
								}
								if ($params['order'] == 'MA') {
    							$postargs['orderby']  = 'date';
    							$postargs['order'] = 'ASC';
								}
                if ($params['order'] == 'MAP') {
									$postargs['meta_key'] = 'valor_post';
    							$postargs['orderby']  = 'meta_value_num';
    							$postargs['order'] = 'DESC';
								}
                if ($params['order'] == 'MEP') {
									$postargs['meta_key'] = 'valor_post';
    							$postargs['orderby']  = 'meta_value_num';
    							$postargs['order'] = 'ASC';
								}
								
								$postcat = new WP_Query($postargs);
								$maxpages = $postcat->max_num_pages;
								while ($postcat->have_posts()) : $postcat->the_post();
									get_template_part('template-parts/posts/content', 'blog-slide');
								endwhile;
								// wp_reset_postdata();
								?>
              </div>
							<?php US_paging_nav($postcat, $paged, $maxpages); ?>
            </div>
            <!-- end:products-list -->
          </div>
        </div>
      </div>
    </section>
    <!-- end:categories -->

  </main>
  <!-- end:main -->
