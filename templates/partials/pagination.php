<div class="pagination">
  <h2 class="screen-reader-text">Post navigation</h2>
  <div class="nav-links archive-navigation">
    <?php
      the_posts_pagination(array(
        'screen_reader_text' => '',
        'before_page_number' =>
        '<span class="meta-nav screen-reader-text">Page</span>'
      ));
    ?>
  </div>
</div>
