<?php
$config_thema_linkprofile    		    = get_theme_mod('US_config_thema_linkprofile');
/*
Template Name: Login
*/

if(is_user_logged_in()) {
  wp_redirect( get_permalink( get_page_by_path( $config_thema_linkprofile ) ) );
}
get_header();

?>

<?php 
$args = array(
  'echo'            => true,
  'redirect'        => get_permalink( get_page_by_path( $config_thema_linkprofile ) ),
  'remember'        => true,
  'value_remember'  => true,
);

?>
<section class="section-login">
  <div class="container">
    <div class="box-form">
      <h2>Login</h2>
      <?php
      if (isset($_GET['login']) && $_GET['login'] == 'failed') {
        echo '<div class="box-error"><p>Nome de utilizador ou Senha inválidos.</p></div>';
      } elseif (isset($_GET['login']) && $_GET['login'] == 'empty') {
        echo '<div class="box-error"><p>Preencha os campos Nome de utilizador e Senha.</p></div>';
      }
      ?>
      <?= wp_login_form( $args ); ?>
      <a href="<?= home_url() ?>/cadastro/">Não tem uma conta? Cadastre-se</a>
      <?php echo do_shortcode('[google_login button_text="Google Login" force_display="yes" /]'); ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>




