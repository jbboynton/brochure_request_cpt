<?php

use JB\BRC\Helpers;

$meta = get_post_meta(get_the_ID());
$url = $meta['brc_brochure_url'][0] ?? '#';
$title = $meta['brc_brochure_title'][0] ?? get_the_title();
$subtitle = $meta['brc_brochure_subtitle'][0] ?? false;
$issuu = $meta['brc_issuu_url'][0] ?? false;


$current_post = get_post();
$thumbnail_url = Helpers::build_brochure_thumbnail_url($current_post);

$book_icon_url = Helpers::build_book_icon_url();

?>

<div class="col-sm-3 brc-brochure-container">
  <a class="brc-thumbnail-wrapper" href="<?php echo $url ?>" rel="noopener noreferrer" target="_blank">
    <div class="brc-thumbnail" style="background-image: url('<?php echo $thumbnail_url ?>')">
      <div class="book_icon">
        <img src="<?php echo $book_icon_url ?>" alt="book-icon">
      </div>
      <p class="brc-view-text">View Catalog</p>
    </div>
  </a>
  <div class="brc-title"><?php echo $title ?></div>
  <?php if ($issuu): ?>
    <div class="brc-product-type"><?php echo $subtitle ?></div>
  <?php endif; ?>
  <div class="brc-links-wrapper">
    <?php if ($issuu): ?>
      <a class="brc-pagination-link" href="<?php echo $issuu ?>" target="_blank" rel="noreferrer noopener">VIEW</a>
      |
    <?php endif; ?>
      <a class="brc-pagination-link" href="<?php echo $url ?>" target="_blank" rel="noreferrer noopener">DOWNLOAD</a>
  </div>
</div>
