<div class="content-wrapper">
    <div id="focus" tabindex="0"></div>
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="fas fa-cash-register fa-2x"></i>
            </span> Cashout Receipt
        </h3>
        <a href="Javascript.history.go(-1)" class="btn btn-gradient-info text-right">back</a>
    </div>
    <div class="hidden-stufff" style="display:none;">
        <input type="text" id="amount" value="<?php print_r($data['val']['0']); ?>">
        <input type="text" id="usage" value="<?php print_r($data['val']['1']); ?>">
        <input type="text" id="from" value="<?php print_r($data['val']['2']); ?>">
        <input type="text" id="date__" value="<?php print_r($data['val']['3']); ?>">
        <input type="text" id="handler" value="<?php print_r($data['val']['4']); ?>">
        <input type="text" id="receipt" value="<?php print_r($data['val']['5']); ?>">
    </div>
    <div class="betslip-container" id="betslip-container">
        <div class="betslip-header-container">
            <div class="betslip-type-container">
                <span class="betslip-type">Cash Out Receipt</span>
                <span class="betslip-bet-count">:</span>
                <span class="betslip-odds"><?php print_r($data['val']['5']); ?></span>
            </div>
        </div>
        <div class="betslip-system">

        </div>
        <div class="betslip-clear">
            <span><?php print_r($data['val']['3']); ?></span>
        </div>
        <div class="betslip-pick-container">
            <div class="betslip-pick">
                <div class="pick-dismiss">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div class="pick-details">
                    <span>Taken From: <?php print_r($data['val']['2']); ?></span><br />
                </div>
                <div class="pick-odds"><?php print_r(number_format($data['val']['0'])); ?>/=</div>
            </div>
            <div class="betslip-pick">
                <div class="pick-dismiss">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div class="pick-details">
                    <span>Usage: <?php print_r($data['val']['1']); ?></span><br />
                </div>
                <div class="pick-odds">N/A</div>
            </div>
            <div class="betslip-pick">
                <div class="pick-dismiss">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div class="pick-details">
                    <span>By: <?php print_r($data['val']['4']); ?></span><br />
                </div>
                <div class="pick-odds">N/A</div>
            </div>
        </div>

        <div class="betslip-accumulators">
            <div class="accumulator-name">
                Total
            </div>
            <div class="accumulator-amount">
                <input value="<?php print_r(number_format($data['val']['0'])); ?>/=" readonly />
            </div>
        </div>
        <div>
        </div>
        <div class="betslip-submit">
            <button class="betslip-submit-button" id="save-cashout"> Confirm And Save</button>
        </div>
        <div class="betslip-submit">
            <button onclick="location.replace(`<?php echo URLROOT; ?>/pages/cashOut`);" class="betslip-submit-button"
                style="background: #d22c2c;color: #fff;">Go
                Back And Make
                Changes</button>
        </div>
        <I class="fas fa-print" style="cursor:pointer;float:right;margin-top: -0.6rem;"
            onClick="printJS({ printable: 'betslip-container', type: 'html', style: '#betslip-container{border:1.3px solid #333;}.betslip-submit-button{display:none;}fa-print{display:none;}.betslip-container{padding:0.6rem;margin:auto 5rem auto 5rem;border-top:4px solid #ffe71f;border-radius:5px;width:375px;background-color:#222;color:white;height:-webkit-fit-content;height:-moz-fit-content;height:fit-content}.betslip-header-container{font-size:20px;background-color:#333;color:#999;padding-right:16px;padding-left:16px}.betslip-type-container{padding:10px}.betslip-type{font-weight:bold;font-family:sans-serif}.betslip-system{display:-webkit-box;display:-ms-flexbox;display:flex;width:100%}.betslip-system-tab{color:#999;background-color:#333;font-size:16px;width:33.33%;border:none;cursor:pointer;padding:14px 16px}.betslip-clear{text-align:right;color:#999;font-size:14px;padding:10px;text-decoration:underline}.betslip-pick{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-direction:row;flex-direction:row;-webkit-box-align:stretch;-ms-flex-align:stretch;align-items:stretch;width:100%}.betslip-pick div{display:inline-block;border:1px solid grey;padding:10px}.betslip-pick .pick-details{width:60%}.betslip-pick .pick-odds{-webkit-box-flex:1;-ms-flex:1;flex:1;float:right}.pick-dismiss{font-size:2em}.pick-details{font-size:12px}.betslip-accumulator{display:-webkit-box;display:-ms-flexbox;display:flex}.accumulator-name{display:inline-block;padding:10px;font-weight:bold}.accumulator-amount{display:inline-block;float:right;padding:10px}.accumulator-amount input{width:60px;border-radius:5px}.betslip-cashout{background-color:green;border:none;margin:10px;color:white}.betslip-details{padding:10px;font-size:12px;color:#999;border:1px solid #333}.betslip-total-stake-value,.betslip-total-odds-value,.betslip-potential-payout-value{float:right;font-size:12px;font-weight:bold;color:white}.betslip-submit{width:100%;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.betslip-submit-button{width:90%;background-color:#ffe71f;margin:10px;height:30px;border:none;border-radius:5px;font-size:16px;font-weight:bold}'})"></I>
    </div>

    <div class="load-wrapp">
        <div class="load-5">
            <p>saving..</p>
            <div class="ring-2">
                <div class="ball-holder">
                    <div class="ball"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert_failed" id="alert_add" style="background: #c70c0c">
        <p id="add-alert"></p>
    </div>
</div>