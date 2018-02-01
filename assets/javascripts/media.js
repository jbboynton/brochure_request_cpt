/**
 * Launches the media library frame. Allows the user to attach media to the
 * current post.
 *
 * The `mediaLocalData` object contains strings that are made available to this
 * scope via the `wp_localize_script()` function. Although intended for
 * translation of arbitrary text, the same behavior can be leveraged to pass in
 * identifiers that have been defined in PHP.
 */

(function($) {
  "use strict";

  $(document).ready(function() {
    var frame;

    $("#" + mediaLocalData.openButton).click(function(e) {
      e.preventDefault();

      if (!frame) {
        frame = buildFrame();
        wp.media.frames.frame = buildFrame();

        frame.on('select', function() {
          var attachment = frame.state().get('selection').first().toJSON();

          saveBrochureToPost(attachment.url);
        });
      }

      frame.open();
    });
  });

  function buildFrame() {
    var mediaInstance = wp.media({
      title: mediaLocalData.frameTitle,
      button: {
        text: mediaLocalData.frameButtonText
      },
      multiple: false,
      library: {
        type: 'application/pdf'
      }
    });

    return mediaInstance;
  }

  function saveBrochureToPost(brochureUrl) {
    $.ajax({
      url: mediaLocalData.ajaxURL,
      type: 'POST',
      data: {
        action: 'set_url',
        post_id: mediaLocalData.current_post_id,
        brochure_url: brochureUrl
      },
      success: function(response) {
        $("#" + mediaLocalData.currentFile).attr('href', brochureUrl);
        $("#" + mediaLocalData.currentFile).html(brochureUrl);
        $("#" + mediaLocalData.deleteButton).prop('disabled', false);

        showBrochureUpdateNotice(response.notice);
      }
    });
  }

  function showBrochureUpdateNotice(html) {
    var parent = $("#post").before(html);
    setTimeout(function() {
      $(".brc-admin-notice").fadeOut(500, function() {
        $(this).remove();
      });
    }, 10000);
  }

})(jQuery);
