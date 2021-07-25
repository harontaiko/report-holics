<?php


/**
 * select all values from the table given in the Query instance
 */
function selectAll($table, $db)
{
  /* mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); */
  $query = "SELECT * FROM " . $table . "";

  //SECURE STMT'S
  $stmt = $db->prepare($query);
  $stmt->execute();

  return $stmt;
}

/**
 * last inserted id
 *
 * obsolete, doesnt work
 */
function LastInsertedId($db)
{
  $query = "SELECT LAST_INSERT_ID()";

  $stmt = $db->prepare($query);
  $stmt->execute();

  return $stmt;
}


/**
 * select count only from given table i.e. total number of values in a table
 *
 * number only!
 */
function selectCount($table, $db)
{
  $query = "SELECT COUNT(*) AS qns FROM " . $table . "";

  //SECURE STMT'S
  $stmt = $db->prepare($query);
  $stmt->execute();

  return $stmt;
}

/**
 * select data in descending order from latest to oldest no max value
 *
 * select all values from the table given in the Query instance
 *
 * without a limit
 */
function SelectAllLatest($ORDER_VALUE, $table, $db)
{
  $query = "SELECT * FROM " . $table . " ORDER BY " . $ORDER_VALUE . " DESC";

  $stmt = $db->prepare($query);
  $stmt->execute();

  return $stmt;
}

/**
 * select data in descending order from latest to oldest WITH LIMIT
 *
 * select all values from the table given in the Query instance
 *
 * with a limit
 */
function SelectAllLatestLimit($ORDER_VALUE_, $limit, $table, $db)
{
  /*         mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); */
  $query =
    "SELECT * FROM " .
    $table .
    " ORDER BY " .
    $ORDER_VALUE_ .
    " DESC LIMIT " .
    $limit .
    "";

  $stmt = $db->prepare($query);
  $stmt->execute();

  return $stmt;
}

/**
 * inserts data into a database without conditions

 * placeholders are in the form ?, ? ... 

 * $fields, $values and $placeholders parameters are all arrays

 * the binders are in the form ('sss..sn') or (iii..in)

 * the number of binders = number of placeholders

 * this function does not support conditions e.g. WHERE.... 

 */
function Insert($fields, $placeholders, $binders, $values, $table, $db)
{

  $field_val = implode(", ", $fields);

  $ph = implode(", ", $placeholders);
 
  $query =
    "INSERT INTO " . $table . " (" . $field_val . ")  VALUES(" . $ph . ")";

  $stmt = $db->prepare($query);

  $stmt->bind_param("" . $binders . "", ...$values);
 
  $stmt->execute();
}

/**
 * update table in the query instance

 * use default sql update query format

 * values are in the form of arrays

 * $values = array($val1, $val2, ....)
 */
function Update($query, $binders, $values, $table, $db)
{
  $stmt = $db->prepare($query);

  $stmt->bind_param("" . $binders . "", ...$values);

  $stmt->execute();
}

/**
 * Delete a row from a table
 *
 * Use default sql DELETE query format
 */
function Delete($query, $binders, $values, $table, $db)
{
  /*  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); */
  $stmt = $db->prepare($query);

  $stmt->bind_param("" . $binders . "", ...$values);

  $stmt->execute();
}

/**
 * SELECT DATA FROM DB WITH CONDITIONS

 * CONDITIONS, WHERE, AND ....e.t.c

 */
function SelectCond($query, $binders, $parameters, $db)
{
  $stmt = $db->prepare($query);

  $stmt->bind_param("" . $binders . "", ...$parameters);

  $stmt->execute();

  return $stmt;
}

/**
 * SELECT DATA FROM DB WITH CONDITIONS

 * NO BINDERS OR PLACEHOLDERS 
     
 * JUST PURE SQL STATEMENTS

 */
function SelectCondFree($query, $table, $db)
{
  $stmt = $db->prepare($query);

  $stmt->execute();

  return $stmt;
}

/**
 * INSERT DATA TO DB WITH CONDITIONS

 * CONDITIONS, WHERE, AND ....e.t.c

 */
function InsertCond($query, $table, $db)
{
  $stmt = $db->prepare($query);

  $stmt->execute();

  return $stmt;
}

/**
 * used to search database for a matching value

 * SELECT * FROM table WHERE $fieldofsearch LIKE $matching value

 * one matching value only

 * use arrays for both parameters
 */
function Search($fieldofSearch, $matchingValue, $table, $db)
{
  $query = "SELECT * FROM " . $table . " WHERE " . $fieldofSearch . " LIKE ?";

  $stmt = $db->prepare($query);

  //only one paramter is passed
  $stmt->bind_param("s", $matchingValue);

  $stmt->execute();

  return $stmt;
}

/**
 * single column efficient fullsearch
 *
 * Efficient but slow
 */
function SingleColumnSearch($matchingVal, $specific_column, $table, $db)
{
  //add full text functionality to column
  $q_f = "ALTER TABLE " . $table . " ADD FULLTEXT (" . $specific_column . ") ";

  $stmt = $db->prepare($q_f);

  $stmt->execute();

  $q =
    "SELECT p.*, MATCH (p." .
    $specific_column .
    ") AGAINST (?) AS score FROM " .
    $table .
    " p WHERE p.question_id <> 23 AND MATCH (p." .
    $specific_column .
    ") AGAINST (?) > 0 LIMIT 4";

  $stmt_s = $db->prepare($q);

  $stmt_s->bind_param("ss", $matchingVal, $matchingVal);

  $stmt_s->execute();

  return $stmt_s;
}

function SingleColumnSearchRelatedQuestion(
  $matchingVal,
  $qId,
  $specific_column,
  $table,
  $db
) {
  //add full text functionality to column
  $q_f = "ALTER TABLE " . $table . " ADD FULLTEXT (" . $specific_column . ") ";

  $stmt = $db->prepare($q_f);

  $stmt->execute();

  $q =
    "SELECT p.*, MATCH (p." .
    $specific_column .
    ") AGAINST (?) AS score FROM " .
    $table .
    " p WHERE p.question_id !=? AND p.question_id <> 23 AND MATCH (p." .
    $specific_column .
    ") AGAINST (?) > 0 LIMIT 4";

  $stmt_s = $db->prepare($q);

  $stmt_s->bind_param("sss", $matchingVal, $qId, $matchingVal);

  $stmt_s->execute();

  return $stmt_s;
}

