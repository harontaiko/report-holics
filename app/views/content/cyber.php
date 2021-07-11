<div class="content-wrapper">

    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-desktop-mac"></i>
            </span> Cyber
        </h3>
    </div>
    <main>
        <?php flash('add-error'); ?>
        <select name="filter-cyber" id="filter-cyber" class="form-control mb-2 mr-sm-2">
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
        <select name="filter-movieshop" id="fiter-movieshop" class="form-control mb-2 mr-sm-2 mb-4 ">
            <option value="default">CASH OUTS MADE -
                <?php echo getCashoutCount('movie', $data['db']); ?>(@<?php echo getCashoutTotal('cyber', $data['db']); ?>)
            </option>
            <?php
             $row = getCashout('cyber', $data['db']);
             while($cash = $row->fetch_assoc()):
             ?>
            <option value="<?php echo isset($cash['cash_receipt_number']) ? $cash['cash_receipt_number']: '' ?>">
                Cashed
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
                <th>Cash</th>
                <th>Till/other</th>
                <th>Net Total</th>
            </tr>
            <?php while ($cyber = $data['cyber']->fetch_assoc()) :  ?>
            <tr>
                <td data-th="date-movie"><?php echo date('jS F Y', strtotime($cyber['date_created'])); ?></td>
                <td data-th="cash-movie"><?php echo number_format($cyber['cash']); ?></td>
                <td data-th="till-movie"><?php echo number_format($cyber['till']); ?></td>
                <td data-th="net-movie">
                    <?php echo number_format(getCybershopTotal($cyber['date_created'], $data['db'])) . '/='; ?></td>
            </tr>
            <?php endwhile ?>
        </table>

        <p>&larr; Total:
            <span
                class="login-err"><?php $cashout = getCashoutTotal('cyber', $data['db']); echo number_format($data['total'] - $cashout); ?></span>
            &rarr;
        </p>
    </main>
</div>