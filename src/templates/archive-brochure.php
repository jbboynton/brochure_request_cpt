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

get_header(); ?>
  <div class="container">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-3">
          <div class="sidebar-widget-area">
            <?php dynamic_sidebar('sidebar-with-filter'); ?>
          </div>
        </div>
        <div class="col-md-9">
          <div class="brc-main-content">
            <div id="posts-container" class="archive">
              <?php if ($wp_query->have_posts()):
                require plugin_dir_path(dirname(__FILE__)) . 'templates/partials/brochure_post_loop.php';
              else:
                require plugin_dir_path(dirname(__FILE__)) . 'templates/partials/none.php';
              endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php get_footer();
