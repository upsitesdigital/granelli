<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 */

?>
<div id="post-<?php the_ID(); ?>" class="products-item">
  <div class="thumb">
    <?= wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'medium') ?>
  </div>
  <?php
    if(get_field('codigo_post')) {
      echo '<span class="cod">A' . get_field('codigo_post') . '</span>';
    }
    the_title( '<h3>', '</h3>' );
    if(get_field('valor_post')) {
      echo '<span class="price">R$ ' . get_field('valor_post') . '</span>';
    }
    if(get_field('localizacao_post')) {
      echo '<span class="location">' . get_field('localizacao_post') . '</span>';
    }
  ?>
  <a href="<?= get_permalink( get_page_by_path( 'anunciar' ) ) ?>?id=<?php the_ID(); ?>" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
  
  <form method="post">
    <input type="hidden" name="delete_id" value="<?php the_ID(); ?>">
    <button class="delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
  </form>
</div>