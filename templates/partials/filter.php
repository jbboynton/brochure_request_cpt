<?php

use JB\BRC\Constants;
use JB\BRC\Helpers;

?>

<div id="spinner-container" class="spinner-container"></div>
<div class="well">
  <form action="<?php echo Constants::$FILTER_UI_ACTION ?>" class="<?php echo Constants::$FILTER_UI_FORM_CLASS ?>" id="<?php echo Constants::$FILTER_UI_PRODUCT_CATEGORIES_ID ?>" method="POST">
    <?php if ($product_categories): ?>
      <div class="form-group">
        <select class="form-control" name="<?php echo Constants::$FILTER_UI_PRODUCT_CATEGORIES_NAME ?>">
          <option selected value="-1">All Products</option>
          <?php foreach ($product_categories as $product_category): ?>
            <?php echo Helpers::build_dropdown_option($product_category) ?>
          <?php endforeach; ?>
        </select>
      </div>
    <?php endif; ?>
  </form>
  <form action="<?php echo Constants::$FILTER_UI_ACTION ?>" class="<?php echo Constants::$FILTER_UI_FORM_CLASS ?>" id="<?php echo Constants::$FILTER_UI_BRANDS_ID ?>" method="POST">
    <?php if ($brands): ?>
      <div class="form-group">
        <select class="form-control" name="<?php echo Constants::$FILTER_UI_BRANDS_NAME ?>">
          <option selected value="-1">All Brands</option>
          <?php foreach ($brands as $brand): ?>
            <?php echo Helpers::build_dropdown_option($brand) ?>
          <?php endforeach; ?>
        </select>
      </div>
    <?php endif; ?>
  </form>
</div>
