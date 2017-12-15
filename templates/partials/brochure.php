<?php

$post = get_post();

$thumbnail = the_post_thumbnail();
$title = the_title();
$url = get_post_meta($post->ID, 'brc_brochure_url', true);

?>

<div class="col-md-3">
  <?php echo $thumbnail ?>
  <?php echo $title ?>
  <a class="menu-button button-green-dark" target="_blank" rel="noopener noreferrer" href="<?php echo $url ?>">Download</a>
</div>
