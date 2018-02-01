<?php

namespace JB\BRC;

use JB\BRC\Constants;
use JB\BRC\Metabox;

class AdminUI {

  private $current_post_id = 0;

  public function __construct() {
    new Metabox();

    add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    add_action('wp_enqueue_scripts', array($this, 'enqueue_public_assets'));
    add_action('in_admin_header', array($this, 'remove_screen_options'));
  }

  public function enqueue_admin_assets() {
    global $post_type;

    if ($post_type == Constants::$POST_TYPE_NAME) {
      $this->enqueue_css();

      $this->set_current_post_id();
      $this->enqueue_media();
      $this->enqueue_admin_ajax();
    }
  }

  public function enqueue_public_assets() {
    global $post_type;
    global $post;

    if ($this->public_assets_are_required($post, $post_type)) {
      $this->enqueue_css();
      $this->enqueue_request_ajax();
      $this->enqueue_modal_js();
      $this->enqueue_cookie_js();
    }
  }

  private function public_assets_are_required($post, $post_type) {
    $is_brochure_post = false;
    $has_brochure_shortcode = false;

    if ($post_type == Constants::$POST_TYPE_NAME) {
      $is_brochure_post = true;
    }

    if (has_shortcode($post->post_content, Constants::$SHORTCODE_POST_LOOP)) {
      $has_brochure_shortcode = true;
    }

    return ($is_brochure_post || $has_brochure_shortcode);
  }

  public function remove_screen_options() {
    global $post_type;
    global $wp_meta_boxes;

    // Remove social sharing and revslider from Brochure edit screen
    if ($post_type == Constants::$POST_TYPE_NAME) {
      $id = get_current_screen()->id;

      unset($wp_meta_boxes[$id]['advanced']['high']['A2A_SHARE_SAVE_meta']);
      unset($wp_meta_boxes[$id]['normal']['default']['mymetabox_revslider_0']);
    }
  }

  private function set_current_post_id() {
    global $post;

    $this->current_post_id = $post->ID;
  }

  /**
   * Enqueues stylesheets. To add more stylesheets, go the the
   * `find_stylesheets()` method definition, and read the comment above the
   * method.
   */
  private function enqueue_css() {
    $styles = $this->find_stylesheets();

    foreach ($styles as $stylesheet) {
      $id = $stylesheet[0];  // Unique identifier for the stylesheet

      wp_register_style(...$stylesheet);
      wp_enqueue_style($id);
    }
  }

  /**
   * Prepares stylesheets to be loaded by WordPress. Add new stylesheets by
   * creating constants for the stylesheet ID and path (see the `Constants`
   * file), and then add them below.
   */
  private function find_stylesheets() {
    return array(
      array(
        Constants::$ADMIN_CSS_ID,
        plugins_url(Constants::$ADMIN_CSS_PATH)
      ),
      array(
        Constants::$PUBLIC_CSS_ID,
        plugins_url(Constants::$PUBLIC_CSS_PATH)
      ),
      array(
        Constants::$SPINNER_CSS_ID,
        plugins_url(Constants::$SPINNER_CSS_PATH)
      )
    );
  }

  private function enqueue_media() {
    $enqueue_media_args = array('post' => $this->current_post_id);
    $media_js_args = $this->media_js_args();
    $media_js_id = $media_js_args[0];
    $media_js_localization_args = $this->media_js_localization($media_js_id);

    wp_enqueue_media();

    wp_register_script(...$media_js_args);
    wp_localize_script(...$media_js_localization_args);
    wp_enqueue_script($media_js_id);
  }

  private function media_js_args() {
    return array(
      Constants::$MEDIA_JS_ID,                 // Unique string identifier
      plugins_url(Constants::$MEDIA_JS_PATH),  // Source URL
      array('jquery'),                         // Dependencies
      null,                                    // Version (null = not versioned)
      true                                     // Load script in footer
    );
  }

