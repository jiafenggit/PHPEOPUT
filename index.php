<?php
header("Content-type:text/html;charset=utf-8");
require_once 'include/error.class.php';

$test['name1']='apple';
$test['price1']='10';
$test['data']=array('year'=>'2014-10-1','moth'=>'10月份');
$test['name2']='orange';
$test['price2']='20';

$test2['name1']='apple';
$test2['price1']='10';
$test2['data']=array('year'=>'2014-10-1','moth'=>'10月份');
$test2['name2']='orange';
$test2['price2']='20';

$test=json_encode($test);

error_info::error_line(__LINE__);
error_info::error_param("测试字符串");
call_user_func(array('error_info','error_param'),$test);
call_user_func(array('error_info','error_param'),$test2);
call_user_func(array('error_info','error_param'),$test2,3);


?>