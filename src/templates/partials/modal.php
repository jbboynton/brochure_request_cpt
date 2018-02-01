<div id="brc-checkout-modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header brc-modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title brc-modal-title">Request Print Catalog</h4>
      </div>
      <div id="brc-confirmation" class="modal-body brc-modal-body">
        <p class="brc-ready-to-order">Ready to place your order? First, review your selected catalogs and verify each quantity below. Then, please tell us where you would like them mailed.</p>
        <?php require plugin_dir_path(__FILE__) . 'accordion.php'; ?>
     </div>
      <div class="modal-footer brc-modal-footer">
        <span id="brc-spinner-submit"></span>
        <button type="button" class="menu-button brc-request-button brc-cancel" data-dismiss="modal">Cancel</button>
        <button type="button" id="brc-request-submit" class="menu-button brc-request-button brc-request-submit">Submit Request</button>
      </div>
    </div>
  </div>
</div>
