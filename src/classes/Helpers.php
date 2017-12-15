<?php

namespace JB\BRC;

class Helpers {

  public static function admin_notice($message_text, $style = "success") {
    $html =
      "<div class=\"notice notice-${style}\">
        <p>${message_text}</p>
      </div>";

    echo $html;
  }

  public static function build_dropdown_option($term) {
    $id = $term->term_id;
    $name = $term->name;

    $html = "<option value=\"${id}\">${name}</option>";

    echo $html;
  }

  public static function pp($data) {
    if (is_array($data)) {
      $data = (str_replace("  ", " ", print_r($data, true)));
    }

    echo '<div style="width:90%;background-color:#fff"><pre>';
    var_dump($data);
    echo "</pre></div>";
  }

}

