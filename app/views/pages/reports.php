<!--Daily, Monthly And Annual reports-->
<?php require(APPROOT . '/views/inc/header.php'); ?>

<body class="reports __reports ">
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
                        <a href="<?php echo URLROOT; ?>/pages/<?php if (strpos($_SERVER['REQUEST_URI'], "pages/reports/sales") !== false) : ?>sales<?php elseif (strpos($_SERVER['REQUEST_URI'], "pages/reports/ps") !== false) :  ?>playstation<?php elseif (strpos($_SERVER['REQUEST_URI'], "pages/reports/movie") !== false) :  ?>movieShop
                            <?php elseif (strpos($_SERVER['REQUEST_URI'], "pages/reports/cyber") !== false) :  ?>cyber<?php elseif (strpos($_SERVER['REQUEST_URI'], "pages/reports/total") !== false) :  ?>total<?php elseif (strpos($_SERVER['REQUEST_URI'], "pages/reports/expense") !== false) :  ?>expenses<?php endif ?>"
                            class="btn btn-gradient-info text-right">back</a>
                    </div>
                    <?php switch($data['reportdate']): case 'today':?>
                    <?php switch($data['shopname']): case 'movie':?>
                    <?php include APPROOT .'/views/reports/dailyMovieShopReport.php'; ?>
                    <?php break;?>
                    <?php case "cyber": ?>
                    <?php include APPROOT .'/views/reports/dailyCyberReport.php'; ?>
                    <?php break;?>
                    <?php case "ps": ?>
                    <?php include APPROOT .'/views/reports/dailyPsReport.php'; ?>
                    <?php break;?>
                    <?php case "total": ?>
                    <?php include APPROOT .'/views/reports/dailyNetReport.php'; ?>
                    <?php break;?>
                    <?php case "expense": ?>
                    <?php include APPROOT .'/views/reports/dailyExpenseReport.php'; ?>
                    <?php break;?>
                    <?php case "sales": ?>
                    <?php include APPROOT .'/views/reports/dailySalesReport.php'; ?>
                    <?php break;?>
                    <?php endswitch; ?>
                    <?php break;?>
                    <?php case "week": ?>
                    <?php switch($data['shopname']): case 'movie':?>
                    <?php include APPROOT .'/views/reports/weeklyMovieShopReport.php'; ?>
                    <?php break;?>
                    <?php case "cyber": ?>
                    <?php include APPROOT .'/views/reports/weeklyCyberReport.php'; ?>
                    <?php break;?>
                    <?php case "ps": ?>
                    <?php include APPROOT .'/views/reports/weeklyPsReport.php'; ?>
                    <?php break;?>
                    <?php case "total": ?>
                    <?php include APPROOT .'/views/reports/weeklyNetReport.php'; ?>
                    <?php break;?>
                    <?php case "expense": ?>
                    <?php include APPROOT .'/views/reports/weeklyExpenseReport.php'; ?>
                    <?php break;?>
                    <?php case "sales": ?>
                    <?php include APPROOT .'/views/reports/weeklySalesReport.php'; ?>
                    <?php break;?>
                    <?php endswitch; ?>
                    <?php break;?>
                    <?php case "month": ?>
                    <?php switch($data['shopname']): case 'movie':?>
                    <?php include APPROOT .'/views/reports/monthlyMovieShopReport.php'; ?>
                    <?php break;?>
                    <?php case "cyber": ?>
                    <?php include APPROOT .'/views/reports/monthlyCyberReport.php'; ?>
                    <?php break;?>
                    <?php case "ps": ?>
                    <?php include APPROOT .'/views/reports/monthlyPsReport.php'; ?>
                    <?php break;?>
                    <?php case "total": ?>
                    <?php include APPROOT .'/views/reports/monthlyNetReport.php'; ?>
                    <?php break;?>
                    <?php case "expense": ?>
                    <?php include APPROOT .'/views/reports/monthlyExpenseReport.php'; ?>
                    <?php break;?>
                    <?php case "sales": ?>
                    <?php include APPROOT .'/views/reports/monthlySalesReport.php'; ?>
                    <?php break;?>
                    <?php endswitch; ?>
                    <?php break;?>
                    <?php case "year": ?>
                    <?php switch($data['shopname']): case 'movie':?>
                    <?php include APPROOT .'/views/reports/annualMovieShopReport.php'; ?>
                    <?php break;?>
                    <?php case "cyber": ?>
                    <?php include APPROOT .'/views/reports/annualCyberReport.php'; ?>
                    <?php break;?>
                    <?php case "ps": ?>
                    <?php include APPROOT .'/views/reports/annualPsReport.php'; ?>
                    <?php break;?>
                    <?php case "total": ?>
                    <?php include APPROOT .'/views/reports/annualNetReport.php'; ?>
                    <?php break;?>
                    <?php case "expense": ?>
                    <?php include APPROOT .'/views/reports/annualExpenseReport.php'; ?>
                    <?php break;?>
                    <?php case "sales": ?>
                    <?php include APPROOT .'/views/reports/annualSalesReport.php'; ?>
                    <?php break;?>
                    <?php endswitch; ?>
                    <?php break;?>
                    <?php case "": ?>

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