<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); 
$whats    		    = get_theme_mod('US_whats');
$whatslink				= str_replace(array('(', ')', '-', ' '), "", $whats);

$config_thema_formpost    		    = get_theme_mod('US_config_thema_formpost');
US_set_post_views(get_the_ID());
?>
  <!-- main -->
  <main>
    <!-- post -->
    <article class="post">
      <div class="container">
        <div class="grid">
          <div class="item">
            <h1><?= the_title() ?></h1>
            <div class="galleries">
							<a href="#" class="btn open-full-image"><i class="fa fa-search" aria-hidden="true"></i></a>
              <div class="primary">
								<?php
								if (have_rows('imagens_post')) :
									while (have_rows('imagens_post')) : the_row();
										$filename = wp_get_attachment_image_src(get_sub_field('imagem'), 'large');
										$mark = get_bloginfo('template_url') . '/assets/img/mark.png';

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

									endwhile;
								endif;
								?>
              </div>
              <div class="slide">
								<?php
								if (have_rows('imagens_post')) :
									while (have_rows('imagens_post')) : the_row();
										//echo wp_get_attachment_image(get_sub_field('imagem'), 'thumbnail');
										$filename = wp_get_attachment_image_src(get_sub_field('imagem'), 'thumbnail');
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
									endwhile;
								endif;
								?>
              </div>
            </div>
            <div class="infos-price">
              <div class="flex border">
                <div class="item">
									<?php
										if(get_field('valor_post')) {
											echo '<span class="label">Valor:</span><span class="price">R$ ' . get_field('valor_post') . '</span>';
										}
									?>
                </div>
                <div class="item">
									<?php
										if(get_field('codigo_post')) {
											echo '<span class="label">Código</span><span class="cod">A' . get_field('codigo_post') . '</span>';
										}
									?>
                </div>
              </div>
              <div class="flex <?php if(get_field('tipo_post') OR get_field('condicao_post')) {echo 'border'; } ?> ">
                <div class="item">
									<?php
										if(get_field('localizacao_post')) {
											echo '<span class="label small">Localização:</span><span class="location">' . get_field('localizacao_post') . '</span>';
										}
									?>
                </div>
                <div class="item">
									<?php
										if(get_field('disponibilidade_post')) {
											echo '<span class="label small">Disponibilidade:</span><span class="date">' . get_field('disponibilidade_post') . '</span>';
										}
									?>
                </div>
              </div>
              <?php if(get_field('tipo_post') OR get_field('condicao_post')) {  ?>
							<div class="flex">
                <div class="item">
									<?php
										if(get_field('condicao_post')) {
											echo '<span class="label small">Condição:</span><span class="location">' . ucfirst(get_field('condicao_post')) . '</span>';
										}
									?>
                </div>
                <div class="item">
									<?php
										if(get_field('tipo_post')) {
											$type = get_field('tipo_post') == 'maquina-equipamento' ? 'Máquina/equipamento' : 'Indústria completa' ;
											echo '<span class="label small">Tipo:</span><span class="date">' . $type . '</span>';
										}
									?>
                </div>
              </div>
							<?php  } ?>
            </div>
            <ul class="white">
							<?php
							$post_categories = wp_get_post_categories( get_the_ID(), array( 'fields' => 'names' ) );
							if( $post_categories ){ // Always Check before loop!
								foreach($post_categories as $name){
									echo '<li>' . $name . '</li>';
								}
							}
							?>
            </ul>
          </div>
          <div class="item">
            <div class="box-descriptions">
              <div class="description">
                <h2>Descrição</h2>
								<?= the_content() ?>
              </div>
              <div class="condition">
                <h2>CONDIÇÕES GERAIS</h2>
                <ul>
									<?php
									if (have_rows('itens_post')) :
										while (have_rows('itens_post')) : the_row();
											echo '<li>' . get_sub_field('item') . '</li>';
										endwhile;
									endif;
									?>
                </ul>
              </div>
              <p class="ps">As informações são de responsabilidade do Proprietário/vendedor</p>
            </div>
            <div class="box-btn">
							<?= '<a href="https://wa.me/55' . $whatslink . '" class="btn-whatsapp"></a>'; ?>
            </div>
            <div class="box-form">
              <h3>Entrar em contato</h3>
							<?= do_shortcode($config_thema_formpost) ?>
            </div>
          </div>
        </div>
      </div>
    </article>
    <!-- end:post -->

    <!-- products-featured -->
    <section class="products-featured">
      <div class="container">
        <h2> Relacionados</h2>
        <div class="slide-products">
					<?php
					$slideargs = array(
						'post_type' 						 => 'post',
						'post_status'            => 'publish',
						'posts_per_page'         => '6',
						'post__not_in'     			 => array(get_the_ID()),
						// 'category_name'				   => 'games',
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

  </main>
  <!-- end:main -->
	
	
	<div class="full-image-gallery">
		<a href="#" class="close"><i class="fa fa-times" aria-hidden="true"></i></a>
		<div class="full-image">
			<?php
			if (have_rows('imagens_post')) :
				while (have_rows('imagens_post')) : the_row();
					$filename = wp_get_attachment_image_src(get_sub_field('imagem'), 'full');
					$mark = get_bloginfo('template_url') . '/assets/img/mark.png';

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

				endwhile;
			endif;
			?>
		</div>
	</div>
<?php
get_footer();