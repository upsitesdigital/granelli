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
$logo_footer    		    = get_theme_mod('US_logo_footer');
$opening_hours    		  = get_theme_mod('US_opening_hours');
$phones    		    			= get_theme_mod('US_phones');
$address    		   			= get_theme_mod('US_address');
$facebook    		   			= get_theme_mod('US_facebook');
$instagram    		   		= get_theme_mod('US_instagram');
$youtube    		   		  = get_theme_mod('US_youtube');
$text_copyright 				= get_theme_mod('US_text_copyright');
$link_privacy_policy 		= get_theme_mod('US_link_privacy_policy');
$signature 							= get_theme_mod('US_signature');

$whats    		    = get_theme_mod('US_whats');
$whatslink				= str_replace(array('(', ')', '-', ' '), "", $whats);
?>
  <!-- footer -->
  <footer id="footer">
    <div class="container">
      <div class="grid">
        <div class="item">
          <div class="logo">
						<?php
						if ($logo_footer != '') {
							echo '<a href="' . esc_url(home_url('/')) . '" rel="home" title="' . get_bloginfo('name') . '">' . wp_get_attachment_image(attachment_url_to_postid($logo_footer), 'full') . '</a>';
						}
						?>
          </div>
        </div>
        <div class="item">
					<?php
					if ($opening_hours != '') {
						echo '<h5>Horario de funcionamento:</h5><p>' . $opening_hours . '</p>';
					}
					?>
        </div>
        <div class="item">
					<?php
					if ($phones != '') {
						echo '<h5>Telefones:</h5><p>' . $phones . '</p>';
					}
					?>
        </div>
      </div>
      <div class="flex border">
				<?php
				if ($address != '') {
					echo '<p>' . $address . '</p>';
				}
				?>
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
      <div class="flex pcustom">
				<?php
				if ($text_copyright != '') {
					echo '<p class="copyright">' . $text_copyright . '</p>';
				}
				if ($link_privacy_policy != '') {
					echo '<a href="' . $link_privacy_policy . '" class="link">Política de privacidade</a>';
				}
				if ($signature != '') {
					echo '<p class="signature">' . $signature . '</p>';
				}
				?>
      </div>
    </div>
  </footer>
  <!-- end:footer -->

	<a href="https://wa.me/55<?= $whatslink ?>" class="btn-whats-fixed">
		<img src="<?= get_bloginfo('template_url') ?>/assets/img/whats-fixed.svg" width="100%" height="100%" />
	</a>
