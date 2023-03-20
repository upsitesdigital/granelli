<?php

function US_customizer_register($wp_customize)
{
  /* create panel Options theme */
  $wp_customize->add_panel(
    new US_WP_Customize_Panel($wp_customize, 'US_client_theme', array(
      'priority'          => 201,
      'title'            => __('Options theme', 'upsites'),
      'description'      => __('Options theme', 'upsites'),
    ))
  );

  /* title_tagline */
  $wp_customize->add_setting('US_email', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_email', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('E-mail', 'upsites'),
  ));
  $wp_customize->add_setting('US_whats', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_whats', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('Whatsapp', 'upsites'),
  ));
  $wp_customize->add_setting('US_text_btn', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_text_btn', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('Texto botão', 'upsites'),
  ));
  $wp_customize->add_setting('US_link_btn', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_link_btn', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('Link botão', 'upsites'),
  ));
  $wp_customize->add_setting('US_link_logged_btn', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_link_logged_btn', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('Link logado botão', 'upsites'),
  ));
  $wp_customize->add_setting('US_logo_footer', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control(
    new WP_Customize_Image_Control(
      $wp_customize,
      'logo_footer',
      array(
        'label'     => __('Logo Rodapé', 'upsites'),
        'section'   => 'title_tagline',
        'settings'  => 'US_logo_footer',
      )
    )
  );
  $wp_customize->add_setting('US_opening_hours', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_opening_hours', array(
    'type' => 'textarea',
    'section' => 'title_tagline',
    'label' => __('Horario de funcionamento', 'upsites'),
  ));
  $wp_customize->add_setting('US_phones', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_phones', array(
    'type' => 'textarea',
    'section' => 'title_tagline',
    'label' => __('Telefones', 'upsites'),
  ));
  $wp_customize->add_setting('US_address', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_address', array(
    'type' => 'textarea',
    'section' => 'title_tagline',
    'label' => __('Endereço', 'upsites'),
  ));
  $wp_customize->add_setting('US_facebook', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_facebook', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('Facebook', 'upsites'),
  ));
  $wp_customize->add_setting('US_instagram', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_instagram', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('Instagram', 'upsites'),
  ));
  $wp_customize->add_setting('US_youtube', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_youtube', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('Youtube', 'upsites'),
  ));
  $wp_customize->add_setting('US_text_copyright', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_text_copyright', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('Copyright', 'upsites'),
  ));
  $wp_customize->add_setting('US_link_privacy_policy', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_link_privacy_policy', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('Link Política de privacidade', 'upsites'),
  ));
  $wp_customize->add_setting('US_signature', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_signature', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('Assinatura', 'upsites'),
  ));
  /* end:title_tagline */


  /* create panel Home Page */
  $wp_customize->add_panel(
    new US_WP_Customize_Panel($wp_customize, 'US_home', array(
      'priority'         => 201,
      'title'            => __('Home Page', 'upsites'),
      'description'      => __('Home page', 'upsites'),
      'panel'            => 'US_client_theme',
    ))
  );

  /* Slide home */
  $wp_customize->add_section(
    'US_slide',
    array(
      'priority'         => 201,
      'title'            => __('Slide', 'upsites'),
      'description'      => __('Slide home', 'upsites'),
      'panel'             => 'US_home'
    )
  );
  $wp_customize->add_setting('US_title_slide', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_title_slide', array(
    'type' => 'text',
    'section' => 'US_slide',
    'label' => __('Título', 'upsites'),
  ));
  $wp_customize->add_setting('US_slide_repeater', array(
    'sanitize_callback' => 'customizer_repeater_sanitize'
  ));
  $wp_customize->add_control(new Customizer_Repeater($wp_customize, 'US_slide_repeater', array(
    'label'   => __('Items', 'upsites'),
    'item_name' => __('Item', 'upsites'),
    'section' => 'US_slide',
    'customizer_repeater_image_control' => false,
    'customizer_repeater_image_mobile_control' => false,
    'customizer_repeater_icon_control' => false,
    'customizer_repeater_link_control' => false,
    'customizer_repeater_title_control' => true,
    'customizer_repeater_subtitle_control' => false,
    'customizer_repeater_text_control' => false,
    'customizer_repeater_shortcode_control' => false,
    'customizer_repeater_repeater_control' => false
  )));
  $wp_customize->add_setting('US_signature', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_signature', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('Assinatura', 'upsites'),
  ));
  /* end:Slide home */

  /* Texts Home */
  $wp_customize->add_section(
    'US_btn_home',
    array(
      'title'    => __('Botões', 'upsites'),
      'priority' => 204,
      'panel'    => 'US_home'
    )
  );
  $wp_customize->add_setting('US_btn_home_title_01', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_btn_home_title_01', array(
    'type' => 'text',
    'section' => 'US_btn_home',
    'label' => __('Título 01', 'upsites'),
  ));
  $wp_customize->add_setting('US_btn_home_subtitle_01', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_btn_home_subtitle_01', array(
    'type' => 'text',
    'section' => 'US_btn_home',
    'label' => __('Subtítulo 01', 'upsites'),
  ));
  $wp_customize->add_setting('US_btn_home_link_01', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_btn_home_link_01', array(
    'type' => 'text',
    'section' => 'US_btn_home',
    'label' => __('Link 01', 'upsites'),
  ));
  $wp_customize->add_setting('US_btn_home_link_logged_01', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_btn_home_link_logged_01', array(
    'type' => 'text',
    'section' => 'US_btn_home',
    'label' => __('Link logado 01', 'upsites'),
  ));
  $wp_customize->add_setting('US_btn_home_img_01', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control(
    new WP_Customize_Image_Control(
      $wp_customize,
      'btn_home_img_01',
      array(
        'label'     => __('Imagem 01', 'upsites'),
        'section'   => 'US_btn_home',
        'settings'  => 'US_btn_home_img_01',
      )
    )
  );
  $wp_customize->add_setting('US_btn_home_div_01', array(
    'sanitize_callback' => 'themename_sanitize',
  ));
  $wp_customize->add_control(
    new US_Separator_Control(
      $wp_customize,
      'US_btn_home_div_01',
      array(
        'section' => 'US_btn_home',
      )
    )
  );
  $wp_customize->add_setting('US_btn_home_title_02', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_btn_home_title_02', array(
    'type' => 'text',
    'section' => 'US_btn_home',
    'label' => __('Título 02', 'upsites'),
  ));
  $wp_customize->add_setting('US_btn_home_subtitle_02', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_btn_home_subtitle_02', array(
    'type' => 'text',
    'section' => 'US_btn_home',
    'label' => __('Subtítulo 02', 'upsites'),
  ));
  $wp_customize->add_setting('US_btn_home_link_02', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_btn_home_link_02', array(
    'type' => 'text',
    'section' => 'US_btn_home',
    'label' => __('Link 02', 'upsites'),
  ));
  $wp_customize->add_setting('US_btn_home_link_logged_02', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_btn_home_link_logged_02', array(
    'type' => 'text',
    'section' => 'US_btn_home',
    'label' => __('Link logado 02', 'upsites'),
  ));
  $wp_customize->add_setting('US_btn_home_img_02', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control(
    new WP_Customize_Image_Control(
      $wp_customize,
      'btn_home_img_02',
      array(
        'label'     => __('Imagem 02', 'upsites'),
        'section'   => 'US_btn_home',
        'settings'  => 'US_btn_home_img_02',
      )
    )
  );
  /* end:Texts Home */


  /* Banners */
  $wp_customize->add_section(
    'US_banner_home',
    array(
      'title'    => __('Banner', 'upsites'),
      'priority' => 204,
      'panel'    => 'US_home'
    )
  );
  $wp_customize->add_setting('US_banner_home_titulo', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_banner_home_titulo', array(
    'type' => 'text',
    'section' => 'US_banner_home',
    'label' => __('Título', 'upsites'),
  ));
  $wp_customize->add_setting('US_banner_home_subtitulo', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_banner_home_subtitulo', array(
    'type' => 'text',
    'section' => 'US_banner_home',
    'label' => __('Subtítulo', 'upsites'),
  ));
  $wp_customize->add_setting('US_banner_home_link', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_banner_home_link', array(
    'type' => 'text',
    'section' => 'US_banner_home',
    'label' => __('Link', 'upsites'),
  ));
  $wp_customize->add_setting('US_banner_home_img', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control(
    new WP_Customize_Image_Control(
      $wp_customize,
      'banner_home_img',
      array(
        'label'     => __('Imagem', 'upsites'),
        'section'   => 'US_banner_home',
        'settings'  => 'US_banner_home_img',
      )
    )
  );
  /* end:Banners */

  /* About */
  $wp_customize->add_section(
    'US_about_home',
    array(
      'title'    => __('Sobre', 'upsites'),
      'priority' => 204,
      'panel'    => 'US_home'
    )
  );
  $wp_customize->add_setting('US_about_home_titulo', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_about_home_titulo', array(
    'type' => 'text',
    'section' => 'US_about_home',
    'label' => __('Título', 'upsites'),
  ));
  $wp_customize->add_setting('US_about_home_subtitulo', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_about_home_subtitulo', array(
    'type' => 'text',
    'section' => 'US_about_home',
    'label' => __('Subtítulo', 'upsites'),
  ));
  $wp_customize->add_setting('US_about_home_text', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_about_home_text', array(
    'type' => 'textarea',
    'section' => 'US_about_home',
    'label' => __('Texto', 'upsites'),
  ));
  $wp_customize->add_setting('US_about_home_img', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control(
    new WP_Customize_Image_Control(
      $wp_customize,
      'about_home_img',
      array(
        'label'     => __('Imagem', 'upsites'),
        'section'   => 'US_about_home',
        'settings'  => 'US_about_home_img',
      )
    )
  );
  /* end:About */

  /* create panel Home Page */
  $wp_customize->add_panel(
    new US_WP_Customize_Panel($wp_customize, 'US_config', array(
      'priority'         => 201,
      'title'            => __('Configuração', 'upsites'),
      'description'      => __('Configuração', 'upsites'),
      'panel'            => 'US_client_theme',
    ))
  );

  /* Slide home */
  $wp_customize->add_section(
    'US_config_thema',
    array(
      'priority'         => 201,
      'title'            => __('Configuração', 'upsites'),
      'description'      => __('Configuração do tema', 'upsites'),
      'panel'             => 'US_config'
    )
  );
  $wp_customize->add_setting('US_config_thema_formpost', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_config_thema_formpost', array(
    'type' => 'text',
    'section' => 'US_config_thema',
    'label' => __('Formulário do post', 'upsites'),
  ));
  $wp_customize->add_setting('US_config_thema_linkmyads', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_config_thema_linkmyads', array(
    'type' => 'text',
    'section' => 'US_config_thema',
    'label' => __('Slug Meus anúncios', 'upsites'),
  ));
  $wp_customize->add_setting('US_config_thema_linkads', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_config_thema_linkads', array(
    'type' => 'text',
    'section' => 'US_config_thema',
    'label' => __('Slug Anúncios', 'upsites'),
  ));
  $wp_customize->add_setting('US_config_thema_linkprofile', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_config_thema_linkprofile', array(
    'type' => 'text',
    'section' => 'US_config_thema',
    'label' => __('Slug Perfil', 'upsites'),
  ));
  $wp_customize->add_setting('US_config_thema_linkallads', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_config_thema_linkallads', array(
    'type' => 'text',
    'section' => 'US_config_thema',
    'label' => __('Slug todos os produtos', 'upsites'),
  ));
}
add_action('customize_register', 'US_customizer_register');


