<?php

// 增加常用就诊人

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$result = array();

do {
  if (empty($_GET['sid'])
    || empty($_GET['name'])
    || empty($_GET['id_card'])
    || empty($_GET['birthday'])
    || !isset($_GET['sex'])
    || !isset($_GET['is_default'])
    || empty($_GET['phone_num'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sid = $_GET['sid'];
  $sex = $_GET['sex'];
  $name = $_GET['name'];
  $id_card = $_GET['id_card'];
  $birthday = $_GET['birthday'];
  $is_default = (int)$_GET['is_default'];
  $phone_num = $_GET['phone_num'];
  if (!user_session::is_sid($sid)
    || !check::is_phone_num($phone_num)
    || !check::is_sex($sex)
    || !check::is_id_card($id_card)
    || !check::is_date($birthday)
    || !check::is_0_or_1($is_default)
    || !check::is_name($name)) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  if (get_magic_quotes_gpc()) {
    $name = stripslashes($name);
  }

  $s_info = user_session::get_session($sid);
  if ($s_info === false) {
    $ret_code = ERR_NOT_LOGIN;
    break;
  }

  $s_info = json_decode($s_info, true);
  if (empty($s_info)) {
    $ret_code = ERR_NOT_LOGIN;
    break;
  }
  $user_id = $s_info['user_id'];

  $num = tb_user_patient::query_user_patients_num($user_id);
  if ($num === false || $num >= 5) {
    $ret_code = ERR_USER_PATIENTS_LIMIT;
    break;
  }
  if ($num === 0) {
    $is_default = 1;
  }

  $new_patient_id = tb_user_patient::insert_new_one($user_id,
    $phone_num,
    $name,
    $id_card,
    $sex,
    $birthday);
  if ($new_patient_id === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  if ($is_default === 1) {
    // update session info
    if (tb_user::set_default_patient($user_id, $new_patient_id) !== false) {
      $s_info['default_patient'] = $new_patient_id;
      user_session::set_session($sid, json_encode($s_info));
    }
  }
  $ret_body['id'] = $new_patient_id;
  $ret_body['name'] = $name;
  $ret_body['sex'] = $sex;
  $ret_body['id_card'] = $id_card;
  $ret_body['phone_num'] = $phone_num;
  $ret_body['birthday'] = $birthday;
  $ret_body['is_default'] = $is_default;

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);