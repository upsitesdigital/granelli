<?php
/*
Template Name: Contato
*/
get_header();
$facebook    		   			= get_theme_mod('US_facebook');
$instagram    		   		= get_theme_mod('US_instagram');
$youtube    		   		  = get_theme_mod('US_youtube');
?>
  <!-- main -->
  <main>
    <!-- contact -->
    <section class="contact">
      <div class="container">
        <div class="grid">
          <div class="item text">
            <h1><?= the_title() ?></h1>
            <ul class="border links">
              <?php
                if(get_field('whatsapp_contact')) {
                  $whats    		    = get_field('whatsapp_contact');
                  $whatslink				= str_replace(array('(', ')', '-', ' '), "", $whats);
                  echo '<li><a href="https://wa.me/55' . $whatslink . '"><svg class="icon"><use xlink:href="' . get_bloginfo('template_url') . '/assets/img/icons.svg#whatsapp"></use></svg> ' . $whats . '</a></li>';
                }
              ?>
              
            </ul>
            <ul class="links">
              <?php
                if(get_field('e-mail_contact')) {
                  echo '<li><a href="mailto:' . get_field('e-mail_contact') . '"><svg class="icon"><use xlink:href="' . get_bloginfo('template_url') . '/assets/img/icons.svg#mail2"></use></svg> ' . get_field('e-mail_contact') . '</a></li>';
                }
              ?>
            </ul>
            <?php
              if(get_field('endereco_contact')) {
                echo '<div class="location"><i class="fa fa-map-marker" aria-hidden="true"></i><p> ' . get_field('endereco_contact') . '</p></div>';
              }
            ?>
            <p class="ptop">Siga-nos nas redes sociais</p>
            <ul class="social-media">
              <?php
              if ($facebook != '') {
                echo '<li><a href="' . $facebook . '"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>';
              }
              if ($instagram != '') {
                echo '<li><a href="' . $instagram . '"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>';
              }
              if ($youtube != '') {
                echo '<li><a href="' . $youtube . '"><img class="icon" src="' . get_bloginfo('template_url') . '/assets/img/youtube.svg" alt=""></a></li>';
              }
              ?>
            </ul>
          </div>
          <div class="item">
            <div class="box-form">
              <h2>Envie sua mensagem</h2>
              <?= do_shortcode(get_field('formulario_contact')) ?>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end:contact -->

  </main>
  <!-- end:main -->
<?php get_footer(); ?>




