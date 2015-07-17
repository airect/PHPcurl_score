<?php

include('CurlTool.class.php');
$curl = new CurlTool();
$username = $_POST['username'];
$passwd   = $_POST['passwd'];
if($passwd == '' || $username == ''){
	exit("请输入账号和密码");
}
$param = array(
	'username' => $username,
	'passwd'   => $passwd
);
$url  =  './cjcx.php';
$curl->curlPost($url,$param);
$content = $curl->getContent();
var_dump($content);

?>