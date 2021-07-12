<!--Daily, Monthly And Annual reports-->
<?php require(APPROOT . '/views/inc/header.php'); ?>

<body class="invoice __invoice">
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
                                <i class="mdi mdi-receipt"></i>
                            </span> Invoice
                        </h3>
                    </div>
                    <?php if($data['invoiceItem'] =="sale"): ?>
                    <?php include APPROOT .'/views/invoice/saleInvoice.php'; ?>
                    <?php elseif($data['invoiceItem'] == "movie"): ?>
                    <?php include APPROOT .'/views/datesfilter/CyberReport.php'; ?>
                    <?php elseif($data['invoiceItem'] == "ps"): ?>
                    <?php include APPROOT .'/views/datesfilter/PsReport.php'; ?>
                    <?php elseif($data['invoiceItem'] == "cyber"): ?>
                    <?php include APPROOT .'/views/datesfilter/PsReport.php'; ?>
                    <?php endif ?>
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