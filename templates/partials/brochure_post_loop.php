<?php

// Maintain a post index during the loop, so that we can wrap
// each group of 3 posts in a `.row` element
$opening_div_index = 3;
$closing_div_index = 4;

while (have_posts()) {
  the_post();

  if ($opening_div_index % 3 == 0) {
    echo '<div class="row">';
  }

  require plugin_dir_path(dirname(__FILE__)) . 'partials/brochure.php';

  if ($closing_div_index % 3 == 0) {
    echo '</div>';
  }

  $opening_div_index++;
  $closing_div_index++;
}

// If the number of posts isn't a multiple of 3, add the closing
// div tag after the loop has finished
if ($wp_query->post_count % 3 != 0) {
  echo '</div>';
}

require plugin_dir_path(dirname(__FILE__)) . 'partials/pagination.php';
wp_reset_postdata();
