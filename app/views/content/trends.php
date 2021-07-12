<div class="content-wrapper">
    <div id="focus" tabindex="0"></div>
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-chart-areaspline"></i>
            </span> Trends
        </h3>
    </div>

    <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Items Sold <i
                            class="mdi mdi-chart-line mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?php echo number_format($data['sold']); ?> items</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Items In Stock <i
                            class="mdi mdi-cash-multiple mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?php echo number_format($data['stock']); ?> items</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Out Of Stock <i
                            class="mdi mdi-cash-usd mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?php echo number_format($data['out']); ?> items</h2>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Created(Weekly) <i
                            class="mdi mdi-cash-usd mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?php echo number_format($data['weeklycount']); ?> items</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Tota Income <i
                            class="mdi mdi-cash-usd mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Ksh <?php echo number_format($data['row']['0']['incometotal']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Total Income <i
                            class="mdi mdi-cash-usd mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Ksh <?php echo number_format($data['row']['0']['till_total']); ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Total Cash <i class="mdi mdi-cash-usd mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Ksh <?php echo number_format($data['row']['0']['cash_total']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Total Profit <i
                            class="mdi mdi-cash-usd mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Ksh <?php echo number_format($data['row']['0']['profittotal']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Total Sales <i
                            class="mdi mdi-cash-usd mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Ksh <?php echo number_format($data['row']['0']['sales_total']); ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-primary card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Average daily Sales <i
                            class="mdi mdi-cash-usd mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Ksh <?php echo number_format($data['avgsales']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Average daily Cash<i
                            class="mdi mdi-cash-usd mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Ksh <?php echo number_format($data['avgcash']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Average daily Till<i
                            class="mdi mdi-cash-usd mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Ksh <?php echo number_format($data['avgtill']); ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">Average daily Income<i
                            class="mdi mdi-cash-usd mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Ksh <?php echo number_format($data['avgincome']); ?></h2>
                </div>
            </div>
        </div>
    </div>


</div>