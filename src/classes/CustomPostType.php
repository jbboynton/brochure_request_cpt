<?php

namespace JB\BRC;

use JB\BRC\TaxonomyRegistrar;
use JB\BRC\Constants;

class CustomPostType {

  private $name = '';
  private $labels = [];
  private $taxonomy_registrar = null;
  private $taxonomies = [];
  private $supported_features = [];

  public function __construct() {
    $this->name = Constants::$POST_TYPE_NAME;
    $this->taxonomy_registrar = new TaxonomyRegistrar();
    $this->build_labels();
    $this->build_supported_features();

    $this->taxonomies = $this->taxonomy_registrar->all();

    $this->register_post_type();
  }

  private function register_post_type() {
    $name = $this->name;
    $args = $this->build_post_type_args();

    register_post_type($this->name, $args);
  }

  private function build_post_type_args() {
    return array(
      'labels' => $this->labels,
      'description' => Constants::$DESCRIPTION,
      'public' => true,
      'exclude_from_search' => false,
      'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_nav_menus' => true,
      'show_in_menu' => true,
      'show_in_menu_bar' => true,
      'menu_position' => 25,
      'menu_icon' => 'dashicons-format-aside',
      'capability_type' => 'post',
      // 'capabilities' can be set, but is generated automatically if omitted
      'map_meta_cap' => null,
      'hierarchical' => false,
      'supports' => $this->supported_features,
      'taxonomies' => $this->taxonomies,
      'has_archive' => true,
      'rewrite' => array('slug' => 'brochure'),
      'query_var' => true,
      'can_export' => true,
      'delete_with_user' => false,
      'show_in_rest' => false,
      'rest_base' => null,
      'rest_controller_class' => null
    );
  }

  private function build_labels() {
    $this->labels = array(
      'name' => 'Brochures',
      'singular_name' => 'Brochure',
      'add_new' => 'Add New',
      'add_new_item' => 'Add New Brochure',
      'edit_item' => 'Edit Brochure',
      'new_item' => 'New Brochure',
      'view_item' => 'View Brochure',
      'view_items' => 'View Brochures',
      'search_items' => 'Search Brochures',
      'not_found' => 'No brochures found.',
      'not_found_in_trash' => 'No brochures found in Trash.',
      'parent_item_colon' => null,
      'all_items' => 'All Brochures',
      'archives' => 'Brochures Archives',
      'attributes' => 'Brochure Attributes',
      'insert_into_item' => null,
      'uploaded_to_this_item' => 'Uploaded to this brochure',
      'featured_image' => 'Brochure Cover',
      'set_featured_image' => 'Choose Brochure Cover',
      'remove_featured_image' => 'Remove Brochure Cover',
      'use_featured_image' => 'Use as Brochure Cover',
      'menu_name' => 'Brochures',
      'filter_items_list' => 'Filter Brochures List',
      'items_list_navigation' => 'Brochures List Navigation',
      'items_list' => 'Filter Brochures List',
      'name_admin_bar' => 'Brochures'
    );
  }

  private function build_supported_features() {
    $this->supported_features = array(
      'title',
      'thumbnail'
    );
  }

}