function SingleColumnSearchQuestionSuggestion(
  $matchingVal,
  $specific_column,
  $table,
  $db
) {
  //add full text functionality to column
  $q_f = "ALTER TABLE " . $table . " ADD FULLTEXT (" . $specific_column . ") ";

  $stmt = $db->prepare($q_f);

  $stmt->execute();

  $q =
    "SELECT p.*, MATCH (p." .
    $specific_column .
    ") AGAINST (?) AS score FROM " .
    $table .
    " p WHERE p.question_id <> 23 AND MATCH (p." .
    $specific_column .
    ") AGAINST (?) > 0 LIMIT 20";

  $stmt_s = $db->prepare($q);

  $stmt_s->bind_param("ss", $matchingVal, $matchingVal);

  $stmt_s->execute();

  return $stmt_s;
}



/**
 * perfoms full text search in database
 *
 * not efficient enough
 *
 *  ADDS FULLTEXT FUNCTIONALITY IN DATABASE
 *
 * currently doesnt work
 *
 *  this function supports natural lang search for one column
 */
function Fullsearch($searchfield, $matchingitem, $table, $db)
{
  //the matching item represents the fields
  $realmatch = $matchingitem;
  //add functionality on one instance
  $q_f = "ALTER TABLE " . $table . " ADD FULLTEXT (" . $realmatch . ") ";
  $stmt = $db->prepare($q_f);

  $stmt->execute();

  //do the actual search
  $q_s =
    "SELECT * FROM " .
    $table .
    " WHERE MATCH " .
    $searchfield .
    " AGAINST(? IN NATURAL LANGUAGE MODE)";
  $stmt_s = $db->prepare($q_s);
  $stmt_s->bind_param("s", $matchingitem);
  $stmt_s->execute();

  return $stmt_s;
}


function LoadUsers($usertable, $db){
  // check user and question data
  $users = "SELECT * FROM " . $usertable . "";

  $stmtusers = $db->prepare($users);

  $stmtusers->execute();

  $resultuser = $stmtusers->get_result();

  if (!($resultuser->num_rows >= 3)){
    $userFields = [
      "username",
      "email",
      "password",
      "is_admin",
      "date_created",
      "time_created",
      "created_by",
      "creator_ip",
    ];
    $userPlaceholders = ["?", "?", "?", "?", '?', '?', '?', '?'];
    $userBinders = "ssssssss";
    
    date_default_timezone_get();
    
    $dateLoggeedIn = date('Y-m-d', time());
          
    $timeLoggeedIn = date('H:i:s T', time());

    $ip = get_ip_address();

    $userValues = [
      "sammy",
      "samuelmbugua479@gmail.com",
      '$2y$10$Ak88YV9kdnr4wL1/MzxQuuj49GRfC.nzXnSq30yxQDNs3.8RCOohi',
      "true",
      $dateLoggeedIn,
      $timeLoggeedIn,
      'sammy',
      $ip,
    ];

    /////////////////////////////////////////////
    $userFields2 = [
      "username",
      "email",
      "password",
      "is_admin",
      "date_created",
      "time_created",
      "created_by",
      "creator_ip",
    ];
    $userPlaceholders2 = ["?", "?", "?", "?", '?', '?', '?', '?'];
    $userBinders2 = "ssssssss";
    $userValues2 = [
      "jeff",
      "jeffniu90@gmail.com",
      '$2y$10$vg3c6Lzt33u6AKlVvr787euiSBppZ3QfpOQHFg4mhFLJoYfDAeolm',
      "true",
      $dateLoggeedIn,
      $timeLoggeedIn,
      'jeff',
      $ip,
    ];

    /////////////////////////////////////////////
    $userFields3 = [
      "username",
      "email",
      "password",
      "is_admin",
      "date_created",
      "time_created",
      "created_by",
      "creator_ip",
    ];
    $userPlaceholders3 = ["?", "?", "?", "?", '?', '?', '?', '?'];
    $userBinders3 = "ssssssss";
    $userValues3 = [
      "haron",
      "harontaiko@gmail.com",
      '$2y$10$YM5yEMw/eA9eeDfO/5hFZuYsvNOe.F..VUvBCXrUJrxqxkQhSPxGC',
      "true",
      $dateLoggeedIn,
      $timeLoggeedIn,
      'haron',
      $ip,
    ];

    try {
      Insert(
        $userFields,
        $userPlaceholders,
        $userBinders,
        $userValues,
        $usertable,
        $db
      );
      Insert(
        $userFields2,
        $userPlaceholders2,
        $userBinders2,
        $userValues2,
        $usertable,
        $db
      );
      Insert(
        $userFields3,
        $userPlaceholders3,
        $userBinders3,
        $userValues3,
        $usertable,
        $db
      );

    } catch (Error $e) {
      return false;
    }
  }
  else{

  }
}

//verify mail and token
function verifyTokenAndmail($table, $email, $db)
{
  $query = "SELECT * FROM " . $table . " WHERE email=?";

  $stmt = $db->prepare($query);
  $stmt->bind_param("s", $email);
  $stmt->execute();

  return $stmt;
}


/**
 * reset token
 */
function ResetToken($table, $id, $newTokenVal, $db)
{
  $query = "UPDATE " . $table . " SET reset_link=? WHERE user_id=?";

  $stmt = $db->prepare($query);
  $stmt->bind_param("ss", $newTokenVal, $id);
  $stmt->execute();

  return $stmt;
}

