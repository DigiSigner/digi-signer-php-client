<?php
namespace DigiSigner;
/*
 * Settings for the configuration.
 */
 
class Config {
	
	public $server_default_url = "https://api.digisigner.com";
    public $version = "/v1";
	public $param_doc_id = 'document_id';
	public $fields_path = "/fields";
	public $attachment_path = '/attachment';

	private $documents_path = '/documents';
	private $signature_requests_path = '/signature_requests';
	
	public $curl_timeout = 30;

	public $documents_url, $signature_requests_url;
		
	
	public function __construct() {
		$this->documents_url = $this->version.$this->documents_path;
		$this->signature_requests_url = $this->version.$this->signature_requests_path;
	}
	
	/*
	 * Static method for easy access to non static config properties
	 */
     public static function instance() {
		static $instance = null;
		
		if(!$instance) {
			$class = __CLASS__;
			$instance = new $class;	
		}
		
		return $instance;
	}
	
    
}
