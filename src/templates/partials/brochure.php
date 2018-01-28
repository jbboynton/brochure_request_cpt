<?php

use JB\BRC\Helpers;

$url = get_post_meta(get_the_ID(), 'brc_brochure_url', true);

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
  <div class="brc-title"><?php the_title(); ?></div>
  <div class="brc-product-type"><?php the_title(); ?></div>
  <div class="brc-contain-download-button">
    <a class="menu-button button-green-dark brc-download-button" target="_blank" rel="noopener noreferrer" href="<?php echo $url ?>">Download</a>
  </div>
</div>
