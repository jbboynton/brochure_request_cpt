<?php

namespace JB\BRC;

class FilterAjax {

  public function __construct() {
    // Filter by brand
    add_action('wp_ajax_brc_filter_by_brand',
      array($this, 'brc_filter_by_brand'));
    add_action('wp_ajax_nopriv_brc_filter_by_brand',
      array($this, 'brc_filter_by_brand'));

    // Filter by product category
    add_action('wp_ajax_brc_filter_by_product_category',
      array($this, 'brc_filter_by_product_category'));
    add_action('wp_ajax_nopriv_brc_filter_by_product_category',
      array($this, 'brc_filter_by_product_category'));
  }

  public function brc_filter_by_brand() {
    $taxonomy = 'brands';
    $this->build_filtered_posts($taxonomy);

    wp_die();
  }

  public function brc_filter_by_product_category() {
    $taxonomy = 'product_categories';
    $this->build_filtered_posts($taxonomy);

    wp_die();
  }

  private function build_filtered_posts($taxonomy) {
    $term_id = $_POST['termID'];

    if ($term_id == -1) {
      $term_id = $this->get_all_term_ids($taxonomy);
    }

    $args = $this->build_filtered_posts_query_args($taxonomy, $term_id);

		$query = new \WP_Query($args);

		if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post();

        require plugin_dir_path(dirname(__DIR__)) .
          'templates/partials/brochure.php';
      }

			wp_reset_postdata();
    } else {
      require plugin_dir_path(dirname(__DIR__)) .
        'templates/partials/none.php';
    }
  }

  private function get_all_term_ids($taxonomy) {
    $args = array(
      'taxonomy' => $taxonomy,
      'hide_empty' => false
    );

    $all_terms = get_terms($args);

    $all_term_ids = array_map(function($term) {
      return $term->term_id;
    }, $all_terms);

    return $all_term_ids;
  }

  private function build_filtered_posts_query_args($taxonomy, $term_id) {
    return array(
      'post_type' => Constants::$POST_TYPE_NAME,
      'orderby' => 'date',
      'tax_query' => array(
        array(
          'taxonomy' => $taxonomy,
          'terms' => $term_id
        )
      )
    );
  }

}

