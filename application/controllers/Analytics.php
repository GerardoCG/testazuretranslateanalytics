<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics extends CI_Controller {
    
    private $key;
    private $host;
    private $path;

	public function __construct()
	{
        parent::__construct();
        $this->key = "eaf493a96e22401da653283e896225ca";
        $this->host = 'https://westus.api.cognitive.microsoft.com';
        $this->path = '/text/analytics/v2.1/sentiment';
    }

    public function text(){
    
		$text = $this->input->post('text');
        $data = array (
            'documents' => array (
                array ( 'id' => '1', 'text' => $text)
            )
        );

        $result = $this->getSentiment($data);

        header('Content-Type: application/json');
        echo json_encode (json_decode ($result));
    }
    
	public function getSentiment($data) {

        $headers = "Content-type: text/json\r\n" .
            "Ocp-Apim-Subscription-Key: $this->key\r\n";
    
        $data = json_encode ($data);

        $options = array (
            'http' => array (
                'header' => $headers,
                'method' => 'POST',
                'content' => $data
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents ($this->host . $this->path, false, $context);
        return $result;
    }

}