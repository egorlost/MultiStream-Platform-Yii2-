<?php

namespace app\models;


Class BingTranslator{

    private $_token = null;
    private $client_id = 'lost1993';
    private $client_secret = 'Ks6bvjUJSGVLjLpF4S4yhiKdN00gaiDdDlJfmQgmAgs=';

    protected static $instance;

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected function __construct()
    {
        $this->_token = $this->getToken();
    }

	private function getToken()
    {
		$postData = array(
			'client_id' => $this->client_id,
			'client_secret' => $this->client_secret,
			'scope' => 'http://api.microsofttranslator.com',
			'grant_type' => 'client_credentials',
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$result = curl_exec($ch);

		$result = json_decode($result);
		
		if(!is_object($result) || empty($result->access_token))
			die($result->error);
		return $result->access_token;
	}
	
	public function translate($content, $languageFrom = 'ru', $languageTo = 'en')
    {
        $postData = array(
            'text' => htmlspecialchars($content, ENT_COMPAT, 'UTF-8'),
            'from' => $languageFrom,
            'to' => $languageTo,
            'contentType' => 'text/plain',
        );

        $ch = curl_init('http://api.microsofttranslator.com/V2/Http.svc/Translate?' . http_build_query($postData));
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->_token));

        $translation = curl_exec($ch);
		
		return htmlspecialchars_decode($translation);
	}
}