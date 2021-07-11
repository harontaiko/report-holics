<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="verify __verify">
    <div class="login-page">
        <h2 class="login-title">Daily Report Reset Password</h2>
        <?php if ($data['rows'] != 1) : ?>
        <div class="form">
            <form>
                <p class="reset-text">
                    The token has expired or no longer exists
                </p>
            </form>
        </div>
        <?php else: ?>
        <div class="form">
            <form action="<?php echo URLROOT; ?>/users/resetPassword" method="POST" class="login-form">
                <p class="login-err"><?php echo isset($data['err']) ? $data['err'] : ''; ?></p>
                <input name="passwordnew" id="passwordnew" type="password" placeholder="New password" required />
                <p class="login-err" id="passwordnew-err"></p>
                <input name="passwordnew-c" id="passwordnew-c" type="password" placeholder="Confirm password"
                    required />
                <p class="login-err" id="passwordnew-err-c"></p>
                <button type="submit" title="reset password" title="reset password" name="reset-pwd">Reset
                    Password</button>
                <p class="message" title="reset password">wrong place? <a href="<?php echo URLROOT; ?>">home</a></p>
            </form>
        </div>

        <?php endif; ?>
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