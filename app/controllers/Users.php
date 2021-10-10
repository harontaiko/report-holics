<?php

class Users extends Controller
{

    public function __construct()
    {
      $this->userModel = $this->model('User'); 
    }

    public function index()
    {

      if($this->isLoggedIn())
      {
        redirect('pages/index');
      }


      $data = ['title' => 'Daily Report'];

      $this->view('users/index', $data);
    }

    public function resetpage()
    {

      if($this->isLoggedIn())
      {
        redirect('pages/index');
      }


      $data = ['title' => 'Daily Report'];

      $this->view('users/resetpage', $data);
    }

    public function saveProfile()
    {

       if($this->isLoggedIn())
      {
        redirect('pages/index');
      }

      $data = ['title'=>'Daily Report'];

      if($_SERVER['REQUEST_METHOD'] == 'POST')
      {

          $data = ['title' => 'Daily Report',
          'id'=>$_SESSION['user_id'],
          'username'=>$_POST['username'],
          'email'=>$_POST['email'],
          'oldPassword'=>$_POST['oldPassword'],
          'newPassword'=>$_POST['newPassword'],
        ];
    
        $data['newPassword'] = password_hash($data['newPassword'], PASSWORD_DEFAULT);
    
        if($this->userModel->checkOldPassword($data)){
          if($this->userModel->UpdateProfile($data)){
            echo json_encode(array('statusCode'=>200));
          }
          else{
            echo json_encode(array('statusCode'=>201));
          }
        }else{
          echo json_encode(array('statusCode'=>317));
        }
      }
      else{
        http_response_code(404);
        include('../app/404.php');
        die();
      } 
    }

    public function profile()
    {
      if($this->isLoggedIn())
      {
        $db = $this->userModel->getDatabaseConnection();

        
        $users = $this->userModel->getUserById($_SESSION['user_id']);
        $arr = array();
        while($x = $users->fetch_assoc()){
          array_push($arr, $x);
        }

        $data = ['title'=>'Profile', 'db'=>$db, 'row'=>$arr];

        $this->view('users/profile', $data);
      }
      else{
        redirect('pages/index');
      }

    }

    public function reset($email)
    {
      if($this->isLoggedIn())
      {
        redirect('pages/index');
      }

      
      $data = ['title' => 'Daily Report', 'email'=>$email];

      $this->view('users/reset', $data);
    }