function getItemSoldCountInventory($name, $db)
{
  $query = 'SELECT COUNT(*) AS cnt FROM dr_sales WHERE sales_item = ?';

  $binders = "s";

  $parameters = array($name);

  $result = SelectCond($query, $binders, $parameters, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();
  
  $count = $rowItem['cnt'];

  try {
      return $count;
  } catch (Error $e) {
      return false;
  }
}

function getExpenseTotal($date, $db)
{
    //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $query = 'SELECT SUM(expense_cost) AS expense_total FROM dr_expenses WHERE date_created=?';

    $binders="s";

    $param = array($date);

    $result = SelectCond($query, $binders, $param, $db);

    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();
        
    $totalexpense = isset($rowItem['expense_total']) ? $rowItem['expense_total'] : 0;

    try {
        return $totalexpense;
    } catch (Error $e) {
        return false;
    } 
}

function getExpenseTotalCount($date, $db)
{
    //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $query = 'SELECT COUNT(*) AS cnt FROM dr_expenses WHERE date_created=?';

    $binders="s";

    $param = array($date);

    $result = SelectCond($query, $binders, $param, $db);

    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();
        
    $totalexpense = isset($rowItem['cnt']) ? $rowItem['cnt'] : 0;

    try {
        return $totalexpense;
    } catch (Error $e) {
        return false;
    } 
}

function getNetExpenses($date,$db)
{
    $query = 'SELECT expense_id, expense_item, expense_cost, date_created, time_created, created_by, creator_ip FROM dr_expenses WHERE date_created=?';

    $binders="s";

    $param = array($date);

    $result = SelectCond($query, $binders, $param, $db);

    $row = $result->get_result();

    try {
        return $row;
    } catch (Error $e) {
        return false;
    } 
}

function getNetSales($date,$db)
{
    $query = 'SELECT sales_item, sales_id, selling_price FROM dr_sales WHERE date_created=?';

    $binders="s";

    $param = array($date);

    $result = SelectCond($query, $binders, $param, $db);

    $row = $result->get_result();

    try {
        return $row;
    } catch (Error $e) {
        return false;
    } 
}

function getItemsOutStock($db)
{
    $query = 'SELECT out_stock AS stock FROM dr_stock';

    $result = SelectCondFree($query, 'dr_stock', $db);

    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();
    
    $instock = isset($rowItem['stock']) ? $rowItem['stock'] : 'N/A';

    try {
        return $instock;
    } catch (Error $e) {
        return false;
    } 
}


function getItemsInStock($db)
{
  $query = 'SELECT in_stock AS stock FROM dr_stock';

  $result = SelectCondFree($query, 'dr_stock', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();
  
  $instock = isset($rowItem['stock']) ? $rowItem['stock'] : 'N/A';

  try {
      return $instock;
  } catch (Error $e) {
      return false;
  } 
}

 function getAverageDailyIncome($db)
{
    $query = 'SELECT AVG(totalincome) AS totalincome FROM dr_nettotal GROUP BY DATE_SUB(NOW(), INTERVAL 1 DAY)';

    $result = SelectCondFree($query, 'dr_nettotal', $db);

    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();
    
    $avgsales = isset($rowItem['totalincome']) ? $rowItem['totalincome'] : 'N/A';

    try {
  return $avgsales;
    } catch (Error $e) {
  return false;
    } 
}

function getItemsSold($db)
{
  $query = 'SELECT COUNT(sales_id) AS stock FROM dr_sales';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();
  
  $instock = isset($rowItem['stock']) ? $rowItem['stock'] : 'N/A';

  try {
      return $instock;
  } catch (Error $e) {
      return false;
  } 
}

function getSalesTotalCount($date, $db)
{
    //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $query = 'SELECT COUNT(*) AS cnt FROM dr_sales WHERE date_created=?';

    $binders="s";

    $param = array($date);

    $result = SelectCond($query, $binders, $param, $db);

    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();
        
    $totalexpense = isset($rowItem['cnt']) ? $rowItem['cnt'] : 0;

    try {
        return $totalexpense;
    } catch (Error $e) {
        return false;
    } 
}

function ItemSold($db)
{
  $query1 = 'SELECT COUNT(sales_id) AS salescount FROM dr_sales GROUP BY sales_item';

  $result1 = SelectCondFree($query1, 'dr_sales', $db);

  $row1 = $result1->get_result();

  $rowItem1 = $row1->fetch_assoc();

  $salescount = isset($rowItem1['salescount']) ? $rowItem1['salescount'] : '0';

  try {
      return $row1->num_rows;
  } catch (Error $e) {
      return false;
  } 
}

function ItemCount($db)
{
  $query2 = 'SELECT SUM(item_quantity) AS cnt FROM dr_inventory WHERE item_name !=?';

  $binders = "s";

  $param = array('NONE');

  $result2 = SelectCond($query2, $binders, $param, $db);

  $row2 = $result2->get_result();

  $rowItem2 = $row2->fetch_assoc();

  $itemcount = isset($rowItem2['cnt']) ? $rowItem2['cnt'] : '0';

  try {
      return $itemcount;
  } catch (Error $e) {
      return false;
  } 
}

function getSaleTotal($date, $db)
{
    //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $query = 'SELECT SUM(selling_price) AS selling_total FROM dr_sales WHERE date_created=?';

    $binders="s";

    $param = array($date);

    $result = SelectCond($query, $binders, $param, $db);

    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();
        
    $totalexpense = isset($rowItem['selling_total']) ? $rowItem['selling_total'] : 0;

    try {
        return $totalexpense;
    } catch (Error $e) {
        return false;
    } 
}


function getBuyingTotal($date, $db)
{
    //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $query = 'SELECT SUM(buying_price) AS buying_total FROM dr_sales WHERE date_created=?';

    $binders="s";

    $param = array($date);

    $result = SelectCond($query, $binders, $param, $db);

    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();
        
    $totalexpense = isset($rowItem['buying_total']) ? $rowItem['buying_total'] : 0;

    try {
        return $totalexpense;
    } catch (Error $e) {
        return false;
    } 
}


function getNetProfit($date, $db)
{
    //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $query = 'SELECT SUM(profit) AS profit_total FROM dr_sales WHERE date_created=?';

    $binders="s";

    $param = array($date);

    $result = SelectCond($query, $binders, $param, $db);

    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();
        
    $totalexpense = isset($rowItem['profit_total']) ? $rowItem['profit_total'] : 0;

    try {
        return $totalexpense;
    } catch (Error $e) {
        return false;
    } 
}

function getMovieshopDate($date, $db)
{
  $query = 'SELECT cash, till FROM dr_movieshop WHERE date_created=?';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  try {
      return $rowItem;
  } catch (Error $e) {
      return false;
  } 
}

function getPsDate($date, $db)
{
  $query = 'SELECT cash, till FROM dr_playstation WHERE date_created=?';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  try {
      return $rowItem;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberDate($date, $db)
{
  $query = 'SELECT cash, till FROM dr_cybershop WHERE date_created=?';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  try {
      return $rowItem;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopTotal($date, $db)
{
  $query = 'SELECT SUM(cash + till) AS movieshop_net FROM dr_movieshop WHERE date_created=?';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['movieshop_net']) ? $rowItem['movieshop_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getCybershopTotal($date, $db)
{
  $query = 'SELECT SUM(cash + till) AS cybershop_net FROM dr_cybershop WHERE date_created=?';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalcyber = isset($rowItem['cybershop_net']) ? $rowItem['cybershop_net'] : 'N/A';

  try {
      return $totalcyber;
  } catch (Error $e) {
      return false;
  } 
}

function getPsTotal($date, $db)
{
  $query = 'SELECT SUM(cash + till) AS ps_net FROM dr_playstation WHERE date_created=?';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalplaystation = isset($rowItem['ps_net']) ? $rowItem['ps_net'] : 'N/A';

  try {
      return $totalplaystation;
  } catch (Error $e) {
      return false;
  } 
}

function saleRecord($db, $date)
{
  $query = 'SELECT sales_id, sales_item, buying_price, selling_price, cash, till, profit, date_created, time_created, created_by, creator_ip FROM dr_sales WHERE date_created = ?';

  $binders = "s";

  $parameters = array($date);

  $result = SelectCond($query, $binders, $parameters, $db);

  $row = $result->get_result();

  $numRows = $row->num_rows;

  if ($numRows > 0) {
      return true;
  } else {
      return false;
  }
}
/////////////////////////////////////////////////////////////////////sales


function getSalesAllDate($date, $db)
{
  $query = 'SELECT sales_id, sales_item, buying_price, selling_price, cash, till, profit, date_created, time_created, created_by, creator_ip FROM dr_sales WHERE date_created=?';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getSalesTotalA($date, $db)
{
  $query = 'SELECT SUM(selling_price) AS sales_net FROM dr_sales WHERE date_created=?';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['sales_net']) ? $rowItem['sales_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

//top 2 sold items this week
function getMostSoldItemsWeek($db)
{
  $query = 'SELECT sales_item, DATE_FORMAT(date_created, "%U"), selling_price FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY sales_item ORDER BY COUNT(*) DESC LIMIT 2';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getSalesAllWeekNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%U"), SUM(selling_price) AS selling, SUM(profit) AS sales_net FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getSalesTotalWeek($db)
{
  $query = 'SELECT SUM(selling_price) AS sales_net FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK)';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['sales_net']) ? $rowItem['sales_net'] : 0;

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getSalesDatesWeek($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%U") FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}


function getSalesProfitWeek($db)
{
  $query = 'SELECT SUM(profit) AS sales_net FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getSalesWeek($db)
{
  $query = 'SELECT SUM(selling_price) AS sales_net FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}


//TOP 3 MOST SOLD ITEMS THIS MONTH 
function getMostSoldItemsMonth($db)
{
  $query = 'SELECT sales_item, selling_price FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY sales_item ORDER BY COUNT(*) DESC LIMIT 3';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getSalesAllMonthNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%M"), SUM(profit) AS profit_net, SUM(selling_price) AS sales_net FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getSalesTotalMonth($db)
{
  $query = 'SELECT SUM(selling_price) AS sales_net FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH)';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['sales_net']) ? $rowItem['sales_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getSalesDatesMonth($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%M") FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}


function getSalesProfitMonth($db)
{
  $query = 'SELECT SUM(profit) AS sales_net FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getSalesMonth($db)
{
  $query = 'SELECT SUM(selling_price) AS sales_net FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getSalesAllYearNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%Y"), SUM(selling_price) AS sales_net, SUM(profit) AS profit_net FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getSalesTotalYear($db)
{
  $query = 'SELECT SUM(selling_price) AS sales_net FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR)';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['sales_net']) ? $rowItem['sales_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

//TOP 6 MOST SOLD ITEMS THIS YEAR 
function getMostSoldItemsYear($db)
{
  $query = 'SELECT sales_item, selling_price FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY sales_item ORDER BY COUNT(*) DESC LIMIT 6';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getSalesDatesYear($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%Y") FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}


function getSalesProfitYear($db)
{
  $query = 'SELECT SUM(profit) AS sales_net FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getSalesYear($db)
{
  $query = 'SELECT SUM(selling_price) AS sales_net FROM dr_sales WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_sales', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}
/////////////////////////////////////////////////////////////////////expenses
function getExpenseAllDate($date, $db)
{
  $query = 'SELECT expense_id, expense_item, expense_cost, date_created, time_created, created_by, creator_ip FROM dr_expenses WHERE date_created=?';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getExpenseTotalA($date, $db)
{
  $query = 'SELECT SUM(expense_cost) AS expense_net FROM dr_expenses WHERE date_created=? GROUP BY date_created';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['expense_net']) ? $rowItem['expense_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getExpenseAllWeekNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%U"), SUM(expense_cost) AS expense_net FROM dr_expenses WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_expenses', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getExpenseTotalWeek($db)
{
  $query = 'SELECT SUM(expense_cost) AS expense_net FROM dr_expenses WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK)';

  $result = SelectCondFree($query, 'dr_expenses', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['expense_net']) ? $rowItem['expense_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getExpenseDatesWeek($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%U") FROM dr_expenses WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_expenses', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getExpenseThisWeek($db)
{
  $query = 'SELECT SUM(expense_cost) AS expense_net FROM dr_expenses WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_expenses', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}


function getExpenseAllMonthNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%M"), SUM(expense_cost) AS expense_net FROM dr_expenses WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_expenses', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getExpenseTotalMonth($db)
{
  $query = 'SELECT SUM(expense_cost) AS expense_net FROM dr_expenses WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH)';

  $result = SelectCondFree($query, 'dr_expenses', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['expense_net']) ? $rowItem['expense_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getExpenseDatesMonth($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%M") FROM dr_expenses WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_expenses', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getExpenseGrossMonth($db)
{
  $query = 'SELECT SUM(expense_cost) AS expense_net FROM dr_expenses WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_expenses', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}


function getExpenseAllYearNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%Y"), SUM(expense_cost) AS expense_net FROM dr_expenses WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_expenses', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getExpenseTotalYear($db)
{
  $query = 'SELECT SUM(expense_cost) AS expense_net FROM dr_expenses WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR)';

  $result = SelectCondFree($query, 'dr_expenses', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['expense_net']) ? $rowItem['expense_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getExpenseDatesYear($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%Y") FROM dr_expenses WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_expenses', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getExpenseGrossYear($db)
{
  $query = 'SELECT SUM(expense_cost) AS expense_net FROM dr_expenses WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_expenses', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}


////////////////////////////////////////////////////////////////////NET TOTAL
function getNetAllDate($date, $db)
{
  $query = 'SELECT sales_id, total_sales, totalprofit, totalincome, totalexpense, cash_sales, till_sales, date_created, time_created, created_by, creator_ip FROM dr_nettotal WHERE date_created=?';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getNetTotalA($date, $db)
{
  $query = 'SELECT totalincome AS total_income FROM dr_nettotal WHERE date_created=?';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalincome = isset($rowItem['total_income']) ? $rowItem['total_income'] : 'N/A';

  try {
      return $totalincome;
  } catch (Error $e) {
      return false;
  } 
}

function getNetAllWeekNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%U"), SUM(cash_sales) AS total_cash, SUM(till_sales) AS total_till, SUM(totalincome) AS net_total FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getNetTotalWeek($db)
{
  $query = 'SELECT SUM(totalincome) AS net_total FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK)';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalweekly = isset($rowItem['net_total']) ? $rowItem['net_total'] : 0;

  try {
      return $totalweekly;
  } catch (Error $e) {
      return false;
  } 
}

function getNetDatesWeek($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%U") FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getNetTillWeek($db)
{
  $query = 'SELECT SUM(till_sales) AS net_till FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getNetCashWeek($db)
{
  $query = 'SELECT SUM(cash_sales) AS cash_total FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getNetGrossWeek($db)
{
  $query = 'SELECT SUM(totalincome) AS total_net FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getNetAllMonthNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%M"), SUM(cash_sales) AS total_cash, SUM(till_sales) AS total_till, SUM(totalincome) AS net_total FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getNetTotalMonth($db)
{
  $query = 'SELECT SUM(totalincome) AS totalnet FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH)';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['totalnet']) ? $rowItem['totalnet'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getNetDatesMonth($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%M") FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getNetGrossMonth($db)
{
  $query = 'SELECT SUM(totalincome) AS totalnet FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getNetCashMonth($db)
{
  $query = 'SELECT SUM(cash_sales) AS cash_net FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getNetTillMonth($db)
{
  $query = 'SELECT SUM(till_sales) AS till_net FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getNetAllYearNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%Y"), SUM(cash_sales) AS total_cash, SUM(till_sales) AS total_till, SUM(totalincome) AS net_total FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getNetTotalYear($db)
{
  $query = 'SELECT SUM(totalincome) AS total_income FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR)';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['total_income']) ? $rowItem['total_income'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getNetDatesYear($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%Y") FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getNetGrossYear($db)
{
  $query = 'SELECT SUM(totalincome) AS totalincome FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getNetTillYear($db)
{
  $query = 'SELECT SUM(till_sales) AS net_till FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getNetCashYear($db)
{
  $query = 'SELECT SUM(cash_sales) AS net_cash FROM dr_nettotal WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_nettotal', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}
///////////////////////////////////////////////////////////////////Playstation
function getPsAllDate($date, $db)
{
  $query = 'SELECT cash, till, created_by, creator_ip FROM dr_playstation WHERE date_created=?';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getPsTotalA($date, $db)
{
  $query = 'SELECT SUM(cash + till) AS ps_net FROM dr_playstation WHERE date_created=?';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['ps_net']) ? $rowItem['ps_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getPsAllWeekNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%U"), SUM(cash) AS total_cash, SUM(till) AS total_till, SUM(cash + till) AS net_total FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getPsTotalWeek($db)
{
  $query = 'SELECT SUM(cash + till) AS ps_net FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK)';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['ps_net']) ? $rowItem['ps_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getPsDatesWeek($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%U") FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getPsTillWeek($db)
{
  $query = 'SELECT SUM(till) AS ps_net FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getPsCashWeek($db)
{
  $query = 'SELECT SUM(cash) AS ps_net FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getPsGrossWeek($db)
{
  $query = 'SELECT SUM(cash+till) AS ps_net FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getPsAllMonthNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%M"), SUM(cash) AS total_cash, SUM(till) AS total_till, SUM(cash + till) AS net_total FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getPsTotalMonth($db)
{
  $query = 'SELECT SUM(cash + till) AS ps_net FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH)';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['ps_net']) ? $rowItem['ps_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getPsDatesMonth($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%M") FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getPsGrossMonth($db)
{
  $query = 'SELECT SUM(cash + till) AS ps_net FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getPsCashMonth($db)
{
  $query = 'SELECT SUM(cash) AS ps_net FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getPsTillMonth($db)
{
  $query = 'SELECT SUM(till) AS ps_net FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getPsAllYearNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%Y"), SUM(cash) AS total_cash, SUM(till) AS total_till, SUM(cash + till) AS net_total FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getPsTotalYear($db)
{
  $query = 'SELECT SUM(cash + till) AS ps_net FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR)';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['ps_net']) ? $rowItem['ps_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getPsDatesYear($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%Y") FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getPsGrossYear($db)
{
  $query = 'SELECT SUM(cash + till) AS ps_net FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getPsTillYear($db)
{
  $query = 'SELECT SUM(till) AS ps_net FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getPsCashYear($db)
{
  $query = 'SELECT SUM(cash) AS ps_net FROM dr_playstation WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_playstation', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}
//////////////////////////////////////////////////////////////////cyber
function getCyberAllYear($db)
{
  $query = 'SELECT cash, till, created_by, creator_ip, date_created FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR)';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberAllDate($date, $db)
{
  $query = 'SELECT cash, till, created_by, creator_ip FROM dr_cybershop WHERE date_created=?';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberTotal($date, $db)
{
  $query = 'SELECT SUM(cash + till) AS cyber_net FROM dr_cybershop WHERE date_created=?';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['cyber_net']) ? $rowItem['cyber_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberAllWeekNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%U"), SUM(cash) AS total_cash, SUM(till) AS total_till, SUM(cash + till) AS net_total FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberTotalWeek($db)
{
  $query = 'SELECT SUM(cash + till) AS cyber_net FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK)';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['cyber_net']) ? $rowItem['cyber_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberDatesWeek($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%U") FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberTillWeek($db)
{
  $query = 'SELECT SUM(till) AS cyber_net FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberCashWeek($db)
{
  $query = 'SELECT SUM(cash) AS cyber_net FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberGrossWeek($db)
{
  $query = 'SELECT SUM(cash+till) AS cyber_net FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%U")';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberAllMonthNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%M"), SUM(cash) AS total_cash, SUM(till) AS total_till, SUM(cash + till) AS net_total FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberTotalMonth($db)
{
  $query = 'SELECT SUM(cash + till) AS cyber_net FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH)';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['cyber_net']) ? $rowItem['cyber_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberDatesMonth($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%M") FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberGrossMonth($db)
{
  $query = 'SELECT SUM(cash + till) AS cyber_net FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberCashMonth($db)
{
  $query = 'SELECT SUM(cash) AS cyber_net FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberTillMonth($db)
{
  $query = 'SELECT SUM(till) AS cyber_net FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberAllYearNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%Y"), SUM(cash) AS total_cash, SUM(till) AS total_till, SUM(cash + till) AS net_total FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberTotalYear($db)
{
  $query = 'SELECT SUM(cash + till) AS cyber_net FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR)';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['cyber_net']) ? $rowItem['cyber_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberDatesYear($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%Y") FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberGrossYear($db)
{
  $query = 'SELECT SUM(cash + till) AS cyber_net FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberTillYear($db)
{
  $query = 'SELECT SUM(till) AS cyber_net FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getCyberCashYear($db)
{
  $query = 'SELECT SUM(cash) AS cyber_net FROM dr_cybershop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_cybershop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}
//////////////////////////////////////////////////////////////////movieshop

function getMovieshopAllDate($date, $db)
{
  $query = 'SELECT cash, till, created_by, creator_ip FROM dr_movieshop WHERE date_created=?';

  $binders="s";

  $param = array($date);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopAllWeek($db)
{
  $query = 'SELECT cash, till, created_by, creator_ip, date_created FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 week)';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopAllMonth($db)
{
  $query = 'SELECT cash, till, created_by, creator_ip, date_created FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH)';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopAllYear($db)
{
  $query = 'SELECT cash, till, created_by, creator_ip, date_created FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR)';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopAllMonthNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%M"), SUM(cash) AS total_cash, SUM(till) AS total_till, SUM(cash + till) AS net_total FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopAllWeekNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%u"), SUM(cash) AS total_cash, SUM(till) AS total_till, SUM(cash + till) AS net_total FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%u")';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopAllYearNet($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%Y"), SUM(cash) AS total_cash, SUM(till) AS total_till, SUM(cash + till) AS net_total FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopTotalYear($db)
{
  $query = 'SELECT SUM(cash + till) AS movieshop_net FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR)';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['movieshop_net']) ? $rowItem['movieshop_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopTotalWeek($db)
{
  $query = 'SELECT SUM(cash + till) AS movieshop_net FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK)';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['movieshop_net']) ? $rowItem['movieshop_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopTotalMonth($db)
{
  $query = 'SELECT SUM(cash + till) AS movieshop_net FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH)';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['movieshop_net']) ? $rowItem['movieshop_net'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopDatesMonth($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%M") FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopDatesWeek($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%u") FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%u")';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopDatesYear($db)
{
  $query = 'SELECT DATE_FORMAT(date_created, "%Y") FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopCashMonth($db)
{
  $query = 'SELECT SUM(cash) AS movieshop_net FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopTillMonth($db)
{
  $query = 'SELECT SUM(till) AS movieshop_net FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopGrossYear($db)
{
  $query = 'SELECT SUM(cash + till) AS movieshop_net FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopGrossWeek($db)
{
  $query = 'SELECT SUM(cash+till) AS movieshop_net FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%u")';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopCashWeek($db)
{
  $query = 'SELECT SUM(cash) AS movieshop_net FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%u")';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopTillWeek($db)
{
  $query = 'SELECT SUM(till) AS movieshop_net FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY DATE_FORMAT(date_created, "%u")';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopTillYear($db)
{
  $query = 'SELECT SUM(till) AS movieshop_net FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopCashYear($db)
{
  $query = 'SELECT SUM(cash) AS movieshop_net FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_created, "%Y")';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

function getMovieshopGrossMonth($db)
{
  $query = 'SELECT SUM(cash + till) AS movieshop_net FROM dr_movieshop WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(date_created, "%M")';

  $result = SelectCondFree($query, 'dr_movieshop', $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

//////////////////////////////////////////////////////////////////////////filter Date Report
function getFileteredReportBetween($from, $to, $shopname, $db)
{
  if($shopname == "movie"){
    $query = 'SELECT cash, till, created_by, creator_ip, date_created FROM dr_movieshop WHERE date_created BETWEEN ? AND ?';

    $binders ="ss";

    $params = array($from, $to);

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();
  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    } 
  }else if($shopname == "cyber"){
    $query = 'SELECT cash, till, created_by, creator_ip, date_created FROM dr_cybershop WHERE date_created BETWEEN ? AND ?';

    $binders ="ss";

    $params = array($from, $to);

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();
  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    } 
  }else if($shopname == "ps"){
    $query = 'SELECT cash, till, created_by, creator_ip, date_created FROM dr_playstation WHERE date_created BETWEEN ? AND ?';

    $binders ="ss";

    $params = array($from, $to);

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();
  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    } 
  }else if($shopname == "total"){
    $query = 'SELECT sales_id, total_sales, totalprofit, totalincome, totalexpense, cash_sales, till_sales, date_created, time_created, created_by, creator_ip FROM dr_nettotal WHERE date_created BETWEEN ? AND ?';

    $binders ="ss";

    $params = array($from, $to);

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();
  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    } 
  }else if($shopname == "expense"){
    $query = 'SELECT expense_id, expense_item, expense_cost, date_created, time_created, created_by, creator_ip FROM dr_expenses WHERE date_created BETWEEN ? AND ? ORDER BY date_created DESC';

    $binders ="ss";

    $params = array($from, $to);

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();
  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    }
  }
  else if($shopname == "sales"){
    $query = 'SELECT sales_id, sales_item, buying_price, selling_price, cash, till, profit, date_created, time_created, created_by, creator_ip FROM dr_sales WHERE date_created BETWEEN ? AND ? ORDER BY date_created DESC';

    $binders ="ss";

    $params = array($from, $to);

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();
  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    }
  }
}

function getFileteredReportTotal($from, $to, $shopname, $db)
{
  if($shopname == "movie"){
    $query = 'SELECT SUM(cash+till) AS total, SUM(till) AS till, SUM(cash) AS cash FROM dr_movieshop WHERE date_created BETWEEN ? AND ?';

    $binders ="ss";

    $params = array($from, $to);

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();
  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    } 
  }else if($shopname == "cyber"){
    $query = 'SELECT SUM(cash+till) AS total, SUM(till) AS till, SUM(cash) AS cash FROM dr_cybershop WHERE date_created BETWEEN ? AND ?';

    $binders ="ss";

    $params = array($from, $to);

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();
  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    } 
  }else if($shopname == "ps"){
    $query = 'SELECT SUM(cash+till) AS total, SUM(till) AS till, SUM(cash) AS cash FROM dr_playstation WHERE date_created BETWEEN ? AND ?';

    $binders ="ss";

    $params = array($from, $to);

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();
  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    }
  }else if($shopname == "total"){
    $query = 'SELECT SUM(cash_sales) AS totalcash, SUM(till_sales) AS totaltill, SUM(totalexpense) AS expensetotal, SUM(total_sales) AS totalsales, SUM(totalincome) AS incometotal FROM dr_nettotal WHERE date_created BETWEEN ? AND ?';

    $binders ="ss";

    $params = array($from, $to);

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();
  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    } 
  }else if($shopname == "expense"){
    $query = 'SELECT SUM(expense_cost) AS exp_total FROM dr_expenses WHERE date_created BETWEEN ? AND ?';

    $binders ="ss";

    $params = array($from, $to);

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();

    $total = isset($rowItem['exp_total']) ? $rowItem['exp_total'] : 'N/A';
  
    try {
        return $total;
    } catch (Error $e) {
        return false;
    }
  }
  else if($shopname == "sales"){
    $query = 'SELECT SUM(selling_price) AS selling, SUM(profit) AS pr FROM dr_sales WHERE date_created BETWEEN ? AND ? ORDER BY date_created DESC';

    $binders ="ss";

    $params = array($from, $to);

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();

  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    }
  }
}

  function getGross($from ,$to, $db)
{
  $query = 'SELECT SUM(total_sales + totalincome) AS net FROM dr_nettotal WHERE date_created BETWEEN ? AND ?';

  $binders ="ss";

  $params = array($from, $to);

  $result = SelectCond($query, $binders, $params, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $total = isset($rowItem['net']) ? $rowItem['net'] : 'N/A';

  try {
      return $total;
  } catch (Error $e) {
      return false;
  }
}

///////////////////////////////////////////////////////////////////invoice
function getSaleItemById($id,$db)
{
  $query = 'SELECT sales_id, sales_item, buying_price, selling_price, cash, till, profit, date_created, time_created, created_by, creator_ip FROM dr_sales WHERE sales_id=?';

  $binders ="s";

  $params = array($id);

  $result = SelectCond($query, $binders, $params, $db);

  $row = $result->get_result();

  try {
      return $row;
  } catch (Error $e) {
      return false;
  } 
}

///////////////////////////////////view inventory item
function getInventoryItemById($id, $db)
{
  //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  $query = 'SELECT item_name FROM dr_inventory WHERE item_id = ?';

  $binders = "s";

  $parameters = array($id);

  $result = SelectCond($query, $binders, $parameters, $db);

  $row = $result->get_result();

  if($row->num_rows > 0){
      return true;
  }else{
    return false;
  }
}

function getLoginCounts($id, $db)
{
  $query = 'SELECT login_count FROM dr_login WHERE user_id=?';

  $binders = "s";

  $param =array($id);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['login_count']) ? $rowItem['login_count'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getLastIp($id, $db)
{
  $query = 'SELECT user_ip FROM dr_login WHERE user_id=?';

  $binders = "s";

  $param =array($id);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['user_ip']) ? $rowItem['user_ip'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getLastActive($id, $db)
{
  $query = 'SELECT time_logged FROM dr_login WHERE user_id=?';

  $binders = "s";

  $param =array($id);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['time_logged']) ? $rowItem['time_logged'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

function getLastDateActive($id, $db)
{
  $query = 'SELECT date_logged FROM dr_login WHERE user_id=?';

  $binders = "s";

  $param =array($id);

  $result = SelectCond($query, $binders, $param, $db);

  $row = $result->get_result();

  $rowItem = $row->fetch_assoc();

  $totalmovie = isset($rowItem['date_logged']) ? $rowItem['date_logged'] : 'N/A';

  try {
      return $totalmovie;
  } catch (Error $e) {
      return false;
  } 
}

/////////////////////////////////////////////////////////checks
function checkForSaleDataToday($date, $db)
{
  $query = 'SELECT sales_id FROM dr_nettotal WHERE date_created = ?';

  $binders = "s";

  $parameters = array($date);

  $result = SelectCond($query, $binders, $parameters, $db);

  $row = $result->get_result();

  if($row->num_rows > 0){
      return true;
  }else{
    return false;
  }
}

/////////////////////////////////////////////////////CASHOUTS
function getCashoutCount($shopname, $db)
{
  if($shopname === "movie")
  {
    $query = 'SELECT COUNT(*) AS count_ FROM dr_cashout WHERE cash_from=?';

    $binders ="s";

    $params = array('movie');

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();

    $count = isset($rowItem['count_']) ? $rowItem['count_'] : 'N/A';
  
    try {
        return $count;
    } catch (Error $e) {
        return false;
    }
  }
  else if($shopname === "ps")
  {
    $query = 'SELECT COUNT(*) AS count_ FROM dr_cashout WHERE cash_from=?';

    $binders ="s";

    $params = array('ps');

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();

    $count = isset($rowItem['count_']) ? $rowItem['count_'] : 'N/A';
  
    try {
        return $count;
    } catch (Error $e) {
        return false;
    }
  }
  else if($shopname === "cyber")
  {
    $query = 'SELECT COUNT(*) AS count_ FROM dr_cashout WHERE cash_from=?';

    $binders ="s";

    $params = array('cyber');

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();

    $count = isset($rowItem['count_']) ? $rowItem['count_'] : 'N/A';
  
    try {
        return $count;
    } catch (Error $e) {
        return false;
    }
  }
  else if($shopname === "sales")
  {
    $query = 'SELECT COUNT(*) AS count_ FROM dr_cashout WHERE cash_from=?';

    $binders ="s";

    $params = array('sales');

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();

    $count = isset($rowItem['count_']) ? $rowItem['count_'] : 'N/A';
  
    try {
        return $count;
    } catch (Error $e) {
        return false;
    }
  }
  else if($shopname === "total")
  {
    $query = 'SELECT COUNT(*) AS count_ FROM dr_cashout WHERE cash_from=?';

    $binders ="s";

    $params = array('total');

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();

    $count = isset($rowItem['count_']) ? $rowItem['count_'] : 'N/A';
  
    try {
        return $count;
    } catch (Error $e) {
        return false;
    }
  }
}

function getCashout($shopname, $db)
{
  if($shopname === "movie")
  {
    $query = 'SELECT cash_id, cash_amount, cash_usage, cash_from, cash_handler, cash_receipt_number, date_created FROM dr_cashout WHERE cash_from=?';

    $binders ="s";

    $params = array('movie');

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();
  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    }
  }
  else if($shopname == "")
  {
    $query = 'SELECT cash_id, cash_amount, cash_usage, cash_from, cash_handler, cash_receipt_number, date_created FROM dr_cashout';

    $result = SelectCondFree($query, 'dr_cashout', $db);
  
    $row = $result->get_result();
  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    }
  }
  else if($shopname === "ps")
  {
    $query = 'SELECT cash_id, cash_amount, cash_usage, cash_from, cash_handler, cash_receipt_number, date_created FROM dr_cashout WHERE cash_from=?';

    $binders ="s";

    $params = array('ps');

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();
  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    }
  }
  else if($shopname === "cyber")
  {
    $query = 'SELECT cash_id, cash_amount, cash_usage, cash_from, cash_handler, cash_receipt_number, date_created FROM dr_cashout WHERE cash_from=?';

    $binders ="s";

    $params = array('cyber');

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();
  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    }
  }
  else if($shopname === "sales")
  {
    $query = 'SELECT cash_id, cash_amount, cash_usage, cash_from, cash_handler, cash_receipt_number, date_created FROM dr_cashout WHERE cash_from=?';

    $binders ="s";

    $params = array('sales');

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();
  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    }
  }
  else if($shopname === "total")
  {
    $query = 'SELECT cash_id, cash_amount, cash_usage, cash_from, cash_handler, cash_receipt_number, date_created FROM dr_cashout WHERE cash_from=?';

    $binders ="s";

    $params = array('total');

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();
  
    try {
        return $row;
    } catch (Error $e) {
        return false;
    }
  }
}

function getCashoutTotal($shopname, $db)
{
  if($shopname === "movie")
  {
    $query = 'SELECT SUM(cash_amount) AS total FROM dr_cashout WHERE cash_from=?';

    $binders ="s";

    $params = array('movie');

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();

    $count = isset($rowItem['total']) ? $rowItem['total'] : 0;
  
    try {
        return $count;
    } catch (Error $e) {
        return false;
    }
  }
  else if($shopname === "ps")
  {
    $query = 'SELECT SUM(cash_amount) AS total FROM dr_cashout WHERE cash_from=?';

    $binders ="s";

    $params = array('ps');

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();

    $count = isset($rowItem['total']) ? $rowItem['total'] : 0;
  
    try {
        return $count;
    } catch (Error $e) {
        return false;
    }
  }
  else if($shopname === "cyber")
  {
    $query = 'SELECT SUM(cash_amount) AS total FROM dr_cashout WHERE cash_from=?';

    $binders ="s";

    $params = array('cyber');

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();

    $count = isset($rowItem['total']) ? $rowItem['total'] : 0;
  
    try {
        return $count;
    } catch (Error $e) {
        return false;
    }
  }    
  else if($shopname === "sales")
  {
    $query = 'SELECT SUM(cash_amount) AS total FROM dr_cashout WHERE cash_from=?';

    $binders ="s";

    $params = array('sales');

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();

    $count = isset($rowItem['total']) ? $rowItem['total'] : 0;
  
    try {
        return $count;
    } catch (Error $e) {
        return false;
    } 
  }
  else if($shopname === "total")
  {
    $query = 'SELECT SUM(cash_amount) AS total FROM dr_cashout WHERE cash_from=?';

    $binders ="s";

    $params = array('total');

    $result = SelectCond($query, $binders, $params, $db);
  
    $row = $result->get_result();

    $rowItem = $row->fetch_assoc();

    $count = isset($rowItem['total']) ? $rowItem['total'] : 0;
  
    try {
        return $count;
    } catch (Error $e) {
        return false;
    }
  }
}