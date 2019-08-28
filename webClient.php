<?php

class WebClient{

    protected $url;
    protected $headerArray;
    protected $method;
    protected $authType;
    protected $sslPassPhrase;
    protected $sslCertType;
    protected $requestBody;
    protected $sslCertFile;
    protected $curlDebug;
    protected $httpCredential;
    private $response;
    private $curlError;
    private $curlInfo;
    private $curlRes;
    private $optionsArray = array();

    public function __construct($url='', $headerArray= [], $method='POST', $authType='BASIC', $sslCertFile='', $sslPassPhrase='', $sslCertType='', $requestBody='', $httpCredential='', $debug=false) {
        $this->url = $url;
        $this->headerArray = $headerArray;
        $this->method = $method;
        $this->authType = $authType;
        $this->sslCertFile = $sslCertFile;
        $this->sslPassPhrase = $sslPassPhrase;
        $this->sslCertType = $sslCertType;
        $this->curlDebug = $debug;
        $this->requestBody = $requestBody;
        $this->httpCredential = $httpCredential;
    }
    
    public function webCall() {
        $this->curlRes = curl_init($this->url);
        
        switch ($this->method) {
            case 'POST':
                $this->optionsArray[CURLOPT_POST] = 1;
                $this->optionsArray[CURLOPT_POSTFIELDS] = $this->requestBody;
                
            break;
            case 'GET':
                $this->optionsArray[CURLOPT_CUSTOMREQUEST] = 'GET';
                $this->optionsArray[CURLOPT_POSTFIELDS] = $this->requestBody;
            break;
            default:
                break;
        }
	
        $this->optionsArray[CURLOPT_HTTPHEADER] = $this->headerArray;

        switch ($this->authType) {
            case "BASIC":
                $this->optionsArray[CURLOPT_USERPWD] = $this->httpCredential;
                break;
            case "certificate":
                $this->optionsArray[CURLOPT_SSLCERT] = $this->sslCertFile;
                $this->optionsArray[CURLOPT_SSLCERTTYPE] = $this->sslCertType;
                $this->optionsArray[CURLOPT_SSLCERTPASSWD] = $this->sslPassPhrase;
                break;    
            default:
                break;
        }
        
        $this->optionsArray[CURLOPT_RETURNTRANSFER] = true;
        if($this->curlDebug){
            $this->optionsArray[CURLOPT_VERBOSE] = true;
        }
        
        curl_setopt_array($this->curlRes, $this->optionsArray);
	$this->response = curl_exec($this->curlRes);
	$this->curlInfo = curl_getinfo($this->curlRes);
        $this->curlError = curl_errno($this->curlRes); 
	curl_close($this->curlRes);
	return array($this->curlError, $this->curlInfo, $this->response);
    }
}
