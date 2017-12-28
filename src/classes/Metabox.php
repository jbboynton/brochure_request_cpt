<?php

namespace JB\BRC;

use JB\BRC\Constants;
use JB\BRC\Brochure;

class Metabox {

  private $post_id = '';
  private $post_types = [];
  private $meta_data = [];

  public function __construct() {
    add_action('post_edit_form_tag', array($this, 'add_enctype'));
    add_action('add_meta_boxes', array($this, 'add_meta_box'));
    add_action('save_post', array($this, 'save'));
  }

  public function add_enctype() {
    echo ' enctype="multipart/form-data"';
  }

  public function add_meta_box() {
    $args = $this->build_meta_box_args();

    add_meta_box(...$args);
  }

  public function callback($current_post) {
    $meta_data = get_post_meta($current_post->ID, 'brc_brochure_url', true);
    $input_id = Constants::$MEDIA_JS_INPUT_ID;
    $launch_button_id = Constants::$MEDIA_JS_LAUNCH_BUTTON_ID;
    $preview_link_id = Constants::$MEDIA_JS_PREVIEW_LINK_ID;
    $clear_button_id = Constants::$MEDIA_JS_CLEAR_BUTTON_ID;
    $current_file_id = Constants::$ADMIN_AJAX_JS_CURRENT_FILE_ID;
    $delete_button_id = Constants::$ADMIN_AJAX_JS_DELETE_BUTTON_ID;
    $delete_button_enabled = ($meta_data ? "enabled" : "disabled");

    ob_start();
    include plugin_dir_path(dirname(__DIR__)) .
      'templates/partials/metabox.php';
    $output = ob_get_contents();
    ob_end_clean();

    echo $output;
  }

  public function save($post_id) {
    // Only proceed if this is a 'brochure' post
    if ($this->is_brochure_post($post_id)) {
      $brochure = new Brochure($post_id);
      $brochure->save();
    }
  }

  private function build_meta_box_args() {
    return array(
      'brc_brochure_uploader',
      'Select A Brochure',
      array($this, 'callback'),
      array(Constants::$POST_TYPE_NAME),
      'normal',
      'high'
    );
  }

  private function is_brochure_post($id) {
    return (get_post_type($id) == 'brochure' ? true : false);
  }

}

