<div class="brc-post">
  <div class="brc-example-area">
    <h3 class="brc-heading">Reference Guide</h3>
    <img src="<?php echo $reference_guide['src'] ?>" alt="<?php echo $reference_guide['alt'] ?>" />
  </div>

  <div class="brc-edit-area">
    <div class="brc-header-group">
      <h3 class="brc-heading">Brochure Properties</h3>
      <span class="alignright" id="brc-spinner-container"></span>
    </div>

    <div class="brc-edit-flex-container">
      <div class="brc-label-group">
        <p class="description">Brochure File</p>
      </div>
      <div class="brc-field-group brc-current-file">
        <a id="<?php echo $current_file_id; ?>" target="_blank" href="<?php echo $meta_data['url'] ?>"><?php echo basename($meta_data['url']) ?></a>
        <div class="brc-button-group">
          <button type="button" id="<?php echo $launch_button_id; ?>" class="brc-button">
            <span class="brc-button-text">Choose</span>
          </button>
          <button type="button" id="<?php echo $delete_button_id; ?>" class="brc-button brc-delete-button" <?php echo $delete_button_enabled; ?>>
            ×
          </button>
        </div>
      </div>
    </div>

    <div class="brc-edit-flex-container">
      <div class="brc-label-group">
        <p class="description">Issuu URL</p>
      </div>
      <div class="brc-field-group">
        <input type="text" class="brc-text-input" id="<?php echo $current_issuu_id; ?>" placeholder="Enter a URL..." value="<?php echo $meta_data['issuu'] ?>" />
      </div>
    </div>

    <div class="brc-edit-flex-container">
      <div class="brc-label-group">
        <p class="description">Brochure Title</p>
      </div>
      <div class="brc-field-group">
        <input type="text" class="brc-text-input" id="<?php echo $current_title_id; ?>" placeholder="Enter a title..." value="<?php echo $meta_data['title'] ?>" />
      </div>
    </div>

    <div class="brc-edit-flex-container">
      <div class="brc-label-group">
        <p class="description">Brochure Subtitle</p>
      </div>
      <div class="brc-field-group">
        <input type="text" class="brc-text-input" id="<?php echo $current_subtitle_id; ?>" placeholder="Enter a subtitle..." value="<?php echo $meta_data['subtitle'] ?>" />
      </div>
    </div>

  </div>

</div>
