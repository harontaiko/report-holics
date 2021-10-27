<div class="content-wrapper">

    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-chart-line"></i>
            </span> Daily Report
        </h3>
        <a id="" class="text-right btn bg-gradient-primary text-white" title="add sale"
            href="<?php echo URLROOT; ?>/pages/sale"><i class="fas fa-plus"></i></a>
    </div>

    <main>
        <input type="hidden" value="<?php echo isset($_SESSION['anime']) ?  $_SESSION['anime']: '';?>" id="anime">
        <header>
            <?php flash('add-error'); ?>
            <table class="table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th colspan="6">INCOME</th>
                        <th colspan="4">SALES</th>
                        <th>SALE PROFIT</th>
                        <th>EXPENSES(ksh)</th>
                        <th colspan="2">TOTAL INCOME</th>
                        <th colspan="2">VIEW</th>
                    </tr>
                    <thead>
                    <tbody>
                        <tr>
                            <td style="background-color: #ffed86;">Date</td>
                            <td span="col" colspan="2">movie shop</td>
                            <td span="col" colspan="2">playstation</td>
                            <td span="col" colspan="2">cyber</td>
                            <td style="background-color: #ffed86;">All products</td>
                            <td style="background-color: #ffed86;">Buying</td>
                            <td style="background-color: #ffed86;" colspan="1">Sold(ksh)</td>
                            <td style="background-color: #111;"></td>
                            <td style="background-color: #ffed86;">Profit</td>
                            <td style="background-color: #ffed86;">Expenses</td>
                            <td style="background-color: #ffed86;">N/A</td>
                            <td style="background-color: #ffed86;">N/A</td>
                            <td style="background-color: #ffed86;">NET TOTAL</td>
                            <td style="background-color: #ffed86;">VIEW</td>
                            <td style="background-color: #ffed86;">SHARE</td>
                            <td style="background-color: #fb0808; color:#fff;">DELETE</td>
                        </tr>
                        <tr>
                            <td style="background-color: #89909f; color:#fff;">Date</td>
                            <td style="background-color: #89909f; color:#fff;">cash</td>
                            <td style="background-color: #89909f; color:#fff;">till</td>
                            <td style="background-color: #89909f; color:#fff;">cash</td>
                            <td style="background-color: #89909f; color:#fff;">till</td>
                            <td style="background-color: #89909f; color:#fff;">cash</td>
                            <td style="background-color: #89909f; color:#fff;">till</td>
                            <td style="background-color: #89909f; color:#fff;">products</td>
                            <td style="background-color: #89909f; color:#fff;">bought(all))</td>
                            <td style="background-color: #89909f; color:#fff;">till+cash</td>
                            <td style=" background-color: #111;"></td>
                            <td style=" background-color: #89909f; color:#fff;">profit</td>
                            <td style=" background-color: #89909f; color:#fff;">expenses</td>
                            <td style="background-color: #89909f; color:#fff;">cash</td>
                            <td style="background-color: #89909f; color:#fff;">till</td>
                            <td style="background-color: #89909f; color:#fff;">GROSS</td>
                            <td style="background-color: #89909f; color:#fff;">SEE</td>
                            <td style="background-color: #89909f; color:#fff;">SHARE</td>
                            <td style="background-color: #fb0808; color:#fff;">DELETE</td>
                        </tr>
                        <?php while ($net = $data['net']->fetch_assoc()) :  ?>
                        <tr id="latest-record" style="background: chartreuse; width: 100vw;">
                            <td><?php echo date('jS F Y', strtotime($net['date_created'])); ?>
                            </td>
                            <td>
                                <?php 
                            $shopcash =  getMovieshopDate($net['date_created'], $data['db']); 
                            echo isset($shopcash['cash']) ? number_format($shopcash['cash']) : '';
                            ?>
                            </td>
                            <td> <?php 
                            $shopcash =  getMovieshopDate($net['date_created'], $data['db']); 
                            echo isset($shopcash['till']) ? number_format($shopcash['till']) : '';
                            ?></td>
                            <td> <?php 
                            $pscash =  getPsDate($net['date_created'], $data['db']); 
                            echo isset($pscash['cash']) ? number_format($pscash['cash']) : '';
                            ?></td>
                            <td> <?php 
                            $pscash =  getPsDate($net['date_created'], $data['db']); 
                            echo isset($pscash['till']) ? number_format($pscash['till']) : '';
                            ?></td>
                            <td> <?php 
                            $cybershop =  getCyberDate($net['date_created'], $data['db']); 
                            echo isset($cybershop['cash']) ? number_format($cybershop['cash']) : '';
                            ?></td>
                            <td> <?php 
                            $cybershop =  getCyberDate($net['date_created'], $data['db']); 
                            echo isset($cybershop['till']) ? number_format($cybershop['till']) : '';
                            ?></td>
                            <!--list group-->
                            <td>
                                <select name="products" id="products-sold">
                                    <option value="total">
                                        <?php echo getSalesTotalCount($net['date_created'], $data['db']); ?>
                                        -total(<?php echo number_format(getSaleTotal($net['date_created'], $data['db'])); ?>)
                                    </option>
                                    <?php 
                                    $sale = getNetSales($net['date_created'], $data['db']);
                                     while ($sl = $sale->fetch_assoc()) :  
                                     ?>
                                    <option value="<?php echo $sl['sales_item'] ?>"><?php echo $sl['sales_item'] ?>
                                        <?php echo number_format($sl['selling_price']) ?></option>
                                    <?php endwhile ?>
                                </select>
                            </td>
                            <td><?php echo number_format(getBuyingTotal($net['date_created'], $data['db'])); ?></td>
                            <td><?php echo number_format(getSaleTotal($net['date_created'], $data['db'])); ?></td>
                            <td style="background-color: #111;"></td>
                            <td><?php echo number_format(getNetProfit($net['date_created'], $data['db'])); ?></td>
                            <!--list group-->
                            <td>
                                <select name="expenses" id="expenses-">
                                    <option value="total">
                                        <?php echo getExpenseTotalCount($net['date_created'], $data['db']); ?>
                                        -total(<?php echo number_format(getExpenseTotal($net['date_created'], $data['db'])); ?>)
                                    </option>
                                    <?php 
                                    $expense = getNetExpenses($net['date_created'], $data['db']);
                                     while ($exp = $expense->fetch_assoc()) :  
                                     ?>
                                    <option value="<?php echo $exp['expense_item'] ?>">
                                        <?php echo $exp['expense_item'] ?> @
                                        <?php echo number_format($exp['expense_cost']); ?></option>
                                    <?php endwhile ?>
                                </select>
                            </td>
                            <td><?php echo number_format($net['cash_sales']); ?></td>
                            <td><?php echo number_format($net['till_sales']); ?></td>
                            <td><a href="#!"><?php echo number_format(($net['cash_sales'] + $net['till_sales'] + getSaleTotal($net['date_created'], $data['db'])) - (getExpenseTotal($net['date_created'], $data['db']))) . '/=';?>
                            </td>
                            <td><a href="<?php echo URLROOT; ?>/pages/viewEdit/<?php echo $net['sales_id']; ?>"><i
                                        title="see record" class="fas fa-eye p-2"></i></a></td>
                            <td><a target="_blank"
                                    href="https://api.whatsapp.com/send?phone=254727678517&text=movieshop%3A%20cash%20 <?php 
                            $shopcash =  getMovieshopDate($net['date_created'], $data['db']); 
                            echo isset($shopcash['cash']) ? number_format($shopcash['cash']) : '';
                            ?>%2C%20till%20 <?php 
                            $shopcash =  getMovieshopDate($net['date_created'], $data['db']); 
                            echo isset($shopcash['till']) ? number_format($shopcash['till']) : '';
                            ?>%20%3D%20<?php  $mvcash =  getMovieshopDate($net['date_created'], $data['db']);  $cashMv = $mvcash['cash'];  $tillMv = $mvcash['till']; echo number_format($cashMv+$tillMv); ?>%0AAccessories%3A%20<?php echo getSalesTotalCount($net['date_created'], $data['db']); ?>%20%40%20<?php echo number_format(getSaleTotal($net['date_created'], $data['db'])); ?>%20%28 
    <?php 
                                    $sale = getNetSales($net['date_created'], $data['db']);
                                     while ($sl = $sale->fetch_assoc()) :  
                                     ?><?php echo $sl['sales_item'] ?>@<?php echo $sl['selling_price'].', ' ?><?php endwhile ?>%29%0Aps%3A<?php $pscash =  getPsDate($net['date_created'], $data['db']); $cashps = $pscash['cash']; $tillps = $pscash['till']; echo number_format($cashps+$tillps);?>%0Acyber%3A%20<?php $cbcash =  getCyberDate($net['date_created'], $data['db']); $cashcyber = $cbcash['cash']; $tillcyber = $cbcash['till']; echo number_format($cashcyber+$tillcyber);?>%0AExpenses%3A%20<?php echo number_format(getExpenseTotal($net['date_created'], $data['db'])).'/='; ?><?php $sale = getNetExpenses($net['date_created'], $data['db']);echo '('; while ($sl = $sale->fetch_assoc()) :  ?><?php echo $sl['expense_item'] ?>@<?php echo $sl['expense_cost'].', ' ?><?php endwhile ?><?php echo ')'; ?>%0Atotal%20cash%3A<?php echo number_format($net['cash_sales']); ?>%0Atotal%20till%3A%20<?php echo number_format($net['till_sales']); ?>%0Acash%20in%20hand%3A%20<?php echo 'movieshop@';  $MV =  getMovieShopDate($net['date_created'], $data['db']); $cashMOVIE = $MV['cash']; $tillMOVIE = $MV['till']; echo number_format($cashMOVIE+$tillMOVIE).', '; echo 'cyber@';  $PS =  getCyberDate($net['date_created'], $data['db']); $cashPS = $PS['cash']; $tillPS = $PS['till']; echo number_format($cashPS+$tillPS).' ,';  echo 'cyber@'; $CB =  getPsDate($net['date_created'], $data['db']); $cashCB = $CB['cash']; $tillCB = $CB['till']; echo number_format($cashCB+$tillCB); ?>%0ANet%20income%3A%20<?php echo number_format(($net['cash_sales'] + $net['till_sales'] + getSaleTotal($net['date_created'], $data['db'])) - (getExpenseTotal($net['date_created'], $data['db']))) . '/=';?>%28excluding%20expenses%29%0A"><i
                                        title="share on whatsapp" class="fab fa-whatsapp p-2"></i></a>

                            </td>
                            <td>
                                <a href="<?php echo URLROOT; ?>/pages/deleteRecord/<?php echo $net['sales_id']; ?>"><i
                                        title="delete record" class="fas fa-trash p-2"></i></a>
                            </td>
                        </tr>

                        <?php endwhile ?>
                    </tbody>
                    <table />
        </header>
    </main>
</div>