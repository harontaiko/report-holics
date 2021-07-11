<?php require(APPROOT . '/views/inc/header.php'); ?>

<body class="invoice __invoice ">
    <?php if($data['invoiceItem'] =="sale"): ?>
    <?php include APPROOT .'/views/invoice/saleInvoice.php'; ?>
    <?php elseif($data['invoiceItem'] == "movie"): ?>
    <?php include APPROOT .'/views/datesfilter/CyberReport.php'; ?>
    <?php elseif($data['invoiceItem'] == "ps"): ?>
    <?php include APPROOT .'/views/datesfilter/PsReport.php'; ?>
    <?php elseif($data['invoiceItem'] == "cyber"): ?>
    <?php include APPROOT .'/views/datesfilter/PsReport.php'; ?>
    <?php endif ?>
</body>
<?php require(APPROOT . '/views/inc/footer.php'); ?>

</html>