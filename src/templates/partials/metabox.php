<div class="brc-post">
  <?php wp_nonce_field('save_brochure', 'brc_nonce'); ?>
  <div class="brc-example-area">
    <h3 class="brc-heading">Reference Guide</h3>
    <img src="<?php echo $reference_guide['src'] ?>" alt="<?php echo $reference_guide['alt'] ?>" />
  </div>

  <div class="brc-edit-area">
    <h3 class="brc-heading">Brochure Properties</h3>
    <div class="brc-edit-flex-container">
      <div class="brc-label-group">
        <p class="description">Brochure File (.pdf)</p>
        <div class="brc-button-group">
          <button type="button" id="<?php echo $delete_button_id; ?>" class="brc-button brc-delete-button" <?php echo $delete_button_enabled; ?>>
            <i class="fa fa-times"></i>
          </button>
          <button type="button" id="<?php echo $launch_button_id; ?>" class="brc-button">
            <span class="brc-button-text">Choose</span>
          </button>
        </div>
      </div>
      <div class="brc-field-group">
        <a class="brc-current-file" id="<?php echo $current_file_id; ?>" target="_blank" href="<?php echo $meta_data ?>"><?php echo $meta_data ?></a>
      </div>
    </div>
  </div>

</div>
