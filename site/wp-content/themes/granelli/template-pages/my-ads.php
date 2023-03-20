<?php
/*
Template Name: Meus anúncios
*/
$user = wp_get_current_user();
$user_id = $user->ID;
if(is_user_logged_in()) {} else {
  $custom_page_url = '"'.home_url().'/login/"';

  wp_redirect( $custom_page_url );
}
if ($_POST) {
  $delete_id = $wpdb->escape($_POST['delete_id']);
  $update_post = array(
    'post_type' => 'post',
    'ID' => $delete_id,
    'post_status' => 'trash'
  );
  $statusTest = wp_update_post($update_post);
}
get_header();
$first_name = $user->first_name;
$config_thema_linkmyads    		    = get_theme_mod('US_config_thema_linkmyads');
$config_thema_linkads    		      = get_theme_mod('US_config_thema_linkads');
$config_thema_linkprofile    		  = get_theme_mod('US_config_thema_linkprofile');
?>

  <!-- main -->
  <main>
    <?php if(is_user_logged_in()) { ?>
      <!-- profile -->
      <section class="profile">
        <div class="container container-custom">
          <div class="grid">
            <div class="sidebar">
              <a href="#" class="menu-sidebar">
                <svg class="icon">
                  <use xlink:href="<?= get_bloginfo('template_url') ?>/assets/img/icons.svg#arrow"></use>
                </svg>
              </a>
              <div class="avatar">
                <?php
                  if(get_field('imagem_do_perfil_user', 'user_'.$user_id)) {
                    echo wp_get_attachment_image(get_field('imagem_do_perfil_user', 'user_'.$user_id), 'thumbnail');
                  } else {
                    echo '<img src="'. get_bloginfo('template_url') .'/assets/img/avatar-default.jpg">';
                  }
                ?>
              </div>
              <h3>
                <svg class="icon">
                  <use xlink:href="<?= get_bloginfo('template_url') ?>/assets/img/icons.svg#arrow"></use>
                </svg> <?= $first_name ?>
              </h3>
              <ul>
              <li><a href="<?= get_permalink( get_page_by_path( $config_thema_linkprofile ) ) ?>">Perfil</a></li>
                <li><a href="<?= get_permalink( get_page_by_path( $config_thema_linkads ) ) ?>">Anúnciar</a></li>
                <li><a href="<?= get_permalink( get_page_by_path( $config_thema_linkmyads ) ) ?>">Meus anúncios</a></li>
                <li><a href="<?php echo wp_logout_url(get_permalink()); ?>">Logout</a></li>
              </ul>
            </div>
            <div class="content">
              <!-- products-list -->
              <div class="products-list">
                <div class="title">
                  <h2>Meus anúncios</h2>
                </div>
                  <?php
                  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                  $postargs = array(
                    'post_type' 						 => 'post',
                    'paged' 								 => $paged,
                    'post_status'            => 'publish',
                    'author' 								 => $user_id,
                  );
                  $postcat = new WP_Query($postargs);
                  $maxpages = $postcat->max_num_pages;
                  if($postcat->have_posts()) {
                    echo '<div class="grid">';
                    while ($postcat->have_posts()) : $postcat->the_post();
                      get_template_part('template-parts/posts/content', 'blog-user');
                    endwhile;
                    echo '</div>';
                  } else {
                    echo '<p>Nenhum anúncio cadastrado</p>';
                  }
                  // wp_reset_postdata();
                  ?>
                <?php US_paging_nav($postcat, $paged, $maxpages); ?>
              </div>
  
              <div class="products-list">
                <div class="title">
                  <h2>Meus anúncios em aprovação</h2>
                </div>
                
                  <?php
                  $postargs = array(
                    'post_type' 						 => 'post',
                    'paged' 								 => $paged,
                    'post_status'            => 'draft',
                    'posts_per_page'         => '-1',
                    'author' 								 => $user_id,
                  );
                  $postcat = new WP_Query($postargs);
                  if($postcat->have_posts()) {
                    echo '<div class="grid">';
                    while ($postcat->have_posts()) : $postcat->the_post();
                      get_template_part('template-parts/posts/content', 'blog-draft');
                    endwhile;
                    echo '</div>';
                  } else {
                    echo '<p>Nenhum anúncio cadastrado</p>';
                  }
                  // wp_reset_postdata();
                  ?>
                
              </div>
              <!-- end:products-list -->
            </div>
          </div>
        </div>
      </section>
      <!-- end:profile -->
    <?php } ?>

  </main>
  <!-- end:main -->

<?php get_footer(); ?>




