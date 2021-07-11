<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="addItem __addItem site-wrap">
    <?php require(APPROOT . '/views/inc/navbar.php'); ?>
    <main>
        <a id="add-record" title="inventory" href="<?php echo URLROOT; ?>/pages/list"><i
                class="fas fa-dolly fa-2x"></i></a>
        <?php flash('add-error'); ?>
        <?php require(APPROOT . '/views/inc/loader.php'); ?>
        <div class="alert alert_success"
            style="color:#fff !important; font-size:x-large; background-color:#4CAF50!important">
            <p id="inventory-alert"></p>
        </div>
        <div class="payment-title">
            <h1>Add to inventory <i class="fas fa-truck-loading fa-2x"></i></h1>
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
                <button id="add-record-invent" name="invent-button" class="add-inventory">Save</button>
            </div>
        </form>
        </ </main>

</body>

<?php require(APPROOT . '/views/inc/footer.php'); ?>

</html>