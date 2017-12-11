<?php

namespace JB\BRC;

class Brochure {

	private $post_id = null;

	public function __construct($post_id) {
		$this->post_id = $post_id;
	}

	public function save() {
		$saved = false;

		if (!$this->files_present()) {
			$saved = true;
		}

		if ($this->is_valid()) {
			$this->upload();
			$saved = true;
		}

		return $saved;
	}

	private function upload() {
    $file_was_uploaded = null;
    $overrides = array('action' => 'editpost');

    $result = wp_handle_upload($_FILES['brc_brochure_uploader'], $overrides);

    if ($this->did_upload_succeed($result)) {
      echo "File is valid, successfully uploaded.";
      $file_was_uploaded = true;
    } else {
      $file_was_uploaded = $result['error'];
    }

    return $file_was_uploaded;
  }

  private function did_upload_succeed($upload_result) {
    $result_exists = ($upload_result ? true : false);
    $no_error_in_result = (!isset($upload_result['error']) ? true : false);

    return ($result_exist && $no_error_in_result);
  }

  private function update_post_meta() {
    $attachments = get_attached_media('application/pdf');
    $attachment_post_ids = array_map(function($attachment) {
      return $attachment->ID;
    }, $attachments);
    $current_attachment = max($attachment_post_ids);
    $attachment_url = wp_get_attachment_url($current_attachment);

    update_post_meta($this->post_id, 'brochure_url', $attachment_url);
  }

	private function is_valid() {
		$valid = false;

		$nonce_verified = $this->verify_nonce();
		$not_autosaving = $this->not_autosaving();
		$files_present = $this->files_present();
		$is_pdf = $this->verify_filetype();

		if ($nonce_verified && $not_autosaving && $files_present && $is_pdf) {
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

	private function files_present() {
		return (!empty($_FILES['brc_brochure_uploader']['name']));
	}

	private function verify_filetype() {
		$flag = false;
		$permitted_filetype = 'application/pdf';
		$uploaded_filetype = $_FILES['brc_brochure_uploader']['type'];

		if ($permitted_filetype == $uploaded_filetype) {
			$flag = true;
		}

		return $flag;
	}

}

