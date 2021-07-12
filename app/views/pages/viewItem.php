<?php require(APPROOT . '/views/inc/header.php'); ?>

<body class="viewItem __viewItem">
    <div class="container-scroller">
        <?php require(APPROOT . '/views/inc/navbar.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php require(APPROOT . '/views/inc/sidebar.php'); ?>

            <div class="main-panel">
                <?php include APPROOT .'/views/content/viewitem.php'; ?>
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="container-fluid clearfix">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright ©
                            Holics Ent 2020</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> created by <a href="#"
                                target="_blank">the fundraiser</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</body>
<?php require(APPROOT . '/views/inc/footer.php'); ?>

</html>