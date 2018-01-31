<?php

namespace JB\BRC;

use JB\BRC\Constants;

class Shortcode {

  public function __construct() {
    $loop_shortcode = Constants::$SHORTCODE_POST_LOOP;

    add_shortcode($loop_shortcode, array($this, 'loop_render'));
  }

  public function loop_render($attributes, $content = '') {
    global $wp_query;

    $paged = (get_query_var('paged') ? get_query_var('paged') : 1);
    $args = array(
      'post_type' => 'brochure',
      'posts_per_archive_page' => 12,
      'paged' => $paged
    );
    $wp_query = new \WP_Query($args);

    ob_start();
    include plugin_dir_path(dirname(__FILE__)) .
      'templates/shortcode-brochure.php';
    $output = ob_get_contents();
    ob_end_clean();

    echo $output;
  }
}

