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
    var spinnerContainer = $("#brc-spinner-container");

    $.ajax({
      url: mediaLocalData.ajaxURL,
      type: 'POST',
      beforeSend: function(xhr) {
        addSpinner(spinnerContainer);
      },
      data: {
        action: 'set_url',
        post_id: mediaLocalData.current_post_id,
        brochure_url: brochureUrl
      },
      success: function(response) {
        removeSpinner(spinnerContainer);
        $("#" + mediaLocalData.currentFile).attr('href', brochureUrl);
        $("#" + mediaLocalData.currentFile).html(brochureUrl);
        $("#" + mediaLocalData.deleteButton).prop('disabled', false);

        showBrochureUpdateNotice(response.notice);
        console.log(response);
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

  function addSpinner(container) {
    var spinner = container.children('.spinner');

    if (!spinnerIsRunning(spinner)) {
      spinner = buildSpinner(container);
      animateSpinner(spinner, 'add');
    }
  }

  function spinnerIsRunning(spinner) {
    var exists = spinner.length ? true : false;
    var notBeingRemoved = isBeingRemoved(spinner);

    return (exists && notBeingRemoved);
  }

  function isBeingRemoved(element) {
    var beingRemoved = element.hasClass('spinner-remove') ? true : false;

    return !beingRemoved;
  }

  function buildSpinner(container) {
    var spinner = $('<div class="spinner spinner-absolute"></div>');
    spinner.appendTo(container);

    return spinner;
  }

  function removeSpinner(container, success) {
    var spinner = container.children('.spinner');

    animateSpinner(spinner, 'remove', success);
  }

  function animateSpinner(container, animation, success) {
    if (container.data('animating')) {
      container.removeClass(container.data('animating')).data('animating', null);
      container.data('animationTimeout') && clearTimeout(container.data('animationTimeout'));
    }

    container.addClass('spinner-' + animation).data('animating', 'spinner-' + animation);
    container.data('animationTimeout', setTimeout(function() {
      animation == 'remove' && container.remove();
      success && success();
    }, parseFloat(container.css('animation-duration')) * 1000));
  }

})(jQuery);
