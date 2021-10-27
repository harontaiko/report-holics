<section id="reports-tbl">

    <button title="print report" type="button" class="btn btn-gradient-success" id="custom-print-report"
        onClick="printJS({ printable: 'container-out-report2', type: 'html', style: '.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(1){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(3){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(4){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(5){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;} .container-out-report tr:nth-child(1){border-color: #f1f1f1; border-bottom: 1px solid #ddd;background: white;}'})">
        <i class=" fas fa-print"></i>
    </button>
    <h1 id="report-title">Weekly Sales <span>Report</span></h1>

    <table class="responstable table table-striped mb-4" id="responstable">

        <tr>
            <th>Week</th>
            <th>Weekly Sales Amount (Ksh)</th>
            <th>Weekly Profit (Ksh)</th>
        </tr>

        <?php 
        
        $m = getSalesAllWeekNet($data['db']);
        while($mv = $m->fetch_assoc()):    
        ?>
        <tr>
            <td style="color: black;">
                <?php echo $mv['DATE_FORMAT(date_created, "%U")']; ?></td>
            <td style="color: black;"><?php echo number_format($mv['selling']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['sales_net']); ?></td>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</section>
<div class="container-out-report" id="container-out-report2">
    <h1 id="report-title">Weekly Sales <span>Report</span></h1>

    <table class="table table-striped">
        <tr>
            <th>Week</th>
            <th>Weekly Sales Amount (Ksh)</th>
            <th>Weekly Profit (Ksh)</th>
        </tr>

        <?php 
        
        $m = getSalesAllWeekNet($data['db']);
        while($mv = $m->fetch_assoc()):    
        ?>
        <tr>
            <td style="color: black;">
                <?php echo  $mv['DATE_FORMAT(date_created, "%U")']; ?></td>
            <td style="color: black;"><?php echo number_format($mv['selling']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['sales_net']); ?></td>
            </td>
        </tr>
        <?php endwhile; ?>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td>Gross: <?php
                    echo number_format(getSalesTotalWeek($data['db']));           
                     ?></td>
            </tr>
        </tfoot>
    </table>
    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        <h4 class="card-title float-left">2 Most Sold Items This Week</h4>
                    </div>
                    <canvas id="line-month-chart-repo-mv" class="mt-4" style="height:380px; width:420px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"></h4>
                    <canvas id="bar-month-chart-repo-mv" style="height:380px; width:420px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"></h4>
                    <canvas id="pie-month-chart-repo-mv" style="height:380px; width:420px"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<!--line chart daily movie report-->
<script>
//get movie shop report for today
$(document).ready(function() {
    $.ajax({
        url: `<?php echo URLROOT; ?>/pages/getSalesRepoWeek`,
        type: "GET",
        dataType: "json",
        success: function(dataResult) {
            if (dataResult.statusCode == 200) {
                //draw charts automatically
                var pieChart = document
                    .getElementById("line-month-chart-repo-mv")
                    .getContext("2d");
                var lineMonthChart2 = document
                    .getElementById("bar-month-chart-repo-mv")
                    .getContext("2d");
                var lineMonthChart3 = document
                    .getElementById("pie-month-chart-repo-mv")
                    .getContext("2d");

                //////////////////////////////////////////////////////////////////////////////most sold item
                //perfom another get for gross
                var pieChartReport = new Chart(pieChart, {
                    type: "pie",
                    data: {
                        labels: dataResult.labels,
                        datasets: [{
                            label: 'Most Sold Items This week',
                            data: dataResult.cost,
                            backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 205, 86)'
                            ],
                            hoverOffset: 4
                        }]
                    },

                });
                //////////////////////////////////////////////////////////////////////////////weekly till
                var lineChartReport2 = new Chart(lineMonthChart2, {
                    type: "line",
                    data: {
                        labels: dataResult.weeks,
                        datasets: [{
                            label: 'Weekly Sales',
                            data: dataResult.sales,
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
                //////////////////////////////////////////////////////////////////////////////weekly cash
                var lineChartReport3 = new Chart(lineMonthChart3, {
                    type: "line",
                    data: {
                        labels: dataResult.weeks,
                        datasets: [{
                            label: 'Weekly Sales Profit',
                            data: dataResult.profits,
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