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
$current_user 		= wp_get_current_user();
$email    		    = get_theme_mod('US_email');
$whats    		    = get_theme_mod('US_whats');
$whatslink				= str_replace(array('(', ')', '-', ' '), "", $whats);
$text_btn    		  = get_theme_mod('US_text_btn');
//$link_btn    		  = get_theme_mod('US_link_btn');
$link_btn    		  = is_user_logged_in() ? get_theme_mod('US_link_logged_btn') : get_theme_mod('US_link_btn');
$config_thema_linkprofile    		  = get_theme_mod('US_config_thema_linkprofile');
?>
	<div class="bar-top">
    <div class="container">
			<?php
			if ($email != '') {
				echo '<a href="mailto:' . $email . '" class="mail"><svg class="icon"><use xlink:href="' . get_bloginfo('template_url') . '/assets/img/icons.svg#mail"></use></svg> ' . $email . '</a>';
			}
			if ($whats != '') {
				echo '<a href="https://wa.me/55' . $whatslink . '"><svg class="icon"><use xlink:href="' . get_bloginfo('template_url') . '/assets/img/icons.svg#whatsapp"></use></svg> ' . $whats . '</a>';
			}
			?>
    </div>
  </div>
  <!-- header -->
  <header id="top">
    <div class="container">
      <div class="grid">
        <div class="item cols-01">
					<?php
					$the_custom_logo = get_theme_mod('custom_logo');
					$site_name = get_bloginfo('name');
					$tagline   = get_bloginfo('description', 'display');
					if (function_exists('the_custom_logo') &&  has_custom_logo()) {
						echo '<a href="' . esc_url(home_url('/')) . '" rel="home" title="' . get_bloginfo('name') . '"><img src="' . esc_url(wp_get_attachment_url(get_theme_mod('custom_logo'))) . '" alt="' . get_bloginfo('name') . '"  /></a>';
					}
					?>
        </div>
        <div class="item cols-02">
          <a href="#" id="open-menu" class="">
            <div class="ani">
              <svg class="close" width="30" height="30" viewBox="0 0 100 100">
                <path class="line line1" d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058" />
                <path class="line line2" d="M 20,50 H 80" />
                <path class="line line3" d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942" />
              </svg>
            </div>
          </a>
          <div class="subgrid">
						<?php if (has_nav_menu('menu')) :
							$itemsWrap = '<ul id="%1$s" class="%2$s">%3$s</ul>';
							wp_nav_menu(
								array(
									'theme_location'       => 'menu',
									'menu'                 => '',
									'container'            => 'ul',
									'container_class'      => 'menu',
									'container_id'         => '',
									'container_aria_label' => '',
									'menu_class'           => '',
									'menu_id'              => '',
									'echo'                 => true,
									'fallback_cb'          => 'wp_page_menu',
									'before'               => '',
									'after'                => '',
									'link_before'          => '',
									'link_after'           => '<svg class="icon"><use xlink:href="' . get_bloginfo('template_url') . '/assets/img/icons.svg#arrow"></use></svg>',
									'items_wrap'           => $itemsWrap,
									'item_spacing'         => 'preserve',
									'depth'                => 0,
									'walker'               => '',
								)
							);
						endif; ?>

            <div class="item cols-03">
							<?php
							if ($link_btn != '') {
								echo '<a href="' . $link_btn . '" class="btn">' . $text_btn . '</a>';
							}
							?>
							<?php 
							if (is_user_logged_in()) {
								echo '<a href="' . get_permalink( get_page_by_path( $config_thema_linkprofile ) ) . '" class="login">'.$current_user->user_login.'</a>';
								} else {
								echo '<a href="'. home_url() .'/login/" class="login">Entrar</a>';
							}
							?>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- end:header -->