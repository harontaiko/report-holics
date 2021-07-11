<button class="previous-report" onclick="location.replace(`<?php echo URLROOT; ?>/pages/playstation`);" title="back"><i
        title="back" class="fas fa-arrow-left"></i></button>
<button title="print report" type="button" id="custom-print-report"
    onClick="printJS({ printable: 'container-out-report', type: 'html', style: '.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(1){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(3){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(2){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(4){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;}.container-out-report td:nth-child(5){border-color: #f1f1f1; border-right: 1px solid #ddd;background: white;} .container-out-report tr:nth-child(1){border-color: #f1f1f1; border-bottom: 1px solid #ddd;background: white;}'})">
    <i class=" fas fa-print"></i>
</button>
<section id="reports-tbl">
    <!--for demo wrap-->
    <h1 id="report-title">Daily Playstation <span>Report</span></h1>

    <table class="responstable" id="responstable">

        <tr>
            <th>Date</th>
            <th>Till income(Ksh)</th>
            <th>Cash income(Ksh)</th>
            <th>Net Total</th>
            <th>Created by</th>
            <th>Host Address</th>
        </tr>

        <?php 
                
                $m = getPsAllDate(date('Y-m-d', time()), $data['db']);
                while($mv = $m->fetch_assoc()):    
                ?>
        <tr>
            <td style="color: black;">
                <?php echo date('Y-m-d', strtotime(date('Y-m-d', time()))); ?></td>
            <td style="color: black;"><?php echo number_format($mv['cash']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['till']); ?></td>
            <td style="color: black;"><?php echo number_format($mv['cash'] + $mv['till']); ?>
            <td style="color: black;"><?php echo $mv['created_by']; ?>
            <td style="color: black;"><?php echo $mv['creator_ip']; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</section>
<div class="container-out-report" id="container-out-report">
    <h1 id="report-title">Daily Playstation <span>Report</span></h1>
    <table>
        <tr>
            <th>Date</th>
            <th>Cash income(Ksh)</th>
            <th>Till income(Ksh)</th>
            <th>Net Total</th>
            <th>Created by</th>
            <th>Host Address</th>
        </tr>

        <?php 
                
                $m = getPsAllDate(date('Y-m-d', time()), $data['db']);
                while($mv = $m->fetch_assoc()):    
                ?>
        <tr>
            <td><?php echo date('Y-m-d', strtotime(date('Y-m-d', time()))); ?></td>
            <td><?php echo number_format($mv['cash']); ?></td>
            <td><?php echo number_format($mv['till']); ?></td>
            <td><?php echo number_format($mv['cash'] + $mv['till']); ?></td>
            <td><?php echo $mv['created_by']; ?></td>
            <td><?php echo $mv['creator_ip']; ?></td>
        </tr>
        <?php endwhile; ?>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total Today: <?php
                  
                    echo number_format(getPsTotal(date('Y-m-d', time()), $data['db']));
                   
                     ?></td>
            </tr>
        </tfoot>
    </table>
    <div class="pie-chart-report-independent">
        <canvas id="pie-chart-repo-mv" style="height:180px; width:120px"></canvas>
    </div>

    <section id="realtime-charts">
        <div class="line-chart-report">
            <canvas id="line-chart-repo-mv" style="height:480px; width:520px"></canvas>
        </div>
        <div class="line2-chart-report">
            <canvas id="line2-chart-repo-mv" style="height:480px; width:520px"></canvas>
        </div>
        <div class="pie-chart-report">
            <canvas id="piee-chart-repo-mv" style="height:180px; width:120px"></canvas>
        </div>
    </section>
</div>
<!--line chart daily cyber report-->
<script>
//get Cyber report for today
$(document).ready(function() {
    $.ajax({
        url: `<?php echo URLROOT; ?>/pages/getCyberRepoToday`,
        type: "GET",
        dataType: "json",
        success: function(dataResult) {
            if (dataResult.statusCode == 200) {
                //draw charts automatically
                var pieChart = document
                    .getElementById("pie-chart-repo-mv")
                    .getContext("2d");

                //////////////////////////////////////////////////////////////////////////////pie
                var pieChartReport = new Chart(pieChart, {
                    type: "pie",
                    data: {
                        labels: ['cash', 'till', 'gross income'],
                        datasets: [{
                            label: 'Playstation Income Distribution',
                            data: [dataResult.movie.cash, dataResult.movie.till,
                                dataResult.movie.total
                            ],
                            backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 205, 86)'
                            ],
                            hoverOffset: 4
                        }]
                    },

                });
            } else {

            }
        }
    })
})
</script>