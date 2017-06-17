<?php

namespace SpareMusic\DigiSigner;

/**
 * Class represents response of API service.
 */

class DigiSignerResponse
{
    private $statusCode = 0;
    private $content = null;//raw response
    private $message = '';
    private $body = null;//an object, parsed from JSON string

    private $successStatuses = array(200, 201, 204);

    public function __construct(Curler $curl)
    {
        $this->statusCode = $curl->getStatusCode();
        $this->content = $curl->getResponse();

        $this->process();//must be called in constructor to prepare $this->body

    }

    public function process()
    {
        $this->body = $this->parseJSON($this->content);

        if (!$this->isSuccessful()) {
            throw new DigiSignerException($this->getMessage(), $this->getErrors(), $this->statusCode);
        }
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function isSuccessful()
    {
        return in_array($this->statusCode, $this->successStatuses);
    }

    public function getMessage()
    {
        $json = $this->getBody();
        return !empty($json->message) ? $json->message : 'Unknown error occured.';
    }

    public function getErrors()
    {
        $json = $this->getBody();

        $errors = array();
        if (!empty($json->errors)) {
            foreach ($json->errors as $error) {
                $errors[] = $error->message;
            }
        }

        return $errors;
    }

    protected function parseJSON($json)
    {
        return json_decode(trim($json));
    }
}
