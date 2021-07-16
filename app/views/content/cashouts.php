<div class="content-wrapper">

    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="fas fa-cash-register"></i>
            </span> Cashouts Made
        </h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="add-items d-flex">
                <input style="border: 1px solid #007bff;" type="text"
                    class="form-control todo-list-input cashouts-filter" data-table="table-cashouts"
                    placeholder="station name / handler / usage">

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-cashouts">
                    <thead>
                        <tr>
                            <th> Date </th>
                            <th> Handler </th>
                            <th> Cash From </th>
                            <th> Amount </th>
                            <th> Usage </th>
                            <th> Receipt </th>
                            <th> Delete </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($cash = $data['out']->fetch_assoc()): ?>
                        <!--push to array for get vars-->
                        <?php $arr = implode(',', $cash); ?>
                        <tr>
                            <td> <?php echo isset($cash['date_created']) ? $cash['date_created']: 'N/A' ?> </td>
                            <td> <?php echo isset($cash['cash_handler']) ? $cash['cash_handler']: 'N/A' ?> </td>
                            <td> <?php echo isset($cash['cash_from']) ? $cash['cash_from']: 'N/A' ?> </td>
                            <td> <?php echo isset($cash['cash_amount']) ? number_format($cash['cash_amount']): 0 ?>
                            </td>
                            <td>
                                <?php echo isset($cash['cash_usage']) ? $cash['cash_usage']: 'N/A' ?>
                            </td>
                            <td><a href="<?php echo URLROOT; ?>/pages/receipts/cashout/<?php echo $arr; ?>"><i
                                        class="fas fa-eye"></i></a></td>
                            </td>
                            <td><a
                                    href="<?php echo URLROOT; ?>/pages/deletecashout/<?php echo isset($cash['cash_id']) ? $cash['cash_id']: 'N/A' ?>"><i
                                        class="fas fa-trash"></i></a></td>
                            </td>

                        </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>