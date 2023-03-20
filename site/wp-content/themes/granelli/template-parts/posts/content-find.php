<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 */

?>
<tr id="post-<?php the_ID(); ?>">
  <td><div><svg class="icon"><use xlink:href="<?= get_bloginfo('template_url') ?>/assets/img/icons.svg#check-circle-duotone"></use></svg> <?php the_title(); ?></div></td>
  <td><div><?= get_field('detalhes_decricao_find') ?></div></td>
  <td><div><?= get_field('destino_find') ?></div></td>
  <td><div><?= get_the_modified_date('d-m-Y') ?></div></td>
</tr>