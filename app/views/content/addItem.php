<div class="content-wrapper">
    <div id="focus" tabindex="0"></div>
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-plus-box"></i>
            </span> New Item
        </h3>
        <a href="Javascript.history.go(-1)" class="btn btn-gradient-info text-right">back</a>
    </div>
    <main>
        <?php flash('add-error'); ?>
        <?php require(APPROOT . '/views/inc/loader.php'); ?>
        <div class="alert alert_success"
            style="color:#fff !important; font-size:x-large; background-color:#4CAF50!important">
            <p id="inventory-alert"></p>
        </div>
        <form enctype="multipart/form-data" id="inventory-form">
            <div class="form-container">

                <div class="field-container">
                    <label for="name">Item Name</label>
                    <input id="item-name" name="item-name" maxlength="50" type="text" required>
                </div>
                <div class="field-container">
                    <label for="name">Quantity</label>
                    <input id="item-quantity" name="item-quantity" type="number" max="100" inputmode="numeric" required>
                </div>
                <div class="field-container">
                    <label for="expirationdate">Buying (Ksh)</label>
                    <input id="item-bp" type="number" name="item-bp" inputmode="numeric" required>
                </div>
                <div class="field-container">
                    <label for="model">Model/Manufacturer</label>
                    <input id="model" name="item-model" type="text" placeholder="write N/A if unavailable" required>
                </div>
                <div class="field-container">
                    <img src="<?php echo URLROOT; ?>/public/images/images/open-box.png" alt="product-avatar"
                        id="product-avatar">
                    <p class="product-label">Product Image</p>
                </div>
                <div class="field-container">
                    <label for="blank">leave blank if not available</label>
                    <input type="file" name="product-image" id="product-image" accept="image/*"
                        onchange="readURL(this)">
                </div>
            </div>
            <div class="fiel-container">
                <button id="add-record-invent" name="invent-button" onclick="$('#focus')[0].focus()"
                    class="btn add-inventory">Add</button>
            </div>
        </form>
    </main>
</div>