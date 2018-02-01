/**
 * Unsets the associated brochure URL from the current post via an AJAX request.
 */

(function($) {
  "use strict";

  $(document).ready(function() {
    $("#" + ajaxLocalData.deleteButton).click(function(e) {
      $.ajax({
        url: ajaxLocalData.ajaxURL,
        type: 'POST',
        data: {
          action: 'unset_url',
          post_id: ajaxLocalData.current_post_id
        },
        success: function(response) {
          showBrochureUpdateNotice(response.notice);

          $("#" + ajaxLocalData.deleteButton).prop('disabled', true);
          $("#" + ajaxLocalData.currentFile).attr('href', "");
          $("#" + ajaxLocalData.currentFile).html("");
        }
      });
    });

    function showBrochureUpdateNotice(html) {
      var parent = $("#post").before(html);
      setTimeout(function() {
        $(".brc-admin-notice").fadeOut(500, function() {
          $(this).remove();
        });
      }, 10000);
    }

  });

})(jQuery);
