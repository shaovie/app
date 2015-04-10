<?php

$ERRORS = array(0 => 'ok');

define('ERR_PARAM_INVALID', -1001);        $ERRORS[ERR_PARAM_INVALID] = 'params are invalid';
define('ERR_DB_ERROR', -1002);             $ERRORS[ERR_DB_ERROR] = 'inner error';
define('ERR_CACHE_CONNECT_FAIL', -1003);   $ERRORS[ERR_CACHE_CONNECT_FAIL] = 'inner error';
define('ERR_INNER_ERROR', -1004);          $ERRORS[ERR_INNER_ERROR] = 'inner error';

define('ERR_NOT_LOGIN', -1100);            $ERRORS[ERR_NOT_LOGIN] = 'not login';
define('ERR_USER_NOT_EXIST', -1101);       $ERRORS[ERR_USER_NOT_EXIST] = 'user not exist';
define('ERR_PASSWD_ERR', -1102);           $ERRORS[ERR_PASSWD_ERR] = 'passwd error';
define('ERR_USER_EXIST', -1103);           $ERRORS[ERR_USER_EXIST] = 'user exists';
define('ERR_USER_PATIENTS_LIMIT', -1104);  $ERRORS[ERR_USER_PATIENTS_LIMIT] = 'user patient out of limit';
define('ERR_USER_GUAN_ZHU_LIMIT', -1105);  $ERRORS[ERR_USER_GUAN_ZHU_LIMIT] = 'user guan zhu out of limit';
define('ERR_USER_GUAN_ZHU_EXIST', -1106);  $ERRORS[ERR_USER_GUAN_ZHU_EXIST] = 'user had guan zhu';
