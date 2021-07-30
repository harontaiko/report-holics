<div class="content-wrapper">

    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-cash-multiple"></i>
            </span> Add Sale
        </h3>

    </div>


    <main>
        <h2 id="add-title">New Record</h2>
        <form action="" method="POST" id="form-add">
            <input style="background: #81ec16;color: red;"
                onchange="document.getElementById(`date__`).value = this.value" type="date" name="date" id="date"
                value="">
            <div class="alert alert_success" id="alert_add">
                <p id="add-alert"></p>
            </div>
            <input type="submit" class="save-record btn-lg btn-gradient-info mb-4 px-2" value="create record">
            <div class="inner_grid">
                <div class="income">
                    <h3>Income</h3>
                    <hr>
                    <div class="cyber-record">
                        <p>Cyber <i class="fas fa-tv"></i></p>
                        <input type="number" name="cyber-cash"
                            value="<?php echo empty($data['cyber'])? '':$data['cyber']['0']['cash']  ?>" id="cyber-cash"
                            placeholder="cash" class="income-calc dr_input">
                        <input type="number" name="cyber-till"
                            value="<?php echo empty($data['cyber'])? '':$data['cyber']['0']['till']  ?>" id="cyber-till"
                            placeholder="till/other" class="income-calc-till dr_input">
                    </div>
                    <div class="ps-record">
                        <p>Playstation <i class="fab fa-playstation"></i></p>
                        <input type="number" name="ps-cash"
                            value="<?php echo empty($data['ps'])? '':$data['ps']['0']['cash']  ?>" id="ps-cash"
                            placeholder="cash" class="income-calc dr_input">
                        <input type="number" name="ps-till"
                            value="<?php echo empty($data['ps'])? '':$data['ps']['0']['till']  ?>" id="ps-till"
                            placeholder="till/other" class="income-calc-till dr_input">
                    </div>
                    <div class="movie-record">
                        <p>Movie Shop<i class="fas fa-compact-disc"></i></p>
                        <input type="number" name="movie-cash"
                            value="<?php echo empty($data['movie'])? '':$data['movie']['0']['cash']  ?>" id="movie-cash"
                            placeholder="cash" class="income-calc dr_input">
                        <input type="number" name="movie-till"
                            value="<?php echo empty($data['movie'])? '':$data['movie']['0']['till']  ?>" id="movie-till"
                            placeholder="till/other" class="income-calc-till dr_input">
                    </div>
                </div>
                <div class="total">
                    <h3>Total (Income)</h3>
                    <hr>
                    <div class="total-record">
                        <p>Net total(excluding sales and expenses)<i class="fas fa-layer-group"></i></p>
                        <input type="number" style="background:aliceblue;" readonly name="total-cash"
                            value="<?php echo empty($data['net'])? '':$data['net']['0']['cash_sales']  ?>"
                            placeholder="Total cash" class="dr_input" id="total-cash">
                        <input type="number" style="background:aliceblue;" readonly name="total-till"
                            value="<?php echo empty($data['net'])? '':$data['net']['0']['till_sales']  ?>"
                            placeholder="till/other" class="dr_input" id="total-till">
                        <p class="total-sales-out-cash" id="total-sales-out-cash">cash total:
                            <?php echo empty($data['net'])? '':number_format($data['net']['0']['cash_sales'])  ?></p>
                        <p class="total-sales-out-till" id="total-sales-out-till">till total:
                            <?php echo empty($data['net'])? '':number_format($data['net']['0']['till_sales']);  ?></p>
                        <p class="total-sales-out-net" id="total-sales-out-net">net
                            total:<?php echo empty($data['net'])? '':number_format($data['net']['0']['totalincome']);  ?>
                        </p>
                    </div>
                </div>
                <div class="sales">
                    <h3>Sales</h3>
                    <hr>
                    <div class="sales-record">
                        <form name="sales-form-rec" id="sales-form-rec">
                            <p>Product Sales <i class="fa fa-cash-register"></i></p>
                            <div id="sc">
                            </div>
                            <div id="sl">
                            </div>
                            <select name="product" id="product" class="dr_input">
                                <?php while ($sales = $data['inventoryAdd']->fetch_assoc()) : ?>
                                <option value="<?php echo isset($sales['item_id']) ? $sales['item_id']: ''; ?>">
                                    <?php echo isset($sales['item_name']) ? $sales['item_name']: ''; ?></option>
                                <?php endwhile ?>
                            </select>
                            <input type="text" readonly name="bought-price" id="bought-price" placeholder="Buying(ksh)"
                                class="dr_input">
                            <input type="text" readonly name="bought-item" id="bought-item" placeholder="item"
                                class="dr_input">
                            <input autocomplete="off" type="number" name="sales-cash" id="sales-cash"
                                placeholder="sell..cash" class="dr_input">
                            <input autocomplete="off" type="number" name="sales-till" id="sales-till"
                                placeholder="sell..till/other" class="dr_input">
                            <input type="hidden" name="date__" id="date__" value="">
                            <input readonly type="number" name="sales-profit" id="sales-profit" placeholder="profit"
                                class="dr_input">
                            <input class="add-product" id="add-sale-btn" type="submit" value="Add">
                        </form>
                    </div>
                </div>
                <div class="expenses">
                    <h3>Expenses</h3>
                    <hr>

                    <div class="expenses-record">
                        <p>Expenses <i class="fas fa-money-bill-alt"></i></p>
                        <div id="exp">
                        </div>
                        <input type="text" placeholder="expense (description)" id="expense_n" name="expense-name"
                            class="dr_input">
                        <input type="number" name="expense-value" id="expense-value" placeholder="used(ksh)"
                            class="dr_input">
                        <button class="add-expense" id="n-expense" type="button">Add</button>
                    </div>
                </div>
            </div>
        </form>

    </main>

</div>