<?php

class User
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

    public function UpdateProfile($data)
    {
       $queryToken = 'UPDATE dr_user SET username=?, email=?, `password`=? WHERE `user_id`=?';

       $bindersToken = 'ssss';

       $valuesToken = array($data['username'], $data['email'], $data['newPassword'], $data['id']);

       
       try {
           Update($queryToken, $bindersToken, $valuesToken, 'dr_user', $this->db);
           return true;
       } catch (Error $e) {
           return 'dad';
       }

    }

    public function checkOldPassword($data)
    {
      $query = 'SELECT `password` FROM dr_user WHERE `user_id` = ?';

      $binders = "s";
 
      $parameters = array($data['id']);
 
      $result = SelectCond($query, $binders, $parameters, $this->db);
 
      $row = $result->get_result();

      $rowItem = $row->fetch_assoc();

      $password = $rowItem['password'];

      $passwordcheck = password_verify($data['oldPassword'], $password);

      if($passwordcheck == false)
      {
        return false;
      }
      else if($passwordcheck == true)
      {
        return true;
      }
      else{
        return false;
      }
 
    }

    public function getUserById($id)
    {
     $query = 'SELECT `user_id`, username, email, `password`, is_admin, date_created, time_created, created_by, creator_ip FROM dr_user WHERE `user_id` = ?';

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

     // Find user by username
     public function findUserByName($username)
     {
         $query = 'SELECT `user_id`, username, email, `password`, is_admin, date_created, time_created, created_by, creator_ip FROM dr_user WHERE username = ?';
 
         $binders = "s";
 
         $parameters = array($username);
 
         $result = SelectCond($query, $binders, $parameters, $this->db);
 
         $row = $result->get_result();
 
         $numRows = $row->num_rows;
 
         if ($numRows > 0) {
             return true;
         } else {
             return false;
         }
     }

     public function UpdateToken($email, $token)
     {
        $queryToken = 'UPDATE dr_user SET reset_link=? WHERE email=?';

        $bindersToken = 'ss';

        $valuesToken = array('', $email);

        
        try {
            Update($queryToken, $bindersToken, $valuesToken, 'dr_user', $this->db);
        } catch (Error $e) {
            return false;
        }

         //save token to db
         $hashedToken = password_hash($token, PASSWORD_DEFAULT);

         $queryTokenSave = 'UPDATE dr_user SET reset_link=? WHERE email=?';

         $bindersTokenSave = 'ss';

         $valuesTokenSave = array($hashedToken, $email);

         try {
            Update($queryTokenSave, $bindersTokenSave, $valuesTokenSave, 'dr_user', $this->db);
         } catch (Error $e) {
            return false;
         }
     }

     public function getUserEmail($username)
     {
      $query = 'SELECT `user_id`, username, email, `password`, is_admin, date_created, time_created, created_by, creator_ip FROM dr_user WHERE username = ?';
 
      $binders = "s";

      $parameters = array($username);

      $result = SelectCond($query, $binders, $parameters, $this->db);

      $row = $result->get_result();

      $numRows = $row->num_rows;

      try {
        return $row;
      } catch (Error $e) {
        return false;
      }
     }
    
    public function login($username, $password, $ip)
    {
      $query = 'SELECT `user_id`, username, email, `password`, is_admin, date_created, time_created, created_by, creator_ip FROM dr_user WHERE username = ?';

      $binders = "s";

      $parameters = array($username);

      $result = SelectCond($query, $binders, $parameters, $this->db);

      $row = $result->get_result();

      $user = $row->fetch_assoc();

      $hashedPassword = $user['password'];
      $userId = $user['user_id'];
      $isAdmin = $user['is_admin'];


      //verify salt and password
      if (password_verify($password, $hashedPassword)) {
          //set record 
          $queryLogin = 'SELECT `user_id`, login_count, is_admin, date_logged, time_logged, user_ip FROM dr_login WHERE `user_id` = ?';

          $bindersLogin = "s";

          $parametersLogin = array($userId);

          $result = SelectCond($queryLogin, $bindersLogin, $parametersLogin, $this->db);

          $rowLogin = $result->get_result();

          $rowCount = $rowLogin->num_rows;

          date_default_timezone_get();

          $dateLoggeedIn = date('Y-m-d', time());
          
          $timeLoggeedIn = date('H:i:s T', time());

          if ($rowCount > 0) {
              //user has logged in before
              $login = $rowLogin->fetch_assoc();

              $realCountLogin = $login['login_count'];

              $queryUpdate = 'UPDATE dr_login SET user_ip=?, login_count=?, date_logged=?, time_logged=? WHERE `user_id`=?';

              $bindersCount = "sssss";

              $values = array($ip, ($realCountLogin + 1), $dateLoggeedIn, $timeLoggeedIn, $userId);

              try {
                  Update($queryUpdate, $bindersCount, $values, 'dr_login', $this->db);
                  return $user;
              } catch (Error $e) {
                  return false;
              }
          } else {
              $loginCount = 1;

              $fields = array('user_id', 'login_count', 'is_admin', 'date_logged', 'time_logged', 'user_ip');

              $placeholders = array('?', '?', '?', '?', '?', '?');

              $bindersCountNew = "ssssss";

              $values = array($userId, $loginCount, $isAdmin, $dateLoggeedIn, $timeLoggeedIn, $ip);

              try {
                  Insert(
                      $fields,
                      $placeholders,
                      $bindersCountNew,
                      $values,
                      'dr_login',
                      $this->db
                  );
                  return $user;
              } catch (Error $e) {
                  return false;
              }
          }
      } else {
          return false;
      }
    }

    public function VerifyTokenAndMail($email)
    {
      $result = verifyTokenAndmail("dr_user", $email, $this->db);
  
      $row = $result->get_result();
      if ($result) {
        return $row;
      } else {
        return false;
      }
    }

    public function ChangePassword($data, $email)
    {
      
      $queryUpdate = 'UPDATE dr_user SET `password`=? WHERE email=?';

      $bindersCount = "ss";

      $values = array($data['pwd1'], $email);

      try {
          Update($queryUpdate, $bindersCount, $values, 'dr_user', $this->db);
          return true;
      } catch (Error $e) {
          return false;
      }
    }
}