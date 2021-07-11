<div class="filtered-repo" id="cyber-filtered-repo">
    <button class="previous-report" onclick="location.replace(`<?php echo URLROOT; ?>/pages/expenses`);" title="back"><i
            title="back" class="fas fa-arrow-left"></i></button>
    <button title="print report" type="button" id="custom-print-report"
        onClick="printJS({ printable: 'cyber-filtered-repo', type: 'html', style: 'h1{font-size:1.25rem;} #custom-print-report{display:none} .previous-report{display:none;} .container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(1){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(3){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(4){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(5){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;} .container-out-report tr:nth-child(1){border-color: #f1f1f1; border-bottom: 1px solid #ddd;background: white;}'})">
        <i class=" fas fa-print"></i>
    </button>
    <h1 id="report-title">Expenses <span>Between <?php echo $data['from'] ?> And
            <?php echo $data['to']; ?></span>
    </h1>

    <table class="responstable" id="responstable">

        <tr>
            <th>Date</th>
            <th>Expense Item</th>
            <th>Amount Spent(Ksh)</th>
            <th>Net Total</th>
            <th>Created By</th>
            <th>Host Address</th>
        </tr>

        <?php 
            
            $m = getFileteredReportBetween($data['from'], $data['to'], 'expense', $data['db']);
            while($mv = $m->fetch_assoc()):    
            ?>
        <tr>
            <td style="color: black;">
                <?php echo $mv['date_created']; ?></td>
            <td style="color: black;"><?php echo ($mv['expense_item']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['expense_cost']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['expense_cost']); ?>
            <td style="color: black;"><?php echo ($mv['created_by']); ?>
            <td style="color: black;"><?php echo ($mv['creator_ip']); ?>
            </td>
        </tr>
        <?php endwhile; ?>
        <tr>
            <td></td>
            <td></td>
            <td style="font-weight: bolder;"><strong>Amount:
                    <?php echo number_format(getFileteredReportTotal($data['from'], $data['to'], 'expense', $data['db'])); ?></strong>
            </td>
            <td style="font-weight: bolder;">Net:
                <?php echo number_format(getFileteredReportTotal($data['from'], $data['to'], 'expense', $data['db'])); ?>
            </td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>