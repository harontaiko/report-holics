<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="editItem __editItem site-wrap">
    <?php require(APPROOT . '/views/inc/navbar.php'); ?>
    <main>
        <?php if(getInventoryItemById($data['id'], $data['db'])): ?>
        <?php flash('add-error'); ?>
        <div class="loader">
            <div class="loading">
            </div>
        </div>
        <div style="color:#fff !important; font-size:x-large; background-color:#4CAF50!important"
            class="alert alert_success">
            <p id="inventory-alert"></p>
        </div>
        <div class="payment-title">
            <h1>Edit <?php print_r($data['row']['0']['item_name']) ?><i class="fas fa-truck-loading fa-2x"></i></h1>
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
                <button id="add-record-invent" class="add-inventory">Save</button>
            </div>
        </form>
        <?php else: ?>
        <div class="box">
            <h1 class="title" id="h1-title">No item found in the records!</h1>
            <h1 class="title hidden" id="h1-title-cloudflare">The Internet on <span style="color:#EA4C98">1</span><span
                    style="color:#BF3188">.</span><span style="color:#304599">1</span><span
                    style="color:#05ADA5">.</span><span style="color:#05ADA5">1</span><span
                    style="color:#FCB134">.</span><span style="color:#F96337">1</span></h1>
            <div class="cloud">
                <div class="cloud-copy" id="cloud-copy"></div>
                <div class="cloud-left" id="cloud-left"></div>
                <div class="cloud-right" id="cloud-right"></div>
                <div class="cloud-bottom" id="cloud-bottom"></div>
                <div class="eye-left">
                    <div class="eyebrow-left invisible" id="eyebrow-left"></div>
                    <div class="pupil"></div>
                </div>
                <div class="eye-right">
                    <div class="eyebrow-right invisible" id="eyebrow-right"></div>
                    <div class="pupil"></div>
                </div>
                <div class="frown" id="frown"></div>
                <div class="smile invisible" id="smile"></div>
                <div class="tear-left" id="tear-left"></div>
                <div class="tear-right" id="tear-right"></div>
                <div class="bolt-left invisible" id="bolt-left"></div>
                <div class="bolt-right invisible" id="bolt-right"></div>
                <div class="bolt-bottom invisible" id="bolt-bottom"></div>
            </div>
        </div>
        <?php endif; ?>
        </ </main>

</body>

<?php require(APPROOT . '/views/inc/footer.php'); ?>

</html>