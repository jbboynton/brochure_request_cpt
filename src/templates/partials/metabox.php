<form action="upload_brochure" method="POST">
  <p class="description">Click <span class="monospace-styled">Choose Brochure</span> to select a brochure. Then, click <span class="monospace-styled">Save Changes</span>.</p>
  <input type="button" id="<?php echo $launch_button_id; ?>" class="button" value="Choose Brochure" />
  <input type="text" id="<?php echo $input_id; ?>" name="<?php echo $input_id; ?>" hidden />
  <?php wp_nonce_field('save_brochure', 'brc_nonce'); ?>
</form>

<span class="current-brochure-area">
  <div class="brochure-link-group">
    <strong>Selected file:</strong>
    <br>
    <a id="<?php echo $preview_link_id; ?>" target="_blank"></a>
  </div>

  <div class="brochure-link-group">
    <strong>Current file:</strong>
    <br>
    <a id="<?php echo $current_file_id; ?>" target="_blank" href="<?php echo $meta_data ?>"><?php echo $meta_data ?></a>
  </div>

  <?php submit_button(); ?>
  <input type="button" id="<?php echo $clear_button_id; ?>" class="button" value="Clear" disabled />
  <form class="unset-brochure-form" action="unset_brochure" method="POST">
    <input type="button" id="<?php echo $delete_button_id; ?>" class="button" value="Remove Brochure" <?php echo $delete_button_enabled; ?>/>
  </form>
</span>

