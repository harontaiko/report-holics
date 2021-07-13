<?php

function getMostRecentSales($db)
{
    $query = 'SELECT sales_id, sales_item, sales_id, selling_price, buying_price, profit, date_created, created_by FROM dr_sales ORDER BY sales_id DESC LIMIT 6';
        
    $result = SelectCondFree($query, 'dr_sales', $db);
        
    $row = $result->get_result();
        
    try {
        return $row;
    } catch (Error $e) {
        return false;
    } 
}

function getCurrentAdmins($db)
{
    $query = 'SELECT `user_id`, login_count, date_logged, time_logged, user_ip FROM dr_login WHERE `user_id` !=? ORDER BY `user_id` ASC';
    
    $binders = "s";

    $param = array(3);
    
    $result = SelectCond($query, $binders, $param, $db);
        
    $row = $result->get_result();
        
    try {
        return $row;
    } catch (Error $e) {
        return false;
    } 
}

function findUserById($id, $db)
{
    $query = 'SELECT username FROM dr_user WHERE `user_id` = ?';

    $binders = "s";

    $parameters = array($id);

    $result = SelectCond($query, $binders, $parameters, $db);

    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();

    $name = isset($rowItem['username']) ? $rowItem['username'] : 'N/A';
  
    try {
        return $name;
    } catch (Error $e) {
        return false;
    }
}

function findDateMadeById($id, $db)
{
    $query = 'SELECT date_created FROM dr_user WHERE `user_id` = ?';

    $binders = "s";

    $parameters = array($id);

    $result = SelectCond($query, $binders, $parameters, $db);

    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();

    $date = isset($rowItem['date_created']) ? $rowItem['date_created'] : 'N/A';
  
    try {
        return $date;
    } catch (Error $e) {
        return false;
    }
}