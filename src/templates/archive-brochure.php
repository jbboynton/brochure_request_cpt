<?php

/**
 * Archive page for the Brochure custom post type.
 */

use JB\BRC\Helpers;

global $wp_query;

$paged = (get_query_var('paged') ? get_query_var('paged') : 1);
$args = array(
  'post_type' => 'brochure',
  'posts_per_archive_page' => 12,
  'paged' => $paged
);
$wp_query = new \WP_Query($args);

require plugin_dir_path(dirname(__FILE__)) . 'templates/shortcode-brochure.php';

