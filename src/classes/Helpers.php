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

  public static function pp($data) {
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
  }


}

