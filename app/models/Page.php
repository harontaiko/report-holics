<?php

class Page
{
    private $db;

    public function __construct()
    {
      $this->db = new Database();
    }

    public function getDatabaseConnection()
    {
      return $this->db;
    }

    public function getSoldItemSearch($item)
    {
        $q_f = "ALTER TABLE dr_sales ADD FULLTEXT(sales_item, date_created)";
        $stmt = $this->db->prepare($q_f);
        $stmt->execute();


        $query = 'SELECT * FROM dr_sales WHERE MATCH(sales_item, date_created) AGAINST(? WITH QUERY EXPANSION)';
        $stmt_s = $this->db->prepare($query);
        $stmt_s->bind_param("s", $item);
        $stmt_s->execute();

        $row = $stmt_s->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        }  
    }

    public function addStock($data)
    {
        $query = 'SELECT stock_id FROM dr_stock';

        $result = SelectCondFree($query, 'dr_stock', $this->db);

        $row = $result->get_result();

        if($row->num_rows > 0)
        {
            //update
            $q = 'UPDATE dr_stock SET in_stock=?, out_stock=?';

            $binders = "ss";

            $param = array($data['in'], $data['out']);
            try {
                Update($q, $binders, $param, 'dr_stock', $this->db);
                return true;
            } catch (Error $e) {
                return false;
            } 
        }
        else{
            //insert
            $fields = array('in_stock', 'out_stock');

            $placeholders = array('?', '?');

            $b = "ss";

            $values = array($data['in'], $data['out']);

            try {
                Insert($fields, $placeholders, $b, $values, 'dr_stock', $this->db);
                return true;
            } catch (Error $e) {
                return false;
            } 
        }

    }

    public function getHighestExpense()
    {
        //weekly
        $query = 'SELECT MAX(expense_cost) AS highest, expense_item FROM dr_expenses WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY date_created';

        $result = SelectCondFree($query, 'dr_expenses', $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }


    public function getNextId($currentId)
    {
        $query = 'SELECT item_id AS id FROM dr_inventory WHERE item_id = (SELECT min(item_id) FROM dr_inventory WHERE item_id > ?)';

        $binders ="s";

        $param = array($currentId);

        $result = SelectCond($query, $binders, $param, $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $id = isset($rowItem['id']) ? $rowItem['id'] : '';

        try {
            return $id;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getPreviousId($currentId)
    {
        $query = 'SELECT item_id AS id FROM dr_inventory WHERE item_id < ? ORDER BY item_id DESC LIMIT 1';

        $binders ="s";

        $param = array($currentId);

        $result = SelectCond($query, $binders, $param, $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $id = isset($rowItem['id']) ? $rowItem['id'] : '';

        try {
            return $id;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getFirstId()
    {
        $query = 'SELECT MIN(item_id) AS id FROM dr_inventory';

        $result = SelectCondFree($query, 'dr_inventory', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $id = isset($rowItem['id']) ? $rowItem['id'] : '';

        try {
            return $id;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getLastId()
    {
        $query = 'SELECT MAX(item_id) AS id FROM dr_inventory';

        $result = SelectCondFree($query, 'dr_inventory', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $id = isset($rowItem['id']) ? $rowItem['id'] : '';

        try {
            return $id;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getStationTotal($station)
    {
        if($station === "movie")
        {
            $query = 'SELECT SUM(cash) + SUM(till) AS current_total FROM dr_movieshop';

            $result = SelectCondFree($query, 'dr_movieshop', $this->db);
    
            $row = $result->get_result();
    
            $rowItem = $row->fetch_assoc();
            
            $salescurrenttotal = isset($rowItem['current_total']) ? $rowItem['current_total'] : '';
    
            try {
                return $salescurrenttotal;
            } catch (Error $e) {
                return false;
            } 
        }
        else if($station === "ps")
        {
            $query = 'SELECT SUM(cash) + SUM(till) AS current_total FROM dr_playstation';

            $result = SelectCondFree($query, 'dr_playstation', $this->db);
    
            $row = $result->get_result();
    
            $rowItem = $row->fetch_assoc();
            
            $salescurrenttotal = isset($rowItem['current_total']) ? $rowItem['current_total'] : '';
    
            try {
                return $salescurrenttotal;
            } catch (Error $e) {
                return false;
            } 
        }
        else if($station === "cyber")
        {
            $query = 'SELECT SUM(cash) + SUM(till) AS current_total FROM dr_cybershop';

            $result = SelectCondFree($query, 'dr_cybershop', $this->db);
    
            $row = $result->get_result();
    
            $rowItem = $row->fetch_assoc();
            
            $salescurrenttotal = isset($rowItem['current_total']) ? $rowItem['current_total'] : '';
    
            try {
                return $salescurrenttotal;
            } catch (Error $e) {
                return false;
            } 
        }
        else if($station === "sales")
        {
            $query = 'SELECT SUM(selling_price) AS current_total FROM dr_sales';

            $result = SelectCondFree($query, 'dr_sales', $this->db);
    
            $row = $result->get_result();
    
            $rowItem = $row->fetch_assoc();
            
            $salescurrenttotal = isset($rowItem['current_total']) ? $rowItem['current_total'] : '';
    
            try {
                return $salescurrenttotal;
            } catch (Error $e) {
                return false;
            } 
        }
        else if($station === "total")
        {
            $query = 'SELECT SUM(total_sales) + SUM(totalincome) AS current_total FROM dr_nettotal';

            $result = SelectCondFree($query, 'dr_nettotal', $this->db);
    
            $row = $result->get_result();
    
            $rowItem = $row->fetch_assoc();
            
            $salescurrenttotal = isset($rowItem['current_total']) ? $rowItem['current_total'] : '';
    
            try {
                return $salescurrenttotal;
            } catch (Error $e) {
                return false;
            } 
        }
    }

    public function SaveCashout($data)
    {
        $fields = array('cash_amount', 'cash_usage', 'cash_from', 'cash_handler', 'cash_receipt_number', 'date_created');

        $placeholders = array('?', '?', '?', '?', '?', '?');
  
        $bindersCountNew = "ssssss";
  
        $values = array($data['Amount'], $data['Usage'], $data['From'], $data['Handler'], $data['Receipt'], $data['Date']);
  
        try {
            Insert(
                $fields,
                $placeholders,
                $bindersCountNew,
                $values,
                'dr_cashout',
                $this->db
            );          
            return true;
        } catch (Error $e) {
            return false;
        }
    }

    public function DeleteRecordAll($data)
    {
        $check = 'SELECT `password` FROM dr_user WHERE `user_id` = ?';

        $hold = "s";

        $val = array($data['user']);

        $result = SelectCond($check, $hold, $val, $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $password = isset($rowItem['password']) ? $rowItem['password'] : '';

        $password_check = password_verify($data['password'], $password);

        if($password_check === false)
        {
            return 0;
        }
        else if($password_check === true)
        {
            //delete record across all tables
            $query = 'DELETE FROM dr_nettotal WHERE sales_id=?';

            $binders = "s";
    
            $parameters = array($data['id']);
            
            $querym = 'DELETE FROM dr_movieshop WHERE date_created=?';

            $bindersm = "s";
    
            $parametersdate = array($data['date']);

            $queryp = 'DELETE FROM dr_playstation WHERE date_created=?';

            $bindersp = "s";

            $queryc = 'DELETE FROM dr_cybershop WHERE date_created=?';

            $bindersc = "s";

            $queryexp = 'DELETE FROM dr_expenses WHERE date_created=?';

            $bindersexp = "s";

            $querys = 'DELETE FROM dr_sales WHERE date_created=?';

            $binderss = "s";
  
            try {
                Delete($query, $binders, $parameters, 'dr_nettotal', $this->db);
                Delete($querym, $bindersm, $parametersdate, 'dr_movieshop', $this->db);
                Delete($queryp, $bindersp, $parametersdate, 'dr_playstation', $this->db);
                Delete($queryc, $bindersc, $parametersdate, 'dr_cybershop', $this->db);
                Delete($queryexp, $bindersexp, $parametersdate, 'dr_expenses', $this->db);
                Delete($querys, $binderss, $parametersdate, 'dr_sales', $this->db);
                return true;
            } catch (Error $e) {
                return false;
            }
        }
        else{
            return 0;
        }

    }

    public function DeleteCashoutAll($data)
    {
        $check = 'SELECT `password` FROM dr_user WHERE `user_id` = ?';

        $hold = "s";

        $val = array($data['user']);

        $result = SelectCond($check, $hold, $val, $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $password = isset($rowItem['password']) ? $rowItem['password'] : '';

        $password_check = password_verify($data['password'], $password);

        if($password_check === false)
        {
            return 0;
        }
        else if($password_check === true)
        {
            //delete record from cashout
            $query = 'DELETE FROM dr_cashout WHERE cash_id=?';

            $binders = "s";
    
            $parameters = array($data['id']);
            
  
            try {
                Delete($query, $binders, $parameters, 'dr_cashout', $this->db);
                return true;
            } catch (Error $e) {
                return false;
            }
        }
        else{
            return 0;
        }

    }

    public function DeleteItem($id)
    {
        $query = 'DELETE FROM dr_inventory WHERE item_id=?';

        $binders = "s";

        $parameters = array($id);

        try {
            Delete($query, $binders, $parameters, 'dr_inventory', $this->db);
            return true;
        } catch (Error $e) {
            return false;
        }
    }

    public function getItemsInStock()
    {
        $query = 'SELECT in_stock AS stock FROM dr_stock';

        $result = SelectCondFree($query, 'dr_stock', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $instock = isset($rowItem['stock']) ? $rowItem['stock'] : 'N/A';

        try {
            return $instock;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getItemsOutStock()
    {
        $query = 'SELECT out_stock AS stock FROM dr_stock';

        $result = SelectCondFree($query, 'dr_stock', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $instock = isset($rowItem['stock']) ? $rowItem['stock'] : 'N/A';

        try {
            return $instock;
        } catch (Error $e) {
            return false;
        } 
    }


    public function getItemsInventory()
    {
        $query = 'SELECT SUM(item_quantity) AS count_total FROM dr_inventory';

        $result = SelectCondFree($query, 'dr_inventory', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $countsales = isset($rowItem['count_total']) ? $rowItem['count_total'] : 'N/A';

        try {
            return $countsales;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getItemsInventoryWeek()
    {
        $query = 'SELECT COUNT(item_quantity) AS count_total FROM dr_inventory WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 WEEK)';

        $result = SelectCondFree($query, 'dr_inventory', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $countsales = isset($rowItem['count_total']) ? $rowItem['count_total'] : 'N/A';

        try {
            return $countsales;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getAverageDailyIncome()
    {
        $query = 'SELECT AVG(totalincome) AS totalincome FROM dr_nettotal GROUP BY DATE_SUB(NOW(), INTERVAL 1 DAY)';

        $result = SelectCondFree($query, 'dr_nettotal', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $avgsales = isset($rowItem['totalincome']) ? $rowItem['totalincome'] : 'N/A';

        try {
            return $avgsales;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getAverageDailyTill()
    {
        $query = 'SELECT AVG(till_sales) AS totaltill FROM dr_nettotal GROUP BY DATE_SUB(NOW(), INTERVAL 1 DAY)';

        $result = SelectCondFree($query, 'dr_nettotal', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $avgsales = isset($rowItem['totaltill']) ? $rowItem['totaltill'] : 'N/A';

        try {
            return $avgsales;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getAverageDailyCash()
    {
        $query = 'SELECT AVG(cash_sales) AS totalcash FROM dr_nettotal GROUP BY DATE_SUB(NOW(), INTERVAL 1 DAY)';

        $result = SelectCondFree($query, 'dr_nettotal', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $avgsales = isset($rowItem['totalcash']) ? $rowItem['totalcash'] : 'N/A';

        try {
            return $avgsales;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getAverageDailySales()
    {
        $query = 'SELECT AVG(total_sales) AS totalsales FROM dr_nettotal GROUP BY DATE_SUB(NOW(), INTERVAL 1 DAY)';

        $result = SelectCondFree($query, 'dr_nettotal', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $avgsales = isset($rowItem['totalsales']) ? $rowItem['totalsales'] : 'N/A';

        try {
            return $avgsales;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getItemsSold()
    {
        //all except salary
        $query = 'SELECT COUNT(*) AS count_total FROM dr_sales';

        $result = SelectCondFree($query, 'dr_sales', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $countsales = isset($rowItem['count_total']) ? $rowItem['count_total'] : 'N/A';

        try {
            return $countsales;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getTotalExpenses()
    {
        //all except salary
        $query = 'SELECT SUM(totalexpense) AS exp_total, SUM(cash_sales) AS cash_total, SUM(till_sales) AS till_total, SUM(totalincome) AS incometotal, SUM(totalprofit) AS profittotal, SUM(total_sales) AS sales_total FROM dr_nettotal';

        $result = SelectCondFree($query, 'dr_nettotal', $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }

    public function saveSaleRecordNowEdit($cyber, $ps, $movie,$date)
    {

      //update movie shop  
      $query = 'UPDATE dr_movieshop SET cash=?, till=?, edited_by=? WHERE date_created=?';

      $binders = "ssss";
      
      $values = array($movie['cash'], $movie['till'], date('y-m-d h:i:s A',time()),$date); 

      //update ps
      $query2 = 'UPDATE dr_playstation SET cash=?, till=?, edited_by=? WHERE date_created=?';

      $binders2 = "ssss";
      
      $values2 = array($ps['cash'], $ps['till'], date('y-m-d h:i:s A',time()),$date); 

      //update cyber
      $query3 = 'UPDATE dr_cybershop SET cash=?, till=?, edited_by=? WHERE date_created=?';

      $binders3 = "ssss";
      
      $values3 = array($cyber['cash'], $cyber['till'], date('y-m-d h:i:s A',time()),$date); 

      $query6 = 'SELECT SUM(expense_cost) AS exp_total FROM dr_expenses WHERE date_created=? GROUP BY date_created';

      $binders6 = "s";

      $parameters6 = array($date);

      $result6 = SelectCond($query6, $binders6, $parameters6, $this->db);

      $row6 = $result6->get_result();

      $rowItem6 = $row6->fetch_assoc();
      
      $expTotal = isset($rowItem6['exp_total']) ? $rowItem6['exp_total'] : '';

      $query7 = 'SELECT SUM(cash) + SUM(till) AS total_sales FROM dr_sales WHERE date_created = ?';

      $binders7 = "s";

      $parameters7 = array($date);

      $result7 = SelectCond($query7, $binders7, $parameters7, $this->db);

      $row7 = $result7->get_result();

      $rowItem7 = $row7->fetch_assoc();
      
      $totalsales = isset($rowItem7['total_sales']) ? $rowItem7['total_sales'] : '';
      //total profit
      $query8 = 'SELECT SUM(profit) AS total_profit FROM dr_sales WHERE date_created = ?';

      $binders8 = "s";

      $parameters8 = array($date);

      $result8 = SelectCond($query8, $binders8, $parameters8, $this->db);

      $row8 = $result8->get_result();

      $rowItem8 = $row8->fetch_assoc();
       
      $totalprofit = isset($rowItem8['total_profit']) ? $rowItem8['total_profit'] : '';

      
      //update net total
      $totalcash = $cyber['cash'] + $ps['cash'] + $$movie['cash'];
      $totaltill = $cyber['till'] + $ps['till'] + $$movie['till'];
      $totalincome = $totalcash + $totaltill;

      $querynet = 'UPDATE dr_nettotal SET total_sales=?, totalprofit=?, totalincome=?, totalexpense=?, cash_sales=?, till_sales=?, edited_by=? WHERE date_created=?';

      $bindersnet = "ssssssss";
      
      $valuesnet = array($totalsales, $totalprofit, $totalincome, $expTotal, $totalcash, $totaltill, date('y-m-d h:i:s A',time()), $date); 

      try { 
          Update($query, $binders, $values, 'dr_movieshop',$this->db);
          Update($query2, $binders2, $values2, 'dr_playstation',$this->db);
          Update($query3, $binders3, $values3, 'dr_cybershop',$this->db);
          Update($querynet, $bindersnet, $valuesnet, 'dr_nettotal',$this->db);
          return true;
      } catch (Error $e) {
          return false;
      }
    }

    public function getAdmins()
    {
        $query = 'SELECT `user_id`, username, email, `password`, is_admin, date_created, time_created, created_by, creator_ip FROM dr_user WHERE user_id !=?';

        $binders = "s";

        $param = array(3);

        $result = SelectCond($query, $binders, $param, $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getExpenseById($date)
    { 
        $query = 'SELECT expense_id, expense_item, expense_cost, date_created, time_created, created_by, creator_ip FROM dr_expenses WHERE date_created=?';

        $binders = "s";

        $param = array($date);

        $result = SelectCond($query, $binders, $param, $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getAllRecordNetT($id)
    { 
        $query = 'SELECT sales_id, total_sales, totalprofit, totalincome, totalexpense, cash_sales, till_sales, date_created, time_created, created_by, creator_ip FROM dr_nettotal WHERE sales_id=?';

        $binders = "s";

        $param = array($id);

        $result = SelectCond($query, $binders, $param, $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getAllRecordNetTotal($id)
    { 
        $query = 'SELECT date_created FROM dr_nettotal WHERE sales_id=?';

        $binders = "s";

        $param = array($id);

        $result = SelectCond($query, $binders, $param, $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $datesold = isset($rowItem['date_created']) ? $rowItem['date_created'] : '';

        try {
            return $datesold;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getCurrentProfitTotal()
    {
        $query = 'SELECT SUM(profit) AS current_total FROM dr_sales';

        $result = SelectCondFree($query, 'dr_sales', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $salescurrentprofit = isset($rowItem['current_total']) ? $rowItem['current_total'] : '';

        try {
            return $salescurrentprofit;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getCurrentNetSumTotal()
    {
        $query = 'SELECT SUM(totalincome + total_sales) AS currentsum FROM dr_nettotal';

        $result = SelectCondFree($query, 'dr_nettotal', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $currentsum = isset($rowItem['currentsum']) ? $rowItem['currentsum'] : '';

        try {
            return $currentsum;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getCurrentNetDiffTotal()
    {
        $query = 'SELECT SUM(totalexpense) AS currentdiff FROM dr_nettotal';

        $result = SelectCondFree($query, 'dr_nettotal', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $currentdiff = isset($rowItem['currentdiff']) ? $rowItem['currentdiff'] : '';

        try {
            return $currentdiff;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getCurrentSaleTotal()
    {
        $query = 'SELECT SUM(selling_price) AS current_total FROM dr_sales';

        $result = SelectCondFree($query, 'dr_sales', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $salescurrenttotal = isset($rowItem['current_total']) ? $rowItem['current_total'] : '';

        try {
            return $salescurrenttotal;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getAlltimeSaleCount()
    {
    //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $query = 'SELECT COUNT(*) AS cnt FROM dr_sales';

        $result = SelectCondFree($query, 'dr_sales', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
            
        $alltimesalecount = isset($rowItem['cnt']) ? $rowItem['cnt'] : 'N/A';

        try {
            return $alltimesalecount;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getAlltimeExpenses()
    {
        $query = 'SELECT expense_id, expense_item, expense_cost, date_created FROM dr_expenses GROUP BY DATE(date_created) ORDER BY expense_id DESC';
    
        $result = SelectCondFree($query, 'dr_expenses', $this->db);
    
        $row = $result->get_result();
    
        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getAlltimeTotal()
    {
        $query = 'SELECT sales_id, total_sales, totalprofit, totalincome, totalexpense, date_created FROM dr_nettotal ORDER BY sales_id DESC';
    
        $result = SelectCondFree($query, 'dr_nettotal', $this->db);
    
        $row = $result->get_result();
    
        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getAlltimeSales()
    {
        $query = 'SELECT sales_id, sales_item, sales_id, selling_price, buying_price, profit, date_created FROM dr_sales ORDER BY sales_id DESC';
    
        $result = SelectCondFree($query, 'dr_sales', $this->db);
    
        $row = $result->get_result();
    
        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getCurrentCyberTotal()
    {
        $query = 'SELECT SUM(cash) + SUM(till) AS current_total FROM dr_cybershop';

        $result = SelectCondFree($query, 'dr_cybershop', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $cybercurrenttotal = isset($rowItem['current_total']) ? $rowItem['current_total'] : '';

        try {
            return $cybercurrenttotal;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getCurrentPsTotal()
    {
        $query = 'SELECT SUM(cash) + SUM(till) AS current_total FROM dr_playstation';

        $result = SelectCondFree($query, 'dr_playstation', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $pscurrenttotal = isset($rowItem['current_total']) ? $rowItem['current_total'] : '';

        try {
            return $pscurrenttotal;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getCurrentMovieTotal()
    {
        $query = 'SELECT SUM(cash) + SUM(till) AS current_total FROM dr_movieshop';

        $result = SelectCondFree($query, 'dr_movieshop', $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $shopcurrenttotal = isset($rowItem['current_total']) ? $rowItem['current_total'] : '';

        try {
            return $shopcurrenttotal;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getNetTotal()
    {
        $query = 'SELECT sales_id, date_created, time_created, cash_sales, till_sales FROM dr_nettotal ORDER BY sales_id DESC';

        $result = SelectCondFree($query, 'dr_nettotal', $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getMovieTotal()
    {
        $query = 'SELECT date_created, cash, till FROM dr_movieshop ORDER BY record_id DESC';

        $result = SelectCondFree($query, 'dr_movieshop', $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getCyberValuesByDate($date)
    {
        $query = 'SELECT cash, till FROM dr_cybershop WHERE date_created=?';

        $binders= "s";

        $values = array($date);

        $result = SelectCond($query, $binders, $values, $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getPsValuesByDate($date)
    {
        $query = 'SELECT cash, till FROM dr_playstation WHERE date_created=?';

        $binders= "s";

        $values = array($date);

        $result = SelectCond($query, $binders, $values, $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getMovieValuesByDate($date)
    {
        $query = 'SELECT cash, till FROM dr_movieshop WHERE date_created=?';

        $binders= "s";

        $values = array($date);

        $result = SelectCond($query, $binders, $values, $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getNetValuesByDate($date)
    {
        $query = 'SELECT sales_id, total_sales, totalprofit, totalincome, totalexpense, cash_sales, till_sales, date_created, time_created, created_by, creator_ip FROM dr_nettotal WHERE date_created=?';

        $binders= "s";

        $values = array($date);

        $result = SelectCond($query, $binders, $values, $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getCyberTotal()
    {
        $query = 'SELECT date_created, cash, till FROM dr_cybershop ORDER BY record_id DESC';

        $result = SelectCondFree($query, 'dr_cybershop', $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getPsTotal()
    {
        $query = 'SELECT date_created, cash, till FROM dr_playstation ORDER BY record_id DESC';

        $result = SelectCondFree($query, 'dr_playstation', $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }

    public function saveNetTotalNow($data)
    {
        //get total sales
        $query = 'SELECT SUM(cash) + SUM(till) AS total_sales FROM dr_sales WHERE date_created = ?';

        $binders = "s";

        $parameters = array($data['date']);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $totalsales = isset($rowItem['total_sales']) ? $rowItem['total_sales'] : '';
        //total profit
        $query2 = 'SELECT SUM(profit) AS total_profit FROM dr_sales WHERE date_created = ?';

        $binders2 = "s";

        $parameters2 = array($data['date']);

        $result2 = SelectCond($query2, $binders2, $parameters2, $this->db);

        $row2 = $result2->get_result();

        $rowItem2 = $row2->fetch_assoc();
         
        $totalprofit = isset($rowItem2['total_profit']) ? $rowItem2['total_profit'] : '';
        //total cyber
        $query3 = 'SELECT SUM(cash + till) AS cybertotal FROM dr_cybershop WHERE date_created=?';

        $binders3 = "s";

        $parameters3 = array($data['date']);

        $result3 = SelectCond($query3, $binders3, $parameters3, $this->db);

        $row3 = $result3->get_result();

        $rowItem3 = $row3->fetch_assoc();
        
        $cyberTotal = isset($rowItem3['cybertotal']) ? $rowItem3['cybertotal'] : '';
        //total shop
        $query4 = 'SELECT SUM(cash + till) AS movieshop_total FROM dr_movieshop WHERE date_created=?';

        $binders4 = "s";

        $parameters4 = array($data['date']);

        $result4 = SelectCond($query4, $binders4, $parameters4, $this->db);

        $row4 = $result4->get_result();

        $rowItem4 = $row4->fetch_assoc();
        
        $shopTotal = isset($rowItem4['movieshop_total']) ? $rowItem4['movieshop_total'] : '';
        //total ps
        $query5 = 'SELECT SUM(cash + till) AS ps_total FROM dr_playstation WHERE date_created=?';

        $binders5 = "s";

        $parameters5 = array($data['date']);

        $result5 = SelectCond($query5, $binders5, $parameters5, $this->db);

        $row5 = $result5->get_result();

        $rowItem5 = $row5->fetch_assoc();
        
        $psTotal = isset($rowItem5['ps_total']) ? $rowItem5['ps_total'] : '';
        //total income
        $TotalIncome = $cyberTotal + $shopTotal + $psTotal;
        //total expense
        $query6 = 'SELECT SUM(expense_cost) AS exp_total FROM dr_expenses WHERE date_created=? GROUP BY date_created';

        $binders6 = "s";

        $parameters6 = array($data['date']);

        $result6 = SelectCond($query6, $binders6, $parameters6, $this->db);

        $row6 = $result6->get_result();

        $rowItem6 = $row6->fetch_assoc();
        
        $expTotal = isset($rowItem6['exp_total']) ? $rowItem6['exp_total'] : '';
        //total till
        $qtill = 'SELECT SUM(tbl.till) AS total_till FROM(SELECT till FROM dr_cybershop WHERE date_created=? UNION ALL SELECT till FROM dr_movieshop WHERE date_created=? UNION ALL SELECT till FROM dr_playstation WHERE date_created=?) tbl';

        $binderstill = "sss";

        $parameterstill = array($data['date'], $data['date'], $data['date']);

        $resulttill = SelectCond($qtill, $binderstill, $parameterstill, $this->db);

        $rowtill = $resulttill->get_result();

        $rowItemtill = $rowtill->fetch_assoc();
        
        $totalTill = isset($rowItemtill['total_till']) ? $rowItemtill['total_till'] : '';

        //total cash
        $qc = 'SELECT SUM(tbl.cash) AS total_cash FROM(SELECT cash FROM dr_cybershop WHERE date_created=? UNION ALL SELECT cash FROM dr_movieshop WHERE date_created=? UNION ALL SELECT cash FROM dr_playstation WHERE date_created=?) tbl';

        $bindersc = "sss";

        $parametersc = array($data['date'], $data['date'], $data['date']);

        $resultc = SelectCond($qc, $bindersc, $parametersc, $this->db);

        $rowc = $resultc->get_result();

        $rowItemc = $rowc->fetch_assoc();
        
        $totalCash = isset($rowItemc['total_cash']) ? $rowItemc['total_cash'] : '';

        //create 
        $fields = array('total_sales', 'totalprofit', 'totalincome', 'totalexpense', 'cash_sales', 'till_sales', 'date_created', 'time_created', 'created_by', 'creator_ip');

        $placeholders = array('?', '?', '?', '?', '?', '?', '?', '?', '?', '?');
  
        $bindersCountNew = "ssssssssss";
  
        $values = array($totalsales, $totalprofit, $TotalIncome, $expTotal, $totalCash, $totalTill, $data['date'], $data['time'], $data['creator'], $data['ip']);
  
        try {
            Insert(
                $fields,
                $placeholders,
                $bindersCountNew,
                $values,
                'dr_nettotal',
                $this->db
            );          
            return true;
        } catch (Error $e) {
            return false;
        }
    }

    public function saveSaleRecordNow($cyber, $ps, $shop)
    {
        $fields = array('cash', 'till', 'date_created', 'time_created', 'created_by', 'creator_ip');

        $placeholders = array('?', '?', '?', '?', '?', '?');
  
        $bindersCountNew = "ssssss";
  
        $values = array($cyber['cash'], $cyber['till'], $cyber['date'], $cyber['time'], $cyber['creator'], $cyber['ip']);
  
        $fieldsp = array('cash', 'till', 'date_created', 'time_created', 'created_by', 'creator_ip');

        $placeholdersp = array('?', '?', '?', '?', '?', '?');
  
        $bindersCountNewp = "ssssss";
  
        $valuesp = array($ps['cash'], $ps['till'], $ps['date'], $ps['time'], $ps['creator'], $ps['ip']);

        $fieldsm = array('cash', 'till', 'date_created', 'time_created', 'created_by', 'creator_ip');

        $placeholdersm = array('?', '?', '?', '?', '?', '?');
  
        $bindersCountNewm = "ssssss";
  
        $valuesm = array($shop['cash'], $shop['till'], $shop['date'], $shop['time'], $shop['creator'], $shop['ip']);
  
        
        try {
            Insert(
                $fields,
                $placeholders,
                $bindersCountNew,
                $values,
                'dr_cybershop',
                $this->db
            );      
            Insert(
                $fieldsp,
                $placeholdersp,
                $bindersCountNewp,
                $valuesp,
                'dr_playstation',
                $this->db
            );      
            Insert(
                $fieldsm,
                $placeholdersm,
                $bindersCountNewm,
                $valuesm,
                'dr_movieshop',
                $this->db
            );      
            return true;
        } catch (Error $e) {
            return false;
        }
    }

    public function CheckSaleExpenseNow($date)
    {
        $query = 'SELECT sales_id FROM dr_sales WHERE date_created=?';

        $binders = "s";

        $parameters = array($date);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        $qE = 'SELECT expense_id FROM dr_expenses WHERE date_created=?';

        $bindersE = 's';

        $parametersE = array($date);

        $resultE = SelectCond($qE, $bindersE, $parametersE, $this->db);

        $rowE = $resultE->get_result();

        if($rowE->num_rows >=1 && $row->num_rows >= 1){
            return 1;
        }elseif($rowE->num_rows <=1 && $row->num_rows >=1){
            return 3;
        }else if($rowE->num_rows >=1 && $row->num_rows <=1){
            return 3;
        }else if($rowE->num_rows <=1 && $row->num_rows <= 1){
            return 4;
        }

    }

    public function DeleteExpenseById($id)
    {
        $query = 'DELETE FROM dr_expenses WHERE expense_id=?';

        $binders ="s";

        $parameters = array($id);

        if(Delete($query, $binders, $parameters, 'dr_expenses', $this->db)){
            return true;
        }
        else{
            return false;
        }

    }

    public function SaveExpenseToday($data)
    {
        $fields = array('expense_item', 'expense_cost', 'date_created', 'time_created', 'created_by', 'creator_ip');

        $placeholders = array('?', '?', '?', '?', '?', '?');
  
        $bindersCountNew = "ssssss";
  
        $values = array($data['name'], $data['amount'], $data['date'], $data['time'], $data['creator'], $data['ip']);
  
        try {
            Insert(
                $fields,
                $placeholders,
                $bindersCountNew,
                $values,
                'dr_expenses',
                $this->db
            );      
            return true;
        } catch (Error $e) {
            return false;
        }
    }

    public function getExpenseToday($date)
    {
        $query = 'SELECT expense_id, expense_item, expense_cost FROM dr_expenses WHERE date_created=?';

        $binders = "s";

        $parameters = array($date);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        }  
    }

    public function getExpenseTodayEdit($date)
    {
        $query = 'SELECT expense_id, expense_item, expense_cost FROM dr_expenses WHERE date_created=?';

        $binders = "s";

        $parameters = array($date);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        }  
    }

    public function getSaleTodayEdit($date)
    {
        $query = 'SELECT sales_id, sales_item, buying_price, selling_price, cash, till, profit, date_created, time_created, created_by, creator_ip FROM dr_sales WHERE date_created=?';

        $binders = "s";

        $parameters = array($date);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        }  
    }

    public function DeleteSaleById($id)
    {
        $query = 'DELETE FROM dr_sales WHERE sales_id=?';

        $binders ="s";

        $parameters = array($id);

        if(Delete($query, $binders, $parameters, 'dr_sales', $this->db)){
            return true;
        }
        else{
            return false;
        }

    }

    public function getSoldToday($date)
    {
        $query = 'SELECT sales_id, sales_item FROM dr_sales WHERE date_created=?';

        $binders = "s";

        $parameters = array($date);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        } 
    }

    public function getLatestSold(){
        //get last id to be inserted, cause we can never know the exact id, since its a cosed app this flaw can be ignored but documented

        $query ="SELECT MAX(sales_id) AS id FROM dr_sales";

        $result = SelectCondFree($query, 'dr_sales',$this->db);

        $row = $result->get_result();

        $data = $row->fetch_assoc();

        $q = 'SELECT sales_id, sales_item FROM dr_sales WHERE sales_id=?';

        $b = "s";

        $p = array($data['id']);

        $result2 = SelectCond($q, $b, $p, $this->db);

        $row2 = $result2->get_result();

        try {
            return $row2;
        } catch (Error $e) {
            return false;
        } 
    }

    //get item count in inventory
    public function getItemInventoryCount($name)
    {
        $query = 'SELECT item_quantity FROM dr_inventory WHERE item_name = ?';

        $binders = "s";

        $parameters = array($name);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        }
    }

    public function saveToSales($data)
    {
      $fields = array('sales_item', 'buying_price', 'selling_price', 'cash', 'till', 'profit', 'date_created', 'time_created', 'created_by', 'creator_ip');

      $placeholders = array('?', '?', '?', '?', '?', '?', '?', '?', '?', '?');

      $bindersCountNew = "ssssssssss";

      $values = array($data['name'], $data['bought'], empty($data['cash']) ? $data['till']: $data['cash'], $data['cash'], $data['till'], $data['profit'], $data['date'], $data['time'], $data['creator'], $data['ip']);

      try {
          Insert(
              $fields,
              $placeholders,
              $bindersCountNew,
              $values,
              'dr_sales',
              $this->db
          );      
          return true;
      } catch (Error $e) {
          return false;
      }
    }



    public function getInventoryItemByIdII($id)
    {
        $query = 'SELECT item_id, item_name, item_quantity, item_buying, item_model, `image`, date_created, time_created, created_by, edited_by, creator_ip FROM dr_inventory WHERE item_id = ?';

        $binders = "s";

        $parameters = array($id);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        }
    }

    public function getInventoryItemById($id)
    {
        $query = 'SELECT item_name FROM dr_inventory WHERE item_id = ?';

        $binders = "s";

        $parameters = array($id);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $name = isset($rowItem['item_name']) ? $rowItem['item_name'] : 'id:not found';

        try {
            return $name;
        } catch (Error $e) {
            return false;
        }
    }

    public function getItemSaleByName($name)
    {
        $query = 'SELECT sales_id, sales_item, buying_price, selling_price, cash, till, profit, date_created, time_created, created_by, creator_ip FROM dr_sales WHERE sales_item = ?';

        $binders = "s";

        $parameters = array($name);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        $numRows = $row->num_rows;

        if ($numRows > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**get sold item count */
    public function getItemSoldCount($name)
    {
        $query = 'SELECT COUNT(*) AS cnt FROM dr_sales WHERE sales_item = ?';

        $binders = "s";

        $parameters = array($name);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $count = isset($rowItem['cnt']) ? $rowItem['cnt'] : 'id:not found';

        try {
            return $count;
        } catch (Error $e) {
            return false;
        }
    }

    public function getInventoryData()
    {
        $query = 'SELECT item_id, item_name, item_quantity, item_buying, item_model, `image`, date_created, time_created, created_by, edited_by, creator_ip FROM dr_inventory WHERE item_id !=? ORDER BY item_id DESC';

        $BINDERS = "s";

        $param = array(5);

        $result = SelectCond($query, $BINDERS, $param, $this->db);

        $row = $result->get_result();

        try {
            return $row;
        } catch (Error $e) {
            return false;
        }
    }

    public function getCashoutById($id)
    {
        $query = 'SELECT cash_id FROM dr_cashout WHERE cash_id = ?';

        $binders = "s";

        $parameters = array($id);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $id = isset($rowItem['cash_id']) ? $rowItem['cash_id'] : 'id:not found';

        try {
            return $id;
        } catch (Error $e) {
            return false;
        }
    }

    public function getRecordById($id)
    {
        $query = 'SELECT sales_id, date_created FROM dr_nettotal WHERE sales_id = ?';

        $binders = "s";

        $parameters = array($id);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $count = isset($rowItem['sales_id']) ? $rowItem['sales_id'] : 'id:not found';

        try {
            return $count;
        } catch (Error $e) {
            return false;
        }
    }

    public function getRecordDateById($id)
    {
        $query = 'SELECT date_created FROM dr_nettotal WHERE sales_id = ?';

        $binders = "s";

        $parameters = array($id);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $date = isset($rowItem['date_created']) ? $rowItem['date_created'] : 'id:not found';

        try {
            return $date;
        } catch (Error $e) {
            return false;
        }
    }

    public function getItemById($id)
    {
        $query = 'SELECT item_id, item_name, item_quantity, item_buying, item_model, `image`, date_created, time_created, created_by, edited_by, creator_ip FROM dr_inventory WHERE item_id = ?';

        $binders = "s";

        $parameters = array($id);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $count = isset($rowItem['item_name']) ? $rowItem['item_name'] : 'id:not found';

        try {
            return $count;
        } catch (Error $e) {
            return false;
        }
    }

    public function getItemByName($name)
    {
        $query = 'SELECT item_id, item_name, item_quantity, item_buying, item_model, `image`, date_created, time_created, created_by, edited_by, creator_ip FROM dr_inventory WHERE item_name = ?';

        $binders = "s";

        $parameters = array($name);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        $numRows = $row->num_rows;

        if ($numRows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getImageByName($name)
    {
        $query = 'SELECT item_id, item_name, item_quantity, item_buying, item_model, `image`, date_created, time_created, created_by, edited_by, creator_ip FROM dr_inventory WHERE `image` = ?';

        $binders = "s";

        $parameters = array($name);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        $numRows = $row->num_rows;

        if ($numRows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getBuyingByDate($date, $id)
    {
        $query = 'SELECT item_buying FROM dr_inventory WHERE item_id=?';

        $binders = "s";

        $parameters = array($id);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $buying = isset($rowItem['item_buying']) ? $rowItem['item_buying'] : 'id:not found';

        try {
            return $buying;
        } catch (Error $e) {
            return false;
        }
    }

    public function getBuyingByName($id)
    {
        $query = 'SELECT item_buying FROM dr_inventory WHERE item_id = ?';

        $binders = "s";

        $parameters = array($id);

        $result = SelectCond($query, $binders, $parameters, $this->db);

        $row = $result->get_result();

        $rowItem = $row->fetch_assoc();
        
        $buying = isset($rowItem['item_buying']) ? $rowItem['item_buying'] : 'id:not found';

        try {
            return $buying;
        } catch (Error $e) {
            return false;
        }
    }

    public function saveToInventoryEdit($data)
    {

      $query = 'UPDATE dr_inventory SET item_name=?, item_quantity=?, item_buying=?, item_model=?, `image`=?, edited_by=? WHERE item_id=?';

      $binders = "sssssss";
      
      $values = array($data['itemName'], $data['itemquantity'], $data['bp'], $data['model'], $data['imagename'], $data['edited_by'], $data['id']); 

      try { 
          Update($query, $binders, $values, 'dr_inventory',$this->db);
          return true;
      } catch (Error $e) {
          return false;
      }
    }

    public function saveToInventoryNullEdit($data)
    {

      $query = 'UPDATE dr_inventory SET item_name=?, item_quantity=?, item_buying=?, item_model=?, date_created=?, time_created=?, created_by=?, edited_by=? WHERE item_id=?';

      $binders = "sssssssss";
      
      $values = array($data['itemName'], $data['itemquantity'], $data['bp'], $data['model'], $data['date'], $data['time'], $data['creator'], $data['edited_by'], $data['id']); 

      try { 
          Update($query, $binders, $values, 'dr_inventory',$this->db);
          return true;
      } catch (Error $e) {
          return false;
      }
    }

    public function saveToInventory($data)
    {
      $fields = array('item_name', 'item_quantity', 'item_buying', 'item_model', 'image', 'date_created', 'time_created', 'created_by', 'creator_ip');

      $placeholders = array('?', '?', '?', '?', '?', '?', '?', '?', '?');

      $bindersCountNew = "sssssssss";

      $values = array($data['itemName'], $data['itemquantity'], $data['bp'], $data['model'], $data['imagename'], $data['date'], $data['time'], $data['creator'], $data['ip']);
      
      try {
          Insert(
              $fields,
              $placeholders,
              $bindersCountNew,
              $values,
              'dr_inventory',
              $this->db
          );
        
          return true;
      } catch (Error $e) {
          return false;
      }
    }

    public function saveToInventoryNull($data)
    {
      $fields = array('item_name', 'item_quantity', 'item_buying', 'item_model', 'date_created', 'time_created', 'created_by', 'creator_ip');

      $placeholders = array('?', '?', '?', '?', '?', '?', '?', '?');

      $bindersCountNew = "ssssssss";

      $values = array($data['itemName'], $data['itemquantity'], $data['bp'], $data['model'], $data['date'], $data['time'], $data['creator'], $data['ip']);

      try {
          Insert(
              $fields,
              $placeholders,
              $bindersCountNew,
              $values,
              'dr_inventory',
              $this->db
          );
          return true;
      } catch (Error $e) {
          return false;
      }
    }

}