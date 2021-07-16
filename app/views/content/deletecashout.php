<div class="content-wrapper">
    <div id="focus" tabindex="0"></div>
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="fas fa-trash fa-2x"></i>
            </span> Delete Cashout
        </h3>
        <a href="<?php echo URLROOT; ?>/pages/cashouts" class="btn btn-gradient-info text-right">back</a>
    </div>
    <div class="alert alert_success" id="alert_add">
        <p id="add-alert"></p>
    </div>
    <div class="confirm">
        <h1><strong>Confirm your action</strong></h1>
        <p>Are you <strong>really</strong> sure that you want to permanently delete this record?
        </p>
        <input type="hidden" id="item-id" value="<?php echo isset($data['id']) ? $data['id']: ''; ?>">
        <button type="button" id="cancel-remove">Cancel</button>
        <button autofocus><a href="#open-modal">Confirm</a></button>
    </div>

    <!-- Modal -->
    <div id="open-modal" class="modal-window">
        <div class="card bg-warning m-4">
            <a href="#" title="Close" class="modal-close" style="font-size: 1.5rem;">&#120;</a>
            <div class="text- lead text-center"></div>
            <h2 class="text-left lead">Enter Password To confirm</h2>
            <label class="sr-only" for="inlineFormInputName2">Confirm password</label>
            <input required type="password" id="password" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2"
                placeholder="password">
            <label class="sr-only" for="inlineFormInputGroupUsername2">Username</label>
            <button type="button" class="btn btn-outline-dark mb-2" id="accept-remove">Confirm</button>
            <?php include APPROOT .'/views/inc/deleterecordLoader.php'; ?>
        </div>
    </div>
    <!-- /Modal -->
</div>