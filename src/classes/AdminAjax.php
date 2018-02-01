<?php

namespace JB\BRC;

use JB\BRC\Constants;
use JB\BRC\Helpers;

class AdminAjax {

  private $url_key = 'brc_brochure_url';
  private $title_key = 'brc_brochure_title';
  private $subtitle_key = 'brc_brochure_subtitle';

  public function __construct() {
    add_action('wp_ajax_set_url', array($this, 'set_url'));
    add_action('wp_ajax_unset_url', array($this, 'unset_url'));

    add_action('wp_ajax_set_title', array($this, 'set_title'));
    add_action('wp_ajax_unset_title', array($this, 'unset_title'));

    add_action('wp_ajax_set_subtitle', array($this, 'set_subtitle'));
    add_action('wp_ajax_unset_subtitle', array($this, 'unset_subtitle'));
  }

  public function set_url() {
    $id = $_POST['post_id'];
    $url = $_POST['brochure_url'];

    if ($this->is_valid_url($url)) {
      $result = $this->set_brochure_meta($id, $this->url_key, $url);
    } else {
      $result['error'] = "Validations failed.";
    }

    wp_send_json($result);
  }

  public function unset_url() {
    $id = $_POST['post_id'];

    $result = $this->unset_brochure_meta($id, $this->url_key);

    wp_send_json($result);
  }

  public function set_title() {
    $id = $_POST['post_id'];
    $title = sanitize_text_field($_POST['brochure_title']);

    $result = $this->set_brochure_meta($id, $this->title_key, $title);

    wp_send_json($result);
  }

  public function unset_title() {
    $id = $_POST['post_id'];

    $result = $this->unset_brochure_meta($id, $this->title_key);

    wp_send_json($result);
  }

  public function set_subtitle() {
    $id = $_POST['post_id'];
    $subtitle = sanitize_text_field($_POST['brochure_subtitle']);

    $result = $this->set_brochure_meta($id, $this->subtitle_key, $subtitle);

    wp_send_json($result);
  }

  public function unset_subtitle() {
    $id = $_POST['post_id'];

    $result = $this->unset_brochure_meta($id, $this->subtitle_key);

    wp_send_json($result);
  }

  private function set_brochure_meta($post_id, $key, $value) {
    $response = [];

    // If the new value is successfully saved to the database...
    if (update_post_meta($post_id, $key, $value)) {
      ob_start();

      $message = "File updated successfully.";
      Helpers::admin_notice($message, "success");

      $response['notice'] = ob_get_contents();

      ob_end_clean();
    } elseif (get_post_meta($post_id, $this->key, true) == $url) {

      // If the URL supplied is the same as the one in the database, then the
      // update_post_meta() call won't do anything and returns false. We're
      // going to just treat this the same as a successful save.
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

  private function unset_brochure_meta($post_id, $key) {
    $response = [];

    // if no brochure is attached, don't try to remove any metadata
    if ($this->check_if_meta_exists($post_id, $key)) {
      if (delete_post_meta($post_id, $key)) {
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

    return $response;
  }

  private function check_if_meta_exists($post_id, $key) {
    return metadata_exists('post', $post_id, $key);
  }

  private function is_valid_url($string) {
    return (filter_var($string, FILTER_VALIDATE_URL) ? true : false);
  }

}

