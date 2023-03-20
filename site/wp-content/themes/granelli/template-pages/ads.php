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
$sucess = array();

$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$url_components = parse_url($url);
parse_str($url_components['query'], $params);
if($params['id'] != '') {
  $post_id = $params['id'];
}

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
  $txtSubCategories = $wpdb->escape($_POST['txtSubCategories']);
  $txtLocation = $wpdb->escape($_POST['txtLocation']);
  $txtState = $wpdb->escape($_POST['txtState']);
  $txtAvailability = $wpdb->escape($_POST['txtAvailability']);
  $txtGeneralconditions = $wpdb->escape($_POST['txtGeneralconditions']);

  $txtCondition = $wpdb->escape($_POST['txtCondition']);
  $txtType = $wpdb->escape($_POST['txtType']);

  $imgFeatured = $_FILES['imgFeatured'];
  $imgGalery = $_FILES['imgGalery'];
  
  $h_txtGeneralconditions = $wpdb->escape($_POST['h_txtGeneralconditions']);
  $h_imgGalery = $wpdb->escape($_POST['h_imgGalery']);
  
  if (empty($txtTitle)) {
    $error['title_empty'] = "O título é obrigatório";
  }
  if (empty($txtDescription)) {
    $error['description_empty'] = "A descição é obrigatória";
  }
  if (empty($txtCategories)) {
    $error['categories_empty'] = "A categoria é obrigatório";
  }
  if (empty($txtValue)) {
    $error['value_empty'] = "O valor é obrigatório";
  }
  if (empty($txtLocation)) {
    $error['location_empty'] = "A localização é obrigatória";
  }
  if (empty($txtState)) {
    $error['state_empty'] = "O estado é obrigatória";
  }
  if (empty($txtAvailability)) {
    $error['availability_empty'] = "A disponibilidade é obrigatória";
  }
  if ($imgFeatured["name"] == '' && $params['id'] == '') {
    $error['featured_empty'] = "A imagem de destaque é obrigatória";
  }
  if ($imgGalery["name"][0] == '' && $params['id'] == '') {
    $error['galery_empty'] = "A galeria de imagens obrigatória";
  }

  $arrcat = array_filter(array( $txtCategories, $txtSubCategories ));
  $location = $txtLocation . ' - ' . $txtState;
  
  if (count($error) == 0) {

    // Insert the post into the database.
    if($params['id'] != '') {
      $my_post = array(
        'post_title'    => $txtTitle,
        'post_content'  => $txtDescription,
        'post_status'   => 'draft',
        'ID'            => $params['id'],
        'post_category' => $arrcat
      );
      $post_id = wp_update_post($my_post);
    } else {
      $my_post = array(
        'post_title'    => $txtTitle,
        'post_content'  => $txtDescription,
        'post_status'   => 'draft',
        'post_author'   => $user_id,
        'post_category' => $arrcat
      );
      $post_id = wp_insert_post( $my_post );
    }
    
    update_field('valor_post', $txtValue, $post_id);
    update_field('codigo_post', $post_id, $post_id);
    update_field('localizacao_post', $location, $post_id);
    update_field('disponibilidade_post', $txtAvailability, $post_id);
    update_field('condicao_post', $txtCondition, $post_id);
    update_field('tipo_post', $txtType, $post_id);

    // set Condições gerais
    $itens_repeater = array_filter(explode(';', $txtGeneralconditions));
    $repeater_key = 'field_63bc3f26a6898';
    $field_key = 'field_63bc3f44a6899';
    // Loop over all staff members.
    if($h_txtGeneralconditions == 'delete') {
      if (!empty(get_field($repeater_key, $post_id))) {
        $count = count(get_field($repeater_key, $post_id));
        for( $index = $count; $index > 0; $index-- ) {
            delete_row($repeater_key, $index, $post_id);
        }
      }
    }
    foreach ($itens_repeater as $item) {
      $value = array(
        $field_key => $item
      );
      add_row($repeater_key, $value, $post_id);
    }

    $galeryrepeater_key = 'field_63bc4077b5997';
    $galeryfield_key = 'field_63bc408db5998';
    if($h_imgGalery == 'delete' && $imgGalery['name'][0] != "") {
      if (!empty(get_field($galeryrepeater_key, $post_id))) {
        $countG = count(get_field($galeryrepeater_key, $post_id));
        for( $indexG = $countG; $indexG > 0; $indexG-- ) {
          delete_row($galeryrepeater_key, $indexG, $post_id);
        }
      }
    }
    if(empty($imgGalery['name'][0]) == "") {
      $galeryitens_repeater = array();
      foreach (reArrayFiles($imgGalery) as $item) {
        array_push($galeryitens_repeater, uploadImg($item,$posts));
      }
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
    
    if ($params['id'] == '') {
      $sucess['sucess'] = "Anúncio publicado";
      wp_safe_redirect( get_permalink() .'?id='.$post_id.'&ads=novo');
    } else {
      $sucess['sucess'] = "Anúncio atualizado";
      wp_safe_redirect( get_permalink() .'?id='.$post_id.'&ads=atualizado');
    }
  }

}
if ($params['ads'] == 'novo') {
  $sucess['sucess'] = "Anúncio publicado";
} elseif($params['ads'] == 'atualizado') {
  $sucess['sucess'] = "Anúncio atualizado";
}
get_header();

