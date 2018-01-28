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

          $("#" + mediaLocalData.inputID).val(attachment.url);
          $("#" + mediaLocalData.previewLink).attr('href', attachment.url);
          $("#" + mediaLocalData.previewLink).html(attachment.url);
          $("#" + mediaLocalData.clearButton).prop('disabled', false);
        });
      }

      frame.open();
    });

    $("#" + mediaLocalData.clearButton).click(function(e) {
      $("#" + mediaLocalData.inputID).val("");
      $("#" + mediaLocalData.previewLink).html("");
      $("#" + mediaLocalData.previewLink).attr('href', "");
      $("#" + mediaLocalData.clearButton).prop('disabled', true);
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

})(jQuery);