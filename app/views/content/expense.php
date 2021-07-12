<div class="content-wrapper">
    <div id="focus" tabindex="0"></div>
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="fas fa-cash-register fa-2x"></i>
            </span> Expenses
        </h3>
        <a href="Javascript.history.go(-1)" class="btn btn-gradient-info text-right">back</a>
    </div>
    <main style="padding: 2rem;">
        <?php flash('add-error'); ?>
        <select name="filter-expense" id="filter-expense" class="form-control mb-2 mr-sm-2">
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
        <div class="row" id="proBanner">
            <div class="col-12">
                <span class="d-flex align-items-center purchase-popup">
                    <p class="lead">Highest Expense Cost(Weekly)</p>
                    <a class="btn download-button purchase-button ml-auto"><?php echo isset($data['highest']['0']['highest']) ? $data['highest']['0']['highest']: 'N/A'; ?>
                        -
                        <?php echo isset($data['highest']['0']['expense_item']) ? $data['highest']['0']['expense_item']: 'N/A'; ?></a>
                </span>
            </div>
        </div>

        <table class="rwd-table table table-bordered">
            <tr>
                <th>Date</th>
                <th>Expense(s)</th>
                <th>Spent(ksh)</th>
                <th>Total</th>
                <th>attatch receipt</th>
                <th>See</th>
            </tr>
            <?php while ($exp = $data['expenses']->fetch_assoc()) :  ?>
            <tr>
                <td data-th="date-expense"><?php echo date('jS F Y', strtotime($exp['date_created'])); ?></td>
                <td data-th="expense-item">
                    <select name="expenses" class="form-control-sm" style="width: 100%; color:#111;">
                        <option value="total">
                            <?php echo getExpenseTotalCount($exp['date_created'], $data['db']); ?>
                            -total(<?php echo number_format(getExpenseTotal($exp['date_created'], $data['db'])); ?>)
                        </option>
                        <?php 
                                    $expense = getNetExpenses($exp['date_created'], $data['db']);
                                     while ($exp2 = $expense->fetch_assoc()) :  
                                     ?>
                        <option value="<?php echo $exp2['expense_item'] ?>">
                            <?php echo $exp2['expense_item'] ?> @
                            <?php echo number_format($exp2['expense_cost']); ?></option>
                        <?php endwhile ?>
                    </select>
                </td>
                <td data-th="expense-total">
                    <?php echo number_format(getExpenseTotal($exp['date_created'], $data['db'])); ?></td>
                <td data-th="expense-total">
                    <?php echo number_format(getExpenseTotal($exp['date_created'], $data['db'])).'/='; ?></td>
                <td data-th="see"><a style="color: #fff;" href="#!"><i class="fas fa-receipt"></i></a></td>
                <td data-th="see"><a style="color: #fff;"
                        href="<?php echo URLROOT; ?>/pages/viewExpense/<?php echo isset($exp['date_created']) ? $exp['date_created']: 'N/A' ?>"><i
                            class="fas fa-eye"></i></a></td>
            </tr>
            <?php endwhile ?>

        </table>

        <p>&larr; Net Expenses: <span class="login-err"><?php echo number_format($data['diff']) .'/='; ?></span>&rarr;
        </p>
    </main>
</div>