<div class="content-wrapper">
    <div id="focus" tabindex="0"></div>
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="fas fa-trash fa-2x"></i>
            </span> Delete Item
        </h3>
        <a href="Javascript.history.go(-1)" class="btn btn-gradient-info text-right">back</a>
    </div>
    <div class="alert alert_success" id="alert_add">
        <p id="add-alert"></p>
    </div>
    <div class="confirm">
        <h1><strong>Confirm your action</strong></h1>
        <p>Are you <strong>really</strong> sure that you want to delete this item?
        </p>
        <input type="hidden" id="item-id" value="<?php echo isset($data['id']) ? $data['id']: ''; ?>">
        <button id="cancel-remove">Cancel</button>
        <button autofocus id="accept-remove">Confirm</button>
    </div>
</div>