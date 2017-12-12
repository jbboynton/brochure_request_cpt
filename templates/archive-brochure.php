<?php
/**
 * The template part for displaying archive
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

get_header(); ?>
  <div class="container">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-9 col-md-push-3">
          <div class="main-content">
            <div class="entry-content archive">
              <?php
                the_archive_title( '<h1>', '</h1>' );
                the_archive_description( '<p>', '</p>' );
              ?>
            </div><!--.entry-content-->
            <div class="archive">
              <?php $args = array('post_type' => 'brochure', 'posts_per_page' => 12); ?>
              <?php $loop = new WP_Query($args); ?>
              <?php if ($loop->have_posts()): ?>

                <?php
                // Start the loop.
                while ($loop->have_posts()): $loop->the_post();

                  /*
                   * Include the Post-Format-specific template for the content.
                   * If you want to override this in a child theme, then include a file
                   * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                   */
                  require plugin_dir_path(dirname(__FILE__)) . 'templates/partials/brochure.php';

                  // End the loop.
                endwhile;

                ?>
                <div class="pagination">
                  <h2 class="screen-reader-text"><?php esc_html__( 'Post navigation', 'visual-composer-starter' ); ?></h2>
                  <div class="nav-links archive-navigation">
                    <?php
                    // Previous/next page navigation.
                    the_posts_pagination( array(
                      'screen_reader_text' => '',
                      'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'visual-composer-starter' ) . '</span>',
                    ) );
                    ?>
                  </div><!--.nav-links archive-navigation-->
                </div><!--.pagination-->
              <?php

              // If no content, include the "No posts found" template.
              else :
                require plugin_dir_path(dirname(__FILE__)) . 'templates/partials/none.php';
              endif;

              ?>

            </div><!--.archive-->
          </div><!--.main-content-->
        </div><!--.<?php echo esc_html( vct_get_maincontent_block_class() ); ?>-->

        <?php get_sidebar(); ?>

      </div><!--.row-->
    </div><!--.content-wrapper-->
  </div><!--.<?php echo esc_html( vct_get_content_container_class() ); ?>-->
<?php get_footer();
