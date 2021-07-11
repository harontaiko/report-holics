<div class="content-wrapper">
    <div id="focus" tabindex="0"></div>
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-plus-box"></i>
            </span> Edit Item
        </h3>
        <a onclick="window.history.go(-1); return false;" class="btn btn-gradient-info text-right">back</a>
    </div>
    <main>
        <?php if(getInventoryItemById($data['id'], $data['db'])): ?>
        <?php flash('add-error'); ?>
        <?php require(APPROOT . '/views/inc/loader.php'); ?>
        <div style="color:#fff !important; font-size:x-large; background-color:#4CAF50!important"
            class="alert alert_success">
            <p id="inventory-alert"></p>
        </div>
        <div class="payment-title">
            <h1>Edit <?php print_r($data['row']['0']['item_name']) ?></h1>
        </div>
        <form enctype="multipart/form-data" id="inventory-form">
            <div class="form-container">
                <input type="hidden" id="item-id" value="<?php echo $data['id']; ?>">
                <div class="field-container">
                    <label for="name">Item Name</label>
                    <input id="item-name" name="item-name" value="<?php print_r($data['row']['0']['item_name']) ?>"
                        maxlength="20" type="text" required>
                </div>
                <div class="field-container">
                    <label for="name">Quantity</label>
                    <input readonly id="item-quantity" name="item-quantity"
                        value="<?php print_r($data['row']['0']['item_quantity']) ?>" type="number" max="10"
                        inputmode="numeric" required>
                    <!--input value increment-->
                </div>
                <div class="field-container">
                    <label for="expirationdate">Increase stock by</label>
                    <input id="item-increase" value="" type="number" name="item-increase" required>
                </div>
                <div class="field-container">
                    <label for="model">New quantity</label>
                    <input readonly id="item-current-qty" value="" name="item-current-qty" type="number"
                        placeholder="current qty" required>
                </div>
                <div class="field-container">
                    <label for="expirationdate">Buying (Ksh)</label>
                    <input id="item-bp" value="<?php print_r($data['row']['0']['item_buying']) ?>" type="number"
                        name="item-bp" inputmode="numeric" required>
                </div>
                <div class="field-container">
                    <label for="model">Model/Manufacturer</label>
                    <input id="model" value="<?php print_r($data['row']['0']['item_model']) ?>" name="item-model"
                        type="text" placeholder="write N/A if unavailable" required>
                </div>
                <div class="field-container">
                    <?php if(empty($data['row']['0']['image'])): ?>
                    <img src="<?php echo URLROOT; ?>/public/images/images/open-box.png" alt="product-avatar"
                        id="product-avatar">
                    <p class="product-label">Product Image</p>
                    <?php else: ?>
                    <img src="<?php echo URLROOT; ?>/public/uploads/<?php print_r($data['row']['0']['image']); ?>"
                        alt="product-avatar" id="product-avatar">
                    <p class="product-label">Product Image</p>
                    <?php endif; ?>
                </div>
                <div class="field-container">
                    <label for="blank">leave blank if not available</label>
                    <input type="file" name="product-image" id="product-image" accept="image/*"
                        onchange="readURL(this)">
                </div>
            </div>
            <div class="fiel-container">
                <button id="add-record-invent" class="add-inventory" onclick="$('#focus')[0].focus()">Save</button>
            </div>
        </form>
        <?php else: ?>
        <div class="box">
            <h1 class="title" id="h1-title">No item found in the records!</h1>
            <script src="https://cdn.lordicon.com//libs/frhvbuzj/lord-icon-2.0.2.js"></script>
            <lord-icon src="https://cdn.lordicon.com//hrqwmuhr.json" trigger="loop"
                colors="primary:#121331,secondary:#08a88a" style="width:250px;height:250px">
            </lord-icon>
        </div>
        <?php endif; ?>
    </main>
</div>