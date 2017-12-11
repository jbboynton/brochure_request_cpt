<form action="upload_brochure" method="POST" class="brc_upload_form" enctype="multipart/form-data">
  <div class="brc-message"></div>
  <p class="description">Upload a brochure here.</p>
  <div id="brochure-file-upload" class="file-upload">
    <input type="file" id="brc_brochure_uploader" name="brc_brochure_uploader" size="25" value="" />
    <?php wp_nonce_field('save_brochure', 'brc_nonce'); ?>
  </div>
</form>
