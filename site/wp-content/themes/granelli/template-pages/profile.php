<?php
/*
Template Name: Perfil
*/
if(is_user_logged_in()) {} else {
  $custom_page_url = '"'.home_url().'/login/"';

  wp_redirect( $custom_page_url );
}
get_header();
$user = wp_get_current_user();
$user_id = $user->ID;

function uploadImg($imgFeatured,$posts) {
  $upload = wp_upload_bits($imgFeatured["name"], null, file_get_contents($imgFeatured["tmp_name"]));
  $filename = $upload['file'];


  $uploadfile = $uploaddir['basedir'] . '/'. 'custom-uploads' . '/';
  move_uploaded_file($filename, $uploadfile);
  $wp_filetype = wp_check_filetype($filename, null );
  $attachment = array(
      'post_mime_type' => $wp_filetype['type'],
      'post_title' => sanitize_file_name($filename),
      'post_content' => '',
      'post_status' => 'inherit'
  );
  $attach_id = wp_insert_attachment( $attachment, $filename, $posts );
  require_once(ABSPATH . 'wp-admin/includes/image.php');
  $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
  wp_update_attachment_metadata( $attach_id, $attach_data );
  
  return $attach_id;
}

global $wpdb;
$error = array();
if ($_POST) {

  $username       = $wpdb->escape($_POST['txtUsername']);
  $phone          = $wpdb->escape($_POST['txtPhone']);
  $email          = $wpdb->escape($_POST['txtEmail']);
  $razaosocial    = $wpdb->escape($_POST['txtRazaosocial']);
  $CNPJ           = $wpdb->escape($_POST['txtCNPJ']);
  $localizacao    = $wpdb->escape($_POST['txtLocalizacao']);
  $sou            = $wpdb->escape($_POST['txtSou']);
  $password       = $wpdb->escape($_POST['txtPassword']);
  $ConfPassword   = $wpdb->escape($_POST['txtConfirmPassword']);
  $imgProfile     = $_FILES['imgProfile'];
  
  if (strpos($username, ' ') !== FALSE) {
    $error['username_space'] = "O nome de usuário tem espaço";
  }

  if (empty($username)) {
    $error['username_empty'] = "O nome de usuário obrigatório";
  }

  if (!is_email($email)) {
    $error['email_valid'] = "O e-mail não tem valor válido";
  }

  if (strcmp($password, $ConfPassword) !== 0) {
    $error['password'] = "As senhas não correspondem";
  }

  if (count($error) == 0) {
    update_user_meta( $user_id, "first_name",  $username );
    update_user_meta( $user_id, "telefone_user",  $phone );
    update_user_meta( $user_id, "razaosocial_user",  $razaosocial );
    update_user_meta( $user_id, "cnpj2_user",  $CNPJ );
    update_user_meta( $user_id, "localizacao_user",  $localizacao );
    update_user_meta( $user_id, "sou_user",  $sou );
    
    if(empty($imgProfile['name']) == "") {
      update_user_meta( $user_id, 'imagem_do_perfil_user', uploadImg($imgProfile,$posts));
      
    }
    //echo "User Created Successfully";
  }
}

$first_name       = $user->first_name;
$user_login       = $user->user_login;
$user_email       = $user->user_email;
$user_phone       = get_user_meta( $user_id, 'telefone_user' , true );
$user_razaosocial = get_user_meta( $user_id, 'razaosocial_user' , true );
$user_CNPJ        = get_user_meta( $user_id, 'cnpj2_user' , true );
$user_localizacao = get_user_meta( $user_id, 'localizacao_user' , true );
$user_sou         = get_user_meta( $user_id, 'sou_user' , true );

