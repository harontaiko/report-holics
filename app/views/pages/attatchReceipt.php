<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="attatchReceipt __attatchReceipt site-wrap">
    <?php require(APPROOT . '/views/inc/navbar.php'); ?>
    <main style="padding: 2rem;">
        <h1>Upload scanned Receipt <span>Here</span></h1>

        <form method="post" class="file-uploader" action="" enctype="multipart/form-data">
            <div class="file-uploader__message-area">
                <p>Select a file to upload</p>
            </div>
            <div class="file-chooser">
                <input class="file-chooser__input" type="file" multiple>
            </div>
            <input class="file-uploader__submit-button" type="submit" value="Upload">
        </form>
    </main>
</body>

<?php require(APPROOT . '/views/inc/footer.php'); ?>

</html>