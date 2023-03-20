<?php
/*
Template Name: Procura
*/

?>

<?php 

get_header();
?>
<section class="section-find">
  <div class="container">
    <h2><?php the_title() ?></h2>
    <?php the_content() ?>
    <table>
      <thead>
        <tr>
          <th>Máquinas / Equipamentos</th>
          <th>Detalhes / Decrição</th>
          <th>Destino</th>
          <th>Data</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $past = date('Y-m-d H:i:s', strtotime('-15 minutes'));
          $postargs = array(
            'post_type' 						 => 'find',
            'posts_per_page'         => -1,
            'post_status'            => 'publish',
            'no_found_rows'          => true,
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false,
            'cache_results'          => false,
            /*'date_query' => array(
              array(
                'column' => 'post_modified_gmt',
                'before' => '1 month ago',
              ),
              array(
                'column' => 'post_modified_gmt',
                'after'  => '2 month ago',
              ),
            ),*/
          );
          $postcat = new WP_Query($postargs);
          while ($postcat->have_posts()) : $postcat->the_post();
            get_template_part('template-parts/posts/content', 'find');
          endwhile;
          wp_reset_postdata();
        ?>
      </tbody>
    </table>
    <div class="box">
      <?= do_shortcode(get_field('formulario_find')) ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>




