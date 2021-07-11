<div class="content-wrapper">

    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>
            </span> Dashboard
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Weekly Sales <i
                            class="mdi mdi-chart-line mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Ksh <?php echo number_format(getSalesTotalWeek($data['db'])); ?></h2>
                    <h6 class="card-text">Increased by 60%</h6>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Weekly Income <i
                            class="mdi mdi-cash-multiple mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Ksh <?php echo number_format(getNetTotalWeek($data['db'])); ?></h2>
                    <h6 class="card-text">Decreased by 10%</h6>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Current Gross <i
                            class="mdi mdi-cash-usd mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Ksh <?php echo number_format(getNetTotalYear($data['db'])); ?></h2>
                    <h6 class="card-text">Increased by 5%</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Total Items Sold <i
                            class="mdi mdi-layers mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?php echo number_format(getItemsSold($data['db'])); ?> items</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Items In Stock <i
                            class="mdi mdi-scale-balance mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?php echo number_format(getItemsInStock($data['db'])); ?> items</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Average daily Income <i
                            class="mdi mdi-cash-100 mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Ksh <?php echo number_format(getAverageDailyIncome($data['db'])); ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        <h4 class="card-title float-left">Sales Monthly Statistics</h4>
                        <div id="visit-sale-chart-legend"
                            class="rounded-legend legend-horizontal legend-top-right float-right"></div>
                    </div>
                    <canvas id="visit-sale-chart" class="mt-4"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top Items Sold This Month</h4>
                    <canvas id="traffic-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Most Recent Sales</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> Date </th>
                                    <th> Item </th>
                                    <th> Bought </th>
                                    <th> Sold </th>
                                    <th> Net Profit </th>
                                    <th> Made By </th>
                                    <th> Invoice </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sale = getMostRecentSales($data['db']);  while ($x = $sale->fetch_assoc()):  ?>
                                <tr>
                                    <td><?php echo date('jS F Y', strtotime($x['date_created']));  ?></td>
                                    <td><?php echo $x['sales_item'] ?></td>
                                    <td><?php echo 'Ksh '.$x['buying_price'] ?></td>
                                    <td><?php echo 'Ksh '.$x['selling_price'] ?></td>
                                    <td><strong><?php echo 'Ksh '.$x['profit'] ?></strong></td>
                                    <td>
                                        <img src="<?php echo URLROOT; ?>/public/images/images/avatar.png" class="mr-2"
                                            alt="image"> David Grey
                                    </td>
                                    <td> <a
                                            href="<?php echo URLROOT; ?>/pages/invoice/sale/<?php echo $x['sales_id']; ?>">invoice</a>
                                    </td>
                                </tr>
                                <?php endwhile ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Admins</h4>
                    <div class="text-right">
                        <a href="<?php echo URLROOT; ?>/users/createUser"
                            class="text-right btn btn-lg btn-gradient-success">create user</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> Name </th>
                                    <th> Created On </th>
                                    <th> Last Address </th>
                                    <th> Last Seen </th>
                                    <th> Logins </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $admin = getCurrentAdmins($data['db']); while($y = $admin->fetch_assoc()): ?>
                                <tr>
                                    <td> <?php echo $y['user_id'] ?> </td>
                                    <td> <?php echo findUserById($y['user_id'], $data['db']) ?> </td>
                                    <td> <?php echo findDateMadeById($y['user_id'],$data['db']) ?> </td>
                                    <td>
                                        <?php echo $y['user_ip'] ?>
                                    </td>
                                    <td><?php echo date('jS F Y', strtotime($y['date_logged']));  ?> at
                                        <?php echo date('h:i:s A', strtotime($y['time_logged']));  ?></td>
                                    <td> <?php echo $y['login_count'] ?></td>
                                </tr>
                                <?php endwhile ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>
<script>
$(document).ready(function() {
    $.ajax({
        url: `<?php echo URLROOT; ?>/pages/getSalesRepoMonth`,
        type: "GET",
        dataType: "json",
        success: function(dataResult) {
            if (dataResult.statusCode == 200) {
                //draw charts automatically
                var pieChart = document
                    .getElementById("traffic-chart")
                    .getContext("2d");
                var lineMonthChart2 = document
                    .getElementById("visit-sale-chart")
                    .getContext("2d");


                //////////////////////////////////////////////////////////////////////////////most sold item
                //perfom another get for gross
                var pieChartReport = new Chart(pieChart, {
                    type: "pie",
                    data: {
                        labels: dataResult.labels,
                        datasets: [{
                            label: 'Most Sold Items This Month',
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
                            label: 'Monthly Sales',
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

            } else {

            }
        }
    })
})
</script>