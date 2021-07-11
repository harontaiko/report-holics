<?php

class Pages extends Controller
{

    public function __construct()
    {
      $this->pageModel = $this->model('Page'); 
    }

    public function dailyreport()
    {
      unset($_SESSION['cash']);
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",  
        ];
        redirect("users/index");
      } 
      //get all sales data
      $net = $this->pageModel->getNetTotal();
      
      $db = $this->pageModel->getDatabaseConnection();

      $inventoryData = $this->pageModel->getInventoryData();

      $data = ['title'=>'Daily Report', "inventory" => $inventoryData, 'db'=>$db, 'net'=>$net];

      $this->view('pages/dailyreport', $data);
    }

    public function saveStock()
    {
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",  
        ];
        redirect("users/index");
      } 

      $data = ['title'=>'Daily Report'];

      if($_SERVER['REQUEST_METHOD'] == 'POST')
      {
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

          $data = ['title'=>'stock', 'in'=>$_POST['in'], 'out'=>$_POST['out']];

          if($this->pageModel->addStock($data))
          {
            echo json_encode(array('statusCode'=>200));
          }else{
            echo json_encode(array('statusCode'=>317));
          }
      }else{
        http_response_code(404);
        include('../app/404.php');
        die();
      }
      
    }

    public function receipts($for, $val)
    {
      //unset cash
      unset($_SESSION['cash']);
      if(isset($val) && isset($val)){
        if (!isset($_SESSION["user_id"])) {
          $data = [
            "title" => "Daily Report",  
          ];
          redirect("users/index");
        } 

        $db = $this->pageModel->getDatabaseConnection();

        $inventoryData = $this->pageModel->getInventoryData();

        $data = ['title'=>''.$for.' receipt', "inventory" => $inventoryData, 'db'=>$db, 'val'=>$val, 'for'=>$for];

        $this->view('pages/receipts', $data);
      }else{
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function cashOuts()
    {
      unset($_SESSION['cash']);
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",  
        ];
        redirect("users/index");
      } 
      //get all sales data
      $net = $this->pageModel->getNetTotal();
      
      $db = $this->pageModel->getDatabaseConnection();

      $inventoryData = $this->pageModel->getInventoryData();

      $out = getCashout('', $db);

      $data = ['title'=>'Receipts', 'out'=>$out, "inventory" => $inventoryData, 'db'=>$db, 'net'=>$net];

      $this->view('pages/cashOuts', $data);
    }

    public function attatchReceipt($date)
    {
      if(isset($date)){
        if (!isset($_SESSION["user_id"])) {
          $data = [
            "title" => "Daily Report",  
          ];
          redirect("users/index");
        } 
        
        $db = $this->pageModel->getDatabaseConnection();

        $inventoryData = $this->pageModel->getInventoryData();

        $data = ['title'=>'Attatch Receipt', "inventory" => $inventoryData, 'db'=>$db, 'date'=>htmlspecialchars($date)];

        $this->view('pages/attatchReceipt', $data);
      }else{
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function list()
    {
      unset($_SESSION['cash']);
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",  
        ];
        redirect("users/index");
      } 
      //get all sales data
      $net = $this->pageModel->getNetTotal();
      
      $db = $this->pageModel->getDatabaseConnection();

      $inventoryData = $this->pageModel->getInventoryData();

      $data = ['title'=>'Inventory', "inventory" => $inventoryData, 'db'=>$db, 'net'=>$net];

      $this->view('pages/list', $data);
    }

    public function inventory()
    {
      unset($_SESSION['cash']);
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",  
        ];
        redirect("users/index");
      } 
      //get all sales data
      $net = $this->pageModel->getNetTotal();
      
      $db = $this->pageModel->getDatabaseConnection();

      $inventoryData = $this->pageModel->getInventoryData();

      $data = ['title'=>'Inventory', "inventory" => $inventoryData, 'db'=>$db, 'net'=>$net];

      $this->view('pages/inventory', $data);
    }

    public function saveCashout()
    {
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",  
        ];
        redirect("users/index");
      } 

      $data = ['title'=>'Daily Report'];

      
      if($_SERVER['REQUEST_METHOD'] == 'POST')
      {
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

          $data = ['title' => 'Daily Report',
          'Amount'=>$_POST['Amount'],
          'Usage'=>$_POST['Usage'],
          'Date'=>$_POST['Date'],
          'Handler'=>$_POST['Handler'],
          'From'=>$_POST['From'],
          'Receipt'=>$_POST['Receipt'],
        ];

        //check for enough cash in station
        $currentstationNet = $this->pageModel->getStationTotal($data['From']);
        if($data['Amount'] > $currentstationNet){
          echo json_encode(array('statusCode'=>318));
        }else{
          if($this->pageModel->SaveCashout($data)){
            echo json_encode(array('statusCode'=>200));
          }
          else{
            echo json_encode(array('statusCode'=>317));
          }
        }
      }
      else{
        http_response_code(404);
        include('../app/404.php');
        die();
      }
  
    }

    public function cashReceipt($val)
    {
      //unset cash
      unset($_SESSION['cash']);
      if(isset($val)){
        if (!isset($_SESSION["user_id"])) {
          $data = [
            "title" => "Daily Report",  
          ];
          redirect("users/index");
        } 

        $db = $this->pageModel->getDatabaseConnection();

        $inventoryData = $this->pageModel->getInventoryData();

        $arr = explode(',', $val);
        $data = ['title'=>'Cashout Receipt', "inventory" => $inventoryData, 'db'=>$db, 'val'=>$arr];

        //store in session
        $_SESSION['cash'] = $arr;

        $this->view('pages/cashReceipt', $data);
      }else{
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function cashOut()
    {
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",  
        ];
        redirect("users/index");
      } 
      //get all sales data
      $net = $this->pageModel->getNetTotal();
      
      $db = $this->pageModel->getDatabaseConnection();

      $inventoryData = $this->pageModel->getInventoryData();

      $data = ['title'=>'Cash Out', "inventory" => $inventoryData, 'db'=>$db, 'net'=>$net];

      $this->view('pages/cashOut', $data);
    }

    public function DeleteItem()
    {
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",  
        ];
        redirect("users/index");
      } 

      $data = ['title'=>'Daily Report'];

      if($_SERVER['REQUEST_METHOD'] == 'POST')
      {
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

          $data = ['title' => 'Daily Report',
          'id'=>$_POST['ID'],
        ];

        if($this->pageModel->DeleteItem($data['id'])){
          echo json_encode(array('statusCode'=>200));
        }
        else{
          echo json_encode(array('statusCode'=>317));
        }
      }
      else{
        http_response_code(404);
        include('../app/404.php');
        die();
      } 
    }

    public function removeItem($id)
    {
      if(isset($id)){
        if (!isset($_SESSION["user_id"])) {
          $data = [
            "title" => "Daily Report",  
          ];
          redirect("users/index");
        } 
        
        $db = $this->pageModel->getDatabaseConnection();

        $inventoryData = $this->pageModel->getInventoryData();

        $name = $this->pageModel->getItemById($id);

        $data = ['title'=>'Delete '.$name.'', "inventory" => $inventoryData, 'db'=>$db, 'id'=>htmlspecialchars($id)];

        $this->view('pages/removeItem', $data);
      }else{
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }
    

    public function trends()
    {
          if (!isset($_SESSION["user_id"])) {
            $data = [
              "title" => "Daily Report",  
            ];
            redirect("users/index");
          } 
          
          $db = $this->pageModel->getDatabaseConnection();

          $users = $this->pageModel->getAdmins();
     
          $inventoryData = $this->pageModel->getInventoryData();

          $total = $this->pageModel->getTotalExpenses();
          $arr = array();
          while($t = $total->fetch_assoc()){
            array_push($arr, $t);
          }

          $avgsales = $this->pageModel->getAverageDailySales();
          $avgcash = $this->pageModel->getAverageDailyCash();
          $avgtill = $this->pageModel->getAverageDailyTill();
          $avgincome = $this->pageModel->getAverageDailyIncome();
          $itemssold = $this->pageModel->getItemsSold();
          $itemsinventory = $this->pageModel->getItemsInventory();
          $itemsinventoryWeek = $this->pageModel->getItemsInventoryWeek();
          $itemsInStock = $this->pageModel->getItemsInStock();
          $itemsoutStock = $this->pageModel->getItemsOutStock();
  
          $data = ['title'=>'Trends', 'row'=>$users, 'weeklycount'=>$itemsinventoryWeek, 'out'=>$itemsoutStock, 'sold'=>$itemssold, 'allitems'=>$itemsinventory, 'stock'=>$itemsInStock, 'db'=>$db, 'inventory'=>$inventoryData, 'row'=>$arr, 'avgsales'=>$avgsales, 'avgcash'=>$avgcash, 'avgtill'=>$avgtill, 'avgincome'=>$avgincome];
  
          $this->view('pages/trends', $data);
    }

    public function activity()
    {
  
          if (!isset($_SESSION["user_id"])) {
            $data = [
              "title" => "Daily Report",  
            ];
            redirect("users/index");
          } 
          
          $db = $this->pageModel->getDatabaseConnection();

          $users = $this->pageModel->getAdmins();
  
          $data = ['title'=>'Activity', 'row'=>$users, 'db'=>$db];
  
          $this->view('pages/activity', $data);
    }

    public function index()
    {
      unset($_SESSION['cash']);
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",  
        ];
        redirect("users/index");
      } 
      //get all sales data
      $net = $this->pageModel->getNetTotal();
      
      $db = $this->pageModel->getDatabaseConnection();

      $inventoryData = $this->pageModel->getInventoryData();

      $data = ['title'=>'Daily Report', "inventory" => $inventoryData, 'db'=>$db, 'net'=>$net];

      $this->view('pages/index', $data);
    }

    public function date($shopname, $from, $to)
    {

       if(isset($from) && isset($shopname) && isset($to)){
        if (!isset($_SESSION["user_id"])) {
          $data = [
            "title" => "Daily Report",  
          ];
          redirect("users/index");
        } 
        
        $db = $this->pageModel->getDatabaseConnection();

        $inventoryData = $this->pageModel->getInventoryData();

        $data = ['title'=>'Filter Report', "inventory" => $inventoryData, 'db'=>$db, 'from'=>htmlspecialchars($from), 'to'=>htmlspecialchars($to), 'shopname'=>htmlspecialchars($shopname)];

        $this->view('pages/date', $data);
      }else{
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function viewEdit($recId)
    {
       if(isset($recId)){
        if (!isset($_SESSION["user_id"])) {
          $data = [
            "title" => "Daily Report",  
          ];
          redirect("users/index");
        } 
        
        $db = $this->pageModel->getDatabaseConnection();

        $inventoryData = $this->pageModel->getInventoryData();

        $datesold = $this->pageModel->getAllRecordNetTotal($recId);

        $inventoryDataAdd = $this->pageModel->getInventoryData();

        //push cyber vals to arr
        $cybervals = getCyberAllDate($datesold, $db);

        $arrcyber = array();

        while( $cb = $cybervals->fetch_assoc()){
          array_push($arrcyber,$cb);
        }

        //push ps vals to arr
        $psvals = getPsAllDate($datesold, $db);

        $arrps = array();

        while( $ps = $psvals->fetch_assoc()){
          array_push($arrps,$ps);
        }

        //push movie vals to arr
        $movievals = getMovieShopAllDate($datesold, $db);

        $arrmovie = array();

        while( $mv = $movievals->fetch_assoc()){
          array_push($arrmovie,$mv);
        }

        //push net total values to array
        $netvals = $this->pageModel->getAllRecordNetT($recId);

        $netarr = array();

        while($nt = $netvals->fetch_assoc()){
          array_push($netarr, $nt);
        }

        date_default_timezone_set('Africa/Nairobi');
        $currentdate = date('Y-m-d h:i:s A', time());

        $data = ['title'=>'View & Edit Record', 'recordDate'=>$datesold, "inventory" => $inventoryData, 'inventoryAdd'=>$inventoryDataAdd, 'db'=>$db, 'id'=>$recId, 'cyber'=>$arrcyber, 'movie'=>$arrmovie, 'ps'=>$arrps, 'netvals'=>$netarr, 'net'=>$netvals, 'date'=>$currentdate];

        $this->view('pages/viewEdit', $data);
      }else{
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function editInventory($itemId)
    {

       if(isset($itemId)){
        if (!isset($_SESSION["user_id"])) {
          $data = [
            "title" => "Daily Report",  
          ];
          redirect("users/index");
        } 
        
        $db = $this->pageModel->getDatabaseConnection();

        $inventoryData = $this->pageModel->getInventoryData();

        $items = $this->pageModel->getInventoryItemByIdII($itemId);

        $itemarray = array();
        while($item = $items->fetch_assoc()){
          array_push($itemarray, $item);
        }

        $data = ['title'=>'Edit', "inventory" => $inventoryData, 'db'=>$db, 'id'=>htmlspecialchars($itemId), 'row'=>$itemarray];

        $this->view('pages/editInventory', $data);
      }else{
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function ViewItem($itemId)
    {

       if(isset($itemId)){
        if (!isset($_SESSION["user_id"])) {
          $data = [
            "title" => "Daily Report",  
          ];
          redirect("users/index");
        } 
        
        $db = $this->pageModel->getDatabaseConnection();

        $inventoryData = $this->pageModel->getInventoryData();

        $items = $this->pageModel->getInventoryItemByIdII($itemId);

        $itemarray = array();
        while($item = $items->fetch_assoc()){
          array_push($itemarray, $item);
        }

        //next id
        $next = $this->pageModel->getNextId($itemId);
        $prev = $this->pageModel->getPreviousId($itemId);
        $last = $this->pageModel->getLastId();
        $first = $this->pageModel->getFirstId();

        $data = ['title'=>'View Item', 'first'=>$first, 'last'=>$last, 'prev'=>$prev, 'next'=>$next, "inventory" => $inventoryData, 'db'=>$db, 'id'=>htmlspecialchars($itemId), 'row'=>$itemarray];

        $this->view('pages/viewItem', $data);
      }else{
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function invoice($invoiceItem, $InvoiceId)
    {

       if(isset($invoiceItem) && isset($InvoiceId)){
        if (!isset($_SESSION["user_id"])) {
          $data = [
            "title" => "Daily Report",  
          ];
          redirect("users/index");
        } 
        
        $db = $this->pageModel->getDatabaseConnection();

        $inventoryData = $this->pageModel->getInventoryData();

        $data = ['title'=>'Invoice', "inventory" => $inventoryData, 'db'=>$db, 'invoiceItem'=>htmlspecialchars($invoiceItem), 'id'=>htmlspecialchars($InvoiceId)];

        $this->view('pages/invoice', $data);
      }else{
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function viewExpense($id)
    {

       if(isset($id)){
        if (!isset($_SESSION["user_id"])) {
          $data = [
            "title" => "Daily Report",  
          ];
          redirect("users/index");
        } 
        
        $db = $this->pageModel->getDatabaseConnection();

        $inventoryData = $this->pageModel->getInventoryData();

        $expense = $this->pageModel->getExpenseById($id);

        //individual vals   
        $arr = array();
        while($mv2 = $expense->fetch_assoc()){
            array_push($arr, $mv2);
        } 

        $data = ['title'=>'Expense - E'.htmlspecialchars(date('Ymd',strtotime($id))).'', 'exp'=>$arr, 'row'=>$expense, "inventory" => $inventoryData, 'db'=>$db, 'date'=>htmlspecialchars($id),];

        $this->view('pages/viewExpense', $data);
      }else{
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function reports($shopname, $reportdate)
    {

       if(isset($shopname) && isset($reportdate)){
        if (!isset($_SESSION["user_id"])) {
          $data = [
            "title" => "Daily Report",  
          ];
          redirect("users/index");
        } 
        
        $db = $this->pageModel->getDatabaseConnection();

        $inventoryData = $this->pageModel->getInventoryData();

        $data = ['title'=>''.htmlspecialchars($reportdate).' Report', "inventory" => $inventoryData, 'db'=>$db, 'shopname'=>htmlspecialchars($shopname), 'reportdate'=>htmlspecialchars($reportdate)];

        $this->view('pages/reports', $data);
      }else{
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function movieShop()
    {
      //unset cash
      unset($_SESSION['cash']);      
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",
        ];
        redirect("users/index");
      }

      date_default_timezone_set('Africa/Nairobi');
      $currentdate = date('M/Y/d h:i:s A', time());

      $inventoryData = $this->pageModel->getInventoryData();

      $db = $this->pageModel->getDatabaseConnection();

      $movie = $this->pageModel->getMovieTotal();

      $alltimeshoptotal = $this->pageModel->getCurrentMovieTotal();

      $data = ['title'=>'Daily Report', 'date'=>$currentdate,"inventory" => $inventoryData, 'db'=>$db, 'movie'=>$movie, 'total'=>$alltimeshoptotal];

      $this->view('pages/movieShop', $data);
    }

    public function cyber()
    {
      //unset cash
      unset($_SESSION['cash']);      
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",
        ];
        redirect("users/index");
      }

      date_default_timezone_set('Africa/Nairobi');
      $currentdate = date('M/Y/d h:i:s A', time());

      $inventoryData = $this->pageModel->getInventoryData();

      $db = $this->pageModel->getDatabaseConnection();

      $cyber = $this->pageModel->getCyberTotal();

      $alltimecybertotal = $this->pageModel->getCurrentCyberTotal();

      $data = ['title'=>'Daily Report', 'date'=>$currentdate, "inventory" => $inventoryData, 'db'=>$db, 'cyber'=>$cyber, 'total'=>$alltimecybertotal];

      $this->view('pages/cyber', $data);
    }

    public function playstation()
    {
      //unset cash
      unset($_SESSION['cash']);      
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",
        ];
        redirect("users/index");
      }

      date_default_timezone_set('Africa/Nairobi');
      $currentdate = date('M/Y/d h:i:s A', time());

      $inventoryData = $this->pageModel->getInventoryData();

      $db = $this->pageModel->getDatabaseConnection();

      $ps = $this->pageModel->getPsTotal();

      $alltimepstotal = $this->pageModel->getCurrentPsTotal();

      $data = ['title'=>'Daily Report', 'date'=>$currentdate, "inventory" => $inventoryData, 'db'=>$db, 'ps'=>$ps, 'total'=>$alltimepstotal];

      $this->view('pages/playstation', $data);
    }

    public function filterReport()
    {
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",
        ];
        redirect("users/index");
      }

      date_default_timezone_set('Africa/Nairobi');
      $currentdate = date('M/Y/d h:i:s A', time());

      $inventoryData = $this->pageModel->getInventoryData();

      $db = $this->pageModel->getDatabaseConnection();

      $data = ['title'=>'Daily Report', 'date'=>$currentdate, "inventory" => $inventoryData, 'db'=>$db];

      $this->view('pages/filterReport', $data);
    }

    public function addItem()
    {
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",
        ];
        redirect("users/index");
      }

      date_default_timezone_set('Africa/Nairobi');
      $currentdate = date('M/Y/d h:i:s A', time());

      $inventoryData = $this->pageModel->getInventoryData();

      $db = $this->pageModel->getDatabaseConnection();

      $data = ['title'=>'Daily Report', 'date'=>$currentdate, "inventory" => $inventoryData, 'db'=>$db];

      $this->view('pages/addItem', $data);
    }

    public function sales()
    {
      //unset cash
      unset($_SESSION['cash']);
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",
        ];
        redirect("users/index");
      }

      date_default_timezone_set('Africa/Nairobi');
      $currentdate = date('M/Y/d h:i:s A', time());

      $inventoryData = $this->pageModel->getInventoryData();

      $db = $this->pageModel->getDatabaseConnection();

      $sales = $this->pageModel->getAlltimeSales();

      $countsales = $this->pageModel->getAlltimeSaleCount();

      $totalsales = $this->pageModel->getCurrentSaleTotal();

      $totalprofit = $this->pageModel->getCurrentProfitTotal();

      $data = ['title'=>'Daily Report', 'date'=>$currentdate, "inventory" => $inventoryData, 'db'=>$db, 'sale'=>$sales, 'count'=>$countsales, 'totalsales'=>$totalsales, 'totalprofit'=>$totalprofit];

      $this->view('pages/sales', $data);
    }

    public function expenses()
    {
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",
        ];
        redirect("users/index");
      }

      date_default_timezone_set('Africa/Nairobi');
      $currentdate = date('M/Y/d h:i:s A', time());

      $inventoryData = $this->pageModel->getInventoryData();

      $db = $this->pageModel->getDatabaseConnection();

      $expenses = $this->pageModel->getAlltimeExpenses();

      $diff = $this->pageModel->getCurrentNetDiffTotal();

      $highest = $this->pageModel->getHighestExpense();

      $arr = array();
      while($h = $highest->fetch_assoc())
      {
        array_push($arr, $h);
      }

      $data = ['title'=>'Daily Report', 'highest'=>$arr, 'date'=>$currentdate, "inventory" => $inventoryData, 'db'=>$db, 'expenses'=>$expenses, 'diff'=>$diff];

      $this->view('pages/expenses', $data);
    }

    public function total()
    {
      //unset cash
      unset($_SESSION['cash']);
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",
        ];
        redirect("users/index");
      }

      date_default_timezone_set('Africa/Nairobi');
      $currentdate = date('M/Y/d h:i:s A', time());

      $inventoryData = $this->pageModel->getInventoryData();

      $db = $this->pageModel->getDatabaseConnection();

      $alltimetotal = $this->pageModel->getAlltimeTotal();

      $sum = $this->pageModel->getCurrentNetSumTotal();

      $diff = $this->pageModel->getCurrentNetDiffTotal();

      $data = ['title'=>'Daily Report', 'date'=>$currentdate, "inventory" => $inventoryData, 'db'=>$db, 'net'=>$alltimetotal, 'sum'=>$sum, 'diff'=>$diff];

      $this->view('pages/total', $data);
    }

    public function sale()
    {
      if (!isset($_SESSION["user_id"])) {
        $data = [
          "title" => "Daily Report",
        ];
        redirect("users/index");
      }
      
      $db = $this->pageModel->getDatabaseConnection();

      date_default_timezone_set('Africa/Nairobi');
      $currentdate = date('Y-m-d h:i:s A', time());

      $inventoryData = $this->pageModel->getInventoryData();
      
      $inventoryDataAdd = $this->pageModel->getInventoryData();

      $dbAdd = $this->pageModel->getDatabaseConnection();

      //select values for today
      $today = date('Y-m-d', time());
      $movie = $this->pageModel->getMovieValuesByDate($today);
      $mvarr = array();
      while($val1 = $movie->fetch_assoc()){
        array_push($mvarr, $val1);
      }

      $cyber = $this->pageModel->getCyberValuesByDate($today);
      $cbarr = array();
      while($val2 = $cyber->fetch_assoc()){
        array_push($cbarr, $val2);
      }

      $ps = $this->pageModel->getPsValuesByDate($today);
      $psarr = array();
      while($val3 = $ps->fetch_assoc()){
        array_push($psarr, $val3);
      }

      $net = $this->pageModel->getNetValuesByDate($today);
      $ntarr = array();
      while($val4 = $net->fetch_assoc()){
        array_push($ntarr, $val4);
      }

      //add store record
      $data = ['title' => 'Add Sale Record', 'net'=>$ntarr, 'cyber'=>$cbarr, 'today'=>$today, 'ps'=>$psarr, 'movie'=>$mvarr, 'date'=>$currentdate, "inventoryAdd" => $inventoryDataAdd, "inventory" => $inventoryData, 'db'=>$db, 'db2' => $dbAdd];

      $this->view('pages/sale',$data);
      
    }

    public function saveSaleCashEdit($date)
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $data = [
          'name' =>$_POST['bought-item'],
          'bought'=>$_POST['bought-price'],
          'cash'=>$_POST['sales-cash'], 
          'till'=>$_POST['sales-till'], 
          'profit'=>$_POST['sales-profit'],
          'date'=>$date, 
          'time'=>date('H:i:s T', time()), 
          'ip'=>get_ip_address(), 
          'creator'=>$_SESSION['user_name']
        ];

        $inventoryData = $this->pageModel->getItemInventoryCount($data['name']);
        $sold = getItemSoldCountInventory($data['name'],$this->pageModel->getDatabaseConnection());

        while($state = $inventoryData->fetch_assoc()){
          $instock = $state['item_quantity'];
        }

        if(($instock - $sold) >= 1){
          if($this->pageModel->saveToSales($data)){
          echo json_encode(array("statusCode"=>200, "name"=>$data['name']));
          }else{
            echo json_encode(array("statusCode"=>317));
          }
        }
        else
        {
          echo json_encode(array("statusCode"=>318));
        }
      
      }
      else{
        http_response_code(404);
        include('../app/404.php');
        die();
      }
      
    }

    public function saveSaleCash()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $data = [
          'name' =>$_POST['bought-item'],
          'bought'=>$_POST['bought-price'],
          'cash'=>$_POST['sales-cash'], 
          'till'=>$_POST['sales-till'], 
          'profit'=>$_POST['sales-profit'],
          'date'=>date('Y-m-d', time()), 
          'time'=>date('H:i:s T', time()), 
          'ip'=>get_ip_address(), 
          'creator'=>$_SESSION['user_name']
        ];

        $inventoryData = $this->pageModel->getItemInventoryCount($data['name']);
        $sold = getItemSoldCountInventory($data['name'],$this->pageModel->getDatabaseConnection());

        while($state = $inventoryData->fetch_assoc()){
          $instock = $state['item_quantity'];
        }

        if(($instock - $sold) >= 1){
          if($this->pageModel->saveToSales($data)){
          echo json_encode(array("statusCode"=>200, "name"=>$data['name']));
          }else{
            echo json_encode(array("statusCode"=>317));
          }
        }
        else
        {
          echo json_encode(array("statusCode"=>318));
        }
      
      }
      else{
        http_response_code(404);
        include('../app/404.php');
        die();
      }
      
    }



    //handle ajax POST & GET submission
    public function saveInventoryEdit($id)
    {  

      if($_SERVER['REQUEST_METHOD'] == 'POST'){
      
      $file = $_FILES['product-image'];
      $fileName = $file['name'];
      $fileTmpName = $file['tmp_name'];
      $fileSize = $file['size'];
      $fileError = $file['error'];
      $fileType = $file['type'];
      $fileExtension = explode('.', $fileName);
      $fileActualExtension = strtolower(end($fileExtension));
      $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'psd', 'svg');
      //saved in the users route
      $fileDestination = '../public/uploads/' . preg_replace('/[^A-Za-z0-9. -]/', '', $fileName);
      $photo = preg_replace('/[^A-Za-z0-9. -]/', '', $fileName);
      
      if ($file) {
        if (in_array($fileActualExtension, $allowedExtensions)) {
          
          $itemName = $_POST['item-name'];
          $itemquantity = $_POST['item-current-qty'];
          $itemBp = $_POST['item-bp'];
          $itemModel = $_POST['item-model'];

          $inventory = [
            'id'=>$id,
            'edited_by'=>$_SESSION['user_name'],
            'date' => date('Y-m-d', time()),
            'time' => date('H:i:s T', time()),
            'ip' => get_ip_address(),
            'itemName' => $itemName,
            'itemquantity' => $itemquantity,
            'bp' => $itemBp,
            'model' => $itemModel,
            'imagename' => $photo,
            'creator' => $_SESSION['user_name'],
            'destination' => $fileDestination,
            'tempname' => $fileTmpName,
          ];

          move_uploaded_file($fileTmpName, $fileDestination);
        
          $save = $this->pageModel->saveToInventoryEdit($inventory);
          
          if($save)
          {
            echo json_encode(array("statusCode"=>200));
          }
          else{
            echo json_encode(array("statusCode"=>417));
          }
        
        }
        else
        {
          $itemName = $_POST['item-name'];
          $itemquantity = $_POST['item-current-qty'];
          $itemBp = $_POST['item-bp'];
          $itemModel = $_POST['item-model'];
  
          $date = date('Y-m-d', time());
            
          $time = date('H:i:s T', time());
  
          $ip = get_ip_address();

          $inventory = [
            'id'=>$id,
            'edited_by'=>$_SESSION['user_name'],
            'date' => $date,
            'time' => $time,
            'ip' => $ip,
            'itemName' => $itemName,
            'itemquantity' => $itemquantity,
            'bp' => $itemBp,
            'model' => $itemModel,
            'creator' => $_SESSION['user_name'],
          ];
        
  
          $save = $this->pageModel->saveToInventoryNullEdit($inventory);
          if($save)
          {
            echo json_encode(array("statusCode"=>200));
          }
          else{
            echo json_encode(array("statusCode"=>417));
          }
        }
      }
      else{
        
        $itemName = $_POST['item-name'];
        $itemquantity = $_POST['item-current-qty'];
        $itemBp = $_POST['item-bp'];
        $itemModel = $_POST['item-model'];

        $date = date('Y-m-d', time());
          
        $time = date('H:i:s T', time());

        $ip = get_ip_address();

        $inventory = [
          'id'=>$id,
          'edited_by'=>$_SESSION['user_name'],
          'date' => $date,
          'time' => $time,
          'ip' => $ip,
          'itemName' => $itemName,
          'itemquantity' => $itemquantity,
          'bp' => $itemBp,
          'model' => $itemModel,
          'creator' => $_SESSION['user_name'],
        ];

        $save = $this->pageModel->saveToInventoryNullEdit($inventory);
        if($save)
        {
          echo json_encode(array("statusCode"=>200));
        }
        else{
          echo json_encode(array("statusCode"=>417));
        }
      }
      
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }    
  }
    public function saveInventory()
    {  

      if($_SERVER['REQUEST_METHOD'] == 'POST'){
      
      $file = $_FILES['product-image'];
      $fileName = $file['name'];
      $fileTmpName = $file['tmp_name'];
      $fileSize = $file['size'];
      $fileError = $file['error'];
      $fileType = $file['type'];
      $fileExtension = explode('.', $fileName);
      $fileActualExtension = strtolower(end($fileExtension));
      $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'psd', 'svg');
      //saved in the users route
      $fileDestination = '../public/uploads/' . preg_replace('/[^A-Za-z0-9. -]/', '', $fileName);
      $photo = preg_replace('/[^A-Za-z0-9. -]/', '', $fileName);
      
      if ($file) {
        if (in_array($fileActualExtension, $allowedExtensions)) {
          
          $itemName = $_POST['item-name'];
          $itemquantity = $_POST['item-quantity'];
          $itemBp = $_POST['item-bp'];
          $itemModel = $_POST['item-model'];

          if($this->pageModel->getItemByName($itemName) || $this->pageModel->getImageByName($photo)){
            echo json_encode(array("statusCode"=>317));
          }else{
        

          $inventory = [
            'date' => date('Y-m-d', time()),
            'time' => date('H:i:s T', time()),
            'ip' => get_ip_address(),
            'itemName' => $itemName,
            'itemquantity' => $itemquantity,
            'bp' => $itemBp,
            'model' => $itemModel,
            'imagename' => $photo,
            'creator' => $_SESSION['user_name'],
            'destination' => $fileDestination,
            'tempname' => $fileTmpName,
          ];

          move_uploaded_file($fileTmpName, $fileDestination);
        
          $save = $this->pageModel->saveToInventory($inventory);
          
          if($save)
          {
            echo json_encode(array("statusCode"=>200));
          }
          else{
            echo json_encode(array("statusCode"=>417));
          }
        }
        }
        else
        {
          $itemName = $_POST['item-name'];
          $itemquantity = $_POST['item-quantity'];
          $itemBp = $_POST['item-bp'];
          $itemModel = $_POST['item-model'];
  
          $date = date('Y-m-d', time());
            
          $time = date('H:i:s T', time());
  
          $ip = get_ip_address();

          if($this->pageModel->getItemByName($itemName) || $this->pageModel->getImageByName($photo)){
            echo json_encode(array("statusCode"=>317));
          }else{
            $inventory = [
              'date' => $date,
              'time' => $time,
              'ip' => $ip,
              'itemName' => $itemName,
              'itemquantity' => $itemquantity,
              'bp' => $itemBp,
              'model' => $itemModel,
              'creator' => $_SESSION['user_name'],
            ];
          
    
            $save = $this->pageModel->saveToInventoryNull($inventory);
            if($save)
            {
              echo json_encode(array("statusCode"=>200));
            }
            else{
              echo json_encode(array("statusCode"=>417));
            }
          }
          
        }
      }
      else{
        
        
        $itemName = $_POST['item-name'];
        $itemquantity = $_POST['item-quantity'];
        $itemBp = $_POST['item-bp'];
        $itemModel = $_POST['item-model'];

        $date = date('Y-m-d', time());
          
        $time = date('H:i:s T', time());

        $ip = get_ip_address();
        if($this->pageModel->getItemByName($itemName) || $this->pageModel->getImageByName($photo)){
          echo json_encode(array("statusCode"=>317));
        }else{
          $inventory = [
            'date' => $date,
            'time' => $time,
            'ip' => $ip,
            'itemName' => $itemName,
            'itemquantity' => $itemquantity,
            'bp' => $itemBp,
            'model' => $itemModel,
            'creator' => $_SESSION['user_name'],
          ];
  
          $save = $this->pageModel->saveToInventoryNull($inventory);
          if($save)
          {
            echo json_encode(array("statusCode"=>200));
          }
          else{
            echo json_encode(array("statusCode"=>417));
          }
        }
      
      }
      
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }    
  }

    public function loadBuyingEdit($date, $itemName)
    {
      if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($date) && isset($itemName))
      {
          $itemId = htmlspecialchars($date);

          if($this->pageModel->getBuyingByDate($date,$itemName)){
            $bp = $this->pageModel->getBuyingByDate($date,$itemName);
            echo json_encode(array("statusCode"=>200, 'row'=>$bp));
          }else{
            echo json_encode(array("statusCode"=>317));
          }
  
      }
      else
      {
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function loadBuying($id)
    {
      if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($id))
      {
          $itemId = htmlspecialchars($id);

          $bp = $this->pageModel->getBuyingByName($itemId);

          $data = ['bp' => $bp];

          $this->view("pages/loadBuying", $data);
      }
      else
      {
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function loadInventoryData()
    {
      if($_SERVER['REQUEST_METHOD'] == 'GET')
      {
        $inventoryData = $this->pageModel->getInventoryData();

        $db = $this->pageModel->getDatabaseConnection();

        $data = ['title'=>'Daily Report', "inventory" => $inventoryData, 'db'=>$db];

        $this->view('pages/loadInventoryData', $data);
      }
      else
      {
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function loadLatestSold()
    {
      if($_SERVER['REQUEST_METHOD'] == 'GET')
      {
        $data = ['title'=>'Daily Report', "latest" => $this->pageModel->getSoldToday()];

        $this->view('pages/loadLatestSold', $data);
      }
      else
      {
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function loadLatestExpense()
    {
      if($_SERVER['REQUEST_METHOD'] == 'GET')
      {
        $data = ['title'=>'Daily Report', "latest" => $this->pageModel->getExpenseToday()];

        $this->view('pages/loadLatestExpense', $data);
      }
      else
      {
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function loadLatestExpenseEdit($date)
    {
      if($_SERVER['REQUEST_METHOD'] == 'GET')
      {
        $data = ['title'=>'Daily Report'];

        if($this->pageModel->getExpenseTodayEdit($date)){
          $row = $this->pageModel->getExpenseTodayEdit($date);
          $result_array = array();
          while($dt = $row->fetch_assoc()) {
            array_push($result_array, $dt);
        }
   
          echo json_encode(array("statusCode"=>200, 'row'=>$result_array));
        }
        else{
          echo json_encode(array("statusCode"=>317));
        }
      }
      else
      {
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function loadLatestSaleEdit($date)
    {
      if($_SERVER['REQUEST_METHOD'] == 'GET')
      {
        $data = ['title'=>'Daily Report'];

        if($this->pageModel->getSaleTodayEdit($date)){
          $row = $this->pageModel->getSaleTodayEdit($date);
          $result_array = array();
          while($dt = $row->fetch_assoc()) {
            array_push($result_array, $dt);
        }
   
          echo json_encode(array("statusCode"=>200, 'row'=>$result_array));
        }
        else{
          echo json_encode(array("statusCode"=>317));
        }
      }
      else
      {
        http_response_code(404);
        include('../app/404.php');
        die();
      }
    }

    public function DeleteSaleNow(){
       if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']))
      {
        $this->pageModel->DeleteSaleById(htmlspecialchars($_POST['id']));
        echo json_encode(array("statusCode"=>200));
      }
      else
      {
        http_response_code(404);
        include('../app/404.php');
        die();
      } 
    }

    public function SaveExpense(){
      if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['expense']) && isset($_POST['amount']))
      {
        $data = [
          'name'=>htmlspecialchars($_POST['expense']), 
          'amount'=>htmlspecialchars($_POST['amount']),
          'date' => date('Y-m-d', time()),
          'time' => date('H:i:s T', time()),
          'creator'=>$_SESSION['user_name'],
          'ip'=>get_ip_address(),
        ];
        if($this->pageModel->SaveExpenseToday($data)){
          echo json_encode(array("statusCode"=>200));
        }else{
          echo json_encode(array("statusCode"=>317));
        }
      }
      else
      {
        http_response_code(404);
        include('../app/404.php');
        die();
      } 
    }

    public function SaveExpenseEdit($date){
      if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['expense']) && isset($_POST['amount']))
      {
        $data = [
          'name'=>htmlspecialchars($_POST['expense']), 
          'amount'=>htmlspecialchars($_POST['amount']),
          'date' => $date,
          'time' => date('H:i:s T', time()),
          'creator'=>$_SESSION['user_name'],
          'ip'=>get_ip_address(),
        ];
        if($this->pageModel->SaveExpenseToday($data)){
          echo json_encode(array("statusCode"=>200));
        }else{
          echo json_encode(array("statusCode"=>317));
        }
      }
      else
      {
        http_response_code(404);
        include('../app/404.php');
        die();
      } 
    }

    public function DeleteExpenseNow(){
      if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']))
     {
       $this->pageModel->DeleteExpenseById(htmlspecialchars($_POST['id']));
       echo json_encode(array("statusCode"=>200));
     }
     else
     {
       http_response_code(404);
       include('../app/404.php');
       die();
     } 
   }

    public function CheckSaleExpense(){
      if($_SERVER['REQUEST_METHOD'] == 'GET')
     {
       if($this->pageModel->CheckSaleExpenseNow(date('Y-m-d', time())) == 1){
        echo json_encode(array("statusCode"=>200));
       }
       else if($this->pageModel->CheckSaleExpenseNow(date('Y-m-d', time())) == 2){
        echo json_encode(array("statusCode"=>318));
       }
       else if($this->pageModel->CheckSaleExpenseNow(date('Y-m-d', time())) == 3){
        echo json_encode(array("statusCode"=>317));
       }
       else if($this->pageModel->CheckSaleExpenseNow(date('Y-m-d', time())) == 4){
        echo json_encode(array("statusCode"=>319));
       }
     }
     else
     {
       http_response_code(404);
       include('../app/404.php');
       die();
     } 
   }

   public function SaveSaleRecordEdit($date){
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      $cyber = [
        'cash'=>htmlspecialchars($_POST['cybercash']), 
        'till'=>htmlspecialchars($_POST['cybertill']),
        'date' => date('Y-m-d', time()),
        'time' => date('H:i:s T', time()),
        'creator'=>$_SESSION['user_name'],
        'ip'=>get_ip_address(),
      ];

      $ps = [
        'cash'=>htmlspecialchars($_POST['pscash']), 
        'till'=>htmlspecialchars($_POST['pstill']),
        'date' => date('Y-m-d', time()),
        'time' => date('H:i:s T', time()),
        'creator'=>$_SESSION['user_name'],
        'ip'=>get_ip_address(),
      ];

      $movie = [
        'cash'=>htmlspecialchars($_POST['moviecash']), 
        'till'=>htmlspecialchars($_POST['movietill']),
        'date' => date('Y-m-d', time()),
        'time' => date('H:i:s T', time()),
        'creator'=>$_SESSION['user_name'],
        'ip'=>get_ip_address(),
      ];

      if($this->pageModel->saveSaleRecordNowEdit($cyber, $ps, $movie, $date)){
        echo json_encode(array("statusCode"=>200));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
   
    }
    else
    {
      http_response_code(404);
      include('../app/404.php');
      die();
    } 
  }
   
   public function SaveSaleRecord(){
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      $cyber = [
        'cash'=>htmlspecialchars($_POST['cybercash']), 
        'till'=>htmlspecialchars($_POST['cybertill']),
        'date' => date('Y-m-d', time()),
        'time' => date('H:i:s T', time()),
        'creator'=>$_SESSION['user_name'],
        'ip'=>get_ip_address(),
      ];

      $ps = [
        'cash'=>htmlspecialchars($_POST['pscash']), 
        'till'=>htmlspecialchars($_POST['pstill']),
        'date' => date('Y-m-d', time()),
        'time' => date('H:i:s T', time()),
        'creator'=>$_SESSION['user_name'],
        'ip'=>get_ip_address(),
      ];

      $movie = [
        'cash'=>htmlspecialchars($_POST['moviecash']), 
        'till'=>htmlspecialchars($_POST['movietill']),
        'date' => date('Y-m-d', time()),
        'time' => date('H:i:s T', time()),
        'creator'=>$_SESSION['user_name'],
        'ip'=>get_ip_address(),
      ];

      if($this->pageModel->saveSaleRecordNow($cyber, $ps, $movie)){
        echo json_encode(array("statusCode"=>200));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
   
    }
    else
    {
      http_response_code(404);
      include('../app/404.php');
      die();
    } 
  }
  
  public function SaveNetTotalEdit(){
    if($_SERVER['REQUEST_METHOD']=='POST'){
      $data = [
        'date' => date('Y-m-d', time()),
        'time' => date('H:i:s T', time()),
        'creator'=>$_SESSION['user_name'],
        'ip'=>get_ip_address(),
      ];
      if($this->pageModel->saveNetTotalNow($data)){
        echo json_encode(array("statusCode"=>200));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }
  
  public function SaveNetTotal(){
    if($_SERVER['REQUEST_METHOD']=='POST'){
      $data = [
        'date' => date('Y-m-d', time()),
        'time' => date('H:i:s T', time()),
        'creator'=>$_SESSION['user_name'],
        'ip'=>get_ip_address(),
      ];
      if($this->pageModel->saveNetTotalNow($data)){
        echo json_encode(array("statusCode"=>200));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getMovieShopRepoMonth()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){

      $db = $this->pageModel->getDatabaseConnection();
      $mv = getMovieshopDatesMonth($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['DATE_FORMAT(date_created, "%M")'];
          array_push($arr, $dates);
        }

        $totalmonthMovie = getMovieshopGrossMonth($db);
          $arrtotal = array();
          while( $mv3 = $totalmonthMovie->fetch_assoc()){
            $totals = $mv3['movieshop_net'];
            array_push($arrtotal,$totals);
          }

        $cashmonthMovie = getMovieshopCashMonth($db);
          $arrcash = array();
          while( $mv4 = $cashmonthMovie->fetch_assoc()){
            $cash = $mv4['movieshop_net'];
            array_push($arrcash,$cash);
          }

        $tillmonthMovie = getMovieshopTillMonth($db);
          $arrtill = array();
          while( $mv5 = $tillmonthMovie->fetch_assoc()){
            $cash = $mv5['movieshop_net'];
            array_push($arrtill,$cash);
          }
          
        echo json_encode(array("statusCode"=>200, 'dates'=>$arr, 'totals'=>$arrtotal, 'cash'=>$arrcash, 'till'=>$arrtill));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getMovieShopRepoWeek()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getMovieshopDatesWeek($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['DATE_FORMAT(date_created, "%u")'];
          array_push($arr, 'week '.$dates);
        }

        $totalTillWeek = getMovieshopTillWeek($db);
        $arrweektill = array();
        while( $mv3 = $totalTillWeek->fetch_assoc()){
          $tillweek = $mv3['movieshop_net'];
          array_push($arrweektill,$tillweek);
        }

        $totalCashWeek = getMovieshopCashWeek($db);
        $arrweekcash = array();
        while( $mv4 = $totalCashWeek->fetch_assoc()){
          $cashweek = $mv4['movieshop_net'];
          array_push($arrweekcash,$cashweek);
        }

        $totalGrossWeek = getMovieshopGrossWeek($db);
        $arrweekgross = array();
        while( $mv4 = $totalGrossWeek->fetch_assoc()){
          $grossweek = $mv4['movieshop_net'];
          array_push($arrweekgross,$grossweek);
        }
          
        echo json_encode(array("statusCode"=>200, 'weeks'=>$arr, 'till'=>$arrweektill, 'cash'=>$arrweekcash, 'gross'=>$arrweekgross));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getMovieShopRepoYear()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $data = [
        'date' => date('Y-m-d', time())
      ];
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getMovieshopDatesYear($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['DATE_FORMAT(date_created, "%Y")'];
          array_push($arr, $dates);
        }

        $totalYEARMovie = getMovieshopGrossYear($db);
        $arryear = array();
        while( $mv3 = $totalYEARMovie->fetch_assoc()){
          $totalsyear = $mv3['movieshop_net'];
          array_push($arryear,$totalsyear);
        }

        $totalTillMovie = getMovieshopTillYear($db);
        $arrtill = array();
        while( $mv4 = $totalTillMovie->fetch_assoc()){
          $totalsyeartill = $mv4['movieshop_net'];
          array_push($arrtill,$totalsyeartill);
        }

        $totalCashMovie = getMovieshopCashYear($db);
        $arrcash = array();
        while( $mv5 = $totalCashMovie->fetch_assoc()){
          $totalsyearcash = $mv5['movieshop_net'];
          array_push($arrcash,$totalsyearcash);
        }
          
        echo json_encode(array("statusCode"=>200, 'years'=>$arr, 'gross'=>$arryear, 'till'=>$arrtill, 'cash'=>$arrcash));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getMovieShopRepoToday()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $data = [
        'date' => date('Y-m-d', time())
      ];
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getMovieshopAllDate($data['date'], $db);
      if($mv){
        $mv2 = $mv->fetch_assoc();
        $movietoday = ['till'=>$mv2['till'], 'cash'=>$mv2['cash'], 'total'=>($mv2['till']+$mv2['cash'])];
        echo json_encode(array("statusCode"=>200, 'movie'=>$movietoday));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getCyberRepoToday()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $data = [
        'date' => date('Y-m-d', time())
      ];
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getCyberAllDate($data['date'], $db);
      if($mv){
        $mv2 = $mv->fetch_assoc();
        $movietoday = ['till'=>$mv2['till'], 'cash'=>$mv2['cash'], 'total'=>($mv2['till']+$mv2['cash'])];
        echo json_encode(array("statusCode"=>200, 'movie'=>$movietoday));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getCyberRepoWeek()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getCyberDatesWeek($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['DATE_FORMAT(date_created, "%U")'];
          array_push($arr, 'week '.$dates);
        }

        $totalTillWeek = getCyberTillWeek($db);
        $arrweektill = array();
        while( $mv3 = $totalTillWeek->fetch_assoc()){
          $tillweek = $mv3['cyber_net'];
          array_push($arrweektill,$tillweek);
        }

        $totalCashWeek = getCyberCashWeek($db);
        $arrweekcash = array();
        while( $mv4 = $totalCashWeek->fetch_assoc()){
          $cashweek = $mv4['cyber_net'];
          array_push($arrweekcash,$cashweek);
        }

        $totalGrossWeek = getCyberGrossWeek($db);
        $arrweekgross = array();
        while( $mv4 = $totalGrossWeek->fetch_assoc()){
          $grossweek = $mv4['cyber_net'];
          array_push($arrweekgross,$grossweek);
        }
          
        echo json_encode(array("statusCode"=>200, 'weeks'=>$arr, 'till'=>$arrweektill, 'cash'=>$arrweekcash, 'gross'=>$arrweekgross));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getCyberRepoMonth()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getCyberDatesMonth($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['DATE_FORMAT(date_created, "%M")'];
          array_push($arr, $dates);
        }

        $totalmonthMovie = getCyberGrossMonth($db);
          $arrtotal = array();
          while( $mv3 = $totalmonthMovie->fetch_assoc()){
            $totals = $mv3['cyber_net'];
            array_push($arrtotal,$totals);
          }

        $cashmonthMovie = getCyberCashMonth($db);
          $arrcash = array();
          while( $mv4 = $cashmonthMovie->fetch_assoc()){
            $cash = $mv4['cyber_net'];
            array_push($arrcash,$cash);
          }

        $tillmonthMovie = getCyberTillMonth($db);
          $arrtill = array();
          while( $mv5 = $tillmonthMovie->fetch_assoc()){
            $cash = $mv5['cyber_net'];
            array_push($arrtill,$cash);
          }
          
        echo json_encode(array("statusCode"=>200, 'dates'=>$arr, 'totals'=>$arrtotal, 'cash'=>$arrcash, 'till'=>$arrtill));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getCyberRepoYear()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getCyberDatesYear($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['DATE_FORMAT(date_created, "%Y")'];
          array_push($arr, $dates);
        }

        $totalYEARMovie = getCyberGrossYear($db);
        $arryear = array();
        while( $mv3 = $totalYEARMovie->fetch_assoc()){
          $totalsyear = $mv3['cyber_net'];
          array_push($arryear,$totalsyear);
        }

        $totalTillMovie = getCyberTillYear($db);
        $arrtill = array();
        while( $mv4 = $totalTillMovie->fetch_assoc()){
          $totalsyeartill = $mv4['cyber_net'];
          array_push($arrtill,$totalsyeartill);
        }

        $totalCashMovie = getCyberCashYear($db);
        $arrcash = array();
        while( $mv5 = $totalCashMovie->fetch_assoc()){
          $totalsyearcash = $mv5['cyber_net'];
          array_push($arrcash,$totalsyearcash);
        }
          
        echo json_encode(array("statusCode"=>200, 'years'=>$arr, 'gross'=>$arryear, 'till'=>$arrtill, 'cash'=>$arrcash));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getPsRepoWeek()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getPsDatesWeek($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['DATE_FORMAT(date_created, "%U")'];
          array_push($arr, 'week '.$dates);
        }

        $totalTillWeek = getPsTillWeek($db);
        $arrweektill = array();
        while( $mv3 = $totalTillWeek->fetch_assoc()){
          $tillweek = $mv3['ps_net'];
          array_push($arrweektill,$tillweek);
        }

        $totalCashWeek = getPsCashWeek($db);
        $arrweekcash = array();
        while( $mv4 = $totalCashWeek->fetch_assoc()){
          $cashweek = $mv4['ps_net'];
          array_push($arrweekcash,$cashweek);
        }

        $totalGrossWeek = getPsGrossWeek($db);
        $arrweekgross = array();
        while( $mv4 = $totalGrossWeek->fetch_assoc()){
          $grossweek = $mv4['ps_net'];
          array_push($arrweekgross,$grossweek);
        }
          
        echo json_encode(array("statusCode"=>200, 'weeks'=>$arr, 'till'=>$arrweektill, 'cash'=>$arrweekcash, 'gross'=>$arrweekgross));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getPsRepoMonth()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getPsDatesMonth($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['DATE_FORMAT(date_created, "%M")'];
          array_push($arr, $dates);
        }

        $totalmonthMovie = getPsGrossMonth($db);
          $arrtotal = array();
          while( $mv3 = $totalmonthMovie->fetch_assoc()){
            $totals = $mv3['ps_net'];
            array_push($arrtotal,$totals);
          }

        $cashmonthMovie = getPsCashMonth($db);
          $arrcash = array();
          while( $mv4 = $cashmonthMovie->fetch_assoc()){
            $cash = $mv4['ps_net'];
            array_push($arrcash,$cash);
          }

        $tillmonthMovie = getPsTillMonth($db);
          $arrtill = array();
          while( $mv5 = $tillmonthMovie->fetch_assoc()){
            $cash = $mv5['ps_net'];
            array_push($arrtill,$cash);
          }
          
        echo json_encode(array("statusCode"=>200, 'dates'=>$arr, 'totals'=>$arrtotal, 'cash'=>$arrcash, 'till'=>$arrtill));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getPsRepoYear()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getPsDatesYear($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['DATE_FORMAT(date_created, "%Y")'];
          array_push($arr, $dates);
        }

        $totalYEARMovie = getPsGrossYear($db);
        $arryear = array();
        while( $mv3 = $totalYEARMovie->fetch_assoc()){
          $totalsyear = $mv3['ps_net'];
          array_push($arryear,$totalsyear);
        }

        $totalTillMovie = getPsTillYear($db);
        $arrtill = array();
        while( $mv4 = $totalTillMovie->fetch_assoc()){
          $totalsyeartill = $mv4['ps_net'];
          array_push($arrtill,$totalsyeartill);
        }

        $totalCashMovie = getPsCashYear($db);
        $arrcash = array();
        while( $mv5 = $totalCashMovie->fetch_assoc()){
          $totalsyearcash = $mv5['ps_net'];
          array_push($arrcash,$totalsyearcash);
        }
          
        echo json_encode(array("statusCode"=>200, 'years'=>$arr, 'gross'=>$arryear, 'till'=>$arrtill, 'cash'=>$arrcash));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getNetRepoToday()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $data = [
        'date' => date('Y-m-d', time())
      ];
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getNetAllDate($data['date'], $db);
      if($mv){
        $mv2 = $mv->fetch_assoc();
        $movietoday = ['till'=>$mv2['till_sales'], 'cash'=>$mv2['cash_sales'], 'total'=>($mv2['totalincome'])];
        echo json_encode(array("statusCode"=>200, 'movie'=>$movietoday));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getNetRepoWeek()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getNetDatesWeek($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['DATE_FORMAT(date_created, "%U")'];
          array_push($arr, 'week '.$dates);
        }

        $totalTillWeek = getNetTillWeek($db);
        $arrweektill = array();
        while( $mv3 = $totalTillWeek->fetch_assoc()){
          $tillweek = $mv3['net_till'];
          array_push($arrweektill,$tillweek);
        }

        $totalCashWeek = getNetCashWeek($db);
        $arrweekcash = array();
        while( $mv4 = $totalCashWeek->fetch_assoc()){
          $cashweek = $mv4['cash_total'];
          array_push($arrweekcash,$cashweek);
        }

        $totalGrossWeek = getNetGrossWeek($db);
        $arrweekgross = array();
        while( $mv4 = $totalGrossWeek->fetch_assoc()){
          $grossweek = $mv4['total_net'];
          array_push($arrweekgross,$grossweek);
        }
          
        echo json_encode(array("statusCode"=>200, 'weeks'=>$arr, 'till'=>$arrweektill, 'cash'=>$arrweekcash, 'gross'=>$arrweekgross));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getNetRepoMonth()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getNetDatesMonth($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['DATE_FORMAT(date_created, "%M")'];
          array_push($arr, $dates);
        }

        $totalmonthMovie = getNetGrossMonth($db);
          $arrtotal = array();
          while( $mv3 = $totalmonthMovie->fetch_assoc()){
            $totals = $mv3['totalnet'];
            array_push($arrtotal,$totals);
          }

        $cashmonthMovie = getNetCashMonth($db);
          $arrcash = array();
          while( $mv4 = $cashmonthMovie->fetch_assoc()){
            $cash = $mv4['cash_net'];
            array_push($arrcash,$cash);
          }

        $tillmonthMovie = getNetTillMonth($db);
          $arrtill = array();
          while( $mv5 = $tillmonthMovie->fetch_assoc()){
            $cash = $mv5['till_net'];
            array_push($arrtill,$cash);
          }
          
        echo json_encode(array("statusCode"=>200, 'dates'=>$arr, 'totals'=>$arrtotal, 'cash'=>$arrcash, 'till'=>$arrtill));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getNetRepoYear()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getNetDatesYear($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['DATE_FORMAT(date_created, "%Y")'];
          array_push($arr, $dates);
        }

        $totalYEARMovie = getNetGrossYear($db);
        $arryear = array();
        while( $mv3 = $totalYEARMovie->fetch_assoc()){
          $totalsyear = $mv3['totalincome'];
          array_push($arryear,$totalsyear);
        }

        $totalTillMovie = getNetTillYear($db);
        $arrtill = array();
        while( $mv4 = $totalTillMovie->fetch_assoc()){
          $totalsyeartill = $mv4['net_till'];
          array_push($arrtill,$totalsyeartill);
        }

        $totalCashMovie = getNetCashYear($db);
        $arrcash = array();
        while( $mv5 = $totalCashMovie->fetch_assoc()){
          $totalsyearcash = $mv5['net_cash'];
          array_push($arrcash,$totalsyearcash);
        }
          
        echo json_encode(array("statusCode"=>200, 'years'=>$arr, 'gross'=>$arryear, 'till'=>$arrtill, 'cash'=>$arrcash));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getExpenseRepoToday()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $data = [
        'date' => date('Y-m-d', time())
      ];
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getExpenseAllDate($data['date'], $db);
      if($mv){
        //expense labels
        $arrlabels = array();
        while( $mv5 = $mv->fetch_assoc()){
          $expenselables = $mv5['expense_item'];
          array_push($arrlabels,$expenselables);
        }
        //expense matching costs
        $mv2 = getExpenseAllDate($data['date'], $db);
        $arrcosts = array();
        while($mv6 = $mv2->fetch_assoc()){
          $expensecosts = $mv6['expense_cost'];
          array_push($arrcosts, $expensecosts);
        }
        echo json_encode(array("statusCode"=>200, 'labels'=>$arrlabels, 'cost'=>$arrcosts));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getExpenseRepoWeek()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getExpenseDatesWeek($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['DATE_FORMAT(date_created, "%U")'];
          array_push($arr, 'week '.$dates);
        }

        $totalweek = getExpenseThisWeek($db);
        $arrweek = array();
        while( $mv3 = $totalweek->fetch_assoc()){
          $weekexp = $mv3['expense_net'];
          array_push($arrweek,$weekexp);
        }
          
        echo json_encode(array("statusCode"=>200, 'weeks'=>$arr, 'expense'=>$arrweek,));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getExpenseRepoMonth()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getExpenseDatesMonth($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['DATE_FORMAT(date_created, "%M")'];
          array_push($arr, $dates);
        }

        $totalmonth = getExpenseGrossMonth($db);
        $arrmonth = array();
        while( $mv3 = $totalmonth->fetch_assoc()){
          $monthexp = $mv3['expense_net'];
          array_push($arrmonth,$monthexp);
        }
          
        echo json_encode(array("statusCode"=>200, 'dates'=>$arr, 'expense'=>$arrmonth,));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getExpenseRepoYear()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getExpenseDatesYear($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['DATE_FORMAT(date_created, "%Y")'];
          array_push($arr, $dates);
        }

        $totalyear = getExpenseGrossYear($db);
        $arryear = array();
        while( $mv3 = $totalyear->fetch_assoc()){
          $yearexp = $mv3['expense_net'];
          array_push($arryear,$yearexp);
        }
          
        echo json_encode(array("statusCode"=>200, 'years'=>$arr, 'expense'=>$arryear,));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getSalesRepoToday()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $data = [
        'date' => date('Y-m-d', time())
      ];
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getSalesAllDate($data['date'], $db);
      if($mv){
        //expense labels
        $arrlabels = array();
        while( $mv5 = $mv->fetch_assoc()){
          $expenselables = $mv5['sales_item'];
          array_push($arrlabels,$expenselables);
        }
        //expense matching costs
        $mv2 = getSalesAllDate($data['date'], $db);
        $arrcosts = array();
        while($mv6 = $mv2->fetch_assoc()){
          $expensecosts = $mv6['selling_price'];
          array_push($arrcosts, $expensecosts);
        }
        echo json_encode(array("statusCode"=>200, 'labels'=>$arrlabels, 'cost'=>$arrcosts));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getSalesRepoWeek()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getMostSoldItemsWeek($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['sales_item'];
          array_push($arr, $dates);
        }

        $totalweek = getMostSoldItemsWeek($db);
        $arrweek = array();
        while( $mv3 = $totalweek->fetch_assoc()){
          $weekexp = $mv3['selling_price'];
          array_push($arrweek,$weekexp);
        }

        $weeksales = getSalesAllWeekNet($db);
        $arrsales = array();
        while( $mv4 = $weeksales->fetch_assoc()){
          $weeksale = $mv4['selling'];
          array_push($arrsales,$weeksale);
        }

        $weekdates = getSalesAllWeekNet($db);
        $arrdates = array();
        while( $mv5 = $weekdates->fetch_assoc()){
          $weekdate = $mv5['DATE_FORMAT(date_created, "%U")'];
          array_push($arrdates,$weekdate);
        }

        $weekprofits = getSalesProfitWeek($db);
        $arrprofits = array();
        while( $mv6 = $weekprofits->fetch_assoc()){
          $weekpr = $mv6['sales_net'];
          array_push($arrprofits,$weekpr);
        }

        $weeklysales = getSalesWeek($db);
        $arrweekly = array();
        while( $mv7 = $weeklysales->fetch_assoc()){
          $weekly = $mv7['sales_net'];
          array_push($arrweekly,$weekly);
        }

        echo json_encode(array("statusCode"=>200, 'labels'=>$arr, 'cost'=>$arrweek, 'weeks'=>$arrdates, 'sales'=>$arrweekly, 'profits'=>$arrprofits));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getSalesRepoMonth()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getMostSoldItemsMonth($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['sales_item'];
          array_push($arr, $dates);
        }

        $totalweek = getMostSoldItemsMonth($db);
        $arrweek = array();
        while( $mv3 = $totalweek->fetch_assoc()){
          $weekexp = $mv3['selling_price'];
          array_push($arrweek,$weekexp);
        }

        $weeksales = getSalesAllMonthNet($db);
        $arrsales = array();
        while( $mv4 = $weeksales->fetch_assoc()){
          $weeksale = $mv4['sales_net'];
          array_push($arrsales,$weeksale);
        }

        $weekdates = getSalesAllMonthNet($db);
        $arrdates = array();
        while( $mv5 = $weekdates->fetch_assoc()){
          $weekdate = $mv5['DATE_FORMAT(date_created, "%M")'];
          array_push($arrdates,$weekdate);
        }

        $weekprofits = getSalesProfitMonth($db);
        $arrprofits = array();
        while( $mv6 = $weekprofits->fetch_assoc()){
          $weekpr = $mv6['sales_net'];
          array_push($arrprofits,$weekpr);
        }

        $weeklysales = getSalesMonth($db);
        $arrweekly = array();
        while( $mv7 = $weeklysales->fetch_assoc()){
          $weekly = $mv7['sales_net'];
          array_push($arrweekly,$weekly);
        }

        echo json_encode(array("statusCode"=>200, 'labels'=>$arr, 'cost'=>$arrweek, 'weeks'=>$arrdates, 'sales'=>$arrweekly, 'profits'=>$arrprofits));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }

  public function getSalesRepoYear()
  {
    if($_SERVER['REQUEST_METHOD']=='GET'){
      $db = $this->pageModel->getDatabaseConnection();
      $mv = getMostSoldItemsYear($db);
      if($mv){
        $arr = array();
        while($mv2 = $mv->fetch_assoc()){
          $dates = $mv2['sales_item'];
          array_push($arr, $dates);
        }

        $totalweek = getMostSoldItemsYear($db);
        $arrweek = array();
        while( $mv3 = $totalweek->fetch_assoc()){
          $weekexp = $mv3['selling_price'];
          array_push($arrweek,$weekexp);
        }

        $weeksales = getSalesAllYearNet($db);
        $arrsales = array();
        while( $mv4 = $weeksales->fetch_assoc()){
          $weeksale = $mv4['sales_net'];
          array_push($arrsales,$weeksale);
        }

        $weekdates = getSalesAllYearNet($db);
        $arrdates = array();
        while( $mv5 = $weekdates->fetch_assoc()){
          $weekdate = $mv5['DATE_FORMAT(date_created, "%Y")'];
          array_push($arrdates,$weekdate);
        }

        $weekprofits = getSalesProfitYear($db);
        $arrprofits = array();
        while( $mv6 = $weekprofits->fetch_assoc()){
          $weekpr = $mv6['sales_net'];
          array_push($arrprofits,$weekpr);
        }

        $weeklysales = getSalesYear($db);
        $arrweekly = array();
        while( $mv7 = $weeklysales->fetch_assoc()){
          $weekly = $mv7['sales_net'];
          array_push($arrweekly,$weekly);
        }

        echo json_encode(array("statusCode"=>200, 'labels'=>$arr, 'cost'=>$arrweek, 'weeks'=>$arrdates, 'sales'=>$arrweekly, 'profits'=>$arrprofits));
      }else{
        echo json_encode(array("statusCode"=>317));
      }
    }else{
      http_response_code(404);
      include('../app/404.php');
      die();
    }
  }
}    