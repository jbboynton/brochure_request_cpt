/**
 * Filters the displayed brochures.
 */

(function($) {
  "use strict";

  $(document).ready(function() {

    $("#" + ajaxLocalData.brandsForm).change(function() {
      parseFilters($(this));
    });

    $("#" + ajaxLocalData.productCategoriesForm).change(function() {
      parseFilters($(this));
    });

    function parseFilters(changedForm) {
      var spinnerContainer = $("#brc-spinner-container-filter");

      var brandsForm = $("#" + ajaxLocalData.brandsForm);
      var productCategoriesForm = $("#" + ajaxLocalData.productCategoriesForm);

      var brandTermID = brandsForm.find("option:selected").val();
      var productTermID = productCategoriesForm.find("option:selected").val();

      $.ajax({
        url: ajaxLocalData.ajaxURL,
        type: changedForm.attr('method'),
        beforeSend: function(xhr) {
          addSpinner(spinnerContainer);
        },
        data: {
          action: changedForm.attr('action'),
          brand_term_id: brandTermID,
          product_term_id: productTermID
        },
        success: function(response) {
          removeSpinner(spinnerContainer);
          insertPosts(response.html);
          updateBrowserState(response);
        }
      });
    }

    function insertPosts(postsHtml) {
      var postsContainer = $("#posts-container");
      postsContainer.html(postsHtml);

      // See codex.wordpress.org/AJAX_in_Plugins#The_post-load_JavaScript_Event
      // for more info about triggering the 'post-load' event
      $(document.body).trigger('post-load');
    }

    function updateBrowserState(ajaxResponse) {
      document.title = "Brochures – " + ajaxResponse.title;

      var currentState = {
        "html": ajaxResponse.html,
        "title": ajaxResponse.title,
        "url": ajaxResponse.url
      };

      window.history.pushState(currentState, "", ajaxResponse.url);
    }

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
