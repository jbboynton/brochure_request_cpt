<?php
/**
 * Plugin Name: Brochure Request CPT
 * Description: Manage brochures and publication requests with WordPress.
 * Version: 1.6.1
 * Author: James Boynton
 */

require_once plugin_dir_path(__FILE__) . 'src/classes/Activation.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/AdminUI.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/AdminAjax.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Brochure.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Constants.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/CustomPostType.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Filter.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/FilterAjax.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Helpers.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Metabox.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/RequestAjax.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Shortcode.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Sidebar.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/TaxonomyRegistrar.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Widget.php';

use JB\BRC;
use JB\BRC\Activation;
use JB\BRC\AdminUI;
use JB\BRC\AdminAjax;
use JB\BRC\Brochure;
use JB\BRC\Constants;
use JB\BRC\CustomPostType;
use JB\BRC\Filter;
use JB\BRC\FilterAjax;
use JB\BRC\Helpers;
use JB\BRC\Metabox;
use JB\BRC\RequestAjax;
use JB\BRC\Shortcode;
use JB\BRC\Sidebar;
use JB\BRC\TaxonomyRegistrar;
use JB\BRC\Widget;

add_action('init', function() {
  new AdminUI();
  new AdminAjax();
  new CustomPostType();
  new Filter();
  new FilterAjax();
  new RequestAjax();
  new Shortcode();
  new Sidebar();
});

add_action('widgets_init', function() {
  new Widget();
});

register_activation_hook(__FILE__, function() {
  Activation::activate();
  flush_rewrite_rules();
});

register_deactivation_hook(__FILE__, function() {
  Activation::deactivate();
  flush_rewrite_rules();
});

