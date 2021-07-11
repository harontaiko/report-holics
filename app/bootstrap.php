<?php
//load config
require "config/config.php";
require "helpers/ip_address_helper.php";
require "helpers/sql_query_helper.php";
require "helpers/url_helper.php";
require "helpers/mail_helper.php";
require "helpers/session_helper.php";
require "helpers/time_helper.php";
require "helpers/receipt_helper.php";
require "helpers/fetch_helper.php";

//AUTO LOAD CORE
spl_autoload_register(function ($className) {
  require "libraries/" . $className . ".php";
});

//create db schema
$schema = new Schema();