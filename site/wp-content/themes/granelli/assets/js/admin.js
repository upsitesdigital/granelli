jQuery(document).ready(function() {

  jQuery('.US_publish').on('click', function() {
    var post_id = jQuery(this).attr('data-post-id');
    var status = jQuery(this).attr('data-status');
    jQuery.ajax({
      url: usAjax.ajaxurl,
      type: "POST",
      data: {
        action: 'change_status',
        post_id: post_id,
        status: status
      },
      success: function(result) {
        console.log(result);
        location.reload();
      }
    });
    return false;
  });

});