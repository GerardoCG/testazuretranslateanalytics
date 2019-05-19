<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Translate extends CI_Controller {
    
    private $key;

    private $host;
    private $path;

    // Translate to German and Italian.
    private $params;

	public function __construct()
	{
        parent::__construct();
        $this->key = "5da384fec5104d81a5ad0512044b9ff1";
        $this->host = "https://api.cognitive.microsofttranslator.com";
        $this->path = "/translate?api-version=3.0";
        $this->params = "&from=es&to=en";
    }
    
	public function text()
	{
		$text = $this->input->post('text');
		$requestBody = array (
            array (
                'Text' => $text,
            ),
        );
        $content = json_encode($requestBody);
        
        $result = $this->translate($content);
        
        header('Content-Type: application/json');
		echo json_encode(json_decode($result));
    }
    
    public function com_create_guid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
              mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
              mt_rand( 0, 0xffff ),
              mt_rand( 0, 0x0fff ) | 0x4000,
              mt_rand( 0, 0x3fff ) | 0x8000,
              mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
      
    public  function translate ($content) {
      
          $headers = "Content-type: application/json\r\n" .
              "Content-length: " . strlen($content) . "\r\n" .
              "Ocp-Apim-Subscription-Key: $this->key\r\n" .
              "X-ClientTraceId: " . $this->com_create_guid() . "\r\n";
      
          $options = array (
              'http' => array (
                  'header' => $headers,
                  'method' => 'POST',
                  'content' => $content
              )
          );
          $context  = stream_context_create ($options);
          $result = file_get_contents ($this->host . $this->path . $this->params, false, $context);
          return $result;
      }

}