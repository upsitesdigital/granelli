<?php
/*
Template Name: Anúnciar
*/
if(is_user_logged_in()) {} else {
  $custom_page_url = '"'.home_url().'/login/"';

  wp_redirect( $custom_page_url );
}
$user = wp_get_current_user();
$user_id = $user->ID;
global $wpdb;
$error = array();

function reArrayFiles(&$file_post) {

  $file_ary = array();
  $file_count = count($file_post['name']);
  $file_keys = array_keys($file_post);

  for ($i=0; $i<$file_count; $i++) {
      foreach ($file_keys as $key) {
          $file_ary[$i][$key] = $file_post[$key][$i];
      }
  }

  return $file_ary;
}
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
if ($_POST) {

  $txtTitle = $wpdb->escape($_POST['txtTitle']);
  $txtDescription = $wpdb->escape($_POST['txtDescription']);
  $txtValue = $wpdb->escape($_POST['txtValue']);
  $txtCategories = $wpdb->escape($_POST['txtCategories']);
  //$txtCode = $wpdb->escape($_POST['txtCode']);
  $txtLocation = $wpdb->escape($_POST['txtLocation']);
  $txtAvailability = $wpdb->escape($_POST['txtAvailability']);
  $txtGeneralconditions = $wpdb->escape($_POST['txtGeneralconditions']);
  $imgFeatured = $_FILES['imgFeatured'];
  $imgGalery = $_FILES['imgGalery'];
  
  if (empty($txtTitle)) {
    $error['title_empty'] = "O título é obrigatório";
  }
  if (empty($txtDescription)) {
    $error['description_empty'] = "A descição é obrigatória";
  }
  if (empty($txtValue)) {
    $error['value_empty'] = "O valor é obrigatório";
  }
  if (empty($txtLocation)) {
    $error['location_empty'] = "A localização é obrigatória";
  }
  if (empty($txtAvailability)) {
    $error['availability_empty'] = "A disponibilidade é obrigatória";
  }
  if ($imgFeatured["name"] == '') {
    $error['featured_empty'] = "A imagem de destaque é obrigatória";
  }
  if ($imgGalery["name"][0] == '') {
    $error['galery_empty'] = "A galeria de imagens obrigatória";
  }

  // Gather post data.
  $my_post = array(
    'post_title'    => $txtTitle,
    'post_content'  => $txtDescription,
    'post_status'   => 'draft',
    'post_author'   => $user_id,
    'post_category' => array( $txtCategories )
  );

  // Insert the post into the database.
  $post_id = wp_insert_post( $my_post );
  update_field('valor_post', $txtValue, $post_id);
  //update_field('codigo_post', $txtCode, $post_id);
  update_field('localizacao_post', $txtLocation, $post_id);
  update_field('disponibilidade_post', $txtAvailability, $post_id);

  // set Condições gerais
  $itens_repeater = array_filter(explode(';', $txtGeneralconditions));
  $repeater_key = 'field_63bc3f26a6898';
  $field_key = 'field_63bc3f44a6899';
  foreach ($itens_repeater as $item) {
    $value = array(
      $field_key => $item
    );
    add_row($repeater_key, $value, $post_id);
  }

  if(empty($imgGalery['name'][0]) == "") {
    $galeryitens_repeater = array();
    foreach (reArrayFiles($imgGalery) as $item) {
      array_push($galeryitens_repeater, uploadImg($item,$posts));
    }
    $galeryrepeater_key = 'field_63bc4077b5997';
    $galeryfield_key = 'field_63bc408db5998';
    foreach ($galeryitens_repeater as $item) {
      $value = array(
        $galeryfield_key => $item
      );
      add_row($galeryrepeater_key, $value, $post_id);
    }
  }
  
  //var_dump(reArrayFiles($imgGalery));
  //var_dump($imgFeatured);
  // set Imagem de destaque
  if(empty($imgFeatured['name']) == "") {
    set_post_thumbnail( $post_id, uploadImg($imgFeatured,$posts) );
  }

  

}
get_header();

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
              <h3>
                <svg class="icon">
                  <use xlink:href="<?= get_bloginfo('template_url') ?>/assets/img/icons.svg#arrow"></use>
                </svg> meu perfil
              </h3>
              <ul>
                <li><a href="<?= get_permalink( get_page_by_path( $config_thema_linkmyads ) ) ?>">Meus anúncios</a></li>
                <li><a href="<?= get_permalink( get_page_by_path( $config_thema_linkads ) ) ?>">Anúnciar</a></li>
                <li><a href="<?= get_permalink( get_page_by_path( $config_thema_linkprofile ) ) ?>">Perfil</a></li>
                <li><a href="<?php echo wp_logout_url(get_permalink()); ?>">Logout</a></li>
              </ul>
            </div>
            <div class="content">
              <!-- products-list -->
              <div class="products-list">
                <div class="title">
                  <h2>Cadastro</h2>
                </div>
                
                <div class="box-form-ads">
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
                    <label for="txtTitle">
                      <span class="label">Título</span>
                      <input type="text" name="txtTitle" id="" placeholder="" value="">
                    </label>
                    <label for="txtDescription">
                      <span class="label">Descrição</span>
                      <textarea id="tinymce" name="txtDescription"></textarea>
                    </label>
                    <label for="txtCategories">
                      <span class="label">Categoria</span>
                      <div class="box-select">
                      <select name="txtCategories">
                        <?php 
                        $categories = get_categories();
                        foreach($categories as $category) {
                          echo '<option value="' . $category->term_id . '">' . $category->name . '</option>';
                        }
                        ?>
                      </select>
                      </div>
                    </label>
                    <label for="txtValue">
                      <span class="label">Valor</span>
                      <input type="text" name="txtValue" id="money" placeholder="" value="">
                    </label>
                    <!-- label for="">
                      <span class="label">Código</span>
                      <input type="text" name="txtCode" id="" placeholder="" value="">
                    </label -->
                    <label for="txtLocation">
                      <span class="label">Localização</span>
                      <input type="text" name="txtLocation" id="" placeholder="" value="">
                    </label>
                    <label for="txtAvailability">
                      <span class="label">Disponibilidade</span>
                      <input type="text" name="txtAvailability" id="date" placeholder="" value="">
                    </label>
                    <label for="txtGeneralconditions">
                      <span class="label">Condições gerais</span>
                      <textarea name="txtGeneralconditions"></textarea>
                      <span class="alert">separar os itens com ";"</span>
                    </label>
                    <?php wp_nonce_field( 'my_image_upload', 'my_image_upload_nonce' ); ?>
                    <label for="imgFeatured">
                      <span class="label">Imagem de destaque</span>
                      <div class="box-file">
                        <div class="txt">Nenhum arquivo</div>
                        <div class="btn-file">
                        <input type="file" name="imgFeatured" accept="image/*" class="image-file" id="" placeholder="" value="">
                        </div>
                      </div>
                    </label>
                    <label for="imgGalery">
                      <span class="label">Galeria de imagens</span>
                      <div class="box-file">
                        <div class="txt">Nenhum arquivo</div>
                        <div class="btn-file">
                          <input type="file" name="imgGalery[]" accept="image/*" class="image-file" placeholder="" value=""  multiple="true">
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




