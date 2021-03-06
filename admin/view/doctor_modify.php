<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';

require_once MNG_ROOT . 'autoload.php'; // below smarty
require_once MNG_ROOT . '../common/cc_key_def.php'; // below smarty

$err_msg = '';
$recent_jh_num = 0;

$tpl->assign("content_title", S_DOCTOR_XIN_XI);
$tpl->assign("doctor_info_title", S_DOCTOR_XIN_XI);
$tpl->assign("new_one", 0);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $doctor_id = $_POST['id'];
  $name = trim($_POST['name']);
  $sex = $_POST['sex'];
  $phone_num = $_POST['phone_num'];
  $classify = $_POST['classify'];
  $disease_id = $_POST['disease'];
  $ke_shi = $_POST['ke_shi'];
  $hospital = trim($_POST['hospital']);
  $expert_in = $_POST['expert_in'];
  $tec_title = $_POST['tec_title'];
  $aca_title = isset($_POST['aca_title']) ? (int)$_POST['aca_title'] : 0;
  $adm_title = $_POST['adm_title'];

  do {
    if (empty($name) || !check::is_name($name)
        || empty($doctor_id) || $doctor_id <= 0
        || !isset($sex) || !check::is_sex($sex)
        || empty($phone_num) || !check::is_phone_num($phone_num)
        || !check::is_doctor_classify($classify)
        || empty($hospital) || strlen($hospital) > 90
        || empty($expert_in) || strlen($expert_in) > 450
        || empty($ke_shi) || !is_numeric($ke_shi)
        || !is_numeric($disease_id)
        || empty($tec_title) || !is_numeric($tec_title)
        || empty($aca_title) || !is_numeric($aca_title)) {
      $err_msg = '输入参数错误';
      break;
    }

    if (get_magic_quotes_gpc()) {
      $name = stripslashes($name);
      $hospital = stripslashes($hospital);
      $expert_in = stripslashes($expert_in);
    }
    $user = $_SESSION['user']['user'];

    tb_doctor::query_doctor_by_phone_num($phone_num);
    if (!empty($doctor_info)) {
      $err_msg = '该电话已经录入！';
      break;
    }
    $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
    if (empty($doctor_info)) {
      $err_msg = '该医生未录入！';
      break;
    }
    if ($doctor_info['employe_id'] != $user) {
      $err_msg = '您没有权限编辑';
      break;
    }

    if (empty(tb_disease::query_disease_by_id($disease_id))) {
      $err_msg = '咨询室病种ID无效';
      break;
    }

    //upload file
    $icon_url = '';
    if (!empty($_FILES['photo']["name"])) {
      $path = "image/doctor/icon/" . date("Ymd");
      $up = new upload($_FILES['photo'],
                       IMG_ROOT . "/" . $path,
                       2*1024*1024,
                       array('.jpg', '.jpeg', '.png')
                      );
      if ($up->just_do_it() === false) {
        $err_msg = $up->error();
        break;
      }
      $icon_url = IMG_BASE_URL . $path . "/" . $up->filename();
    }

    $disease_list = array("disease1", "disease2", "disease3", "disease4");
    $rel_disease_list = array($disease_id);
    foreach ($disease_list as $dis) {
      if (!empty($_POST[$dis])) {
        $id = (int)$_POST[$dis];
        if (!empty(tb_disease::query_disease_by_id($id))) {
          if (!in_array($id, $rel_disease_list))
            $rel_disease_list[] = $id;
        }
      }
    }

    $update_info = array();
    if (!empty($name)) {
      $update_info['name'] = $name;
    }
    if (!empty($phone_num)) {
      $update_info['phone_num'] = $phone_num;
    }
    if (!empty($classify)) {
      $update_info['classify'] = $classify;
    }
    $update_info['sex'] = $sex;
    if (!empty($icon_url)) {
      $update_info['icon_url'] = $icon_url;
    }
    if (!empty($ke_shi)) {
      $update_info['ke_shi'] = $ke_shi;
    }
    if (!empty($disease_id)) {
      $update_info['disease_id'] = $disease_id;
    }
    if (!empty($tec_title)) {
      $update_info['tec_title'] = $tec_title;
    }
    if (!empty($aca_title)) {
      $update_info['aca_title'] = $aca_title;
    }
    if (isset($adm_title)) {
      $update_info['adm_title'] = $adm_title;
    }
    if (!empty($hospital)) {
      $update_info['hospital'] = $hospital;
    }
    if (!empty($expert_in)) {
      $update_info['expert_in'] = $expert_in;
    }

    if (tb_doctor::update($doctor_id, $update_info) !== false) {
      foreach ($rel_disease_list as $dis) {
        tb_disease_rel_doctor::update($dis, $doctor_id);
      }
      $err_msg = '编辑成功';
    } else {
      $err_msg = '系统内部错误，编辑失败';
    }
  } while (false);
  build_html($doctor_id);
  alert($err_msg);
} else {
  if (empty($_GET['id'])) {
    $err_msg = "query failed";
  } else {
    $doctor_id = $_GET['id'];
    $tpl->assign("refer", $_SERVER['HTTP_REFERER']);
    build_html($doctor_id);
  }
}

function build_html($doctor_id)
{
  global $tpl;
  global $recent_jh_num;
  $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
  if ($doctor_info === false || empty($doctor_info)) {
    $err_msg = "query failed";
  } else {
    $tpl->assign("id", $doctor_id);
    $tpl->assign("name", $doctor_info['name']);
    $tpl->assign("phone_num", $doctor_info['phone_num']);
    $tpl->assign("classify", $doctor_info['classify']);
    $tpl->assign("sex", $doctor_info['sex']);
    $tpl->assign("icon_url", $doctor_info['icon_url']);
    $tpl->assign("ke_shi", $doctor_info['ke_shi']);
    $tpl->assign("tec_title", $doctor_info['tec_title']);
    $tpl->assign("aca_title", $doctor_info['aca_title']);
    $tpl->assign("adm_title", $doctor_info['adm_title']);
    $tpl->assign("hospital", $doctor_info['hospital']);
    $tpl->assign("expert_in", $doctor_info['expert_in']);
    $tpl->assign("c_time", $doctor_info['c_time']);
    $tpl->assign("disease_id", $doctor_info['disease_id']);

    if (!empty($doctor_info['master_id'])) {
      $info = tb_doctor::query_doctor_by_id($doctor_info['master_id']);
      if (!empty($info)) {
        $tpl->assign("master_name", $info['name']);
      }
    }

    $ret = tb_disease::query_all();
    $tpl->assign('disease_rows', $ret === false ? array() : $ret);
    
    $dis_ret = tb_disease_rel_doctor::query_doctor_rel_disease($doctor_id);
    if (!empty($dis_ret)) {
      $i = 1;
      foreach ($dis_ret as $dis) {
        if (!empty($dis)) {
          $tpl->assign("disease_id" . $i, $dis['disease_id']);
          $i++;
        }
      }
    }

    $recent_jh_num = 1;
  }
}

  $tpl->assign("refer", '');
$tpl->assign("err_msg", $err_msg);
$tpl->assign("inc_name", "doctor_info.html");
$tpl->display("home.html");
