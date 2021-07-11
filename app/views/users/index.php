<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="login __login">
    <div class="login-page">
        <?php flash('resetsuccess'); ?>

        <h2 class="login-title">Daily Report</h2>
        <div class="form">
            <form action="<?php echo URLROOT; ?>/users/recover" method="POST" class="register-form">
                <input name="username-recover" type="text" placeholder="enter your username" required />
                <button type="submit" name="recover-email" title="link is sent to associated email">send recovery
                    link</button>
                <p class="message">wrong place? <a href="#" title="back to login">back</a></p>
            </form>
            <form action="<?php echo URLROOT; ?>/users/login" method="POST" class="login-form">
                <i class="mdi mdi-lock icon-lg"></i>
                <p class="login-err"><?php echo isset($data['err']) ? $data['err'] : ''; ?></p>
                <input name="username" type="text" placeholder="username" required
                    value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>" />
                <input name="password" id="login-pwd" type="password" placeholder="password" required />
                <button type="submit" title="login" title="login" name="login">login</button>
                <p class="message" title="reset password">Forgot password? <a href="#">reset</a></p>
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