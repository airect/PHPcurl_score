<?php
/**
 * 
 * @Class CurlTool
 * @author Airect
 *
 */
error_reporting(0);
class CurlTool {
	protected  $url;
	//GET或POST的键值对
	protected  $arguments = array();
	//curl options
	protected  $options = array(
		//CURLOPT_HEADER => 1,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.132 Safari/537.36',
		CURLOPT_FOLLOWLOCATION => 1
	);
	//cookie
	protected $cookie = '';
	//接受到的html
	protected  $content;
	//返回的信息
	protected  $response;
	
	protected  $errorInfo = array(
			'arguments' => '参数错误',
			'curl_error' => 'curl执行错误'
	);
	
	
	public $errorMsg;
	
	
	function  __construct() {
//		session_start();
//		if($url !== ''){
//			$this->url = $url;
//			if(is_array($arguments)){
//				$this->arguments = $arguments;
//			}
//		}
//		if(!$_SESSION['cookie']){
//			$this->cookie = $_SESSION['cookie'];
//		}
	}
	function __destruct(){
		
	}
	//post
	public function curlPost($url = '',$param = array()) {
		if($url !== ''){
			$this->url = $url;
		}
		$this->arguments = $param;
		//$this->options   = array();
		$this->curlCore(2);
	}
	
	//get
	public function curlGet($url = '',$param = array()) {
		if($url !== ''){
			$this->url = $url;
		}
		$this->arguments = $param;
//		$this->options = array();
		$this->curlCore(1);
	}
	
	
	//curl核心代码
	protected function curlCore($method = 'get') {
		$ch = curl_init($this->url);
		
		//设置参数
		if($method == 1){ //default get
			
		}elseif($method == 2){ //post
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $this->arguments);
		}
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt_array($ch, $this->options);
		curl_setopt($ch, CURLOPT_HEADER, true);
		//curl_setopt($ch, CURLOPT_NOBODY, true);
		
		//带上cookie
		if($this->cookie){
			curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
		}
		
		//获取返回内容
		$this->content  = $content   = curl_exec($ch);
		$this->response = $response  = curl_getinfo($ch);
		
		
		//保存cookie
		$falg = preg_match('/Set-Cookie:.*?;/', $content, $cookie);
		if($falg){
			$cookie = $cookie[0];
			$this->cookie = substr($cookie,11);
//			var_dump($header);	
		}
		
		//错误信息
		$error = curl_error($ch);
		//var_dump($error);
		//http状态
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		//关闭curl连接
		curl_close($ch);
		
		if($http_code != 200){
			$this->errorMsg = $this->errorInfo['curl_error'] . $error . $http_code;
			return false;
		}
			
	}
	public function getContent (){
		return $this->content;
	}
	public function getResponse() {
		return $this->response;
	}
	
}

?>