<?php
/**
 * 主程
 */
error_reporting(0);

include 'CurlTool.class.php';
$curl = new CurlTool();
$username = $_POST['username'];
$passwd   = $_POST['passwd'];
//POST http://202.194.48.12:9004/loginAction.do
$login_param = array(
	'zjh' => $username,
	'mm'  => $passwd
);
$login_url = 'http://202.194.48.12:9004/loginAction.do';
$curl->curlPost($login_url, $login_param);
$title = $curl->getContent();
//echo $title;
//$flag = preg_match('/<title>.*<\/title>/', $title,$matches);
//if($flag){
//	$title = $matches[0];
//	if($title == '<title>URP 综合教务系统 - 登录</title>'){
//		exit("账号或密码错误");	
//	}
////	var_dump($title);
//}else{
//	echo 'error';
//	return;
//}

//GET http://202.194.48.12:9004/bxqcjcxAction.do?pageSize=30
$socre_url = 'http://202.194.48.12:9004/bxqcjcxAction.do?pageSize=50';
$socre_param = array();
$curl->curlGet($socre_url, $socre_param);
$socre_info = $curl->getContent();
$score_info = mb_convert_encoding($socre_info, 'utf-8', 'gb2312,gbk');
var_dump($socre_info);

//注销
$logout_url = 'http://202.194.48.12:9004/logout.do';
$curl->curlPost($logout_url, array('loginType'=>'platformLogin'));
//正则抓取
preg_match_all('/<tr\sclass="odd"[.\n]*>/',$socre_info,$matches);
//echo '<pre>';
//var_dump($matches[0][0]);
//echo $matches[0][0];
//echo '</pre>';
//

?>