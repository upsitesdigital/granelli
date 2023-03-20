/**
 * Home
 */
export default function() {
  $(document).on('click', '.anchor', function() {
    var $target = $(this).attr('href');
    var $offset = $($target).position().top;
    $('body,html').animate({ scrollTop: $offset }, 1000);
    return false;
  });
  $(document).on('click', '#open-menu', function() {
    $('.seach-box').removeClass('act');
    $('body').toggleClass('menu-open');
    $(this).toggleClass('opened').attr('aria-expanded', 'true');

    return false;
  });

  $(document).on('click', '.menu-sidebar', function() {
    $('body').toggleClass('menu-sidebar-open');

    return false;
  });
  $(document).on('click', '.box-order a', function() {
    var search = window.location.search;
    var url = window.location.origin + window.location.pathname
    if (search != '' && search.match(/order=az/)) {
      console.log('tem');
      url = url + search;
    } else if (search != '') {
      console.log('tem2');
      url = url + search + "&order=az";
    } else {
      console.log('não tem');
      url = url + "?order=az";
    }
    location.assign(url);
    return false;
  });

  $(document).on('change', '.filter-select', function() {
    var option = $(this).val();
    var search = window.location.search;
    var url = window.location.origin + window.location.pathname
    var p = search.match(/\?/) ? '&' : '?';
    console.log(p);
    console.log(search.replace(/order=.*$/, ''));

    if (search != '' && search.match(/order=/)) {
      console.log('tem');
      if (option == '') {
        url = url;
      } else {
        url = url + search.replace(/order=.*$/, '') + "order=" + option;
      }
    } else {
      console.log('não tem');
      url = url + search + p + "order=" + option;
    }
    location.assign(url);
    console.log(option);
    return false;
  });

  $(document).on('change', '.image-file', function() {
    var name = $(this).prop('files');
    if (name.length >= 2) {
      $(this).closest('.box-file').find('.txt').html(name.length + ' arquivos');
    } else {
      $(this).closest('.box-file').find('.txt').html(name[0].name);
    }
    return false;
  });
  $(document).on('click', '#d_txtGeneralconditions', function() {
    $(this).closest('#box_Generalconditions').find('[name="h_txtGeneralconditions"]').val('delete');
    $(this).closest('#box_Generalconditions').hide();
    return false;
  });
  $(document).on('click', '#d_imgGalery', function() {
    $(this).closest('#box_Galery').find('[name="h_imgGalery"]').val('delete');
    $(this).closest('#box_Galery').hide();
    return false;
  });
  $('select[name="txtCategories"]').on('change', function() {
    var category_id = this.value;
    $.ajax({
      url: usAjax.ajaxurl,
      type: "POST",
      data: {
        action: 'get_subcat',
        category_id: category_id
      },
      success: function(result) {
        $("select[name='txtSubCategories']").html(result);
      }
    });
  });
  $('#date').mask('00/00/0000');
  $('#money').mask("#.##0,00", { reverse: true });
  tinymce.init({
    selector: '#tinymce',
    menubar: false,
    content_css: 'tinymce-5-dark',
    content_style: '.mce-content-body {background: #333333;}',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'bold italic bullist',
  });


  $('select#city').html('<option value="">selecione</option>').prop('disabled', 'disabled');
  if ($('select#state').length > 0) {
    $.ajax({
      url: "https://servicodados.ibge.gov.br/api/v1/localidades/estados",
      type: "GET",
      success: function(result) {
        $('select#state').html('<option value="">selecione</option>');
        let field = 'nome';
        let selected = '';
        result = result.sort((a, b) => (a[field] || "").toString().localeCompare((b[field] || "").toString()));
        result.map((item) => {
          console.log('teste');
          if ($('select#state').data('selected') != '') {
            selected = $('select#state').data('selected') == item.nome ? 'selected' : '';
            let state = $('select#state').data('selected') == item.nome ? item.sigla : '';
            if ($('select#city').data('selected') != '' && $('select#state').data('selected') == item.nome) {
              selectCity(state);
            }
          }
          let html = '<option ' + selected + ' value="' + item.nome + '" data-value="' + item.sigla + '">' + item.nome + '</option>';
          $('select#state').append(html);
        });
      }
    });
  }

  $('select#state').on('change', function() {
    let state = $(this).children("option:selected").attr('data-value');
    console.log(state);
    $('select#city').html('<option value="">selecione</option>').prop('disabled', 'disabled');
    selectCity(state);
  });

  function selectCity(state) {
    $.ajax({
      url: "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" + state + "/municipios",
      type: "GET",
      success: function(result) {
        let field = 'nome';
        let selected = '';
        result = result.sort((a, b) => (a[field] || "").toString().localeCompare((b[field] || "").toString()));
        result.map((item) => {
          if ($('select#city').data('selected') != '') {
            selected = $('select#city').data('selected') == item.nome ? 'selected' : '';
          }
          let html = '<option ' + selected + ' value="' + item.nome + '">' + item.nome + '</option>';
          $('select#city').append(html).removeAttr("disabled");
        });
      }
    });
  }

  jQuery('#loginform').find('.login-password > #user_pass').wrap('<div class="pass"></div>');
  jQuery('#loginform').find('.login-password > .pass').append('<span id="look"><i class="fa fa-eye" aria-hidden="true"></i></span>');
  $(document).on('click', '#look', function() {
    let type = $(this).closest('.pass').find('#user_pass').attr('type') == 'text' ? 'password' : 'text';
    $(this).toggleClass('act').closest('.pass').find('#user_pass').attr('type', type);
    return false;
  });

  $(document).on('click', '.galleries .open-full-image', function() {
    $('body').addClass('gallery-open');
    return false;
  });
  $(document).on('click', '.full-image-gallery .close', function() {
    $('body').removeClass('gallery-open');
    return false;
  });
}