<?php

namespace JB\BRC;

use JB\BRC\Constants;

class TaxonomyRegistrar {

  private $registered_taxonomies = [];

  public function __construct() {
    $this->register_all();
  }

  public function get_registered_taxonomies() {
    return $this->registered_taxonomies;
  }

  /**
   * Alias of get_registered_taxonomies().
   */
  public function all() {
    return $this->get_registered_taxonomies();
  }

  private function register_all() {
    $taxonomy_data = $this->taxonomy_data();

    foreach ($taxonomy_data as $data) {
      $registered_taxonomy = $this->register($data);
      $this->registered_taxonomies[] = $registered_taxonomy;
    }
  }

  /**
   * Registers a single taxonomy if it doesn't already exist. Returns the name
   * of the taxonomy on success, or an error message on failure.
   */
  private function register($taxonomy_args) {
    $name = $taxonomy_args['name'];
    $args = $taxonomy_args['args'];
    $object = Constants::$POST_TYPE_NAME;

    if ($this->is_new_taxonomy($name)) {
      register_taxonomy($name, $object, $args);
    } else {
      $code = 'taxonomy_already_exists';
      $message = 'This taxonomy already exists.';

      // TODO: raise WP Error or implement smarter error handling
      die($this->registration_error($code, $name, $message));
    }

    return $name;
  }

  private function registration_error($error_code, $taxonomy_name, $message) {
    $error = "Could not register taxonomy ${taxonomy_name}: ${message}";

    return new WP_Error($error_code, $error);
  }

  private function is_new_taxonomy($taxonomy_name) {
    return (!taxonomy_exists($taxonomy_name) ? true : false);
  }

  /**
   * Add new taxonomies to this post type here. All array items are created and
   * associated to the Brochure custom post type during the `init` action.
   */
  private function taxonomy_data() {
    return array(

      // Brands
      array(
        'name' => 'brands',
        'args' => array(
          'labels' => array(
            'name' => 'Brands',
            'singular_name' => 'Brand',
            'menu_name' => 'Brands',
            'all_items' => 'All Brands',
            'edit_item' => 'Edit Brand',
            'view_item' => 'View Brand',
            'update_item' => 'Update Brand',
            'add_new_item' => 'Add New Brand',
            'new_item_name' => 'New Brand Name',
            'parent_item' => null,
            'parent_item_colon' => null,
            'search_items' => 'Search Brands',
            'popular_items' => 'Popular Brands',
            'separate_items_with_commas' => 'Separate brands with commas',
            'add_or_remove_items' => 'Add or remove brands',
            'choose_from_most_used' => false,
            'not_found' => 'No brands found.'
          ),
          'public' => true,
          'publicly_queryable' => true,
          'show_ui' => true,
          'show_in_menu' => true,
          'show_in_nav_menus' => true,
          'show_in_rest' => false,
          'rest_base' => null,
          'rest_controller_class' => null,
          'show_tagcloud' => true,
          'show_in_quick_edit' => true,
          'meta_box_cb' => null,
          'show_admin_column' => true,
          'description' => '',
          'hierarchical' => false,
          'update_count_callback' => null,
          'query_var' => true,
          'rewrite' => array('slug' => 'brand'),
          'capabilities' => array(),
          'sort' => false
        )
      ),

      // Product Categories
      array(
        'name' => 'product_categories',
        'args' => array(
          'labels' => array(
            'name' => 'Product Categories',
            'singular_name' => 'Product Category',
            'menu_name' => 'Product Categories',
            'all_items' => 'All Product Categories',
            'edit_item' => 'Edit Product Category',
            'view_item' => 'View Product Category',
            'update_item' => 'Update Product Category',
            'add_new_item' => 'Add New Product Category',
            'new_item_name' => 'New Product Category',
            'parent_item' => null,
            'parent_item_colon' => null,
            'search_items' => 'Search Product Categories',
            'popular_items' => 'Popular Product Categories',
            'separate_items_with_commas' =>
              'Separate product categories with commas',
            'add_or_remove_items' => 'Add or remove product categories',
            'choose_from_most_used' => false,
            'not_found' => 'No product categories found.'
          ),
          'public' => true,
          'publicly_queryable' => true,
          'show_ui' => true,
          'show_in_menu' => true,
          'show_in_nav_menus' => true,
          'show_in_rest' => false,
          'rest_base' => null,
          'rest_controller_class' => null,
          'show_tagcloud' => true,
          'show_in_quick_edit' => true,
          'meta_box_cb' => null,
          'show_admin_column' => true,
          'description' => '',
          'hierarchical' => false,
          'update_count_callback' => null,
          'query_var' => 'product_categories',
          'rewrite' => true,
          'capabilities' => array(),
          'sort' => false
        )
      )

    );
  }

}

