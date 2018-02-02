<?php
/* Outputs the Insights Videos in an archive layout. */
?>

<div class="container">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-3">
        <div class="sidebar-widget-area">
          <?php dynamic_sidebar('sidebar-with-filter'); ?>
        </div>
      </div>
      <div class="col-md-9">
      <div class="brc-request-all">
          <a class="menu-button brc-request-button">Request Print Catalogs <i class="fa fa-book"></i></a>
        </div>
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