$config_thema_linkmyads    		    = get_theme_mod('US_config_thema_linkmyads');
$config_thema_linkads    		      = get_theme_mod('US_config_thema_linkads');
$config_thema_linkprofile    		  = get_theme_mod('US_config_thema_linkprofile');
?>

  <!-- main -->
  <main>
    <?php if(is_user_logged_in()) { ?>
      <!-- profile -->
      <section class="profile">
        <div class="container container-custom">
          <div class="grid">
            <div class="sidebar">
              <a href="#" class="menu-sidebar">
                <svg class="icon">
                  <use xlink:href="<?= get_bloginfo('template_url') ?>/assets/img/icons.svg#arrow"></use>
                </svg>
              </a>
              <div class="avatar">
                <?php
                  if(get_field('imagem_do_perfil_user', 'user_'.$user_id)) {
                    echo wp_get_attachment_image(get_field('imagem_do_perfil_user', 'user_'.$user_id), 'thumbnail');
                  } else {
                    echo '<img src="'. get_bloginfo('template_url') .'/assets/img/avatar-default.jpg">';
                  }
                ?>
              </div>
              <h3>
                <svg class="icon">
                  <use xlink:href="<?= get_bloginfo('template_url') ?>/assets/img/icons.svg#arrow"></use>
                </svg> <?= $first_name ?>
              </h3>
              <ul>
                <li><a href="<?= get_permalink( get_page_by_path( $config_thema_linkprofile ) ) ?>">Perfil</a></li>
                <li><a href="<?= get_permalink( get_page_by_path( $config_thema_linkads ) ) ?>">Anúnciar</a></li>
                <li><a href="<?= get_permalink( get_page_by_path( $config_thema_linkmyads ) ) ?>">Meus anúncios</a></li>
                <li><a href="<?php echo wp_logout_url(get_permalink()); ?>">Logout</a></li>
              </ul>
            </div>
            <div class="content">
              <!-- products-list -->
              <div class="products-list">
                <div class="title column">
                  <div class="avatar">
                    <?php
                      if(get_field('imagem_do_perfil_user', 'user_'.$user_id)) {
                        echo wp_get_attachment_image(get_field('imagem_do_perfil_user', 'user_'.$user_id), 'thumbnail');
                      } else {
                        echo '<img src="'. get_bloginfo('template_url') .'/assets/img/avatar-default.jpg">';
                      }
                    ?>
                  </div>
                  <h2>Meu perfil</h2>
                </div>
                
                <div class="box-form">
                  <?php
                  if (count($error) != 0) {
                    echo '<div class="box-error">';
                    foreach ($error as $value) {
                      echo '<p>' . $value . '</p>';
                    }
                    echo '</div>';
                  }
                  ?>
                  <form method="post" enctype="multipart/form-data">
                    <label for="">
                      <span class="label">Nome completo</span>
                      <input type="text" name="fullName" id="" placeholder="Digite seu nome completo" value="<?= $first_name ?>">
                    </label>
                    <label for="">
                      <span class="label">Telefone/Celular</span>
                      <input type="text" name="txtPhone" id="" placeholder="Digite seu telefone/celular" value="<?= $user_phone ?>">
                    </label>
                    <label for="">
                      <span class="label">Nome de usuário</span>
                      <input type="text" name="txtUsername" id="" placeholder="Digite seu nome de usuário" value="<?= $user_login ?>" readonly>
                    </label>
                    <label for="">
                      <span class="label">E-mail</span>
                      <input type="text" name="txtEmail" id="" placeholder="Digite seu email" value="<?= $user_email ?>" readonly>
                    </label>
                    <label for="">
                      <span class="label">Razão social</span>
                      <input type="text" name="txtRazaosocial" id="" placeholder="Digite a razão social" value="<?= $user_razaosocial ?>">
                    </label>
                    <label for="">
                      <span class="label">CNPJ</span>
                      <input type="text" name="txtCNPJ" id="" placeholder="Digite o CNPJ" value="<?= $user_CNPJ ?>">
                    </label>
                    <label for="">
                      <span class="label">Localização</span>
                      <input type="text" name="txtLocalizacao" id="" placeholder="Digite a Localização" value="<?= $user_localizacao ?>">
                    </label>
                    <label for="txtSou">
                      <span class="label">Sou</span>
                      <div class="box-select">
                        <?php $sou = $user_sou; ?>
                        <select name="txtSou">
                          <option value="">Selecione</option>
                          <option <?= $sou == 'proprietario' ? 'selected' : '' ; ?> value="proprietario">Proprietário</option>
                          <option <?= $sou == 'vendedor' ? 'selected' : '' ; ?> value="vendedor">Vendedor autorizado</option>
                        </select>
                      </div>
                    </label>
                    <!-- label for="">
                      <span class="label">Senha</span>
                      <input type="text" name="txtPassword" id="" placeholder="Digite sua senha">
                    </label>
                    <label for="">
                      <span class="label">Confirme senha</span>
                      <input type="text" name="txtConfirmPassword" id="" placeholder="Confirme sua senha">
                    </label -->
                    <label for="imgProfile">
                      <span class="label">Imagem de perfil</span>
                        <div class="box-file">
                          <div class="txt">Nenhum arquivo</div>
                          <div class="btn-file">
                            <input type="file" name="imgProfile" accept="image/*" class="image-file" id="" placeholder="" value="">
                          </div>
                        </div>
                    </label>
                    <div class="center">
                      <input type="submit" value="Enviar" class="btn">
                    </div>
                  </form>
                </div>
                <?php US_paging_nav($postcat, $paged, $maxpages); ?>
              </div>
              <!-- end:products-list -->
            </div>
          </div>
        </div>
      </section>
      <!-- end:profile -->
    <?php } ?>
  </main>
  <!-- end:main -->

<?php get_footer(); ?>




