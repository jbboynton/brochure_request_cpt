<?php

/**
 * FilterAjax.php
 * Handles AJAX requests from the Brochures archive page. Determines what posts
 * are requested, and retrieves them from a custom `WP_Query`.
 */

namespace JB\BRC;

use JB\BRC\Helpers;

class FilterAjax {

  private $brand_term_ids = array();
  private $product_term_ids = array();
  private $url_base = '';  // The relative path to the brochures archive page

  public function __construct() {
    $this->url_base = Constants::$POST_ARCHIVE_REL_URL;

    add_action('wp_ajax_brc_filter_brochures',
      array($this, 'brc_filter_brochures'));
    add_action('wp_ajax_nopriv_brc_filter_brochures',
      array($this, 'brc_filter_brochures'));
  }

  public function brc_filter_brochures() {
    $html = $this->build_markup();
    $page_title = get_bloginfo('name');
    $url = '/' . $this->url_base;

    $response = array(
      'html' => $html,
      'title' => $page_title,
      'url' => $url
    );

    wp_send_json($response);
  }

  private function build_markup() {
    ob_start();

    $this->set_term_ids();
    $this->build_filtered_posts();

    $output = ob_get_contents();
    ob_end_clean();

    return $output;
  }

  private function set_term_ids() {
    $brand_term_id = $_POST['brand_term_id'];
    $product_term_id = $_POST['product_term_id'];

    if ($brand_term_id == -1) {
      $this->brand_term_ids = $this->get_all_term_ids('brands');
    } else {
      $this->brand_term_ids = $brand_term_id;
    }

    if ($product_term_id == -1) {
      $this->product_term_ids = $this->get_all_term_ids('product_categories');
    } else {
      $this->product_term_ids = $product_term_id;
    }
  }

  /**
   * build_filtered_posts function
   *
   * Extracts the term IDs from the `$_POST` global for both taxonomies. If the
   * term ID is -1, then all terms are returned for that specific taxonomy.
   * The term ID (or IDs) is saved in an instance variable.
   *
   * The custom query occurs in this method as well. The query arguments are
   * returned from a private method, and then the new query is instantiated. The
   * loop requires in template files.
   */
  private function build_filtered_posts() {
    global $wp_query;

    $args = $this->build_filtered_posts_query_args();
    $wp_query = new \WP_Query($args);

    /**
     * To fix the pagination URL, the `$_SERVER['REQUEST_URI']` variable needs
     * to be set to whatever page is making this AJAX request. In this case, the
     * filter on the archive page is making this request, so we can overwrite
     * the `REQUEST_URI` value to the relative path to the archive page. Below,
     * `REQUEST_URI` is reset to its initial value.
     */
    $original_request_uri = $this->overwrite_request_uri();
    if ($wp_query->have_posts()) {
      require plugin_dir_path(dirname(__FILE__)) .
        'templates/partials/brochure_post_loop.php';
    } else {
      require plugin_dir_path(dirname(__FILE__)) .
        'templates/partials/none.php';
    }

    $this->overwrite_request_uri($original_request_uri);
  }

  /**
   * get_all_term_ids function
   *
   * Takes the name of a taxonomy as a parameter, and then returns the
   * corresponding `WP_Term` objects for each of its terms. Then, the terms are
   * looped over, and each term's ID is saved in a new array. The array of term
   * IDs is returned.
   */
  private function get_all_term_ids($taxonomy) {
    $args = array(
      'taxonomy' => $taxonomy,
      'hide_empty' => false
    );

    $all_terms = get_terms($args);
    $all_term_ids = array();

    foreach ($all_terms as $term) {
      $all_term_ids[] = $term->term_id;
    }

    return $all_term_ids;
  }

  /**
   * build_filtered_posts_query_args function
   *
   * Returns the arguments for the custom `WP_Query`.
   */
  private function build_filtered_posts_query_args() {

    /**
     * Pagination arguments here included here. When you land on the brochures
     * archive page, the pagination works as expected. As far as I know, the
     * only time this fails is when you select one of the filter options, then
     * try to reselect "All Brands" or "All Product Categories".
     *
     * I've debugged the contents of the `$loop` variable - it seems to be
     * finding the correct number of posts, but it's not able to paginate them.
     */
    $paged = (get_query_var('paged') ? get_query_var('paged') : 1);

    /**
     * TODO: more predictable filtering behavior
     *
     * This implementation assumes that any brochure will always have a
     * value for each taxonomy - or in other words, it assumes that any given
     * brochure will always have a brand and a product category assigned to it.
     * This is problematic because assigning a specific brand or product
     * category is a manual action. It's also an optional step - no warnings or
     * validations are triggered if a brochure is missing a value for a
     * taxonomy.
     *
     * This assumption that every brochure has values for all its taxonomies
     * causes an issue in the cases where a brochure is missing one or more
     * values for its taxonomies. Essentially, if a brochure is missing any
     * terms, it won't be returned, even if the user is requesting to view "All
     * Products".
     *
     * A better solution might be to have a way to tag any missing terms as
     * "Uncategorized", or better yet, find a way to enforce that all taxonomies
     * are required when the brochure is created.
     */

    return array(
      'post_type' => Constants::$POST_TYPE_NAME,
      'orderby' => 'date',
      'posts_per_archive_page' => 12,
      'paged' => $paged,
      'tax_query' => array(
        'relation' => 'AND',
        array(
          'taxonomy' => 'brands',
          'terms' => $this->brand_term_ids
        ),
        array(
          'taxonomy' => 'product_categories',
          'terms' => $this->product_term_ids
        )
      )
    );
  }

  private function overwrite_request_uri($new_uri = '') {
    $new_uri = ($new_uri != '' ? $new_uri : $this->url_base);
    $original_request_uri = $_SERVER['REQUEST_URI'];

    $_SERVER['REQUEST_URI'] = $new_uri;

    return $original_request_uri;
  }

}
