<?php

class tb_employe
{
  private static $tb_name  = 'employe';
  private static $all_cols = '*';

  public static function insert_new_one($user,
                                        $passwd,
                                        $name,
                                        $c_time)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $name = $db->escape($name);
    $passwd = $db->escape($passwd);
    $sql = "insert into "
      . self::$tb_name
      . "(user,passwd,name,c_time)"
      . "value('$user','$passwd','$name',$c_time)";
    if ($db->execute($sql) === false) {
      return false;
    }
    return $db->affected_rows() == 1;
  }
  public static function update_passwd($user, $passwd)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $passwd = $db->escape($passwd);
    $sql = "update "
      . self::$tb_name
      . " set passwd='$passwd'"
      . " where user='{$user}' limit 1";
    return $db->get_row($sql);
  }

  public static function login_auth($user, $passwd)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select 1 from "
      . self::$tb_name
      . " where user='{$user}' and passwd='{$passwd}' limit 1";
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) return false;
    return $ret == '1';
  }
  public static function query_employe_is_exist($user)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select 1 from "
      . self::$tb_name
      . " where user='{$user}' limit 1";
    return $db->get_one_row_col($sql, 0) == '1';
  }

  public static function query_employe_by_id($user)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " where user='{$user}' limit 1";
    return $db->get_row($sql);
  }
};
