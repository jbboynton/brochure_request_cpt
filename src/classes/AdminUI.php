<?php

namespace JB\BRC;

use JB\BRC\Constants;
use JB\BRC\Metabox;

class AdminUI {

  private $current_post_id = null;

  public function __construct() {
    add_action('admin_head', array($this, 'set_current_post_id'));

    new Metabox();

    add_action('admin_enqueue_scripts', array($this, 'enqueue_assets'));
  }

  public function set_current_post_id() {
    global $post;

    $this->current_post_id = $post->ID;
  }

  public function enqueue_assets() {
    global $post_type;

    if ($post_type == Constants::$POST_TYPE_NAME) {
      $this->enqueue_css();
      $this->enqueue_media();
      $this->enqueue_ajax();
    }
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
    return array(
      $script_id,
      'mediaLocalData',
      array(
        'frameTitle' => Constants::$MEDIA_FRAME_TITLE,
        'openButton' => Constants::$MEDIA_JS_LAUNCH_BUTTON_ID,
        'frameButtonText' => Constants::$MEDIA_FRAME_BUTTON_TEXT,
        'inputID' => Constants::$MEDIA_JS_INPUT_ID,
        'previewLink' => Constants::$MEDIA_JS_PREVIEW_LINK_ID,
        'clearButton' => Constants::$MEDIA_JS_CLEAR_BUTTON_ID
      )
    );
  }

  private function enqueue_ajax() {
    $ajax_js_args = $this->ajax_js_args();
    $ajax_js_id = $ajax_js_args[0];
    $ajax_js_localization_args = $this->ajax_js_localization($ajax_js_id);

    wp_register_script(...$ajax_js_args);
    wp_localize_script(...$ajax_js_localization_args);
    wp_enqueue_script($ajax_js_id);
  }

  private function ajax_js_args() {
    return array(
      Constants::$AJAX_JS_ID,                 // Unique string identifier
      plugins_url(Constants::$AJAX_JS_PATH),  // Source URL
      array('jquery'),                        // Dependencies
      null,                                   // Version (null = not versioned)
      false                                   // Load script in footer
    );
  }

  private function ajax_js_localization($script_id) {
    global $post;

    return array(
      $script_id,
      'ajaxLocalData',
      array(
        'ajaxURL' => admin_url('admin-ajax.php'),
        'currentFile' => Constants::$AJAX_JS_CURRENT_FILE_ID,
        'deleteButton' => Constants::$AJAX_JS_DELETE_BUTTON_ID,
        'current_post_id' => $post->ID
      )
    );
  }

}
