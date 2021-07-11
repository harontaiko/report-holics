<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="expense __expense site-wrap">
    <?php require(APPROOT . '/views/inc/navbar.php'); ?>
    <main style="padding: 2rem;">
        <?php flash('add-error'); ?>
        <h2 class="movie-title">Expenses <i class="fas fa-pen fa-2x"></i></h2>
        <select name="filter-expense" id="filter-expense" class="dr_input">
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
        <section class="todo">
            <li>
                <h3>Highest Expense Cost(weekly) <strong>
                        <p class="highlight">
                            <?php echo isset($data['highest']['0']['highest']) ? $data['highest']['0']['highest']: 'N/A'; ?>
                            -
                            <?php echo isset($data['highest']['0']['expense_item']) ? $data['highest']['0']['expense_item']: 'N/A'; ?>
                        </p>
                    </strong></h3>
            </li>
        </section>
        <table class="rwd-table">
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
                    <select name="expenses" style="width: 100%; color:#111;">
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

</body>

<?php require(APPROOT . '/views/inc/footer.php'); ?>

</html>