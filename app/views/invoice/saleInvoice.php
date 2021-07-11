<?php  
  $mv = getSaleItemById($data['id'],$data['db']);     
$arr = array();
while($mv2 = $mv->fetch_assoc()){
    array_push($arr, $mv2);
} 
?>
<button title="print invoice" type="button" class="print-invoice" id="custom-print-report"
    onClick="printJS({ printable: 'this-current-invoice', type: 'html', style: '      .company-name {font-size: 25px;text-align: center;font-weight: bold;}   .company-heading {font-size: 17px;text-align: center;}.company-image {position: relative;}.company-image img {float: left;top: 0px;left: 0px;right: 0px;bottom: 0px;width: 150px;position: absolute;}'})">
    <i class=" fas fa-print"></i>
</button>
<table style='width:100%;' id="this-current-invoice">
    <tr>
        <td>
            <style>
            .company-name {
                font-size: 25px;
                text-align: center;
                font-weight: bold;
            }

            .company-heading {
                font-size: 17px;
                text-align: center;
            }

            .company-image {
                position: relative;
            }

            .company-image img {
                float: left;
                top: 0px;
                left: 0px;
                right: 0px;
                bottom: 0px;
                width: 150px;
                position: absolute;
            }

            .top-header-div {
                border-top: 1px solid #000;
                display: flex;
            }

            .top-header-table {
                border: 1px solid #000;
                width: 100%;
                border-collapse: collapse;
            }

            .customer-table {
                float: left;
                width: 100%;
                padding: 0px;
                border-spacing: 0px;
            }

            .invoice-table {
                float: right;
                width: 100%;
                text-align: right;
            }

            .template1-invoice-heading {
                font-size: 25px;
                text-align: center;
                font-weight: bold;
            }

            .template2-invoice-heading {
                font-size: 30px;
                text-align: right;
                font-weight: bold;
            }

            #rightTable {
                border-collapse: collapse;
                padding: 0px;
                border-spacing: 0px;
                width: 100%
            }

            .leftCol {
                vertical-align: top;
                border-bottom: 1px solid #000;
                width: 50%;
                border-right: 1px solid #000;
            }

            .rightCol {
                vertical-align: top;
                border-bottom: 1px solid #000;
                width: 50%;
            }

            thead {
                display: table-header-group;
            }
            </style>
            <div class='company-heading'>
                <div class='company-name'>Holics Ent Shop</div><br>&#9993; ndenderuhub@gmail.com,
                &#9742;0724094086<br>
            </div><br style='clear:both' />
            <div class='template1-invoice-heading'>Sales Invoice</div>
            <table class='top-header-table'>
                <tr>
                    <td width=50% style='vertical-align:top;'>
                        <table class='customer-table' style='vertical-align:top;'>
                            <tr style="font-style:italic;font-weight:bold;">
                                <td>Bill To:</td>
                            </tr>
                            <tr style="font-weight:bold;">
                                <td>By jeff</td>
                            </tr>
                            <tr>
                                <td>&#9993; ndenderuhub@gmail.com</td>
                            </tr>
                            <tr>
                                <td>&#9742;0724094086</td>
                            </tr>
                        </table>
                    <td width=50% style='border-left:1px solid #000;vertical-align:top'>
                        <table id=rightTable>
                            <tr>
                                <td class='leftCol'>Invoice
                                    No<br><b>DR0<?php echo isset($arr['0']['sales_id']) ? $arr['0']['sales_id']: 'N/A'; ?></b>
                                <td class='rightCol'>
                                    Date<br><b><?php echo isset($arr['0']['date_created']) ? $arr['0']['date_created']: 'N/A'; ?></b>
                            <tr>
                                <td class='leftCol'>Purchase Order
                                    No<br><b>DR0<?php echo isset($arr['0']['sales_id']) ? $arr['0']['sales_id']: 'N/A'; ?></b>
                                <td class='rightCol'>Due
                                    Date<br><b><?php echo isset($arr['0']['date_created']) ? $arr['0']['date_created']: 'N/A'; ?></b>
                            <tr>
                                <td>&nbsp;
                        </table>
            </table>
            <style>
            td {
                border: none;
            }

            #itemTable {
                border: 1px solid #000;
                border-collapse: collapse;
            }

            #itemTable th {
                font-size: 16px;
                border: 1px solid #000;
                border-radius: 1px 0 0;
                text-align: center;
                font-weight: bold;
            }

            #itemTable td {
                border-left: 1px solid #000;
                border-right: 1px solid #000;
                border-top: none;
                border-bottom: none;
            }
            </style>
            <table id=itemTable width='100%' cellpadding=1>
                <thead>
                    <tr>
                        <th width=20>#
                        <th width=300>Description
                        <th width=30>HSN
                        <th>QTY
                        <th>Units
                        <th>Rate</th>
                        <th>Per</th>
                        <th>Discount
                        <th>Tax
                        <th>Amount
                    </tr>
                </thead>
                <tr>
                    <td style='text-align:left'>1</td>
                    <td><?php echo isset($arr['0']['sales_item']) ? $arr['0']['sales_item']: 'N/A'; ?></td>
                    <td>N/A
                    <td style='text-align:right'>1.00
                    <td>nos
                    <td align=right>
                        <?php echo isset($arr['0']['selling_price']) ? number_format($arr['0']['selling_price']): 'N/A'; ?>.00
                    </td>
                    <td align=left>ONE</td>
                    <td align=right>0%
                    <td>0.00
                    <td align=right>
                        <?php echo isset($arr['0']['selling_price']) ? number_format($arr['0']['selling_price']): 'N/A'; ?>.00
                    </td>
                </tr>
                <tr style='font-weight:bold'>
                    <td style='border-top:1px solid #000'>
                    <td style='border-top:1px solid #000' colspan='8' align=right>Subtotal </td>
                    <td style='border-top:1px solid #000' align=right>
                        <?php echo isset($arr['0']['selling_price']) ? number_format($arr['0']['selling_price']): 'N/A'; ?>.00
                    </td>
                </tr>
                <tr>
                    <th style='text-align: left;'>&nbsp;
                    <th style='text-align: left;' colspan=2>Total
                    <th style='text-align: right;'>
                        <?php echo isset($arr['0']['selling_price']) ? number_format($arr['0']['selling_price']): 'N/A'; ?>.00
                    <th style='text-align: left;'>&nbsp;
                    <th style='text-align: left;'>&nbsp;
                    <th style='text-align: left;'>&nbsp;
                    <th style='text-align: left;'>&nbsp;
                    <th style='text-align: left;' colspan=1>&nbsp;
                    <th style='text-align: right;font-weight:bold;'>
                        KES<?php echo isset($arr['0']['selling_price']) ? number_format($arr['0']['selling_price']): 'N/A'; ?>.00
        </td>
    </tr>
    <tr style='font-weight:regular;'>
        <td>
        <td style='text-align:right' colspan=8><b>Paid</b></td>
        <td align=right>
            <b>KES<?php echo isset($arr['0']['selling_price']) ? number_format($arr['0']['selling_price']): 'N/A'; ?>.00</b>
        </td>
    </tr>
    <tr style='font-weight:regular;'>
        <td></td>
        <td style='text-align:right' colspan=8><b>Balance</b></td>
        <td align=right style='color:#008200'><b>KES0.00</b></td>
    </tr>
</table>
<div style='margin-left: 100px;margin-top: -50px;' align=left>
    <div
        style='width: 120px;height: 50px;border: 5px solid #F93131;text-align: center;vertical-align:middle;display: table-cell;-ms-transform: rotate(-27deg);-webkit-transform: rotate(-27deg);transform: rotate(-27deg);'>
        <h1>
            <font color=#F93131 face=helvetica,Ariel,Lucida Console>PAID</font>
        </h1>
    </div>
</div>
<table class='top-header-table'>
    <tr>
        <td><br><br>
            <table width=100%>
                <tr>
                    <td width=70%><span contenteditable>We declare that this invoice shows the actual price of the
                            goods described and that all particulars are true and correct.</span></td>
                    <td width=30%; align=right valign=bottom>
                        <table width=100%>
                            <tr>
                                <td align=right>
                            <tr>
                                <td align=right>Authorized Signatory
                        </table>
            </table>
</table>
<div class='company-heading'>This is a computer generated invoice</div>
</table>