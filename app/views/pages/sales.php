<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="sales __sales site-wrap">
    <?php require(APPROOT . '/views/inc/navbar.php'); ?>
    <main>
        <?php flash('add-error'); ?>
        <h2 class="movie-title">Sales <i class="fas fa-shopping-cart fa-2x"></i></h2>
        <select name="filter-sales" id="filter-sales" class="dr_input">
            <option value="default">Filter</option>
            <option value="today">Today</option>
            <option value="week">Weekly</option>
            <option value="month">Monthly</option>
            <option value="year">This year</option>
        </select>
        <section class="todo">
            <form id="filter-movie-date">
                <fieldset>
                    <label for="from">from</label>
                    <input type="date" id="date-1" name="nom" class="dr_input" placeholder="From">
                </fieldset>

                <fieldset>
                    <label for="to">to</label>
                    <input type="date" id="date-2" name="prenom" class="dr_input" placeholder="To">
                </fieldset>
                <button type="button" class="get-repo-btw" id="get-repo-btw">get</button>
            </form>
        </section>
        <select name="filter-movieshop" id="fiter-movieshop" class="dr_input">
            <option value="default">CASH OUTS MADE -
                <?php echo getCashoutCount('sales', $data['db']); ?>(@<?php echo getCashoutTotal('sales', $data['db']); ?>)
            </option>
            <?php
             $row = getCashout('sales', $data['db']);
             while($cash = $row->fetch_assoc()):
             ?>
            <option value="<?php echo isset($cash['cash_receipt_number']) ? $cash['cash_receipt_number']: '' ?>">Cashed
                out By
                <?php echo isset($cash['cash_handler']) ? $cash['cash_handler']: ''; ?> For
                <?php echo isset($cash['cash_usage']) ? $cash['cash_usage']: ''; ?>
                @<?php echo isset($cash['cash_amount']) ? $cash['cash_amount']: ''; ?> on
                <?php echo isset($cash['date_created']) ? $cash['date_created']: ''; ?></option>
            <?php endwhile ?>
        </select>
        <table class="rwd-table">
            <tr>
                <th>Date</th>
                <th>Item(name)</th>
                <th>Bought(ksh)</th>
                <th>Sold(ksh)</th>
                <th>Net profit</th>
                <th>Invoice</th>
            </tr>
            <?php while ($sale = $data['sale']->fetch_assoc()) :  ?>
            <tr>
                <td data-th="date-sold"><?php echo date('jS F Y', strtotime($sale['date_created']));  ?></td>
                <td data-th="item-name"><?php echo $sale['sales_item'] ?></td>
                <td data-th="item-buying"><?php echo $sale['buying_price'] ?></td>
                <td data-th="item-selling"><?php echo $sale['selling_price'] ?></td>
                <td data-th="sold-profit"><?php echo $sale['profit'] ?></td>
                <td data-th="print-invoice"><a
                        href="<?php echo URLROOT; ?>/pages/invoice/sale/<?php echo $sale['sales_id']; ?>"><i
                            style="color: #fff;" class="fas fa-file-invoice"></i></a></td>
            </tr>
            <?php endwhile ?>
        </table>

        <p>&larr; Sold a total of <span class="login-err"><?php echo number_format($data['count']); ?></span> items up
            to
            <?php echo isset($data['date']) ? $data['date']: ''; ?> For a total of <span
                class="login-err"><?php $cashout = getCashoutTotal('sales', $data['db']); echo number_format($data['totalsales'] - $cashout); ?></span>&rarr;
        </p>
    </main>

</body>

<?php require(APPROOT . '/views/inc/footer.php'); ?>

</html>