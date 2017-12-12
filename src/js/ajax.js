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
          action: 'unset_brochure',
          post_id: ajaxLocalData.current_post_id
        },
        success: function(response) {
          $("form#post").prepend(response);
          $("#" + ajaxLocalData.deleteButton).prop('disabled', true);
          $("#" + ajaxLocalData.currentFile).attr('href', "");
          $("#" + ajaxLocalData.currentFile).html("");
        }
      });
    });
  });

})(jQuery);
