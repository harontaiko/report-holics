<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="trends __trends site-wrap">
    <?php require(APPROOT . '/views/inc/navbar.php'); ?>
    <ul class="auto-grid">
        <li>
            <h3>Items Sold: <strong>
                    <p class="highlight"><?php echo number_format($data['sold']); ?></p>
                </strong></h3>
        </li>
        <li>
            <h3>Items In Stock: <strong>
                    <p class="highlight"><?php echo number_format($data['stock']); ?></p>
                </strong></h3>
        </li>
        <li>
            <h3>Out of Stock: <strong>
                    <p class="highlight"><?php echo number_format($data['out']); ?></p>
                </strong></h3>
        </li>
        <li>
            <h3>Created(weekly): <strong>
                    <p class="highlight"><?php echo number_format($data['weeklycount']); ?></p>
                </strong></h3>
        </li>
        <li>
            <h3>Total Income: <strong>
                    <p class="highlight"><?php echo number_format($data['row']['0']['incometotal']); ?></p>
                </strong></h3>
        </li>
        <li>
            <h3>Total Till: <strong>
                    <p class="highlight"><?php echo number_format($data['row']['0']['till_total']); ?></p>
                </strong></h3>
        </li>
        <li>
            <h3>Total Cash: <strong>
                    <p class="highlight"><?php echo number_format($data['row']['0']['cash_total']); ?></p>
                </strong></h3>
        </li>
        <li>
            <h3>Total Profit: <strong>
                    <p class="highlight"><?php echo number_format($data['row']['0']['profittotal']); ?></p>
                </strong></h3>
        </li>
        <li>
            <h3>Total Sales: <strong>
                    <p class="highlight"><?php echo number_format($data['row']['0']['sales_total']); ?></p>
                </strong></h3>
        </li>
        <li>
            <h3>Average Total Sales Per Day: <strong>
                    <p class="highlight"><?php echo number_format($data['avgsales']); ?></p>
                </strong></h3>
        </li>
        <li>
            <h3>Average Cash Per Day: <strong>
                    <p class="highlight"><?php echo number_format($data['avgcash']); ?></p>
                </strong></h3>
        </li>
        <li>
            <h3>Average Till Per Day: <strong>
                    <p class="highlight"><?php echo number_format($data['avgtill']); ?></p>
                </strong></h3>
        </li>
        <li>
            <h3>Average Net Income Per Day: <strong>
                    <p class="highlight"><?php echo number_format($data['avgincome']); ?></p>
                </strong></h3>
        </li>
    </ul>
</body>

<?php require(APPROOT . '/views/inc/footer.php'); ?>

</html>