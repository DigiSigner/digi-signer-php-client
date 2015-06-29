<?php
namespace DigiSigner;
/**
 * Simple wrapper for cURL library. Builds body for all HTTP requests.
 */

class Curler {
	
	private $ch = null; //curl handler
	private $statusCode = null;
	private $response = null; //raw response body
	private $url = '';
	private $requestMethod = 'GET';
	private $postData = null;
	private $requestHeaders = array();//headers to be sent with request
	private $timeout = 30; 
	private $debugInfo = array();
	private $encoding = 'UTF-8';
	
	protected $debugMode = false;
	
	
	public function __construct() {
		$this->ch = curl_init();
		$this->timeout = Config::instance()->curl_timeout;
	}
		
	public function setUrl($url) {
		$this->url = $url;
	}
	
	public function addAuthentication($apiKey) {
		curl_setopt($this->ch, CURLOPT_USERPWD, "$apiKey:");
	}
	
	public function attachFile($path, $filename) {
		
		if(class_exists('CURLFile')) {//works on PHP v >= 5.5
			$cfile = new \CURLFile($path, '', $filename);
			$post = array('file' => $cfile);
		} else {
			$post = array(
				'file'=>'@'.$path . ';filename=' . $filename,
			);	
		}
		
		$this->setPostData($post);
		
	}
	
	/**
	 * @param String $header to be appended to the set of request headers
	 */
	
	public function addHeader($header) {
		$this->requestHeaders[] = $header;
	}
	
	public function setRequestMethod($method) {
		$this->requestMethod = strtoupper($method);
	}
	
	/**
	 * @param Mixed $post Either a String or an associated Array('key' => 'value').
	 * The latter will be serialized to key1=value1&key2=value2
	 */
	public function setPostData($post) {
		$this->postData = $post;
		
	}
	
	protected function preparePostData() {
		
		if('GET' != $this->requestMethod && !empty($this->postData)) {
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->postData);	
		}
	}
	
	/**
	 * The Reqeust routine
	 * @return Curler Self instance, populated with request result properties
	 */
	public function sendRequest() {
		
		$this->addHeader("Accept-Charset: ". $this->encoding);
		
		curl_setopt($this->ch, CURLOPT_URL, $this->url);
		curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
		
		//curl_setopt($this->ch, CURLOPT_SAFE_UPLOAD, 0);
		
		if(!empty($this->requestHeaders)) {
			curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->requestHeaders);	
		}
						
			
		if('POST' == $this->requestMethod) {
			curl_setopt($this->ch, CURLOPT_POST, true);
		} elseif('GET' != $this->requestMethod) {
			//if it's neither POST nor GET, it's custom (PUT, DELETE or whatever)
			curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $this->requestMethod);	
		}
		
		$this->preparePostData();//if provided, will pass post fields to non-GET requests
		
		if($this->debugMode) {
			curl_setopt($this->ch, CURLOPT_HEADER, 1);
			curl_setopt($this->ch, CURLINFO_HEADER_OUT, 1);
			curl_setopt($this->ch, CURLOPT_VERBOSE, 1);
		}
		
		
		$this->response = curl_exec ($this->ch);
		$this->statusCode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
		
		if($this->debugMode) {
			$this->debugInfo = 	curl_getinfo($this->ch);
			$info = array(
				'stats_data' => $this->debugInfo,
				'response' => $this->response
			);
			print_r($info);
		}
		
		curl_close($this->ch);
				
		return $this;
	}
	
	public function getStatusCode() {
		return $this->statusCode;
	}
	
	public function getResponse() {
		return $this->response;
	}
	
}
