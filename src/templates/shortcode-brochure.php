<?php
/* Outputs brochures in an archive layout. */
?>

<div class="container">
  <div class="content-wrapper">
    <div class="brc-row-flex">
      <h1 class="brc-page-title">Brochures &amp; Catalogs</h1>
      <div class="brc-request-all">
        <a id="brc-request-all" class="menu-button brc-request-button">Request Print Catalogs <span id="brc-counter" class="badge brc-counter"></span></a>
        <span id="brc-spinner-container"></span>
      </div>
      <?php require plugin_dir_path(dirname(__FILE__)) . 'templates/partials/modal.php'; ?>
    </div>
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

