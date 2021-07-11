<div class="content-wrapper">

    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-layers"></i>
            </span> Gross
        </h3>
    </div>
    <main>
        <?php flash('add-error'); ?>
        <select name="filter-total" id="filter-total" class="form-control mb-2 mr-sm-2">
            <option value="default">Filter</option>
            <option value="today">Today</option>
            <option value="week">Weekly</option>
            <option value="month">Monthly</option>
            <option value="year">This year</option>
        </select>
        <form class="form-inline mt-4 mb-4" id="filter-movie-date">
            <label class="mr-2">From</label>
            <input type="date" id="date-1" name="nom" class="form-control" placeholder="From">
            <label class="ml-2 mr-2">To</label>
            <input type="date" id="date-2" name="prenom" class="form-control" placeholder="To">
            <button type="button" class="btn btn-gradient-primary mb-2 ml-2" id="get-repo-btw">Get</button>
        </form>
        <select name="filter-movieshop" id="fiter-movieshop" class="form-control mb-2 mr-sm-2 mb-4">
            <option value="default">CASH OUTS MADE -
                <?php echo getCashoutCount('total', $data['db']); ?>(@<?php echo getCashoutTotal('total', $data['db']); ?>)
            </option>
            <?php
             $row = getCashout('total', $data['db']);
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
        <table class="rwd-table table table-bordered">
            <tr>
                <th>Date</th>
                <th>Expense(ksh)</th>
                <th>Sales(ksh)</th>
                <th>Income(cyber,ps,shop)</th>
                <th>Net Total(ksh)</th>
                <th>See</th>
            </tr>
            <?php while ($net = $data['net']->fetch_assoc()) :  ?>
            <tr>
                <td data-th="date-net"><?php echo date('jS F Y', strtotime($net['date_created'])); ?></td>
                <td data-th="expense-net"><?php echo number_format($net['totalexpense']); ?></td>
                <td data-th="sales-net"><?php echo number_format($net['total_sales']); ?></td>
                <td data-th="income-net"><?php echo number_format($net['totalincome']); ?></td>
                <td data-th="total-net">
                    <?php echo number_format($net['totalincome'] + $net['total_sales'] -($net['totalexpense'])).'/='; ?>
                </td>
                <td data-th="see"><i class="fas fa-eye"></i></td>
            </tr>
            <?php endwhile ?>

        </table>

        <p>&larr; Net Total(exclusive of expenses): <span
                class="login-err"><?php $cashout = getCashoutTotal('total', $data['db']); echo number_format($data['sum'] - $data['diff'] - $cashout) . '/='; ?></span>&rarr;
        </p>
    </main>
</div>