<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

$err_msg = '';
if ($_SERVER['REQUEST_METHOD'] == "GET") {
  do {
    if (empty($_GET['id'])) {
      $err_msg = "参数错误";
      break;
    }

    $doctor_id = $_GET['id'];
    $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
    if ($doctor_info === false || empty($doctor_info)) {
      $err_msg = "查找该医生失败";
      break;
    }

    $tpl->assign("doctor_id", $doctor_id);
    $tpl->assign("content_title", "添加文章 - <b>" . $doctor_info['name'] . "</b>");
    $tpl->assign("new_one", 1);

    $tpl->display("doctor_article.html");
    exit;
  } while (false);
  alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
  do {
    $user = $_SESSION['user']['user'];

    $doctor_id = $_POST['doctor_id'];
    $topic = $_POST['topic'];
    $article_type = (int)$_POST['article_type'];
    $content = $_POST['editorValue'];

    if (strlen($topic) > 90
        || ($article_type < 1 || $article_type > 4)
        || strlen($content) > 12000) {
      $err_msg = "标题或内容太长";
      break;
    }

    if (get_magic_quotes_gpc()) {
      $topic = stripslashes($topic);
      $content = stripslashes($content);
    }

    $path = "image/article/icon";
    $up = new upload($_FILES['icon'],
                     IMG_ROOT . "/" . $path,
                     2*1024*1024,
                     array('.jpg', '.jpeg', '.png')
                    );
    if ($up->just_do_it() === false) {
      $err_msg = $up->error();
      break;
    }
    $icon_url = IMG_BASE_URL . $path . "/" . $up->filename();

    $new_article_id = tb_doctor_article::insert_new_one($doctor_id,
                                                        $icon_url,
                                                        $article_type,
                                                        $topic,
                                                        $content,
                                                        time());
    if ($new_article_id !== false) {
      $err_msg = "添加成功!";
      alert_and_redirect($err_msg, "view/doctor_article_view.php?id=$new_article_id&doctor_id=$doctor_id");
    }
  } while (false);
  alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
}
