<!--Daily, Monthly And Annual reports-->
<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="reports __reports ">
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
</body>
<?php require(APPROOT . '/views/inc/footer.php'); ?>

</html>