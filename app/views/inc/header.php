<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="host" href="<?php echo URLROOT; ?>">
    <link rel="canonical" href="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" />
    <meta name="og:url" content="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="icon" href="<?php echo URLROOT; ?>/public/images/images/dailyhackstore.ico" type="image/ico" />
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/public/images/images/dailyhackstore.ico" type="image/ico" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/theme/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/theme/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/theme/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/stylesheets/css/style.css">
    <title><?php echo $data['title']; ?></title>

</head>