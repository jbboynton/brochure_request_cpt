<?php

/**
 * TODO:
 * 1. handle uploads with the "Media Uploader" (see customer header meta plugin)
 * 2. filter the URL to the post so it points to the PDF attachment page
 * 3. give some sort of indication that there's an attached file on the UI page
 */
namespace JB\BRC;

use JB\BRC\Constants;
use JB\BRC\Brochure;

class Metabox {

  private $post_types = [];

  public function __construct() {

		add_action('post_edit_form_tag', array($this, 'add_enctype'));
		add_action('add_meta_boxes', array($this, 'add_meta_box'));
		add_action('save_post', array($this, 'save'));
		add_action('admin_notices', array($this, 'invalid'));
		add_action('admin_notices', array($this, 'valid'));
	}

  public function add_enctype() {
    echo ' enctype="multipart/form-data"';
  }

  public function add_meta_box() {
    $args = $this->build_meta_box_args();

    add_meta_box(...$args);
  }

  private function build_meta_box_args() {
    return array(
      'brc_brochure_uploader',
      'Upload a brochure',
      array($this, 'callback'),
      array(Constants::$POST_TYPE_NAME),
      'normal',
      'high'
    );
  }

  public function callback() {
    ob_start();
    include plugin_dir_path(dirname(__FILE__)) . 'templates/metabox.php';
    $output = ob_get_contents();
    ob_end_clean();

    echo $output;
  }

  public function save($post_id) {
    // Only proceed if this is a 'brochure' post
    if (!$this->is_brochure_post($post_id)) {
      return;
    }

    $brochure = new Brochure($post_id);

    if ($brochure->save()) {
      $this->create_save_success_message();
    } else {
      $this->create_save_error();
    }
  }

  public function is_brochure_post($id) {
    return (get_post_type($id) == 'brochures' ? true : false);
  }

  public function create_save_error() {
    $error = new \WP_Error('save_failed', $message);
    add_filter('redirect_post_location', function ($location) use ($error) {
      return add_query_arg('brc_error', $error->get_error_code(), $location);
    });
  }

  public function create_save_success_message() {
    add_filter('redirect_post_location', function ($location) {
      return add_query_arg('brc_success', 1, $location);
    });
  }

  public function valid() {
    if (array_key_exists('brc_success', $_GET)) {
      $message = "Brochure uploaded successfully.";
      ?>
        <div class="notice notice-success is-dismissible">
          <p><?php echo $message; ?></p>
        </div>
      <?php
    }
  }

  public function invalid() {
    if (array_key_exists('brc_error', $_GET)) {
      $message = "PDF could not be saved. Please make sure the file you are " .
        "trying to upload is a PDF document, and has a <code>.pdf</code> " .
        "extension.";
      ?>
        <div class="notice notice-error is-dismissible">
          <p><?php echo $message; ?></p>
        </div>
      <?php
    }
  }

}

