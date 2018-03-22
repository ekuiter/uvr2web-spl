<?php

/**
 * Contains DB class
 *
 * @package Database
 */
 
/**
 * Database
 *
 * Manages the database connection and querying.
 *
 * @package Database
 */

class DB {

  /**
   * Database server
   */
  private static $server = '';
  /**
   * User name
   */
  private static $user = '';
  /**
   * Password
   */
  private static $pass = '';
  /**
   * Database name
   */
  private static $dbname = '';
  /**
   * Database type (de facto only MySQL)
   */
  private static $type = '';
  /**
   * Database charset
   */
  private static $charset = '';
  /**
   * Database handle
   */
  private static $db;
  /**
   * Affected rows
   */
  private static $rows;

  /**
   * Initializes the database
   * @param string $server
   * @param string $user
   * @param string $pass
   * @param string $dbname
   * @param string $type
   * @param string $charset
   */
  public static function start($server, $user, $pass, $dbname, $type = 'MySQL', $charset = 'utf8') {
    self::$server = $server;
    self::$user = $user;
    self::$pass = $pass;
    self::$dbname = $dbname;
    self::$charset = $charset;
    self::$type = strtolower($type);
  }

  /**
   * Checks if the database is connected
   */
  public static function isConnected() {
    if (empty(self::$db))
      return false;
    else
      return true;
  }

  /**
   * Connects to the database
   */
  public static function connect() {
    if (self::$type == 'mysql') {
      self::$db = @mysqli_connect(self::$server, self::$user, self::$pass);            
      @mysqli_set_charset(self::$db, self::$charset);
      if (!@mysqli_select_db(self::$db, self::$dbname))
        throw new Exception('Database name invalid');
    } else {
      self::$db = false;
      throw new Exception('Invalid type, check constructor');
    }
    if (empty(self::$db)) {
      self::$db = false;
      throw new Exception('Error connecting to the database, check constructor');
    }
  }

  private static function modify_sql($sql) {
    if (Runtime::hasFeature("single sensor") && isset($GLOBALS['id'])) {
      $parts = explode('-', $GLOBALS['id']);
      if (count($parts) < 2)
        throw new Exception("invalid ID");
      $prefix = $parts[0];
      $sql = str_replace('uvr2web_config', "{$prefix}_config", $sql);
      $sql = str_replace('uvr2web_data', "{$prefix}_data", $sql);
      $sql = str_replace('uvr2web_users', "{$prefix}_users", $sql);
    }
    return $sql;
  }

  /**
   * Queries the database with SQL
   * @param string $sql
   */
  public static function query($sql) {
    $sql = self::modify_sql($sql);
    if (self::$type == 'mysql')
      $result = self::query_mysqli($sql);
    else
      throw new Exception('Invalid type, check constructor');
    return $result;
  }
  
  /**
   * Multi queries the database with SQL
   * @param string $sql
   */
  public static function multi_query($sql) {
    $sql = self::modify_sql($sql);
    if (self::$type == 'mysql')
      self::multi_query_mysqli($sql);
    else
      throw new Exception('Invalid type, check constructor');
  }

  /**
   * Queries a MySQL database
   * @param string $sql
   */
  private static function query_mysqli($sql) {
    if (empty(self::$db)) {
      if (!self::isConnected())
        throw new Exception('Database not connected');
      throw new Exception('Invalid database connection, check constructor');
    }
    $query = @mysqli_query(self::$db, $sql);
    self::$rows = @mysqli_affected_rows(self::$db);
    if (!$query)
      return false;
    else if ($query === true)
      return array();
    $result = array();
    $i = 0;
    while (false != ($row = @mysqli_fetch_assoc($query))) {
      foreach ($row as $column_key => $column_value)
        $result[$i][$column_key] = $column_value;
      $i+=1;
    }
    return $result;
  }
  
  /**
   * Multi ueries a MySQL database
   * @param string $sql
   */
  private static function multi_query_mysqli($sql) {
    if (empty(self::$db)) {
      if (!self::isConnected())
        throw new Exception('Database not connected');
      throw new Exception('Invalid database connection, check constructor');
    }
    $query = @mysqli_multi_query(self::$db, $sql);
    self::$rows = @mysqli_affected_rows(self::$db);
  }

  /**
   * Fetches affected rows
   */
  public static function get_rows() {
    return self::$rows;
  }

  /**
   * Escapes a string
   * @param string $string
   */
  public static function escape($string) {
    if (self::$type == 'mysql')
      return @mysqli_real_escape_string(self::$db, $string);
    else
      throw new Exception('Invalid type, check constructor');        
  }
}

?>