<section id="reports-tbl">

    <button title="print report" class="btn btn-gradient-success" type="button" id="custom-print-report"
        onClick="printJS({ printable: 'container-out-report2', type: 'html', style: '.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(1){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(3){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(4){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(5){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;} .container-out-report tr:nth-child(1){border-color: #f1f1f1; border-bottom: 1px solid #ddd;background: white;}'})">
        <i class=" fas fa-print"></i>
    </button>
    <h1 id="report-title">Weekly Playstation <span>Report</span></h1>

    <table class="responstable table table-striped mb-4" id="responstable">

        <tr>
            <th>Week</th>
            <th>Weekly Cash income(Ksh)</th>
            <th>Weekly Till income(Ksh)</th>
            <th>Weekly Net Total</th>
        </tr>

        <?php 
        
        $m = getPsAllWeekNet($data['db']);
        while($mv = $m->fetch_assoc()):    
        ?>
        <tr>
            <td style="color: black;">
                <?php echo 'Week '. $mv['DATE_FORMAT(date_created, "%U")']; ?></td>
            <td style="color: black;"><?php echo number_format($mv['total_cash']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['total_till']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['net_total']); ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</section>
<div class="container-out-report" id="container-out-report2">
    <h1 id="report-title">Weekly Playstation <span>Report</span></h1>

    <table class="table table-striped">
        <tr>
            <th>Week</th>
            <th>Weekly Cash income(Ksh)</th>
            <th>Weekly Till income(Ksh)</th>
            <th>Weekly Net Total</th>
        </tr>

        <?php 
        
        $m = getPsAllWeekNet($data['db']);
        while($mv = $m->fetch_assoc()):    
        ?>
        <tr>
            <td style="color: black;">
                <?php echo 'Week '. $mv['DATE_FORMAT(date_created, "%U")']; ?></td>
            <td style="color: black;"><?php echo number_format($mv['total_cash']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['total_till']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['net_total']); ?>
            </td>
        </tr>
        <?php endwhile; ?>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td>Weekly total: <?php
                    echo number_format(getPsTotalWeek( $data['db']));
                     ?></td>
            </tr>
        </tfoot>
    </table>
    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
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
    <!--line chart daily movie report-->
    <script>
    //get movie shop report for today
    $(document).ready(function() {
        $.ajax({
            url: `<?php echo URLROOT; ?>/pages/getPsRepoWeek`,
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
                    console.log(dataResult.till);
                    //////////////////////////////////////////////////////////////////////////////weekly gross
                    //perfom another get for gross
                    var lineChartReport = new Chart(lineMonthChart, {
                        type: "line",
                        data: {
                            labels: dataResult.weeks,
                            datasets: [{
                                label: 'Gross Weekly Income Movie Shop',
                                data: dataResult.gross,
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
                    //////////////////////////////////////////////////////////////////////////////weekly till
                    var lineChartReport2 = new Chart(lineMonthChart2, {
                        type: "line",
                        data: {
                            labels: dataResult.weeks,
                            datasets: [{
                                label: 'Till Weekly Income Movie Shop',
                                data: dataResult.till,
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
                                label: 'Cash Weekly Income Movie Shop',
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