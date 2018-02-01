<?php

namespace JB\BRC;

use JB\BRC\Constants;
use JB\BRC\Helpers;

class AdminAjax {

  private $key = 'brc_brochure_url';

  public function __construct() {
    add_action('wp_ajax_set_url', array($this, 'set_url'));
    add_action('wp_ajax_unset_url', array($this, 'unset_url'));
  }

  public function set_url() {
    $response = array();
    $id = $_POST['post_id'];
    $url = $_POST['brochure_url'];

    if (update_post_meta($id, $this->key, $url)) {
      ob_start();

      $message = "File updated successfully.";
      Helpers::admin_notice($message, "success");

      $response['notice'] = ob_get_contents();

      ob_end_clean();
    } else {
      ob_start();

      $message = "Could not save the file.";
      Helpers::admin_notice($message, "error");

      $response['notice'] = ob_get_contents();

      ob_end_clean();
    }

    wp_send_json($response);
  }

  public function unset_url() {
    $response = array();
    $id = $_POST['post_id'];

    // if no brochure is attached, don't try to remove any metadata
    if ($this->check_if_brochure_exists($id)) {
      if (delete_post_meta($id, $this->key)) {
        ob_start();

        $message = "File removed successfully.";
        Helpers::admin_notice($message, "success");

        $response['notice'] = ob_get_contents();

        ob_end_clean();
      } else {
        ob_start();

        $message = "Could not remove the current file.";
        Helpers::admin_notice($message, "error");

        $response['notice'] = ob_get_contents();

        ob_end_clean();
      }
    }

    // wp_die();
    wp_send_json($response);
  }

  private function check_if_brochure_exists($post_id) {
    return metadata_exists('post', $post_id, $this->key);
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