$first_name = $user->first_name;

$config_thema_linkmyads    		    = get_theme_mod('US_config_thema_linkmyads');
$config_thema_linkads    		      = get_theme_mod('US_config_thema_linkads');
$config_thema_linkprofile    		  = get_theme_mod('US_config_thema_linkprofile');

$title = '';
if($post_id != '') { $title = get_the_title( $post_id); } elseif(count($error) != 0) { $title = $txtTitle; }

$content = '';
if($post_id != '') { $post_content = get_post($post_id);$content = $post_content->post_content; } elseif(count($error) != 0) {$content = $txtDescription;}

$prices = '';
if($post_id != '') { $prices = get_field('valor_post', $post_id); } elseif(count($error) != 0) { $prices = $txtValue; }

$availability = '';
if($post_id != '') { $availability = get_field('disponibilidade_post', $post_id); } elseif(count($error) != 0) { $availability = $txtAvailability; } else { $availability = date("d/m/Y");}
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
                  } elseif(count($sucess) != 0) {
                    echo '<div class="box-sucess">';
                    foreach ($sucess as $value) {
                      echo '<p>' . $value . '</p>';
                    }
                    echo '</div>';
                  }
                  ?>
                  <form method="post" enctype="multipart/form-data">
                    <label for="txtTitle">
                      <span class="label">Título do anúncio</span>
                      <input type="text" name="txtTitle" id="" placeholder="Máquina / Equipamento / Agroindústria" value="<?= $title ?>">
                    </label>
                    <label for="txtDescription">
                      <span class="label">Descrição</span>
                      <textarea id="tinymce" name="txtDescription"><?= $content ?></textarea>
                    </label>
                    <label for="txtCategories">
                      <span class="label">Categoria</span>
                      <div class="box-select">
                        <select name="txtCategories">
                          <option value="">Selecione a categoria</option>
                          <?php 
                          $args = array(
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'parent' => 0
                          );
                          $categories = get_categories($args);
                          foreach($categories as $category) {
                            $act = '';
                            if($post_id != '') { 
                              $selectedcatargs = array(
                                'parent' => 0
                              );
                              $selectedcat = wp_get_post_categories( $post_id,$selectedcatargs );
                              $act = $category->term_id == $selectedcat[0] ? 'selected' : '';
                            } elseif(count($error) != 0) {
                              $act = $category->term_id == $txtCategories ? 'selected' : '';
                            }
                            echo '<option ' . $act . ' value="' . $category->term_id . '">' . $category->name . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </label>
                    <label for="txtSubCategories">
                      <span class="label">Subcategoria</span>
                      <div class="box-select">
                        <select name="txtSubCategories">
                          
                          <?php if($post_id != '') { 
                            $args = array(
                              'child_of' => $selectedcat[0],
                              'taxonomy' => 'category',
                              'hide_empty' => 0,
                              'hierarchical' => true,
                              'depth'  => 1,
                              'parent' => $selectedcat[0]
                            );
                            if ( isset($selectedcat[0]) ) {
                              $has_children = get_categories($args);
                              if ( $has_children ) {
                                $selectedsubcatargs = array(
                                  'parent' => $selectedcat[0]
                                );
                                $selectedsubcat = wp_get_post_categories( $post_id,$selectedsubcatargs );
                                echo '<option value="">Selecione a subcategoria</option>';
                                foreach ($has_children as $category) {
                                  $act = $category->cat_ID == $selectedsubcat[0] ? 'selected' : '';
                                  echo '<option ' . $act . ' value="'.$category->cat_ID.'">' . $category->cat_name . '</option>';
                                }
                              } else {
                                echo '<option value="">Nenhuma subcategoria!</option>';
                              }  
                             } else {
                              echo '<option value="">Selecione a subcategoria</option>';
                             }
                          } elseif(count($error) != 0) {
                            $args = array(
                              'child_of' => $txtCategories,
                              'taxonomy' => 'category',
                              'hide_empty' => 0,
                              'hierarchical' => true,
                              'depth'  => 1,
                              'parent' => $txtCategories
                            );
                            if ( isset($txtCategories) ) {
                              $has_children = get_categories($args);
                              if ( $has_children ) {
                                $selectedsubcatargs = array(
                                  'parent' => $txtCategories
                                );
                                $selectedsubcat = wp_get_post_categories($selectedsubcatargs );
                                echo '<option value="">Selecione a subcategoria</option>';
                                foreach ($has_children as $category) {
                                  $act = $category->cat_ID == $txtSubCategories ? 'selected' : '';
                                  echo '<option ' . $act . ' value="'.$category->cat_ID.'">' . $category->cat_name . '</option>';
                                }
                              } else {
                                echo '<option value="">Nenhuma subcategoria!</option>';
                              }  
                             } else {
                              echo '<option value="">Selecione a subcategoria</option>';
                             }
                          } else {
                            echo '<option value="">Selecione a subcategoria</option>';
                          } ?>
                        </select>
                      </div>
                    </label>
                    <label for="txtValue">
                      <span class="label">Valor</span>
                      <input type="text" name="txtValue" id="money" placeholder="Defina um valor" value="<?= $prices ?>">
                    </label>
                    <!-- label for="">
                      <span class="label">Código</span>
                      <input type="text" name="txtCode" id="" placeholder="" value="">
                    </label -->
                    <label for="txtLocation">
                      <span class="label">Localização</span>
                      <div class="sub-grid">
                        <div class="box-select">
                        <?php if($post_id != '') { 
                          $selectedstate = explode(' - ', get_field('localizacao_post', $post_id))[1]; 
                        } elseif(count($error) != 0) {
                          $selectedstate = $txtState;
                        } ?>
                          <select id="state" name="txtState" data-selected="<?= $selectedstate ?>">
                            <option value="">Selecione</option>
                          </select>
                        </div>
                        <div class="box-select">
                          <?php if($post_id != '') { 
                            $selectedcity = explode(' - ', get_field('localizacao_post', $post_id))[0]; 
                          } elseif(count($error) != 0) {
                            $selectedcity = $txtLocation;
                          } ?>
                          <select id="city" name="txtLocation" data-selected="<?= $selectedcity ?>">
                            <option value="">Selecione</option>
                          </select>
                          <!-- input type="text" name="txtLocation" id="" placeholder="Defina a cidade" value="<?php if($post_id != '') { echo explode(' - ', get_field('localizacao_post', $post_id))[0]; } ?>" -->
                        </div>
                      </div>
                    </label>
                    <label for="txtCondition">
                      <span class="label">Condição</span>
                      <div class="box-select">
                        <?php if($post_id != '') { $conditionEq = get_field('condicao_post', $post_id); } elseif(count($error) != 0) { $conditionEq = $txtCondition; } ?>
                        <select id="" name="txtCondition">
                          <option value="">Selecione</option>
                          <option <?= $conditionEq == 'novo' ? 'selected' : '' ; ?> value="novo">Novo</option>
                          <option <?= $conditionEq == 'seminovo' ? 'selected' : '' ; ?> value="seminovo">Seminovo</option>
                          <option <?= $conditionEq == 'reformado' ? 'selected' : '' ; ?> value="reformado">Reformado</option>
                          <option <?= $conditionEq == 'usado' ? 'selected' : '' ; ?> value="usado">Usado</option>
                        </select>
                      </div>
                    </label>
                    <label for="txtType">
                      <span class="label">Tipo</span>
                      <div class="box-select">
                        <?php if($post_id != '') { $typeEq = get_field('tipo_post', $post_id); } elseif(count($error) != 0) { $typeEq = $txtType; } ?>
                        <select id="" name="txtType">
                          <option value="">Selecione</option>
                          <option <?= $typeEq == 'maquina-equipamento' ? 'selected' : '' ; ?> value="maquina-equipamento">Máquina/equipamento</option>
                          <option <?= $typeEq == 'industria-completa' ? 'selected' : '' ; ?> value="industria-completa">Indústria completa</option>
                        </select>
                      </div>
                    </label>
                    <label for="txtAvailability">
                      <span class="label">Disponibilidade</span>
                      <input type="text" name="txtAvailability" id="date" placeholder="Defina a data de disponibilidade" value="<?= $availability ?>">
                    </label>
                    <label for="txtGeneralconditions">
                      <span class="label" data-tooltip="Inserir as informações de forma pagamento, transporte, condições do equipamento, etc.">
                        Condições gerais
                        <svg class="icon"><use xlink:href="<?= get_bloginfo('template_url') ?>/assets/img/icons.svg#info"></use></svg>
                      </span>
                      
                        <?php
                        if (have_rows('itens_post', $post_id) && $post_id != '') :
                          echo '<div id="box_Generalconditions"><ul class="condition">';
                          while (have_rows('itens_post', $post_id)) : the_row();
                            echo '<li>' . get_sub_field('item') . '</li>';
                          endwhile;
                          echo '</ul>';
                          echo '<a href="#" id="d_txtGeneralconditions" class="btn-delete"><i class="fa fa-trash-o" aria-hidden="true"></i><span>Deletar todos</a>';
                          echo '<input name="h_txtGeneralconditions" type="hidden" value="">';
                          echo '</div>';
                        endif;
                        ?>
                      
                      <textarea name="txtGeneralconditions" placeholder="Defina as condições, separadas por ;"><?php if(count($error) != 0) { echo $txtGeneralconditions; } ?></textarea>
                      <span class="alert">separar os itens com ";"</span>
                    </label>
                    <?php wp_nonce_field( 'my_image_upload', 'my_image_upload_nonce' ); ?>
                    <label for="imgFeatured">
                      <span class="label">Imagem de destaque</span>
                      <?php 
                      if ($post_id != '') : 
                        echo '<div id="box_Featured"><div class="images-list">' . wp_get_attachment_image(get_post_thumbnail_id($post_id), 'thumbnail') . '</div></div>';
                      endif;
                      ?>
                      <div class="box-file">
                        <div class="txt">Nenhum arquivo</div>
                        <div class="btn-file">
                        <input type="file" name="imgFeatured" accept="image/*" class="image-file" id="" placeholder="" value="">
                        </div>
                      </div>
                    </label>
                    <label for="imgGalery">
                      <span class="label">Galeria de imagens</span>
                      <?php
                      if (have_rows('imagens_post', $post_id) && $post_id != '') :
                        echo '<div id="box_Galery"><div class="images-list">';
                        while (have_rows('imagens_post', $post_id)) : the_row();
                          echo wp_get_attachment_image(get_sub_field('imagem'), 'thumbnail');
                        endwhile;
                        echo '</div>';
                        echo '<a href="#" id="d_imgGalery" class="btn-delete"><i class="fa fa-trash-o" aria-hidden="true"></i><span>Deletar todos</a>';
                        echo '<input name="h_imgGalery" type="hidden" value="">';
                        echo '</div>';
                      endif;
                      ?>
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




