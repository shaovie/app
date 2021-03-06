<?php

class ke_shi
{
  public static $ke_shi_map = 
    array(1010 => "心血管内科",
          1011 => "神经内科",
          1012 => "消化内科",
          1013 => "内分泌科",
          1014 => "免疫科",
          1015 => "呼吸科",
          1016 => "肾病内科",
          1017 => "血液科",
          1018 => "感染内科",
          1019 => "过敏反应科",
          1020 => "老年病科",
          1021 => "疼痛诊疗科",
          1022 => "高压氧科",
          1023 => "普通科",
          1110 => "神经外科",
          1111 => "心血管外科",
          1112 => "腹部外科",
          1113 => "胸外科",
          1114 => "整形科",
          1115 => "乳腺外科",
          1116 => "泌尿外科",
          1117 => "肝胆外科",
          1118 => "肛肠科",
          1119 => "血管外科",
          1120 => "功能神经外科",
          1121 => "微创外科",
          1122 => "普外科",
          1210 => "妇科",
          1211 => "产科",
          1212 => "妇科内分泌",
          1213 => "妇泌尿科",
          1214 => "产前诊断科",
          1215 => "遗传咨询科",
          1216 => "计划生育科",
          1217 => "妇产科",
          1310 => "生殖中心",
          1410 => "儿科",
          1411 => "新生儿科",
          1412 => "小儿呼吸科",
          1413 => "小儿消化科",
          1414 => "小儿营养保健科",
          1415 => "小儿神经内科",
          1416 => "小儿心内科",
          1417 => "小儿肾内科",
          1418 => "小儿血液科",
          1419 => "小儿感染科",
          1420 => "小儿精神科",
          1421 => "小儿妇科",
          1422 => "小儿外科",
          1423 => "小儿心外科",
          1424 => "小儿胸外科",
          1425 => "小儿骨科",
          1426 => "小儿泌尿科",
          1427 => "小儿神经外科",
          1428 => "小儿整形科",
          1429 => "小儿康复科",
          1430 => "小儿急诊科",
          1510 => "骨科",
          1511 => "脊柱外科",
          1512 => "手外科",
          1513 => "创伤骨科",
          1514 => "骨关节科",
          1515 => "矫形骨科",
          1516 => "骨肿瘤科",
          1517 => "骨质疏松科",
          1518 => "足踝外科",
          1519 => "中西医结合正骨科",
          1610 => "眼肌",
          1611 => "眼科",
          1612 => "小儿眼科",
          1613 => "眼底",
          1614 => "角膜科",
          1615 => "青光眼",
          1616 => "白内障",
          1617 => "眼外科",
          1618 => "眼眶及肿瘤",
          1619 => "屈光",
          1620 => "眼整形",
          1621 => "中医眼科",
          1710 => "口腔科",
          1711 => "颌面外科",
          1712 => "正畸科",
          1713 => "牙体牙髓科",
          1714 => "牙周科",
          1715 => "口腔黏膜科",
          1716 => "儿童口腔科",
          1717 => "口腔修复科",
          1718 => "种植科",
          1719 => "口腔预防科",
          1720 => "综合科",
          1721 => "口腔特诊科",
          1722 => "老年口腔病科",
          1723 => "口腔急诊科",
          1810 => "耳科",
          1811 => "鼻科",
          1812 => "咽喉科",
          1813 => "头颈外科",
          1814 => "耳鼻喉科",
          1910 => "肿瘤内科",
          1911 => "肿瘤外科",
          1912 => "肿瘤妇科",
          1913 => "放疗科",
          1914 => "骨肿瘤科",
          1915 => "肿瘤康复科",
          1916 => "肿瘤综合科",
          2010 => "皮肤科",
          2011 => "性病科",
          2110 => "男科",
          2210 => "皮肤美容",
          2310 => "烧伤科",
          2410 => "精神科",
          2411 => "心理咨询科",
          2412 => "司法鉴定科",
          2413 => "药物依赖科",
          2510 => "中医妇产科",
          2511 => "中医儿科",
          2512 => "中医骨科",
          2513 => "中医皮肤科",
          2514 => "中医内分泌",
          2515 => "中医消化科",
          2516 => "中医呼吸科",
          2517 => "中医肾病内科",
          2518 => "中医免疫科",
          2519 => "中医心内科",
          2520 => "中医神经内科",
          2521 => "中医肿瘤科",
          2522 => "中医血液科",
          2523 => "中医感染内科",
          2524 => "中医肝病科",
          2525 => "中医五官科",
          2526 => "中医男科",
          2527 => "针灸科",
          2528 => "中医按摩科",
          2529 => "中医外科",
          2530 => "中医乳腺外科",
          2531 => "中医肝肠科",
          2532 => "中医老年病科",
          2533 => "中医理疗科",
          2534 => "中医正骨科",
          2535 => "中医科",
          2610 => "中西医结合科",
          2710 => "肝病科",
          2711 => "传染科",
          2712 => "艾滋病科",
          2713 => "传染危重室",
          2810 => "结核病科",
          2910 => "介入医学科",
          3010 => "康复科",
          3011 => "理疗科",
          3110 => "运动医学科",
          3210 => "疼痛科",
          3011 => "麻醉科",
          3310 => "职业病科",
          3410 => "地方病科",
          3510 => "营养科",
          3610 => "医学影像科",
          3710 => "病理科",
          3810 => "急诊科",
          3811 => "预防保健科",
          3812 => "药剂科",
          3813 => "体检科",
          3814 => "血透中心",
          3815 => "碎石中心",
          3816 => "ICU",
          3817 => "护理咨询",
          );
  public static function get_match_id_list($ke_shi_str)
  {
    if (empty($ke_shi_str)) return array();

    $result = array();
    foreach (self::$ke_shi_map as $id => $name) {
      if (strstr($name, $ke_shi_str) !== false) {
        $result[] = $id;
      }
    }
    return $result;
  }
  public static function get_name_by_id($ke_shi_id)
  {
    if (!array_key_exists($ke_shi_id, self::$ke_shi_map)) {
      return '';
    }
    return self::$ke_shi_map[$ke_shi_id];
  }
}
