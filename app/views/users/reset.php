<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="login __login">
    <div class="login-page">
        <h2 class="login-title">Daily Report Reset Password</h2>
        <div class="form">
            <form>
                <p class="reset-text">A password reset link has been sent to
                    <span class="email-recover"><?php echo isset($data['email']) ? $data['email'] : ''; ?></span>
                <p><a href="<?php echo URLROOT; ?>"><i class="fas fa-undo"></i></a></p>
                </p>
            </form>
        </div>
    </div>
</body>

<noscript>
    <div id="no_script">This site requires and runs entirely on javascript, please Ensure Javascript
        is enabled
        on your browser for smooth & better experience</div>
</noscript>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="<?php echo URLROOT; ?>/public/javascript/main.min.js"></script>

</html>