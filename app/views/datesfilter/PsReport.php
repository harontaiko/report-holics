<div class="filtered-repo" id="ps-filtered-repo">
    <button title="print report" type="button" class="btn btn-gradient-success" id="custom-print-report"
        onClick="printJS({ printable: 'ps-filtered-repo', type: 'html', style: 'h1{font-size:1.25rem;} #custom-print-report{display:none} .previous-report{display:none;} .container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(1){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(3){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(4){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(5){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;} .container-out-report tr:nth-child(1){border-color: #f1f1f1; border-bottom: 1px solid #ddd;background: white;}'})">
        <i class=" fas fa-print"></i>
    </button>
    <h1 id="report-title">Playstation <span>Report Between <?php echo $data['from'] ?> And
            <?php echo $data['to']; ?></span>
    </h1>

    <table class="responstable table table-hover table-bordered" id="responstable">

        <tr>
            <th>Date</th>
            <th>Cash income(Ksh)</th>
            <th>Till income(Ksh)</th>
            <th>Net Total</th>
            <th>Created By</th>
            <th>Host Address</th>
        </tr>

        <?php 
            
            $m = getFileteredReportBetween($data['from'], $data['to'], 'ps', $data['db']);
            while($mv = $m->fetch_assoc()):    
            ?>
        <tr>
            <td style="color: black;">
                <?php echo $mv['date_created']; ?></td>
            <td style="color: black;"><?php echo number_format($mv['cash']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['till']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['cash'] + $mv['till']); ?>
            <td style="color: black;"><?php echo ($mv['created_by']); ?>
            <td style="color: black;"><?php echo ($mv['creator_ip']); ?>
            </td>
        </tr>
        <?php endwhile; ?>
        <?php 
                  $arr = array();
                  $d =  getFileteredReportTotal($data['from'], $data['to'], 'ps', $data['db']);
                  while($p =$d->fetch_assoc()){
                      array_push($arr, $p);
                  }
            ?>
        <tr>
            <td></td>
            <td style="font-weight: bolder;"><strong>cash:
                    <?php echo isset($arr['0']['cash']) ? number_format($arr['0']['cash']): 'N/A'; ?></strong>
            </td>
            <td style="font-weight: bolder;">till:
                <?php echo isset($arr['0']['till']) ? number_format($arr['0']['till']): 'N/A'; ?></td>
            <td style="font-weight: bolder;"><strong>Total:
                    <?php echo isset($arr['0']['total']) ? number_format($arr['0']['total']): 'N/A'; ?></strong>
            </td>
            <td></td>
        </tr>
    </table>
</div>