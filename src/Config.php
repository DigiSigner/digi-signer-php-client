<?php

namespace SpareMusic\DigiSigner;

/*
 * Settings for the configuration.
 */

class Config
{
    public $server = "https://api.digisigner.com";
    public $version = "/v1";
    public $param_doc_id = 'document_id';
    private $documents_path = '/documents';
    private $signature_requests_path = '/signature_requests';

    public $curl_timeout = 30;


    public $server_url, $documents_url, $signature_requests_url;


    public function __construct()
    {
        $this->server_url = $this->server . $this->version;
        $this->documents_url = $this->server_url . $this->documents_path;
        $this->signature_requests_url = $this->server_url . $this->signature_requests_path;
    }

    /*
     * Static method for easy access to non static config properties
     */

    static public function instance()
    {
        static $instance = null;

        if (!$instance) {
            $class = __CLASS__;
            $instance = new $class;
        }

        return $instance;
    }
}
