<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';

require_once MNG_ROOT . 'autoload.php'; // below smarty

$ba_rows = array();
$page = 1;
$pages = 1;
$total_num = 0;

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

if (!isset($_GET['p'])) {
  $page = 1;
} else {
  $page = (int)$_GET['p'];
}

$employe_id = $_SESSION['user']['user'];

$total_num = tb_ba::query_ba_total_num();
if (($page - 1) * 10 > $total_num) {
  $page = (int)($total_num / 10) + 1;
}
if ($page < 1) { $page = 1; }

$ba_rows = tb_ba::query_ba_limit(($page - 1) * 10, 10);
if ($ba_rows === false) {
  $err_msg = '访问数据库失败';
  break;
}
$pages = (int)($total_num / 10) + 1;
if ($total_num % 10 == 0) {
  $pages -= 1;
}

$tpl->assign("refer", $_SERVER['HTTP_REFERER']);
$tpl->assign("content_title", "病友吧");
$tpl->assign("ba_rows", $ba_rows === false ? array() : $ba_rows);
$tpl->assign("inc_name", "bing_you_ba_list.html");
$tpl->assign("page", $page);
$tpl->assign("total_num", $total_num);
$tpl->assign("pages", $pages);

$tpl->display("home.html");