<div class="filtered-repo" id="cyber-filtered-repo">
    <button title="print report" class="btn btn-gradient-success" type="button" id="custom-print-report"
        onClick="printJS({ printable: 'cyber-filtered-repo', type: 'html', style: 'h1{font-size:1.25rem;} #custom-print-report{display:none} .previous-report{display:none;} .container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(1){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(3){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(4){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(5){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;} .container-out-report tr:nth-child(1){border-color: #f1f1f1; border-bottom: 1px solid #ddd;background: white;}'})">
        <i class=" fas fa-print"></i>
    </button>
    <h1 id="report-title">Sales <span>Made Between <?php echo $data['from'] ?> And
            <?php echo $data['to']; ?></span>
    </h1>

    <table class="responstable table table-hover table-bordered" id="responstable">

        <tr>
            <th>Date</th>
            <th>Item(name)</th>
            <th>Bought(ksh)</th>
            <th>Sold(ksh)</th>
            <th>Net profit</th>
            <th>Sale by</th>
            <th>Invoice</th>
        </tr>

        <?php 
            
            $m = getFileteredReportBetween($data['from'], $data['to'], 'sales', $data['db']);
            while($mv = $m->fetch_assoc()):    
            ?>
        <tr>
            <td style="color: black;">
                <?php echo $mv['date_created']; ?></td>
            <td style="color: black;"><?php echo ($mv['sales_item']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['buying_price']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['selling_price']); ?>
            <td style="color: black;"><?php echo number_format($mv['profit']); ?>
            <td style="color: black;"><?php echo ($mv['created_by']); ?>
            <td style="color: black;"><a
                    href="<?php echo URLROOT; ?>/pages/invoice/sale/<?php echo $mv['sales_id']; ?>"><i
                        style="color: #111;" class="fas fa-file-invoice"></i></a>
            </td>
        </tr>
        <?php endwhile; ?>
        <?php 
                  $arr = array();
                  $d =  getFileteredReportTotal($data['from'], $data['to'], 'sales', $data['db']);
                  while($p =$d->fetch_assoc()){
                      array_push($arr, $p);
                  }
            ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td style="font-weight: bolder;"><strong>Selling:
                    <?php echo isset($arr['0']['selling']) ? number_format($arr['0']['selling']): 'N/A'; ?></strong>
            </td>
            <td style="font-weight: bolder;">Profit:
                <?php echo isset($arr['0']['pr']) ? number_format($arr['0']['pr']): 'N/A'; ?></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>