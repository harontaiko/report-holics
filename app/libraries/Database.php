<?php

/**
 * @package		chuoni Alumni Database
 * @package		Database configuration 
 * @author		Haron Taiko
 * @copyright	Copyright (c) 2020, www.chuonialumni.co.ke, (https://www.chuonialumni.co.ke/)
 * @link		https://www.chuonialumni.co.ke
 */



class Database
{

    private $host = DB_HOST;
    private $dbname = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;

    private $stmt;
    private $error;
    private $conn;


    private $default;
    private $sql;
    private $tables;
    private $nw_table_names;
    private $table_num_query;
    private $table_num_result;
    private $table_num;

    //by default all prefixes are lowercase
    private $DB_PREFIX = 'dr';


    /**
     * connect
     *
     * @return void
     */

    public function __construct()
    {
        $this->conn = null;
        //connect using MYSQLI
        try {
            $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);
        } catch (mysqli_sql_exception $e) {
            echo 'connection error :-(' . $e->getMessage();
        }

        return $this->conn;
    }

    public function prepare($query)
    {
        return $this->conn->prepare($query);
    }

    public function execute($query)
    {
        return $this->stmt->execute();
    }

    public function close()
    {
        return $this->conn->close();
    }
}