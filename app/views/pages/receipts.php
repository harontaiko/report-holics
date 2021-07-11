<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="receipts __receipts site-wrap">
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
</body>

<?php require(APPROOT . '/views/inc/footer.php'); ?>

</html>