<?php

/**
 * RequestAjax.php
 */

namespace JB\BRC;

use JB\BRC\Helpers;

class RequestAjax {

  private $brochures = array();
  private $html = '';
  private $user = '';
  private $request = '';
  private $modal_html = '';

  public function __construct() {
    add_action('wp_ajax_build_modal', array($this, 'build_modal'));
    add_action('wp_ajax_nopriv_build_modal', array($this, 'brc_build_modal'));

    add_action('wp_ajax_request_brochures', array($this, 'request_brochures'));
    add_action('wp_ajax_nopriv_request_brochures',
      array($this, 'request_brochures'));
  }

  public function build_modal() {
    $this->brochures = $_POST['modal_data'] ?? array();
    $this->build_markup();
    $this->build_user_data();

    $response = array(
      'html' => $this->html,
      'user' => $this->user
    );

    wp_send_json($response);
  }

  public function request_brochures() {
    $this->request = $_POST['request_data'] ?? array();

    $result = $this->mail_request();
    $this->build_modal_html();

    $response = array(
      'data' => $result,
      'modalHtml' => $this->modal_html
    );

    wp_send_json($response);
  }

  private function build_markup() {
    $end = "</li>";

    foreach ($this->brochures as $brochure) {
      $count = 1;

      // Starting <li>
      $li_start = "<li class=\"list-group-item brc-flex-li brc-line-item\">";

      // Close icon
      $icon = "<div class=\"brc-li-icon\" data-brochure-id=\"{$brochure}\">";
      $icon .= "<i class=\"fa fa-times-circle\"></i></div>";

      // Brochure title
      $name = "<div class=\"brc-li-item-name\">{$brochure}</div>";

      // Quantity select
      $form = "<form class=\"form-inline brc-li-form\"><div class=\"";
      $form .= "form-group\"><label for=\"brc-quantity-{$count}\">QTY:";
      $form .= "</label><input type=\"text\" class=\"form-control ";
      $form .= "brc-li-text\" id=\"brc-quantity-{$count}\" value=\"1\"></div>";
      $form .= "</form>";

      // Ending <li>
      $li_end = "</li>";

      $this->html .= "{$li_start}{$icon}{$name}{$form}{$li_end}";

      $count++;
    }

    // Total request
    $li_total_start = "<li class=\"list-group-item brc-flex-li brc-total\">";
    $total = "{$li_total_start}<span class=\"brc-li-total\">TOTAL:</span>";
    $total .= "<span id=\"brc-li-total-qty\" class=\"brc-li-total-qty\">";
    $total .= "</div>{$li_end}";

    $this->html .= $total;

    return $output;
  }

  private function build_user_data() {
    $user = wp_get_current_user()->ID;
    $user_meta = get_user_meta($user);

    $this->user = array(
      'firstName' => $user_meta['first_name'][0] ?? '',
      'lastName' => $user_meta['last_name'][0] ?? '',
      'company' => $user_meta['company'][0] ?? '',
      'addressLine1' => $user_meta['address_line_1'][0] ?? '',
      'addressLine2' => $user_meta['address_line_2'][0] ?? '',
      'city' => $user_meta['city'][0] ?? '',
      'state' => $user_meta['state'][0] ?? '',
      'zipCode' => $user_meta['zip_code'][0] ?? ''
    );
  }

  private function mail_request() {
    $recipients = "support@clearymillwork.com";
    $subject = "New Brochure Request from ClearyMillwork.com";
    $message = "";
    $headers = "Content-type: text/plain";

    $message .= "Requested Brochures".PHP_EOL;
    $message .= "===================".PHP_EOL;
    $message .= PHP_EOL;

    foreach ($this->request['brochures'] as $brochure) {
      $message .= "Title:          $brochure[0]".PHP_EOL;
      $message .= "Quantity:       $brochure[1]".PHP_EOL;
      $message .= PHP_EOL;
    }

    $message .= PHP_EOL;
    $message .= "Shipping Information".PHP_EOL;
    $message .= "====================".PHP_EOL;
    $message .= PHP_EOL;

    $user = $this->request['user'];
    $message .= "First Name:     {$user[0]}".PHP_EOL;
    $message .= "Last Name:      {$user[1]}".PHP_EOL;
    $message .= "Company:        {$user[2]}".PHP_EOL;
    $message .= "Address Line 1: {$user[3]}".PHP_EOL;
    $message .= "Address Line 2: {$user[4]}".PHP_EOL;
    $message .= "City:           {$user[5]}".PHP_EOL;
    $message .= "State:          {$user[6]}".PHP_EOL;
    $message .= "Zip Code:       {$user[7]}".PHP_EOL;

    if (wp_mail($recipients, $subject, $message, $headers)) {
      $result = "Thank you for your inquiry!";
    } else {
      $result = "There was a problem with your request. Pleae contact ";
      $result .= "<a href=\"mailto:support@clearymillwork.com\">support@";
      $result .= "clearymillwork.com</a>.";
    }

    return $result;
  }

  private function build_modal_html() {
    ob_start();

    include plugin_dir_path(dirname(__FILE__)) .
      'templates/partials/modal.php';
    $this->modal_markup = ob_get_contents();

    ob_end_clean();
  }

}

