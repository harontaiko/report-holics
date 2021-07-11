<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="addItem __cashOut site-wrap">
    <?php require(APPROOT . '/views/inc/navbar.php'); ?>
    <main>
        <?php flash('add-error'); ?>
        <div class="loader">
            <div class="loading">
            </div>
        </div>
        <div class="alert alert_success"
            style="color:#fff !important; font-size:x-large; background-color:#4CAF50!important">
            <p id="inventory-alert"></p>
        </div>

        <div class="payment-title">
            <h1>Cash Out <i class="fas fa-cash-register fa-2x"></i></h1>
        </div>
        <form enctype="multipart/form-data" id="inventory-form">
            <div class="form-container">

                <div class="field-container">
                    <label for="name">Amount(ksh)</label>
                    <input id="amount" name="amount" maxlength="50" type="text" required
                        value="<?php if(isset($_SESSION['cash']['0'])){print_r($_SESSION['cash']['0']);}else{echo '';} ?>">
                </div>
                <div class="field-container">
                    <label for="name">Usage</label>
                    <input id="usage" name="usage" maxlength="50" type="text" placeholder="e.g. token" required
                        value="<?php if(isset($_SESSION['cash']['1'])){print_r($_SESSION['cash']['1']);}else{echo '';} ?>">
                </div>
                <div class="field-container">
                    <label for="name">Cash From</label>
                    <select
                        style="margin-top: 3px;padding: 15px;font-size: 16px;width: auto;border-radius: 3px;border: 1px solid #dcdcdc;"
                        name="cash-from" id="cash-from">
                        <option value="movie">Movie Shop</option>
                        <option value="ps">Playstation</option>
                        <option value="cyber">Cyber</option>
                        <option value="sales">Sales</option>
                        <option value="total">net total</option>
                    </select>
                </div>
                <div class="field-container">
                    <label for="name">Date</label>
                    <input id="date-" name="date" type="date" required
                        value="<?php if(isset($_SESSION['cash']['3'])){print_r($_SESSION['cash']['3']);}else{echo '';} ?>">
                </div>
                <div class="field-container">
                    <label for="handler">Handler Name</label>
                    <input id="handler" name="handler" type="text" placeholder="Handler" required
                        value="<?php if(isset($_SESSION['cash']['4'])){print_r($_SESSION['cash']['4']);}else{echo '';} ?>">
                </div>
                <div class="field-container">
                    <label for="receipt-num">Receipt Num *<i>changes on refresh</i></label>
                    <input id="receipt-num" name="receipt-num" type="text"
                        value="<?php if(isset($_SESSION['cash']['5'])){print_r($_SESSION['cash']['5']);}else{echo '';} ?>"
                        readonly required>
                </div>
            </div>
            <div class="field-container">
                <button id="add-record-invent" name="invent-button" class="add-inventory">Cash Out</button>
            </div>
        </form>
    </main>

</body>

<?php require(APPROOT . '/views/inc/footer.php'); ?>

</html>