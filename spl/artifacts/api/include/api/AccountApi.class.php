<?php

/**
 * Contains AccountApi class
 *
 * @package Api
 */

/**
 * Account API
 *
 * Adds, updates and deletes users.
 *
 * @package Api
 */

class AccountApi {
  
  public $index = 'Returns a list of uvr2web accounts (admin-only).';
  public $index_ex = array('account.index');
  public $create = 'Creates a new account with the given options (admin-only).';
  public $create_ex = array('account.create(my_user,my_pass,my_pass,user)', 'account.create(my_user,my_pass,my_pass,admin)');
  public $read = 'Reads an account with the given id (admin-only).';
  public $read_ex = array('account.read(1)');
  public $update = 'Updates an account with the given id and options (admin-only).';
  public $update_ex = array('account.update(1,new_user,,,admin)', 'account.update(1,new_user,new_pass,new_pass,admin)');
  public $destroy = 'Destroys an account with the given id and username (admin-only).';
  public $destroy_ex = array('account.destroy(1,my_user)');
  
  function __before() {
    if (!Runtime::hasFeature("user management"))
      throw new Exception("user management deactivated");
    ApiHelper::authenticate('admin');
  }
  
  function index() {
    return DB::query('SELECT id, username, role FROM uvr2web_users');
  }
  
  function create($username, $password, $password_confirmation, $role) {
    ApiHelper::ensure(array($username, $password, $password_confirmation));
    $username = DB::escape($username);
    $role = DB::escape($role);
    if ($role != 'user' && $role != 'admin') throw new Exception('invalid role');
    if ($password != $password_confirmation) throw new Exception('passwords don\'t match');  
    $password = DB::escape((new Password($password))->hash());
    
    DB::query("INSERT INTO uvr2web_users (username, password, role) VALUES('$username', '$password', '$role')");
    if (DB::get_rows() > 0)
      return DB::query("SELECT id, username, role FROM uvr2web_users WHERE username='$username'")[0];
    else
      throw new Exception("'$username' already exists");
  }
  
  function read($id) {
    ApiHelper::ensure($id);
    $id = DB::escape($id);
    $result = DB::query("SELECT id, username, role FROM uvr2web_users WHERE id=$id");
    if (!$result)
      throw new Exception("account id $id does not exist");
    return $result[0];
  }
  
  function update($id, $username, $password, $password_confirmation, $role) {
    ApiHelper::ensure($username);
    $id = DB::escape($id);
    $username = DB::escape($username);
    $role = DB::escape($role);
    $this->read($id);
    if ($role != 'user' && $role != 'admin') throw new Exception('invalid role');
    
    $pwstring = '';
    if ($password || $password_confirmation) {
      if ($password == $password_confirmation)
        $pwstring = ", password='" . DB::escape((new Password($password))->hash()) . "'";
      else
        throw new Exception('passwords don\'t match');
    }
    DB::query("UPDATE uvr2web_users SET username='$username'$pwstring, role='$role' WHERE id=$id");
    return $this->read($id);
  }
  
  function destroy($id, $username) {
    ApiHelper::ensure($username);
    $id = DB::escape($id);
    $user = $this->read($id);
    if ($user['username'] != $username) throw new Exception("username is wrong");
    
    if ($user['role'] == 'admin') {
      DB::query("SELECT * FROM uvr2web_users WHERE role='admin'");
      if (DB::get_rows() > 1) {
        DB::query("DELETE FROM uvr2web_users WHERE id=$id");
        return $user;
      } else
        throw new Exception('the last admin can not be destroyed');
    } else {
      DB::query("DELETE FROM uvr2web_users WHERE id=$id");
      return $user;
    }
  }
  
}

?>