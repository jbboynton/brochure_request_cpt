<?php

namespace JB\BRC;

class Constants {

  // Post type info
  public static $POST_TYPE_NAME = 'brochure';
  public static $DESCRIPTION =
    'A custom post type for representing brochures and catalogs.';
  public static $POST_ARCHIVE_REL_URL = 'resources/brochures-catalogs';

  // Images
  public static $IMAGES_DIR_REL_PATH = 'brochure_request_cpt/assets/images';

  // Templates
  public static $ARCHIVE_TEMPLATE_PATH =
    'brochure_request_cpt/src/templates/archive-brochure.php';

  // Styles
  public static $ADMIN_CSS_ID = 'brc_admin_css';
  public static $ADMIN_CSS_PATH =
    'brochure_request_cpt/assets/stylesheets/admin.css';

  public static $PUBLIC_CSS_ID = 'brc_public_css';
  public static $PUBLIC_CSS_PATH =
    'brochure_request_cpt/assets/stylesheets/public.css';

  public static $LOGGED_OUT_CSS_ID = 'brc_logged_out_css';
  public static $LOGGED_OUT_CSS_PATH =
    'brochure_request_cpt/assets/stylesheets/logged_out.css';

  public static $SPINNER_CSS_ID = 'brc_spinner_css';
  public static $SPINNER_CSS_PATH =
    'brochure_request_cpt/assets/stylesheets/spinner.css';

  // Media
  public static $MEDIA_JS_ID = 'brc_media_js';
  public static $MEDIA_JS_PATH =
    'brochure_request_cpt/assets/javascripts/media.js';

  public static $MEDIA_JS_LAUNCH_BUTTON_ID = 'brc-launch-media-uploader-button';
  public static $MEDIA_JS_INPUT_ID = 'brc-selected-brochure-url';

  public static $MEDIA_FRAME_TITLE = 'Choose or Upload a Brochure';
  public static $MEDIA_FRAME_BUTTON_TEXT = 'Use this brochure';

  // Admin AJAX
  public static $ADMIN_AJAX_JS_ID = 'brc_ajax_js';
  public static $ADMIN_AJAX_JS_PATH =
    'brochure_request_cpt/assets/javascripts/adminAjax.js';
  public static $ADMIN_AJAX_JS_CURRENT_FILE_ID = 'brc-current-file-url';
  public static $ADMIN_AJAX_JS_CURRENT_ISSUU_ID = 'brc-current-issuu-url';
  public static $ADMIN_AJAX_JS_CURRENT_TITLE_ID = 'brc-current-title-url';
  public static $ADMIN_AJAX_JS_CURRENT_SUBTITLE_ID = 'brc-current-subtitle-url';
  public static $ADMIN_AJAX_JS_DELETE_BUTTON_ID = 'brc-delete-button';

  // Request AJAX
  public static $REQUEST_AJAX_ID = 'brc_request_ajax_js';
  public static $REQUEST_AJAX_PATH =
    'brochure_request_cpt/assets/javascripts/requestAjax.js';

  // Modal JS
  public static $MODAL_JS_ID = 'brc_bs_modal_js';
  public static $MODAL_JS_PATH =
    'brochure_request_cpt/assets/javascripts/bootstrap-modal.js';

  // Cookie JS
  public static $COOKIE_JS_ID = 'brc_bs_cookie_js';
  public static $COOKIE_JS_PATH =
    'brochure_request_cpt/assets/javascripts/js-cookie.js';

  // Filter (widget info)
  public static $FILTER_ID = 'brc_post_filter';
  public static $FILTER_UI_NAME = 'Brochure Filter';
  public static $FILTER_DESCRIPTION =
    'Sort and filter for the Brochures archive page.';
  public static $FILTER_PHP_CLASS = 'JB\BRC\Filter';

  // Filter (UI component)
  public static $FILTER_UI_FORM_CLASS = 'brc_brochures_filter_form';
  public static $FILTER_UI_ACTION = 'brc_filter_brochures';

  public static $FILTER_UI_BRANDS_ID = 'brc_brands_filter';
  public static $FILTER_UI_BRANDS_NAME = 'brc_brands_filter';

  public static $FILTER_UI_PRODUCT_CATEGORIES_ID =
    'brc_product_categories_filter';
  public static $FILTER_UI_PRODUCT_CATEGORIES_NAME =
    'brc_product_categories_filter';

  // Filter AJAX
  public static $FILTER_AJAX_JS_ID = 'brc_filter_js';
  public static $FILTER_AJAX_JS_PATH =
    'brochure_request_cpt/assets/javascripts/filterAjax.js';

  // Shortcode
  public static $SHORTCODE_POST_LOOP = 'brc_post_loop';

  /**
   * Helper functions
   */
  public static function brochure_thumbnail_rel_path() {
    $base = self::$IMAGES_DIR_REL_PATH;

    return "${base}/no-image-available.png";
  }

  public static function book_icon_rel_path() {
    $base = self::$IMAGES_DIR_REL_PATH;

    return "${base}/book-icon.png";
  }

  public static function reference_guide_rel_path() {
    $base = self::$IMAGES_DIR_REL_PATH;

    return "${base}/reference-guide.png";
  }

}

