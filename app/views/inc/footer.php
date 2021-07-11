<noscript>
    <div id="no_script">This site requires and runs entirely on javascript, please Ensure Javascript
        is enabled
        on your browser for smooth & better experience</div>
</noscript>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="<?php echo URLROOT; ?>/public/javascript/fontawesome.min.js"></script>
<?php if (strpos($_SERVER['REQUEST_URI'], "pages/reports") !== false) :  ?>
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>
<?php elseif(strpos($_SERVER['REQUEST_URI'], 'pages/date') !== false): ?>
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<?php elseif(strpos($_SERVER['REQUEST_URI'], 'pages/invoice') !== false): ?>
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<?php elseif(strpos($_SERVER['REQUEST_URI'], 'pages/viewExpense') !== false): ?>
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<?php elseif(strpos($_SERVER['REQUEST_URI'], 'pages/viewItem') !== false): ?>
<script src="https://cdn.jsdelivr.net/npm/@mladenilic/threesixty.js/dist/threesixty.js"></script>
<?php elseif(strpos($_SERVER['REQUEST_URI'], 'pages/cashReceipt') !== false): ?>
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<?php elseif(strpos($_SERVER['REQUEST_URI'], 'pages/receipts') !== false): ?>
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<?php endif ?>
<script src="<?php echo URLROOT; ?>/public/theme/vendors/js/vendor.bundle.base.js"></script>
<?php if(strpos($_SERVER['REQUEST_URI'], 'pages/index') !== false): ?>
<script src="<?php echo URLROOT; ?>/public/theme/vendors/chart.js/Chart.min.js"></script>
<?php endif ?>
<script src="<?php echo URLROOT; ?>/public/theme/js/off-canvas.js"></script>
<script src="<?php echo URLROOT; ?>/public/theme/js/hoverable-collapse.js"></script>
<script src="<?php echo URLROOT; ?>/public/theme/js/misc.js"></script>
<script src="<?php echo URLROOT; ?>/public/theme/js/todolist.js"></script>
<script src="<?php echo URLROOT; ?>/public/javascript/main.min.js"></script>
<?php  $data['db']->close(); ?>