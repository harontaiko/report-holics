<section id="reports-tbl">

    <button title="print report" class="btn btn-gradient-success" type="button" id="custom-print-report"
        onClick="printJS({ printable: 'container-out-report2', type: 'html', style: '.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(1){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(3){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(4){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(5){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;} .container-out-report tr:nth-child(1){border-color: #f1f1f1; border-bottom: 1px solid #ddd;background: white;}'})">
        <i class=" fas fa-print"></i>
    </button>
    <h1 id="report-title">Monthly Expense <span>Report</span></h1>

    <table class="responstable table table-striped mb-4" id="responstable">

        <tr>
            <th>Month</th>
            <th>Monthly Expense Amount(Ksh)</th>
            <th>Monthly Expense Total</th>
        </tr>

        <?php 
        
        $m = getExpenseAllMonthNet($data['db']);
        while($mv = $m->fetch_assoc()):    
        ?>
        <tr>
            <td style="color: black;">
                <?php echo $mv['DATE_FORMAT(date_created, "%M")']; ?></td>
            <td style="color: black;"><?php echo number_format($mv['expense_net']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['expense_net']); ?></td>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</section>
<div class="container-out-report" id="container-out-report2">
    <h1 id="report-title">Monthly Expense <span>Report</span></h1>

    <table class="table table-striped">
        <tr>
            <th>Month</th>
            <th>Monthly Expense Amount(Ksh)</th>
            <th>Monthly Expense Total</th>
        </tr>

        <?php 
        
        $m = getExpenseAllMonthNet($data['db']);
        while($mv = $m->fetch_assoc()):    
        ?>
        <tr>
            <td style="color: black;">
                <?php echo $mv['DATE_FORMAT(date_created, "%M")']; ?></td>
            <td style="color: black;"><?php echo number_format($mv['expense_net']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['expense_net']); ?></td>
            </td>
        </tr>
        <?php endwhile; ?>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Gross: <?php
                    echo number_format(getExpenseTotalMonth($data['db']));  
                     ?></td>
            </tr>
        </tfoot>
    </table>

    <section id="realtime-charts">
        <div class="line-chart-report">
            <canvas style="visibility: hidden;" id="line-month-chart-repo-mv"
                style="height:380px; width:420px"></canvas>
        </div>
        <div class="bar-chart-report">
            <canvas id="bar-month-chart-repo-mv" style="height:380px; width:420px"></canvas>
        </div>
        <div class="pie-chart-report">
            <canvas style="visibility: hidden;" id="pie-month-chart-repo-mv" style="height:380px; width:420px"></canvas>
        </div>
    </section>
</div>
<!--line chart daily movie report-->
<script>
//get movie shop report for today
$(document).ready(function() {
    $.ajax({
        url: `<?php echo URLROOT; ?>/pages/getExpenseRepoMonth`,
        type: "GET",
        dataType: "json",
        success: function(dataResult) {
            if (dataResult.statusCode == 200) {
                //draw charts automatically
                var lineMonthChart = document
                    .getElementById("line-month-chart-repo-mv")
                    .getContext("2d");
                var lineMonthChart2 = document
                    .getElementById("bar-month-chart-repo-mv")
                    .getContext("2d");
                var lineMonthChart3 = document
                    .getElementById("pie-month-chart-repo-mv")
                    .getContext("2d");

                //////////////////////////////////////////////////////////////////////////////monhtly gross
                //perfom another get for gross
                var lineChartReport = new Chart(lineMonthChart, {
                    type: "line",
                    data: {
                        labels: dataResult.dates,
                        datasets: [{
                            label: '',
                            data: dataResult.totals,
                            fill: false,
                            borderColor: 'rgb(209, 31, 31)',
                            backgroundColor: 'rgb(209, 31, 31)',
                            borderColor: 'rgb(209, 31, 31)',
                            pointBorderColor: 'rgb(0, 0, 0)',
                            borderWidth: 4,
                            tension: 0.1
                        }]
                    },

                });
                //////////////////////////////////////////////////////////////////////////////monhtly till
                var lineChartReport2 = new Chart(lineMonthChart2, {
                    type: "line",
                    data: {
                        labels: dataResult.dates,
                        datasets: [{
                            label: 'Monthly Expense Trend',
                            data: dataResult.expense,
                            fill: false,
                            borderColor: 'rgb(20, 20, 243)',
                            backgroundColor: 'rgb(20, 20, 243)',
                            borderColor: 'rgb(20, 20, 243)',
                            pointBorderColor: 'rgb(0, 0, 0)',
                            borderWidth: 4,
                            tension: 0.1
                        }]
                    },

                });
                //////////////////////////////////////////////////////////////////////////////monhtly cash
                var lineChartReport3 = new Chart(lineMonthChart3, {
                    type: "line",
                    data: {
                        labels: dataResult.dates,
                        datasets: [{
                            label: '',
                            data: dataResult.cash,
                            fill: false,
                            borderColor: 'rgb(243, 239, 20)',
                            backgroundColor: 'rgb(243, 239, 20)',
                            borderColor: 'rgb(243, 239, 20)',
                            pointBorderColor: 'rgb(0, 0, 0)',
                            borderWidth: 4,
                            tension: 0.1
                        }]
                    },

                });
            } else {

            }
        }
    })
})
</script>