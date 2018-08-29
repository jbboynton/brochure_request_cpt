/**
 * Request process for brochures.
 */

(function($) {
  "use strict";

  $(document).ready(function() {

    $(document).ajaxComplete(function() {
      loadCart();
    });

    $.fn.toggleRequest = function() {
      var brochureId = this.data("brochure-id");

      if (inCart(brochureId)) {
        this.request("remove");
      } else {
        this.request("add");
      }

      return this;
    };

    $.fn.request = function(action) {
      var brochureId = this.data("brochure-id");
      var brochureElement = findByBrochureId(this, brochureId);

      if (action === "add") {
        addToCart(brochureId);

        brochureElement.addClass("brc-selected");
        brochureElement.html("Selected");
      } else if (action === "remove") {
        removeFromCart(brochureId);

        brochureElement.removeClass("brc-selected");
        brochureElement.html("Request");
      }

      updateCounter();
      updateTotal();

      return this;
    };

    function findByBrochureId(currentObj, brochureId) {
      var selector = ".brc-request-single[data-brochure-id='" + brochureId +
        "']";
      var element = '';

      if (currentObj.hasClass(".brc-request-single")) {
        element = currentObj;
      } else {
        element = $(selector);
      }

      return element;
    }

    function addToCart(brochureId) {
      var cart = getCart();

      if (!inCart(brochureId)) {
        cart.push(brochureId);
      }

      saveCart(cart);
    }

    function removeFromCart(brochureId) {
      var cart = getCart();
      var position = cart.indexOf(brochureId);

      if (inCart(brochureId)) {
        cart.splice(position, 1);
      }

      saveCart(cart);
    }

    function inCart(brochureId) {
      var cart = getCart();
      var position = cart.indexOf(brochureId);
      var isInCart = false;

      if (position !== -1) {
        isInCart = true;
      }

      return isInCart;
    }

    function getCart() {
      var cartString = Cookies.get("brc_cart");
      var cart = [];

      if (cartString) {
        cart = JSON.parse(cartString);
      }

      return cart;
    }

    function saveCart(cart) {
      var cartString  = JSON.stringify(cart);

      Cookies.set("brc_cart",  cartString);
    }

    function resetCart() {
      console.log('resetting');
      var empty = [];

      saveCart(empty);
    }

    function loadCart() {
      $(".brc-request-single").each(function() {
        var brochureId = $(this).data("brochure-id");

        if (inCart(brochureId)) {
          $(this).addClass("brc-selected");
          $(this).html("Selected");
        }
      });

      updateCounter();
    }

    function updateCounter() {
      var counter = $("#brc-counter");
      var cart = getCart();
      var total = cart.length;

      if (total <= 0) {
        counter.hide();
      } else {
        counter.show();
      }

      counter.html(total);
    }

    function updateTotal() {
      var quantity = $("#brc-li-total-qty");
      var quantityInputs = $(".brc-li-text");
      var total = 0;

      quantityInputs.each(function() {
        var value = $(this).val();
        value = parseInt(value);

        if (value) {
          total += value;
        } else {
          $(this).val("0");
        }

      });

      quantity.html(total);
    }

    function buildRequestData() {
      var brochures = buildBrochureData();
      var user = buildUserData();

      return ({ brochures: brochures, user: user });
    }

    function buildBrochureData() {
      var listItems = $(".brc-line-item");
      var brochures = [];

      listItems.each(function() {
        var name = $(this).find(".brc-li-item-name").html();
        var quantity = $(this).find(".brc-li-text").val();

        brochures.push([name, quantity]);
      });

      return brochures;
    }

    function buildUserData() {
      var firstName = $("#brc-ship-first-name");
      var lastName = $("#brc-ship-last-name");
      var company = $("#brc-ship-company");
      var addressLine1 = $("#brc-ship-address-line-1");
      var addressLine2 = $("#brc-ship-address-line-2");
      var city = $("#brc-ship-city");
      var state = $("#brc-ship-state");
      var zipCode = $("#brc-ship-zip-code");

      var requiredFields = [firstName, lastName, addressLine1, city, state, zipCode];
      var emptyFields = validate(requiredFields);

      if (emptyFields === undefined || emptyFields.length == 0) {
        var user = [
          firstName.val(),
          lastName.val(),
          company.val(),
          addressLine1.val(),
          addressLine2.val(),
          city.val(),
          state.val(),
          zipCode.val()
        ];
      } else {
        applyValidationErrors(emptyFields);
        var user = false;
      }

      return user;
    }

    function validate(formData) {
      var invalidFields = [];

      formData.forEach(function(object) {
        if (!object.val()) {
          invalidFields.push(object);
        }
      });

      return invalidFields;
    }

    function applyValidationErrors(fields) {
      fields.forEach(function(field) {
        field.css("borderColor", "#AA0000");

        field.on("blur", function() {
          if (field.val()) {
            field.css("borderColor", "");
          }

          $("#brc-validation-message").remove();
        });
      });
    }

    function populateForm(userData) {
      $("#brc-ship-first-name").val(userData.firstName);
      $("#brc-ship-last-name").val(userData.lastName);
      $("#brc-ship-company").val(userData.company);
      $("#brc-ship-address-1").val(userData.addressLine1);
      $("#brc-ship-address-2").val(userData.addressLine2);
      $("#brc-ship-city").val(userData.city);
      $("#brc-ship-state").val(userData.state);
      $("#brc-ship-zip-code").val(userData.zipCode);
    }

    $("body").on("touchstart click", ".brc-request-single", function() {
      $(this).toggleRequest();
    });

    $("body").on("touchstart click", "#brc-clear-all", function() {
      $(".brc-request-single").each(function() {
        $(this).request("remove");
      });

      resetCart();
      updateCounter();
    });

    $("body").on("touchstart click", "#brc-request-all", function() {
      var counter = $("#brc-counter");

      if (counter.html() > 0) {

        var modalData = getCart();
        var spinnerContainer = $("#brc-spinner-container");

        $.ajax({
          url: localized.ajaxUrl,
          type: 'POST',
          beforeSend: function(xhr) {
            addSpinner(spinnerContainer);
          },
          data: {
            action: 'build_modal',
            post_id: localized.currentPostId,
            modal_data: modalData
          },
          success: function(response) {
            removeSpinner(spinnerContainer);

            $("#brc-requested-catalogs").html(response.html);
            updateTotal();
            populateForm(response.user);

            $("body").on("touchstart click", ".brc-li-icon", function() {
              $(this).request("remove");
              $(this).closest("li").remove();

              updateTotal();
              updateCounter();

              var lineItems = $(".brc-line-item");
              if (!lineItems.length) {
                $("#brc-checkout-modal").modal('hide');
              }
            });

            var quantityInputs = $(".brc-li-text");
            quantityInputs.change(function() {
              updateTotal();
            });

            $("#brc-checkout-modal").modal();
          }
        });

      }
    });

    $("body").on("touchstart click", "#brc-request-submit", function() {
      var spinnerContainer = $("#brc-spinner-submit");
      var modalBody = $("#brc-confirmation");
      var requestData = buildRequestData();

      if (requestData.user) {
        $.ajax({
          url: localized.ajaxUrl,
          type: 'POST',
          beforeSend: function(xhr) {
            addSpinner(spinnerContainer);
            modalBody.fadeOut(500);
          },
          data: {
            action: 'request_brochures',
            post_id: localized.currentPostId,
            request_data: requestData.user
          },
          success: function(response) {
            console.log('test');
            removeSpinner(spinnerContainer);
            modalBody.html(response.data).fadeIn(500);
            $("#brc-request-submit").remove();

            $(".brc-request-single").each(function() {
              $(this).request("remove");
            });

            resetCart();
            updateCounter();

            $("#brc-checkout-modal").on('hidden.bs.modal', function() {
              $(this).replaceWith(response.modalHtml);
            });
          }
        });
      } else {
        var shippingInfoPane = $("#brc-shipping-info-link");
        var spanText = "<span id='brc-validation-message' class='small'> – " +
          "please fill in required fields</span>";
        var span = $(spanText);

        $("#brc-validation-message").remove();
        shippingInfoPane.append(span);

        if (shippingInfoPane.hasClass('collapsed')) {
          shippingInfoPane.trigger('click');
        }
      }
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
        container
        .removeClass(container.data('animating'))
        .data('animating', null);
        container
        .data('animationTimeout') &&
          clearTimeout(container.data('animationTimeout'));
      }

      container
      .addClass('brc-spinner-' + animation)
      .data('animating', 'brc-spinner-' + animation);
      container
      .data('animationTimeout', setTimeout(function() {
        animation == 'remove' && container.remove();
        success && success();
      },
      parseFloat(container.css('animation-duration')) * 1000));
    }

    loadCart();

  });

})(jQuery);
