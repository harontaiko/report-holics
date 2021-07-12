<div class="filtered-repo" id="cyber-filtered-repo">
    <button title="print report" type="button" class="btn btn-gradient-success" id="custom-print-report"
        onClick="printJS({ printable: 'cyber-filtered-repo', type: 'html', style: 'h1{font-size:1.25rem;} #custom-print-report{display:none} .previous-report{display:none;} .container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(1){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(3){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(4){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(5){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;} .container-out-report tr:nth-child(1){border-color: #f1f1f1; border-bottom: 1px solid #ddd;background: white;}'})">
        <i class=" fas fa-print"></i>
    </button>
    <h1 id="report-title">Net <span>Report Between <?php echo $data['from'] ?> And
            <?php echo $data['to']; ?></span>
    </h1>

    <table class="responstable net-tbl table table-hover table-bordered" id="responstable">

        <tr>
            <th>Date</th>
            <th>Total Cash income(Ksh)</th>
            <th>Total Till income(Ksh)</th>
            <th>Total Expenses</th>
            <th>Total Sales</th>
            <th>Total Income(cyber,ps,movie)</th>
            <th>Gross Net Total</th>
            <th>Created By</th>
            <th>Host Address</th>
        </tr>

        <?php 
            
            $m = getFileteredReportBetween($data['from'], $data['to'], 'total', $data['db']);
            while($mv = $m->fetch_assoc()):    
            ?>
        <tr>
            <td style="color: black;">
                <?php echo $mv['date_created']; ?></td>
            <td style="color: black;"><?php echo number_format($mv['cash_sales']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['till_sales']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['totalexpense']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['total_sales']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['totalincome']); ?></td>
            <td style="color: black;" class="totalincome">
                <?php echo number_format($mv['totalincome'] + $mv['total_sales']); ?></td>
            <td style="color: black;"><?php echo ($mv['created_by']); ?></td>
            <td style="color: black;"><?php echo ($mv['creator_ip']); ?>
            </td>
        </tr>
        <?php endwhile; ?>
        <?php 
                  $arr = array();
                  $d =  getFileteredReportTotal($data['from'], $data['to'], 'total', $data['db']);
                  while($p =$d->fetch_assoc()){
                      array_push($arr, $p);
                  }
            ?>
        <tr>
            <td></td>
            <td style="font-weight: bolder;"><strong>cash:
                    <?php echo isset($arr['0']['totalcash']) ? number_format($arr['0']['totalcash']): 'N/A'; ?></strong>
            </td>
            <td style="font-weight: bolder;">till:
                <?php echo isset($arr['0']['totaltill']) ? number_format($arr['0']['totaltill']): 'N/A'; ?></td>
            <td style="font-weight: bolder;"><strong>Total:
                    <?php echo isset($arr['0']['expensetotal']) ? number_format($arr['0']['expensetotal']): 'N/A'; ?></strong>
            </td>
            <td style="font-weight: bolder;"><strong>Sales:
                    <?php echo isset($arr['0']['totalsales']) ? number_format($arr['0']['totalsales']): 'N/A'; ?></strong>
            </td>
            <td style="font-weight: bolder;"><strong>Income:
                    <?php echo isset($arr['0']['incometotal']) ? number_format($arr['0']['incometotal']): 'N/A'; ?></strong>
            </td>
            <td style="font-weight: bolder;" id="ttl">Gross:
                <strong><?php echo number_format(getGross($data['from'] ,$data['to'], $data['db'])); ?></strong>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>