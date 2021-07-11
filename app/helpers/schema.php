<?php

//movieshop table
$movieshop_table =
  '
CREATE TABLE ' .
  $this->DB_PREFIX .
  '_movieshop( 
 record_id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
 cash varchar(64) NOT NULL,
 till varchar(64) NOT NULL,
 date_created varchar(64) NOT NULL,
 time_created varchar(64) NOT NULL,
 created_by varchar(256) NOT NULL,
 edited_by varchar(256) NULL,
 creator_ip varchar(256) NULL
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
';

//cybershop table
$cybershop_table =
  '
CREATE TABLE ' .
  $this->DB_PREFIX .
  '_cybershop( 
 record_id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
 cash varchar(64) NOT NULL,
 till varchar(64) NOT NULL,
 date_created varchar(64) NOT NULL,
 time_created varchar(64) NOT NULL,
 created_by varchar(256) NOT NULL,
 edited_by varchar(256) NULL,
 creator_ip varchar(256) NULL
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
';

//playstation table
$playstation_table =
  '
CREATE TABLE ' .
  $this->DB_PREFIX .
  '_playstation( 
 record_id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
 cash varchar(64) NOT NULL,
 till varchar(64) NOT NULL,
 date_created varchar(64) NOT NULL,
 time_created varchar(64) NOT NULL,
 created_by varchar(256) NOT NULL,
 edited_by varchar(256) NULL,
 creator_ip varchar(256) NULL
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
';

$sales_table =
  '
CREATE TABLE ' .
  $this->DB_PREFIX .
  '_sales( 
sales_id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
sales_item varchar(64) NULL,
buying_price varchar(64) NULL,
selling_price varchar(64) NULL,
cash varchar(64) NULL,
till varchar(64) NULL,
profit varchar(64) NULL,
date_created varchar(64) NOT NULL,
time_created varchar(64) NOT NULL,
created_by varchar(256) NOT NULL,
edited_by varchar(256) NULL,
creator_ip varchar(256) NULL
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
';

$expenses_table =
  '
CREATE TABLE ' .
  $this->DB_PREFIX .
  '_expenses( 
expense_id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
expense_item varchar(64) NULL,
expense_cost int(11) NULL,
date_created varchar(64) NOT NULL,
time_created varchar(64) NOT NULL,
created_by varchar(256) NOT NULL,
edited_by varchar(256) NULL,
creator_ip varchar(256) NULL
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
';

$nettotal_table =
  '
CREATE TABLE ' .
  $this->DB_PREFIX .
  '_nettotal( 
sales_id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
total_sales varchar(64) NULL,
totalprofit varchar(256) NULL,
totalincome varchar(256) NULL,
totalexpense varchar(256) NULL,
cash_sales varchar(64) NULL,
till_sales varchar(64) NULL,
date_created varchar(64) NOT NULL,
time_created varchar(64) NOT NULL,
created_by varchar(256) NOT NULL,
edited_by varchar(256) NULL,
creator_ip varchar(256) NULL
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
';

$user_table = 
'
CREATE TABLE ' .
  $this->DB_PREFIX .
  '_user( 
user_id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
username varchar(64) NOT NULL,
email varchar(64) NOT NULL,
password varchar(64) NOT NULL,
is_admin varchar(64) NULL,
date_created varchar(64) NOT NULL,
time_created varchar(64) NOT NULL,
created_by varchar(256) NOT NULL,
edited_by varchar(256) NULL,
creator_ip varchar(256) NULL,
reset_link varchar(256) NULL
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
';

$inventory_table = 
'
CREATE TABLE ' .
  $this->DB_PREFIX .
  '_inventory( 
item_id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
item_name varchar(64) NOT NULL,
item_quantity varchar(64) NOT NULL,
item_buying varchar(64) NOT NULL,
item_model varchar(64) NOT NULL,
image varchar(64) NULL,
date_created varchar(64) NOT NULL,
time_created varchar(64) NOT NULL,
created_by varchar(256) NOT NULL,
edited_by varchar(256) NULL,
creator_ip varchar(256) NULL
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
';

$login_table =
'
CREATE TABLE ' .
  $this->DB_PREFIX .
  '_login( 
user_id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
login_count varchar(64) NOT NULL,
is_admin varchar(64) NULL,
date_logged varchar(64) NOT NULL,
time_logged varchar(64) NOT NULL,
user_ip varchar(256) NULL
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
';

$cashout =
'
CREATE TABLE ' .
  $this->DB_PREFIX .
  '_cashout( 
cash_id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
cash_amount varchar(64) NOT NULL,
cash_usage varchar(64) NOT NULL,
cash_from varchar(64) NULL,
cash_handler varchar(64) NULL,
cash_receipt_number varchar(64) NULL,
date_created varchar(64) NOT NULL
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
';

$stock =
'
CREATE TABLE ' .
  $this->DB_PREFIX .
  '_stock( 
stock_id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
in_stock varchar(64) NOT NULL,
out_stock varchar(64) NULL
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
';