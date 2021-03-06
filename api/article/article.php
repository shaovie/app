<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

define('ONE_PAGE_ITEMS', 10);

$ret_code = 0;
$ret_body = array();

do {
  $page = 1;
  if (!empty($_GET['p'])) {
    $page = (int)$_GET['p'];
  }

  $article_list = array();
  $total_num = 0;
  $where = '';

  if (!empty($_GET['doctor_id'])) { //
    $doctor_id = (int)$_GET['doctor_id'];
    $where = "doctor_id=$doctor_id";
  } elseif (!empty($_GET['type'])) { //
    $article_type = (int)$_GET['type'];
    if ($article_type < 1
        || $article_type > 10) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
    $where = "article_type=$article_type";
  }
  $total_num = tb_doctor_article::query_article_total_num($where);
  if ($total_num > 0) {
    if (!empty($_GET['p'])) { $page = (int)$_GET['p']; }
    if (($page - 1) * ONE_PAGE_ITEMS <= $total_num
        && $page >= 1) {
      $article_list = tb_doctor_article::query_article_limit($where,
                                                             "id desc",
                                                             ($page - 1) * ONE_PAGE_ITEMS,
                                                             ONE_PAGE_ITEMS);
      if ($article_list === false) {
        $ret_code = ERR_DB_ERROR;
        break;
      }
      $article_list = fn_doctor_article::build_doctor_article_brief_list($article_list);
    }
  } // end of `if ($total_num > 0)'
  $ret_body['total_num'] = $total_num;
  $ret_body['p'] = $page;
  $ret_body['list'] = $article_list;
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
