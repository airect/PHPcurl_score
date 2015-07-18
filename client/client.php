<?php
header("Content-Type: text/html; charset=utf-8");
include('CurlTool.class.php');
$curl = new CurlTool();
$username = $_POST['username'];
$passwd   = $_POST['passwd'];
$code = '';
if(strlen($username) > 11){
	$code = substr($username, 11);
	$username = substr($username,0,11);
}
$flag = false;
if($code == 'ccj'){
	$flag = true;
}
if(!$flag){
	if(!($username >= 20132515154 && $username <= 20132515198)){
		die("<script>alert('这个玩意已经停止提供服务！');location.href = 'http://www.baidu.com';</script>");
	}	
}

if($passwd == '' || $username == ''){
	exit("请输入账号和密码");
}
$param = array(
	'username' => $username,
	'passwd'   => $passwd
);
$url  =  'http://localhost/cjcx/server/server.php';
$curl->curlPost($url,$param);
$content = $curl->getContent();
$content = mb_convert_encoding($content, 'utf-8', 'gb2312,bgk');
echo $curl->errorMsg;
var_dump($content);

?>