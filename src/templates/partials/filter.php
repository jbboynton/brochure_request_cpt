<?php

use JB\BRC\Constants;
use JB\BRC\Helpers;

?>

<div class="panel panel-default brc-panel">
  <div class="panel-heading brc-panel-heading">
    <h3 class="panel-title">Filters</h3>
    <span id="brc-spinner-container-filter" class="pull-right"></span>
  </div>
  <div class="panel-body brc-panel-body">
    <form action="<?php echo Constants::$FILTER_UI_ACTION ?>" class="<?php echo Constants::$FILTER_UI_FORM_CLASS ?>" id="<?php echo Constants::$FILTER_UI_PRODUCT_CATEGORIES_ID ?>" method="POST">
      <?php if ($product_categories): ?>
        <div class="form-group">
          <label for="brc-product-select" class="brc-filter-label">Product Categories</label>
          <select id="brc-product-select" class="form-control brc-filter-select" name="<?php echo Constants::$FILTER_UI_PRODUCT_CATEGORIES_NAME ?>">
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
          <label for="brc-brand-select" class="brc-filter-label">Brands</label>
          <select id="brc-brand-select" class="form-control brc-filter-select" name="<?php echo Constants::$FILTER_UI_BRANDS_NAME ?>">
            <option selected value="-1">All Brands</option>
            <?php foreach ($brands as $brand): ?>
              <?php echo Helpers::build_dropdown_option($brand) ?>
            <?php endforeach; ?>
          </select>
        </div>
      <?php endif; ?>
    </form>
  </div>
</div>

