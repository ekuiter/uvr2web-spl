<?php

/**
 * Contains Backup class
 *
 * @package AdminPages
 */

/**
 * Backup page
 *
 * Allows to backup the database.
 *
 * @package AdminPages
 */

class Backup {

  /**
   * Gets page title
   */
  public function title() {
    return Loc::t('backup');
  }

  /**
   * Renders the backup section
   */
  public function render() {
    $do_backup = Loc::t('do backup');
    $backup_body = Loc::t('backup body');
    echo <<<code
    <p>$backup_body</p>
    <a class="btn btn-primary" href="index.php?p=admin&live">$do_backup</a>
code;
  }

  function do_backup() {
    echo $this->backup_tables($GLOBALS['cfg']['server'], $GLOBALS['cfg']['username'], $GLOBALS['cfg']['password'], $GLOBALS['cfg']['database'], 'uvr2web_config,uvr2web_data,uvr2web_users');
  }

  function backup_tables($host, $user, $pass, $name, $tables = '*') {
    $link = mysql_connect($host, $user, $pass);
    mysql_set_charset('utf8');
    mysql_select_db($name, $link);
    //get all of the tables
    if($tables == '*') {
      $tables = array();
      $result = mysql_query('SHOW TABLES');
      while($row = mysql_fetch_row($result)) {
        $tables[] = $row[0];
      }
    } else {
      $tables = is_array($tables) ? $tables : explode(',',$tables);
    }
    $return = '';
    //cycle through
    foreach($tables as $table) {
      $result = mysql_query('SELECT * FROM '.$table);
      $num_fields = mysql_num_fields($result);

      $return.= 'DROP TABLE IF EXISTS '.$table.';';
      $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
      $return.= "\n\n".$row2[1].";\n\n";
      for ($i = 0; $i < $num_fields; $i++) {
        while($row = mysql_fetch_row($result)) {
          $return.= 'INSERT INTO '.$table.' VALUES(';
          for($j=0; $j<$num_fields; $j++) {
            $row[$j] = addslashes($row[$j]);
            $row[$j] = @ereg_replace("\n","\\n",$row[$j]);
            if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
            if ($j<($num_fields-1)) { $return.= ','; }
          }
          $return.= ");\n";
        }
      }
      $return.="\n\n\n";
    }
    return $return;
  }

}

?>