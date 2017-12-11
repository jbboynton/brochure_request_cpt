<?php
/**
 * Plugin Name: Brochure Request CPT
 * Description: Manage brochures and publication requests with WordPress.
 * Version: 0.1.0
 * Author: James Boynton
 */

include 'vendor/autoload.php';

require_once plugin_dir_path(__FILE__) . 'src/classes/Activation.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Constants.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/CustomPostType.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/TaxonomyRegistrar.php';

use JB\BRC;
use JB\BRC\Activation;
use JB\BRC\Constants;
use JB\BRC\CustomPostType;
use JB\BRC\TaxonomyRegistrar;

add_action('init', function() {
  new CustomPostType();
});

register_activation_hook(__FILE__, function() {
	Activation::activate();
  flush_rewrite_rules();
});

register_deactivation_hook(__FILE__, function() {
	Activation::deactivate();
  flush_rewrite_rules();
});
