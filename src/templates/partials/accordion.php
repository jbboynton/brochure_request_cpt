<?php

$user = wp_get_current_user();

?>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a class="brc-panel-title-button" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Requested Catalogs
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <ul id="brc-requested-catalogs" class="list-group brc-requested-catalogs"></ul>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a id="brc-shipping-info-link" class="brc-panel-title-button collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Shipping Information
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        <form class="brc-shipping-info">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="brc-ship-first-name">First Name</label>
                <input name="brc-ship-first-name" type="text" class="form-control brc-ship-field" id="brc-ship-first-name" placeholder="First Name">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="brc-ship-last-name">Last Name</label>
                <input name="brc-ship-last-name" type="text" class="form-control brc-ship-field" id="brc-ship-last-name" placeholder="Last Name">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="brc-ship-company">Company</label>
                <input name="brc-ship-company" type="text" class="form-control brc-ship-field" id="brc-ship-company" placeholder="Company">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="brc-ship-address-line-1">Address Line 1</label>
                <input name="brc-ship-address-line-1" type="text" class="form-control brc-ship-field" id="brc-ship-address-line-1" placeholder="Address Line 1">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="brc-ship-address-line-2">Address Line 2</label>
                <input name="brc-ship-address-line-2" type="text" class="form-control brc-ship-field" id="brc-ship-address-line-2" placeholder="Address Line 2">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-5">
              <div class="form-group">
                <label for="brc-ship-city">City</label>
                <input name="brc-ship-city" type="text" class="form-control brc-ship-field" id="brc-ship-city" placeholder="City">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="brc-ship-zip">State</label>
                <input name="brc-ship-state" type="text" class="form-control brc-ship-field" id="brc-ship-state" placeholder="State">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="brc-ship-zip">Zip Code</label>
                <input name="brc-ship-zip-code" type="text" class="form-control brc-ship-field" id="brc-ship-zip-code" placeholder="Zip Code">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
