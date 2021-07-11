<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="receipts __receipts site-wrap">
    <?php require(APPROOT . '/views/inc/navbar.php'); ?>
    <div class="container-tabs">
        <!-- Tab 1 -->
        <input type="radio" id="tab-link-1" name="tabset" checked>
        <label for="tab-link-1">Cash Outs</label>
        <input type="radio" id="tab-link-2" name="tabset">
        <label for="tab-link-2">Expenses</label>
        <input type="radio" id="tab-link-3" name="tabset">
        <label for="tab-link-3">Other</label>
        <!-- Tab content -->
        <div class="tab-content">
            <section class="tab-panel" id="tab-1">
                <h2>Cash Outs</h2>
                <div class="container-cashouts">

                    <h2>Cash Out Receipts</h2>

                    <ul>
                        <?php while($cash = $data['out']->fetch_assoc()): ?>
                        <li>
                            <!--push to array for get vars-->
                            <?php $arr = implode(',', $cash); ?>
                            <input type="radio" id="f-option" name="selector">
                            <label
                                for="f-option"><?php echo isset($cash['date_created']) ? $cash['date_created']: 'N/A' ?>,
                                <?php echo isset($cash['cash_usage']) ? $cash['cash_usage']: 'N/A' ?>
                                @<?php echo isset($cash['cash_amount']) ? $cash['cash_amount']: 'N/A' ?></label> <i
                                class="fas link"></i>
                            <a class="link-cashouts"
                                href="<?php echo URLROOT; ?>/pages/receipts/cashout/<?php echo $arr; ?>"><i
                                    class="fas fa-link"></i></a>
                            <div class="check"></div>
                        </li>
                        <?php endwhile ?>
                    </ul>
                </div>

                <div class="signature">
                    <p>Made with <i class="fas fa-heart"></i> by <a href="#!">The Fundraiser</a></p>
                </div>
            </section>
            <section class="tab-panel" id="tab-2">
                <h2>Expense Receipts</h2>
                <p>Coming soon</p>
            </section>
            <section class="tab-panel" id="tab-3">
                <h2>Other Receipts</h2>
                <p>Coming soon</p>

            </section>
        </div>
    </div>
</body>

<?php require(APPROOT . '/views/inc/footer.php'); ?>

</html>