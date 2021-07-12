<?php require(APPROOT . '/views/inc/header.php'); ?>

<body class="date __date ">
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
                                <i class="mdi mdi-chart-areaspline"></i>
                            </span> Report
                        </h3>
                        <a href="<?php echo URLROOT; ?>/pages/<?php if (strpos($_SERVER['REQUEST_URI'], "pages/date/sales") !== false) : ?>sales<?php elseif (strpos($_SERVER['REQUEST_URI'], "pages/date/ps") !== false) :  ?>playstation<?php elseif (strpos($_SERVER['REQUEST_URI'], "pages/date/movie") !== false) :  ?>movieShop
                            <?php elseif (strpos($_SERVER['REQUEST_URI'], "pages/date/cyber") !== false) :  ?>cyber<?php elseif (strpos($_SERVER['REQUEST_URI'], "pages/date/total") !== false) :  ?>total<?php elseif (strpos($_SERVER['REQUEST_URI'], "pages/date/expense") !== false) :  ?>expenses<?php endif ?>"
                            class="btn btn-gradient-info text-right">back</a>
                    </div>
                    <?php switch($data['shopname']): case 'movie':?>
                    <?php include APPROOT .'/views/datesfilter/MovieShopReport.php'; ?>
                    <?php break;?>
                    <?php case "cyber": ?>
                    <?php include APPROOT .'/views/datesfilter/CyberReport.php'; ?>
                    <?php break;?>
                    <?php case "ps": ?>
                    <?php include APPROOT .'/views/datesfilter/PsReport.php'; ?>
                    <?php break;?>
                    <?php case "total": ?>
                    <?php include APPROOT .'/views/datesfilter/NetReport.php'; ?>
                    <?php break;?>
                    <?php case "expense": ?>
                    <?php include APPROOT .'/views/datesfilter/ExpenseReport.php'; ?>
                    <?php break;?>
                    <?php case "sales": ?>
                    <?php include APPROOT .'/views/datesfilter/SalesReport.php'; ?>
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