<?php

namespace JB\BRC;

class Sidebar {

  public function __construct() {
    $sidebar_with_filter_args = $this->sidebar_with_filter_args();

    register_sidebar($sidebar_with_filter_args);
  }

  private function sidebar_with_filter_args() {
    return array(
      'name' => 'Sidebar with Filter',
      'id' => 'sidebar-with-filter',
      'description' => 'Add widgets here to appear on the Brochure Request page.',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget' => '</section>',
      'before_title' => '<h3 class="widget-title">',
      'after_title' => '</h2>',
    );
  }

}

