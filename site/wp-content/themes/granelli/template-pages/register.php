<?php
/*
Template Name: Register
*/

?>

<?php 

global $wpdb;
$error = array();
if ($_POST) {

  $fullName = $wpdb->escape($_POST['fullName']);
  $username = $wpdb->escape($_POST['txtUsername']);
  $email = $wpdb->escape($_POST['txtEmail']);
  $phone = $wpdb->escape($_POST['txtPhone']);
  $password = $wpdb->escape($_POST['txtPassword']);
  $ConfPassword = $wpdb->escape($_POST['txtConfirmPassword']);
  $term = $wpdb->escape($_POST['txtTerm']);
  
  if (strpos($username, ' ') !== FALSE) {
    $error['username_space'] = "O nome de usuário tem espaço";
  }

  if (empty($username)) {
    $error['username_empty'] = "O nome de usuário obrigatório";
  }

  if (username_exists($username)) {
    $error['username_exists'] = "O nome de usuário já existe";
  }

  if (!is_email($email)) {
    $error['email_valid'] = "O e-mail não tem valor válido";
  }

  if (email_exists($email)) {
    $error['email_existence'] = "E-mail já existe";
  }
  
  if (empty($phone)) {
    $error['phone_empty'] = "O telefone é obrigatório";
  }

  if (empty($term)) {
    $error['term_empty'] = "Aceitar o termo é obrigatório";
  }

  if (strcmp($password, $ConfPassword) !== 0) {
    $error['password'] = "As senhas não correspondem";
  }

  if (count($error) == 0) {
    $new_user_id = wp_create_user($username, $password, $email);
    update_user_meta( $new_user_id, "first_name",  $fullName);
    update_user_meta($new_user_id, 'telefone_user', $phone);
    echo "User Created Successfully";
    $custom_page_url = '"'.home_url().'/login/"';

    wp_redirect( $custom_page_url );
    exit();
  }
}
get_header();
?>

<section class="section-register">
  <div class="container">
    
    <div class="box-form">
      <h2>Cadastro</h2>
      <?php
      if (count($error) != 0) {
        echo '<div class="box-error">';
        foreach ($error as $value) {
          echo '<p>' . $value . '</p>';
        }
        echo '</div>';
      }
      ?>
      <form method="post">
        <label for="">
          <span class="label">Nome completo</span>
          <input type="text" name="fullName" id="" placeholder="Digite seu nome completo" value="<?= $fullName ?>">
        </label>
        <label for="">
          <span class="label">Nome de usuário</span>
          <input type="text" name="txtUsername" id="" placeholder="Digite seu nome de usuário" value="<?= $username ?>">
        </label>
        <label for="">
          <span class="label">E-mail</span>
          <input type="text" name="txtEmail" id="" placeholder="Digite seu email" value="<?= $email ?>">
        </label>
        <label for="">
          <span class="label">Telefone/Celular</span>
          <input type="text" name="txtPhone" id="" placeholder="Digite seu telefone/celular" value="<?= $phone ?>">
        </label>
        <label for="">
          <span class="label">Senha</span>
          <input type="password" name="txtPassword" id="" placeholder="Digite sua senha">
        </label>
        <label for="">
          <span class="label">Confirme senha</span>
          <input type="password" name="txtConfirmPassword" id="" placeholder="Confirme sua senha">
        </label>
        <label class="term" for="txtTerm">
          <input name="txtTerm" type="checkbox" value="aceito"> <span>Termo de autorização de uso informações e imagens</span>
        </label>
        <div class="center">
          <input type="submit" value="Enviar" class="btn">
        </div>
      </form>
    </div>
  </div>
</section>

<?php get_footer(); ?>




