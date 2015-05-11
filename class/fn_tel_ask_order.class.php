<?php

class fn_tel_ask_order
{
  public static function build_order_brief_list($order_list)
  {
    $brief_list = array();
    foreach ($order_list as $item) {
      $order = array();
      $order['id']    = $item['id'];

      $doctor_info = tb_doctor::query_doctor_by_id($item['doctor_id']);
      if (empty($doctor_info)) {
        $order['doctor'] = $doctor_info['name'];
      } else {
        $order['doctor'] = '';
      }
      $order['patient']  = $item['name'];
      $order['expected_time_b'] = $item['expected_time_b'];
      $order['expected_time_e'] = $item['expected_time_e'];
      $order['disease_desc'] = $item['disease_desc'];
      $order['emr_url'] = explode(";", $item['emr_url']);
      $brief_list[] = $order;
    }
    return $brief_list;
  }
}