  private function media_js_localization($script_id) {
    global $post;

    return array(
      $script_id,
      'mediaLocalData',
      array(
        'ajaxURL' => admin_url('admin-ajax.php'),
        'frameTitle' => Constants::$MEDIA_FRAME_TITLE,
        'openButton' => Constants::$MEDIA_JS_LAUNCH_BUTTON_ID,
        'frameButtonText' => Constants::$MEDIA_FRAME_BUTTON_TEXT,
        'inputID' => Constants::$MEDIA_JS_INPUT_ID,
        'currentFile' => Constants::$ADMIN_AJAX_JS_CURRENT_FILE_ID,
        'deleteButton' => Constants::$ADMIN_AJAX_JS_DELETE_BUTTON_ID,
        'current_post_id' => $post->ID
      )
    );
  }

  private function enqueue_admin_ajax() {
    $admin_ajax_js_args = $this->admin_ajax_js_args();
    $admin_ajax_js_id = $admin_ajax_js_args[0];
    $admin_ajax_js_localization_args =
      $this->admin_ajax_js_localization($admin_ajax_js_id);

    wp_register_script(...$admin_ajax_js_args);
    wp_localize_script(...$admin_ajax_js_localization_args);
    wp_enqueue_script($admin_ajax_js_id);
  }

  private function admin_ajax_js_args() {
    return array(
      Constants::$ADMIN_AJAX_JS_ID,                 // Unique string identifier
      plugins_url(Constants::$ADMIN_AJAX_JS_PATH),  // Source URL
      array('jquery'),                              // Dependencies
      null,                                   // Version (null = not versioned)
      false                                   // Load script in footer
    );
  }

  private function admin_ajax_js_localization($script_id) {
    global $post;

    return array(
      $script_id,
      'ajaxLocalData',
      array(
        'ajaxURL' => admin_url('admin-ajax.php'),
        'currentFile' => Constants::$ADMIN_AJAX_JS_CURRENT_FILE_ID,
        'currentIssuu' => Constants::$ADMIN_AJAX_JS_CURRENT_ISSUU_ID,
        'currentTitle' => Constants::$ADMIN_AJAX_JS_CURRENT_TITLE_ID,
        'currentSubtitle' => Constants::$ADMIN_AJAX_JS_CURRENT_SUBTITLE_ID,
        'deleteButton' => Constants::$ADMIN_AJAX_JS_DELETE_BUTTON_ID,
        'current_post_id' => $post->ID
      )
    );
  }

  private function enqueue_request_ajax() {
    $args = $this->request_ajax_args();
    $id = $args[0];
    $localized_args = $this->request_ajax_localization($id);

    wp_register_script(...$args);
    wp_localize_script(...$localized_args);
    wp_enqueue_script($id);
  }

  private function request_ajax_args() {
    return array(
      Constants::$REQUEST_AJAX_ID,                 // Unique string identifier
      plugins_url(Constants::$REQUEST_AJAX_PATH),  // Source URL
      array('jquery'),                              // Dependencies
      null,                                   // Version (null = not versioned)
      false                                   // Load script in footer
    );
  }

  private function request_ajax_localization($script_id) {
    global $post;

    return array(
      $script_id,
      'localized',
      array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'currentPostId' => $post->ID
      )
    );
  }

  private function enqueue_modal_js() {
    $args = $this->modal_args();
    $id = $args[0];

    wp_register_script(...$args);
    wp_enqueue_script($id);
  }

  private function modal_args() {
    return array(
      Constants::$MODAL_JS_ID,
      plugins_url(Constants::$MODAL_JS_PATH),
      array('jquery'),
      null,
      false
    );
  }

  private function enqueue_cookie_js() {
    $args = $this->cookie_args();
    $id = $args[0];

    wp_register_script(...$args);
    wp_enqueue_script($id);
  }

  private function cookie_args() {
    return array(
      Constants::$COOKIE_JS_ID,
      plugins_url(Constants::$COOKIE_JS_PATH),
      array('jquery'),
      null,
      false
    );
  }

}
