<?php require(APPROOT . '/views/inc/header.php'); ?>

<body class="receipts __receipts">
    <div class="container-scroller">
        <?php require(APPROOT . '/views/inc/navbar.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php require(APPROOT . '/views/inc/sidebar.php'); ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div id="focus" tabindex="0"></div>
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                                <i class="mdi mdi-fax"></i>
                            </span> Receipts
                        </h3>
                        <a href="<?php echo URLROOT; ?>/pages/cashouts"
                            class="btn btn-gradient-info text-right">back</a>
                    </div>
                    <?php require(APPROOT . '/views/inc/navbar.php'); ?>
                    <?php switch($data['for']): case 'cashout':?>
                    <?php include APPROOT .'/views/receipts/cashoutReceipt.php'; ?>
                    <?php break;?>
                    <?php case 2: ?>
                    <?php include APPROOT .'/views/receipts/expenseReceipt.php'; ?>
                    <?php break;?>
                    <?php case 3: ?>
                    <?php include APPROOT .'/views/receipts/soldReceipt.php'; ?>
                    <?php break;?>
                    <?php case 4: ?>
                    <?php include APPROOT .'/views/receipts/otherReceipt.php'; ?>
                    <?php break;?>
                    <?php endswitch; ?>
                </div>
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="container-fluid clearfix">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright ©
                            Holics Ent 2020</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> created by <a href="#"
                                target="_blank">the fundraiser</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</body>
<?php require(APPROOT . '/views/inc/footer.php'); ?>

</html>

<?php require(APPROOT . '/views/inc/header.php'); ?>