function US_register_cpts()
{
  /**
   * Post Type: Procuras.
   */

   $labels = [
    "name" => __("Procuras", "upsites"),
    "singular_name" => __("Procura", "upsites"),
  ];

  $args = [
    "label" => __("Procuras", "upsites"),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => true,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "rest_namespace" => "wp/v2",
    "has_archive" => false,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "delete_with_user" => false,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "can_export" => false,
    "rewrite" => ["slug" => "find", "with_front" => true],
    "query_var" => true,
    "supports" => ["title"],
    "show_in_graphql" => false,
  ];

  register_post_type("find", $args);

}
add_action('init', 'US_register_cpts');


function US_register_taxes()
{

}
add_action('init', 'US_register_taxes');

if (function_exists('acf_add_local_field_group')) :
  acf_add_local_field_group(array(
    'key' => 'group_63bc3f17c900d',
    'title' => 'Condições gerais',
    'fields' => array(
      array(
        'key' => 'field_63bc3f26a6898',
        'label' => 'Itens',
        'name' => 'itens_post',
        'type' => 'repeater',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'collapsed' => '',
        'min' => 0,
        'max' => 0,
        'layout' => 'table',
        'button_label' => '',
        'sub_fields' => array(
          array(
            'key' => 'field_63bc3f44a6899',
            'label' => 'Item',
            'name' => 'item',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
          ),
        ),
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'post',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
  ));
  
  acf_add_local_field_group(array(
    'key' => 'group_63bc551e8a059',
    'title' => 'Contato',
    'fields' => array(
      array(
        'key' => 'field_63bc553608f49',
        'label' => 'Whatsapp',
        'name' => 'whatsapp_contact',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_63bc555408f4a',
        'label' => 'E-mail',
        'name' => 'e-mail_contact',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_63bc556008f4b',
        'label' => 'Endereço',
        'name' => 'endereco_contact',
        'type' => 'textarea',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'maxlength' => '',
        'rows' => '',
        'new_lines' => 'br',
      ),
      array(
        'key' => 'field_63bc557408f4c',
        'label' => 'Formulário',
        'name' => 'formulario_contact',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'page_template',
          'operator' => '==',
          'value' => 'template-pages/contact.php',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => array(
      1 => 'the_content',
      2 => 'excerpt',
      3 => 'discussion',
      4 => 'comments',
      5 => 'revisions',
      7 => 'author',
      8 => 'format',
      10 => 'featured_image',
      11 => 'categories',
      12 => 'tags',
      13 => 'send-trackbacks',
    ),
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
  ));
  
  acf_add_local_field_group(array(
    'key' => 'group_63bc3ff600c2d',
    'title' => 'Galeria de imagens',
    'fields' => array(
      array(
        'key' => 'field_63bc4077b5997',
        'label' => 'Imagens',
        'name' => 'imagens_post',
        'type' => 'repeater',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'collapsed' => '',
        'min' => 0,
        'max' => 0,
        'layout' => 'table',
        'button_label' => '',
        'sub_fields' => array(
          array(
            'key' => 'field_63bc408db5998',
            'label' => 'Imagem',
            'name' => 'imagem',
            'type' => 'image',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'return_format' => 'id',
            'preview_size' => 'thumbnail',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
          ),
        ),
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'post',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
  ));
  
  acf_add_local_field_group(array(
    'key' => 'group_63bc3e86cef8e',
    'title' => 'Informações extras',
    'fields' => array(
      array(
        'key' => 'field_63bc3eacca988',
        'label' => 'Valor',
        'name' => 'valor_post',
        'type' => 'price',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'format' => '|2/,/.|',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => 'R$',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_63bc3ec3ca989',
        'label' => 'Código',
        'name' => 'codigo_post',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_63bc3ed4ca98a',
        'label' => 'Localização',
        'name' => 'localizacao_post',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_63bc3ee0ca98b',
        'label' => 'Disponibilidade',
        'name' => 'disponibilidade_post',
        'type' => 'date_picker',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'display_format' => 'd/m/Y',
        'return_format' => 'd/m/Y',
        'first_day' => 1,
      ),
      
      array(
        'key' => 'field_63bc3ee0ca98c',
        'label' => 'Condição',
        'name' => 'condicao_post',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'choices' => array(
          'novo' => 'Novo',
          'seminovo' => 'Seminovo',
          'reformado' => 'Reformado',
          'usado' => 'Usado',
        ),
        'default_value' => false,
        'allow_null' => 1,
        'multiple' => 0,
        'ui' => 0,
        'return_format' => 'value',
        'ajax' => 0,
        'placeholder' => '',
      ),
      array(
        'key' => 'field_63bc3ee0ca98d',
        'label' => 'Tipo',
        'name' => 'tipo_post',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'choices' => array(
          'maquina-equipamento' => 'Máquina/equipamento',
          'industria-completa' => 'Indústria completa',
        ),
        'default_value' => false,
        'allow_null' => 1,
        'multiple' => 0,
        'ui' => 0,
        'return_format' => 'value',
        'ajax' => 0,
        'placeholder' => '',
      ),

    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'post',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
  ));

  acf_add_local_field_group(array(
    'key' => 'group_63e2a7432677b',
    'title' => 'Formulário',
    'fields' => array(
      array(
        'key' => 'field_63e2a75a15513',
        'label' => 'Formulário',
        'name' => 'formulario_find',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'page_template',
          'operator' => '==',
          'value' => 'template-pages/find.php',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => array(
      1 => 'excerpt',
      2 => 'discussion',
      3 => 'comments',
      4 => 'revisions',
      5 => 'author',
      6 => 'format',
      8 => 'featured_image',
      9 => 'categories',
      10 => 'tags',
      11 => 'send-trackbacks',
    ),
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
  ));
  
  acf_add_local_field_group(array(
    'key' => 'group_63e1750025c9b',
    'title' => 'Procuras',
    'fields' => array(
      array(
        'key' => 'field_63e1751048d82',
        'label' => 'Detalhes / Decrição',
        'name' => 'detalhes_decricao_find',
        'type' => 'textarea',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'maxlength' => '',
        'rows' => 4,
        'new_lines' => 'br',
      ),
      array(
        'key' => 'field_63e1753348d83',
        'label' => 'Destino',
        'name' => 'destino_find',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'find',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
  ));
  
  acf_add_local_field_group(array(
    'key' => 'group_63c5ac3c2255e',
    'title' => 'Telefone',
    'fields' => array(
      array(
        'key' => 'field_63c5ac6947707',
        'label' => 'Telefone',
        'name' => 'telefone_user',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'user_form',
          'operator' => '==',
          'value' => 'all',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
  ));

  acf_add_local_field_group(array(
    'key' => 'group_640108e5c0039',
    'title' => 'Destacar anúncio',
    'fields' => array(
      array(
        'key' => 'field_6401092af825c',
        'label' => 'Destacar',
        'name' => 'destacar_post',
        'type' => 'true_false',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'message' => '',
        'default_value' => 0,
        'ui' => 1,
        'ui_on_text' => '',
        'ui_off_text' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'post',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
  ));
  
  acf_add_local_field_group(array(
    'key' => 'group_6403aedfe7d0d',
    'title' => 'Avatar',
    'fields' => array(
      array(
        'key' => 'field_6403af238b5a5',
        'label' => 'Imagem do perfil',
        'name' => 'imagem_do_perfil_user',
        'type' => 'image',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'return_format' => 'id',
        'preview_size' => 'medium',
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'user_form',
          'operator' => '==',
          'value' => 'all',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
  ));

  acf_add_local_field_group(array(
    'key' => 'group_640e164e5d944',
    'title' => 'Informações extras',
    'fields' => array(
      array(
        'key' => 'field_640e168a40132',
        'label' => 'Razão social',
        'name' => 'razaosocial_user',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_640e16ad40133',
        'label' => 'CNPJ',
        'name' => 'cnpj2_user',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_640e16bb40134',
        'label' => 'Localização',
        'name' => 'localizacao_user',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array(
        'key' => 'field_640e27ea4a04a',
        'label' => 'Sou',
        'name' => 'sou_user',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'choices' => array(
          'proprietario' => 'Proprietário',
          'vendedor' => 'Vendedor autorizado',
        ),
        'default_value' => false,
        'allow_null' => 1,
        'multiple' => 0,
        'ui' => 0,
        'return_format' => 'value',
        'ajax' => 0,
        'placeholder' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'user_form',
          'operator' => '==',
          'value' => 'all',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
  ));
endif;
