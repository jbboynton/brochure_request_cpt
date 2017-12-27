<?php

namespace JB\BRC;

use JB\BRC\Constants;
use JB\BRC\Helpers;

class AdminAjax {

  public function __construct() {
    add_action('wp_ajax_unset_brochure', array($this, 'unset_brochure'));
  }

  public function unset_brochure() {
    $id = $_POST['post_id'];
    $key = 'brc_brochure_url';

    // if no brochure is attached, don't try to remove any metadata
    if ($this->check_if_brochure_exists($id, $key)) {

      if (delete_post_meta($id, $key)) {
        $this->success_notice();
      } else {
        $this->failed_notice();
      }

    }

    wp_die();
  }

  private function check_if_brochure_exists($post_id, $key) {
    return metadata_exists('post', $post_id, $key);
  }

  private function success_notice() {
    $message = "Brochure removed successfully.";
    Helpers::admin_notice($message, "success");
  }

  private function failed_notice() {
    $message = "<strong>Error:</strong> Could not remove the brochure.";
    Helpers::admin_notice($message, "error");
  }

}

