<?php

namespace JB\BRC;

use JB\BRC\Constants;

class Widget {

  public function __construct() {
    register_widget(Constants::$FILTER_PHP_CLASS);
  }

}

