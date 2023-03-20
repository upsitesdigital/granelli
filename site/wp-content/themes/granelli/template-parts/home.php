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
$title_slide 							= get_theme_mod('US_title_slide');
$btn_home_title_01 				= get_theme_mod('US_btn_home_title_01');
$btn_home_subtitle_01 		= get_theme_mod('US_btn_home_subtitle_01');
$btn_home_link_01 				= is_user_logged_in() ? get_theme_mod('US_btn_home_link_logged_01') : get_theme_mod('US_btn_home_link_01');

$btn_home_img_01 					= get_theme_mod('US_btn_home_img_01');
$btn_home_title_02 				= get_theme_mod('US_btn_home_title_02');
$btn_home_subtitle_02 		= get_theme_mod('US_btn_home_subtitle_02');
$btn_home_link_02 				= is_user_logged_in() ? get_theme_mod('US_btn_home_link_logged_02') : get_theme_mod('US_btn_home_link_02');
$btn_home_img_02 					= get_theme_mod('US_btn_home_img_02');

$banner_home_titulo 			= get_theme_mod('US_banner_home_titulo');
$banner_home_subtitulo 		= get_theme_mod('US_banner_home_subtitulo');
$banner_home_link 				= get_theme_mod('US_banner_home_link');
$banner_home_img 					= get_theme_mod('US_banner_home_img');

$about_home_titulo 				= get_theme_mod('US_about_home_titulo');
$about_home_subtitulo 		= get_theme_mod('US_about_home_subtitulo');
$about_home_text 					= get_theme_mod('US_about_home_text');
$about_home_img 					= get_theme_mod('US_about_home_img');

$config_thema_linkallads 					= get_theme_mod('US_config_thema_linkallads');
?>
  <!-- main -->
  <main>
    <!-- banner-full -->
    <section class="banner-full">
      <div class="container">
				<?php
				if ($title_slide != '') {
					echo '<h2>' . $title_slide . '</h2>';
				}
				$US_slide_repeater = get_theme_mod('US_slide_repeater', json_encode(array()));
				$US_slide_repeater_decoded = json_decode($US_slide_repeater);
				echo '<p>';
				$count = 1;
				foreach ($US_slide_repeater_decoded as $repeater_item) {
					echo $repeater_item->title;
					if($count != sizeof( $US_slide_repeater_decoded )) {
						echo ' <span>|</span> ';
					}
					$count++;
				}
				echo '</p>';
				?>
        <div class="filter">
          <div class="grid">
            <div class="item">
              <label for="">Agroindústria</label>
              <div class="box-select">
                <select name="" id="">
                  <option value="">Todas</option>
                  <?php 
                  $categories = get_categories();
                  foreach($categories as $category) {
                    echo '<option value="' . get_category_link($category->term_id) . '">' . $category->name . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="item box-search">
              <label for="">Digite abaixo o que está procurando</label>
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
          </div>
        </div>
      </div>
    </section>
    <!-- end:banner-full -->

    <!-- mega-btns -->
    <section class="mega-btns">
      <div class="container">
        <div class="grid">
					<?php
					if ($btn_home_link_01 != '') {
						echo '<a href="' . $btn_home_link_01 . '" class="item" style="background-image: url(' . $btn_home_img_01 . ');">';
							echo '<h3>' . $btn_home_title_01 . '</h3>';
							echo '<span>' . $btn_home_subtitle_01 . '</span>';
						echo '</a>';
					}
					if ($btn_home_link_02 != '') {
						echo '<a href="' . $btn_home_link_02 . '" class="item" style="background-image: url(' . $btn_home_img_02 . ');">';
							echo '<h3>' . $btn_home_title_02 . '</h3>';
							echo '<span>' . $btn_home_subtitle_02 . '</span>';
						echo '</a>';
					}
					?>
        </div>
      </div>
    </section>
    <!-- end:mega-btns -->

    <!-- products-featured -->
    <section class="products-featured">
      <div class="container">
        <h2>Produtos em destaque</h2>
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
    </section>
    <!-- end:products-featured -->

    <!-- products-list -->
    <section class="products-list">
      <div class="container">
        <div class="title">
          <h2>Veja também</h2>
          <a href="<?= get_permalink( get_page_by_path( $config_thema_linkallads ) ) ?>">Ver todos os produtos
            <svg class="icon">
              <use xlink:href="<?= get_bloginfo('template_url') ?>/assets/img/icons.svg#arrow2"></use>
            </svg>
          </a>
        </div>
        <div class="grid">
          <?php
					$slideargs = array(
						'post_type' 						 => 'post',
						'post_status'            => 'publish',
						'posts_per_page'         => '12',
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
				<div class="link-bottom">
          <span></span>
          <a href="<?= get_permalink( get_page_by_path( $config_thema_linkallads ) ) ?>">Ver todos os produtos
            <svg class="icon">
              <use xlink:href="<?= get_bloginfo('template_url') ?>/assets/img/icons.svg#arrow2"></use>
            </svg>
          </a>
        </div>
      </div>
    </section>
    <!-- end:products-list -->

    <!-- banner -->
		<?php
		if ($banner_home_link != '') {
			echo '<section class="banner">';
				echo '<div class="container">';
					echo '<div class="box" style="background-image: url(' . $banner_home_img . ');">';
						echo '<div class="internal">';
							echo '<h3>' . $banner_home_titulo . '</h3>';
							echo '<a href="' . $banner_home_link . '">' . $banner_home_subtitulo . ' <svg class="icon"><use xlink:href="' . get_bloginfo('template_url') . '/assets/img/icons.svg#arrow2"></use></svg></a>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</section>';
		}
		?>
    <!-- end:banner -->

    <!-- welcome -->
		<?php
		if ($about_home_titulo != '') {
			echo '<section class="welcome">';
				echo '<div class="container">';
					echo '<div class="grid">';
						echo '<div class="item">';
							echo '<span>' . $about_home_subtitulo . '</span>';
							echo '<h2>' . $about_home_titulo . '</h2>';
							echo '<p>' . $about_home_text . '</p>';
						echo '</div>';
						echo '<div class="item image">';
							echo '<img src="' . $about_home_img . '" alt="">';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</section>';
		}
		?>
    <!-- end:welcome -->

  </main>
  <!-- end:main -->