    public function resetPassword()
    {
      if($this->isLoggedIn())
      {
        redirect('pages/index');
      }

      
      $data = ['title' => 'Daily Report'];

      if(isset($_POST['reset-pwd']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = ['title' => 'Daily Report', 'pwd1'=>htmlspecialchars($_POST['passwordnew']),
        'err'=>'',
        'pwd2'=>htmlspecialchars($_POST['passwordnew-c']),
      ];

      //validate
      if(empty($data['pwd1']) || empty($data['pwd2']))
      {
        $data['err'] = 'please fill in all values';
      }else if($data['pwd1'] !== $data['pwd2'])
      {
        exit(0);
      }
      else{
        $mail = $_SESSION['mail'];
        $verify =  password_verify(hex2bin($_SESSION['token']), $_SESSION['mail']['reset_link']);

        if($verify == false)
        {
          exit(0);
        }
        elseif($verify == true)
        {
          //change password in db
          $data['pwd1'] = password_hash($data['pwd1'], PASSWORD_DEFAULT);
          $this->userModel->ChangePassword($data, $_SESSION['resetEmail']);
          $db = $this->userModel->getDatabaseConnection();
          ResetToken('dr_user', $_SESSION['mail']['user_id'], '', $db);
          //redirect to login with flash
          //unset vars
          unset($_SESSION['mail']);
          unset($_SESSION['rows']);
          unset($_SESSION['token']);
          unset($_SESSION['resetEmail']);
          unset($_SESSION['db']);
          flash('resetsuccess','password reset was successful, login to continue');
          redirect('users/index'); 
        }
        else
        {
          exit(0);
        }
      }
      }
    }

    public function verify($token, $email)
    {
      if($this->isLoggedIn())
      {
        redirect('pages/index');
      }

      //let user change their password
      $row = $this->userModel->VerifyTokenAndMail($email);

      $numRows = $row->num_rows;
  
      $userMail = $row->fetch_assoc();
  
      $db = $this->userModel->getDatabaseConnection();
  
      $data = [
        "title" => "Daily Report",
        "rows" => $numRows,
        "mail" => $userMail,
        "token" => $token,
        "db" => $db,
      ];
      //store in session
      $_SESSION['mail'] = $data['mail'];
      $_SESSION['rows'] = $data['rows'];
      $_SESSION['token'] = $data['token'];
      $_SESSION['resetEmail'] = $email;
      $_SESSION['db'] = $data['db'];
      $this->view("users/verify", $data);
    }

    public function login()
    {
       //check if session is on
       if($this->isLoggedIn())
       {
         redirect('pages/index');
       }
 
         $data = ['title'=>'Daily Report'];
 
         if(isset($_POST['login']) && $_SERVER['REQUEST_METHOD'] == 'POST')
         {
             $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
 
             //init data
             $data = 
             [
               'title' => 'Daily Report',
               'err' => '',
               'username' => htmlspecialchars($_POST['username']),
               'password' =>htmlspecialchars($_POST['password']),
               'ip' => get_ip_address(),
             ];
 
             //validate
             if(empty($data['username']))
             {
               $data['err'] = 'please fill out the username';
               $this->view("users/index", $data);
             }
             else if(empty($data['password']))
             {
               $data['err'] = 'please fill out the password';
               $this->view("users/index", $data);
             }
             else if(strlen($data['password']) < 5)
             {
               $data['err'] = 'password is too short';
               $this->view("users/index", $data);
             } elseif (!$this->userModel->findUserByName($data["username"])) {
               $data["err"] =
               "a user with that username does not exist, please request admin for an account";
             $this->view("users/index", $data);
           }
             else if(empty($data['err']))
             {
               //zero errors
               $loggedinUser = $this->userModel->login(
                 $data["username"],
                 $data["password"],
                 $data["ip"]
               );
 
               if ($loggedinUser) {
                 //authentication == true
                 $this->createUserSession($loggedinUser);
                 //create loading animation
                 $this->createLoadingAnime($loggedinUser);
               } else {
                 $data["err"] =
                   "incorrect password, please check your password";
                 // Load View
                 $this->view("users/index", $data);
               }
             }
         }
         else
         {
             //init data
             $data = 
             [
               'title' => 'Daily Report',
               'err' => '',
               'username' => '',
               'password' => '',
               'ip'=>''
             ];
 
             $this->view('users/index', $data);
 
         }
    }

    public function recover()
    {
      //recover user password
      if($this->isLoggedIn())
      {
      redirect('pages/index');
      }

      $data = ['title'=>'Daily Report'];

      if(isset($_POST['recover-email']) && $_SERVER['REQUEST_METHOD'] == 'POST')
      {
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

          $data = ['title' => 'Daily Report',
          'err'=>'',
         'username-recover' => htmlspecialchars($_POST['username-recover'])
        ];

        $userdata = $this->userModel->findUserByName($data['username-recover']);
        if($userdata){
          //username exists, get matching email
          $row = $this->userModel->getUserEmail($data['username-recover']);
          $usermaildata = $row->fetch_assoc();
          $usermail = $usermaildata['email'];

          $token = random_bytes(32);
          $passwordReset = new Mail($usermail, $data['username-recover']);
          //save in db, clear any existing
          $this->userModel->UpdateToken($usermail, $token);
          $tokenReadable = bin2hex($token);
          $passwordReset->SendResetPasswordLink($tokenReadable);
          //redirect to reset with get vars
          redirect('users/reset/'.$usermail.'');
        }
        else{
          //username could not be associated with any email or it doesnt exist
          $data['err'] = 'username could not be associated with any email or it doesn\'t exist';
          $this->view('users/index', $data);
        }
      }  
      else
      {
        $data = ['title' => 'Daily Report',
          'err'=>'',
         'username-recover' => ''
        ];
        $this->view('users/index', $data);
      }    
    }

      // Create Session With User Info
      public function createUserSession($user)
      {
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["user_email"] = $user["email"];
        $_SESSION["user_name"] = $user["username"];

        //load
        sleep(1.1);

        redirect("pages/index");
      }

      public function createLoadingAnime($user)
      {
        $_SESSION["anime"] = $user["user_id"].'anime';
      }

      // Logout & Destroy Session
      public function logout()
      {
        sleep(1);
        unset($_SESSION["user_id"]);
        unset($_SESSION["user_email"]);
        unset($_SESSION["user_name"]);
        session_destroy();
        
        redirect("users/index");
        
      }

      // Check Logged In
      public function isLoggedIn()
      {
        if (isset($_SESSION["user_id"])) {
          return true;
        } else {
          return false;
        }
      }
}