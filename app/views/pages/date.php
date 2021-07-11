<?php require(APPROOT . '/views/inc/header.php'); ?>

<body class="date __date ">
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
</body>
<?php require(APPROOT . '/views/inc/footer.php'); ?>

</html>