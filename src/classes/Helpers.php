<?php

namespace JB\BRC;

use JB\BRC\Constants;

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

  public static function build_brochure_thumbnail_url($post) {
    $default_thumbnail_path = Constants::brochure_thumbnail_rel_path();
    $default_thumbnail_url = plugins_url($default_thumbnail_path);

    $current_post_thumbnail_url = get_the_post_thumbnail_url($post);

    if ($current_post_thumbnail_url) {
      $thumbnail = $current_post_thumbnail_url;
    } else {
      $thumbnail = $default_thumbnail_url;
    }

    return $thumbnail;
  }

  public static function build_book_icon_url() {
    $default_icon_path = Constants::book_icon_rel_path();

    return plugins_url($default_icon_path);
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

