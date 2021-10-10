<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="login _login">
    <div class="login-page">
        <?php flash('resetsuccess'); ?>

        <h2 class="login-title">Reset Password</h2>
        <div class="form auth-form-light text-left p-5">
            <form action="<?php echo URLROOT; ?>/users/recover" method="POST">
                <input name="username-recover" type="text" placeholder="enter your username" required />
                <button type="submit" name="recover-email" title="link is sent to associated email">send recovery
                    link</button>
                <p class="message">wrong place? <a href="<?php echo URLROOT;?>/users/index"
                        title="back to login">back</a></p>
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