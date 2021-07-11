<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="removeItem __removeItem site-wrap">
    <?php require(APPROOT . '/views/inc/navbar.php'); ?>
    <div class="alert alert_success" id="alert_add">
        <p id="add-alert"></p>
    </div>
    <div class="confirm">
        <h1><strong>Confirm your action</strong></h1>
        <p>Are you <strong>really</strong> sure that you want to delete this item?
        </p>
        <input type="hidden" id="item-id" value="<?php echo isset($data['id']) ? $data['id']: ''; ?>">
        <button id="cancel-remove">Cancel</button>
        <button autofocus id="accept-remove">Confirm</button>
    </div>
</body>

<?php require(APPROOT . '/views/inc/footer.php'); ?>

</html>