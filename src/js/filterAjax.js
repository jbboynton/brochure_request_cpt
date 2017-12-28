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
      var spinnerContainer = $("#spinner-container");
      var postsContainer = $("#posts-container");

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
          $(document.body).trigger('post-load');
          removeSpinner(spinnerContainer);
          postsContainer.html(response);
        }
      });
    }

    function addSpinner(container) {
      var spinner = container.children('.spinner');

      if (!spinnerIsRunning(spinner)) {
        !spinner.length;
        spinner = buildSpinner(container);
        animateSpinner(spinner, 'add');
      }
    }

    function buildSpinner(container) {
      var spinner = $('<div class="spinner spinner-absolute"></div>');
      spinner.appendTo(container);

      return spinner;
    }

    function spinnerIsRunning(spinner) {
      var hasLength = spinner.length ? true : false;
      var notBeingRemoved = !spinner.hasClass('spinner-remove') ? true : false;

      return (hasLength && notBeingRemoved);
    }

    function removeSpinner(container, success) {
      var spinner = container.children('.spinner');
      spinner.length;
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

  });

})(jQuery);
