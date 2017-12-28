<?php

$url = get_post_meta(get_the_ID(), 'brc_brochure_url', true);

?>

<div class="col-md-4 brochure-container">
  <a class="wrapper" href="#">
    <div class="thumb_nail" style="background-image: url(<?php the_post_thumbnail_url(); ?>) !important; ">
      <div class="book_icon">
        <img src="https://cleary-millwork.s3.amazonaws.com/uploads/2018/01/r_b_icon.png" alt="book-icon">
      </div>
      <p class="text">View Catalog</p>
    </div>
  </a>
  <div class="the_title"><?php the_title(); ?></div>
  <div class="the_product_type"><?php the_title(); ?></div>
  <div class="contain-download-button">
    <a class="menu-button button-green-dark green-download-button  " target="_blank" rel="noopener noreferrer" href="<?php echo $url ?>">Download</a>
  </div>
</div>
