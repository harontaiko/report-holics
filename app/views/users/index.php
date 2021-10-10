<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="login _login">
    <div class="login-page">
        <?php flash('resetsuccess'); ?>

        <h2 class="login-title">Daily Report</h2>
        <div class="form auth-form-light text-left p-5">
            <form action="<?php echo URLROOT; ?>/users/recover" method="POST" class="register-form">
                <input name="username-recover" type="text" placeholder="enter your username" required />
                <button type="submit" name="recover-email" title="link is sent to associated email">send recovery
                    link</button>
                <p class="message">wrong place? <a href="#" title="back to login">back</a></p>
            </form>
            <form action="<?php echo URLROOT; ?>/users/login" method="POST" class="login-form">
                <img src="<?php echo URLROOT; ?>/public/images/images/dailyhackstore.ico" class="img-fluid auth-logo">
                <p class="login-err"><?php echo isset($data['err']) ? $data['err'] : ''; ?></p>
                <div class="form-group">
                    <input name="username" class="form-control form-control-lg" type="text" placeholder="username"
                        required value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>" />
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" name="password" id="login-pwd" type="password"
                        placeholder="password" required />
                </div>
                <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn"
                    title="login" title="login" name="login">login</button>
                <p class="message" title="reset password">Forgot password? <a
                        href="<?php echo URLROOT;?>/users/resetpage">reset</a></p>
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