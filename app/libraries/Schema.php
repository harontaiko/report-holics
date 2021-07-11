<?php

/**
 * @package		dailyreport Tables
 * @package		Table Auto configuration
 * @author		Haron Taiko
 * @copyright	Copyright (c) 2020, www.dailyreport-holics.com, (https://www.dailyreport-holics.com/)
 * @link		https://www.dailyreport-holics.com
 */
/*
-----------------------------------------------------------
--
-- Database: `daily report`
--
-- Table prefix 'dr' [d]aily [r]eport
-----------------------------------------------------------
*/

/**
 * create all tables
 */
class Schema extends Database
{
  private $stmt;
  private $query;
  private $default;
  private $sql;
  private $tables;
  private $nw_table_names;
  private $table_num_query;
  private $table_num_result;
  private $table_num;

  //by default all prefixes are lowercase
  private $DB_PREFIX = "dr";

  /**
   * createAll
   *
   * @return void
   */
  public function __construct()
  {
    $this->conn = new Database();

    //check table number
    $this->table_num_query = "SHOW TABLES in ".DB_NAME."";
    $this->stmt = $this->conn->prepare($this->table_num_query);
    $this->stmt->execute();
    $this->table_num_result = $this->stmt->get_result();
    $this->table_num = $this->table_num_result->num_rows;

    if (!$this->table_num) {
      require "../app/helpers/schema.php";

      //CREATE TABLE STATEMENTS
      $this->tables = [
        $movieshop_table,
        $cybershop_table,
        $playstation_table,
        $sales_table,
        $expenses_table,
        $nettotal_table,
        $user_table,
        $inventory_table,
        $login_table,
        $cashout,
        $stock,
      ];

      $this->nw_table_names = [
        "" . $this->DB_PREFIX . "_movieshop",
        "" . $this->DB_PREFIX . "_cybershop",
        "" . $this->DB_PREFIX . "_playstation",
        "" . $this->DB_PREFIX . "_sales",
        "" . $this->DB_PREFIX . "_expenses",
        "" . $this->DB_PREFIX . "_sales",
        "" . $this->DB_PREFIX . "_nettotal",
        "" . $this->DB_PREFIX . "_user",
        "" . $this->DB_PREFIX . "_inventory",
        "" . $this->DB_PREFIX . "_login",
        "" . $this->DB_PREFIX . "_cashout",
        "" . $this->DB_PREFIX . "_stock",
      ];

      //default execution first
      foreach ($this->nw_table_names as $nw_table) {
        $this->default = "DROP TABLE IF EXISTS " . $nw_table . "";
        $this->stmt = $this->conn->prepare($this->default);
        $this->stmt->execute();
      }

      //for each sql statement
      foreach ($this->tables as $k => $this->sql) {
        //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->stmt = $this->conn->prepare($this->sql);
        $this->stmt->execute();
      }

      LoadUsers('dr_user', $this->conn);

    } else {
      //run null->optimizes loading
    }

  }
}