/**
 * Unsets the associated brochure URL from the current post via an AJAX request.
 */

(function($) {
  "use strict";

  $(document).ready(function() {
    $("#" + ajaxLocalData.deleteButton).click(function(e) {
      var spinnerContainer = $("#brc-spinner-container");

      $.ajax({
        url: ajaxLocalData.ajaxURL,
        type: 'POST',
        beforeSend: function(xhr) {
          addSpinner(spinnerContainer);
        },
        data: {
          action: 'unset_url',
          post_id: ajaxLocalData.current_post_id
        },
        success: function(response) {
          removeSpinner(spinnerContainer);
          // showBrochureUpdateNotice(response.notice);

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

    $("#" + ajaxLocalData.currentIssuu).blur(function() {
      var issuuUrl = $(this).val();
      var spinnerContainer = $("#brc-spinner-container");

      if ($(this).hasClass("brc-invalid")) {
        $(this).removeClass("brc-invalid");
      }

      $.ajax({
        url: ajaxLocalData.ajaxURL,
        type: 'POST',
        beforeSend: function(xhr) {
          addSpinner(spinnerContainer);
        },
        data: {
          action: 'set_issuu',
          post_id: ajaxLocalData.current_post_id,
          issuu_url: issuuUrl
        },
        success: function(response) {
          if (response.error) {
            showBrochureUpdateNotice(response.notice);
            $("#" + ajaxLocalData.currentIssuu).addClass("brc-invalid");
          }

          removeSpinner(spinnerContainer);
        }
      });
    });

    $("#" + ajaxLocalData.currentTitle).blur(function() {
      var brochureTitle = $(this).val();
      var spinnerContainer = $("#brc-spinner-container");

      $.ajax({
        url: ajaxLocalData.ajaxURL,
        type: 'POST',
        beforeSend: function(xhr) {
          addSpinner(spinnerContainer);
        },
        data: {
          action: 'set_title',
          post_id: ajaxLocalData.current_post_id,
          brochure_title: brochureTitle
        },
        success: function(response) {
          removeSpinner(spinnerContainer);
          // showBrochureUpdateNotice(response.notice);
        }
      });
    });

    $("#" + ajaxLocalData.currentSubtitle).blur(function() {
      var brochureSubtitle = $(this).val();
      var spinnerContainer = $("#brc-spinner-container");

      $.ajax({
        url: ajaxLocalData.ajaxURL,
        type: 'POST',
        beforeSend: function(xhr) {
          addSpinner(spinnerContainer);
        },
        data: {
          action: 'set_subtitle',
          post_id: ajaxLocalData.current_post_id,
          brochure_subtitle: brochureSubtitle
        },
        success: function(response) {
          console.log(response);
          removeSpinner(spinnerContainer);
          // showBrochureUpdateNotice(response.notice);
        }
      });
    });

    function addSpinner(container) {
      var spinner = container.children('.brc-spinner');

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
      var beingRemoved = element.hasClass('brc-spinner-remove') ? true : false;

      return !beingRemoved;
    }

    function buildSpinner(container) {
      var spinner = $('<div class="brc-spinner .brc-spinner-absolute"></div>');
      spinner.appendTo(container);

      return spinner;
    }

    function removeSpinner(container, success) {
      var spinner = container.children('.brc-spinner');

      animateSpinner(spinner, 'remove', success);
    }

    function animateSpinner(container, animation, success) {
      if (container.data('animating')) {
        container.removeClass(container.data('animating')).data('animating', null);
        container.data('animationTimeout') && clearTimeout(container.data('animationTimeout'));
      }

      container.addClass('brc-spinner-' + animation).data('animating', 'brc-spinner-' + animation);
      container.data('animationTimeout', setTimeout(function() {
        animation == 'remove' && container.remove();
        success && success();
      }, parseFloat(container.css('animation-duration')) * 1000));
    }

  });


})(jQuery);
