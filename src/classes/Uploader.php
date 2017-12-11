<?php

use JB\BRC;

class Uploader {

  private $post_id;
  private $attachment_id;

  public function __construct($post_id) {
    $this->post_id = $post_id;
  }

  public function upload() {
    $this->attachment_id =
      media_handle_upload('brc_brochure_uploader', $this->post_id);

    if (is_wp_error($this->attachment_id)) {
      wp_die('There was an error uploading your file.');
    }
  }

}

