<?php

namespace DigiSigner;

class DigiSignerException extends \Exception {

    private $errors = array();
    private $httpCode = 0;
	protected $message = '';

    public function __construct($message, $errors = array(), $httpCode = 0) {
        $this->message = $message;
		$this->errors = $errors;
        $this->httpCode = $httpCode;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getHttpCode() {
        return $this->httpCode;
    }

}
