<?php

namespace JB\BRC;

use JB\BRC\Constants;

class Filter extends \WP_Widget {

  public function __construct() {
    $args = array(
      Constants::$FILTER_ID,
      Constants::$FILTER_UI_NAME,
      array('description' => Constants::$FILTER_DESCRIPTION)
    );

    parent::__construct(...$args);

    add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
  }

  public function enqueue_assets() {
    global $post_type;
    global $post;

    if ($post_type == Constants::$POST_TYPE_NAME ||
        $this->public_assets_are_required($post, $post_type)) {
      $this->enqueue_filter_ajax();
      $this->enqueue_public_css();
    }
  }

  private function public_assets_are_required($post, $post_type) {
    $is_brochure_post = false;
    $has_brochure_shortcode = false;

    if ($post_type == Constants::$POST_TYPE_NAME) {
      $is_brochure_post = true;
    }

    if (has_shortcode($post->post_content, Constants::$SHORTCODE_POST_LOOP)) {
      $has_brochure_shortcode = true;
    }

    return ($is_brochure_post || $has_brochure_shortcode);
  }

  public function widget($args, $instance) {
    $brands = $this->get_terms('brands');
    $product_categories = $this->get_terms('product_categories');

    echo $args['before_widget'];

    ob_start();
    include plugin_dir_path(dirname(__FILE__)) .
      'templates/partials/filter.php';
    $output = ob_get_contents();
    ob_end_clean();

    echo $args['after_widget'];
    echo $output;
  }

  public function form($instance) {
    $title = $this->maybe($instance, 'title');
    $title_id = esc_attr($this->get_field_id('title'));
    $title_name = esc_attr($this->get_field_name('title'));

    ob_start();
    include plugin_dir_path(dirname(__FILE__)) .
      'templates/partials/filter_options.php';
    $output = ob_get_contents();
    ob_end_clean();

    echo $output;
  }

  public function update($new_instance, $old_instance) {
    $instance = $old_instance;

    $instance['title'] = $this->maybe($new_instance, 'title');

    return $instance;
  }

  /**
   * Returns the value if the key is set, or the empty string if not.
   */
  private function maybe($instance, $key) {
    $value = "";

    if (!empty($instance[$key])) {
      $value = strip_tags($instance[$key]);
    }

    return $value;
  }

  private function get_terms($taxonomy_name) {
    $args = array(
      'taxonomy' => $taxonomy_name,
      'orderby' => 'name',
      'hide_empty' => false
    );

    return get_terms($args);
  }

  private function enqueue_filter_ajax() {
    $filter_ajax_js_args = $this->filter_ajax_js_args();
    $filter_ajax_js_id = $filter_ajax_js_args[0];
    $filter_ajax_js_localization_args =
      $this->filter_ajax_js_localization($filter_ajax_js_id);

    wp_register_script(...$filter_ajax_js_args);
    wp_localize_script(...$filter_ajax_js_localization_args);
    wp_enqueue_script($filter_ajax_js_id);
  }

  private function filter_ajax_js_args() {
    return array(
      Constants::$FILTER_AJAX_JS_ID,                 // Unique string identifier
      plugins_url(Constants::$FILTER_AJAX_JS_PATH),  // Source URL
      array('jquery'),                              // Dependencies
      null,                                   // Version (null = not versioned)
      false                                   // Load script in footer
    );
  }

  private function filter_ajax_js_localization($script_id) {
    return array(
      $script_id,
      'ajaxLocalData',
      array(
        'ajaxURL' => admin_url('admin-ajax.php'),
        'brandsForm' => Constants::$FILTER_UI_BRANDS_ID,
        'productCategoriesForm' => Constants::$FILTER_UI_PRODUCT_CATEGORIES_ID
      )
    );
  }

  /**
   * Enqueues stylesheets. To add more stylesheets, go the the
   * `find_stylesheets()` method definition, and read the comment above the
   * method.
   */
  private function enqueue_public_css() {
    $styles = $this->find_stylesheets();

    foreach ($styles as $stylesheet) {
      $id = $stylesheet[0];  // Unique identifier for the stylesheet

      wp_register_style(...$stylesheet);
      wp_enqueue_style($id);
    }
  }

  /**
   * Prepares stylesheets to be loaded by WordPress. Add new stylesheets by
   * creating constants for the stylesheet ID and path (see the `Constants`
   * file), and then add them below.
   */
  private function find_stylesheets() {
    return array(
      array(
        Constants::$PUBLIC_CSS_ID,
        plugins_url(Constants::$PUBLIC_CSS_PATH)
      )
    );
  }

}

