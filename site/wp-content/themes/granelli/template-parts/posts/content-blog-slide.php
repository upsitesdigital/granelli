<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 */

?>
<a href="<?= get_the_permalink() ?>" id="post-<?php the_ID(); ?>" class="products-item">
  <div class="thumb">
    <?php 
      $filename = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'products-item');
      $mark = get_bloginfo('template_url') . '/assets/img/mark-thumb.png';

      //var_dump($filename);

      list($w1, $h1) = getimagesize($filename[0]);
      list($w, $h) = getimagesize($mark);

      $w2 = $w1 - $w;
      $h2 = $h1 - $h;

      $filename = imagecreatefromstring(file_get_contents($filename[0]));
      $mark = imagecreatefrompng($mark);
      imagesavealpha($mark, true);
      imagecopy($filename, $mark, $w2, $h2, 0, 0, $w, $h);
      
      ob_start();
      imagepng($filename);
      $imgData=ob_get_clean();
      imagedestroy($filename);

      echo '<img src="data:image/png;base64,'.base64_encode($imgData).'" />';
    ?>
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
</a>