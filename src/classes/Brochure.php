<?php

namespace JB\BRC;

use JB\BRC\Constants;

class Brochure {

  private $post_id = null;

  public function __construct($post_id) {
    $this->post_id = $post_id;
  }

  public function save() {
    $saved = false;
    $url = $this->get_brochure_url_from_post();

    if ($url && $this->is_valid()) {
      $this->update_metadata($url);
      $saved = true;
    }

    return $saved;
  }

  private function get_brochure_url_from_post() {
    $brochure = $_POST[Constants::$MEDIA_JS_INPUT_ID] ?? '';
    $valid_url = $this->validate_url($brochure);

    if (!$valid_url) {
      $brochure = null;
    }

    return $brochure;
  }

  private function validate_url($string) {
    return (filter_var($string, FILTER_VALIDATE_URL) ? true : false);
  }

  private function update_metadata($url) {
    update_post_meta($this->post_id, 'brc_brochure_url', $url);
  }

  private function is_valid() {
    $valid = false;

    $nonce_verified = $this->verify_nonce();
    $not_autosaving = $this->not_autosaving();

    if ($nonce_verified && $not_autosaving) {
      $valid = true;
    }

    return $valid;
  }

  private function verify_nonce() {
    $nonce = $_POST['brc_nonce'];

    return wp_verify_nonce($nonce, 'save_brochure');
  }

  private function not_autosaving() {
    $flag = true;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      $flag = false;
    }

    return $flag;
  }

}

