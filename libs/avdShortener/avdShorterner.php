<?php

/*
*
*
*
*/
class avdShortener {
    
    private $baseURL = null;
    private $hashLength = 6;

    function __construct($baseURL) {
        $this->baseURL = $baseURL;
    }

    public function generateURLData($longURL) {

        $hash = $this->hash($longURL);

	return array(
            'longURL' => $longURL,
            'shortURL' => $this->baseURL . $hash,
            'created' => time(),
            'hash' => $hash,
        );
    }

    public function saveURLData ($URLData) {
        $mongo = new Mongo();

        $db = $mongo->shortener;
        $hashedLinks = $db->hashedLinks;

        $hashedLinks->insert($URLData);
    }

    public function loadURLData($hash) { 
        $mongo = new Mongo();

        $db = $mongo->shortener;
        $hashedLinks = $db->hashedLinks;
        
        $URLData = $hashedLinks->findOne(array('hash' => $hash));

	if($URLData != null) {
            return $URLData;
        }
        else {
            return null;
        }
    }

    public function isAlreadyHashed($hash) {
        $mongo = new Mongo();

        $db = $mongo->shortener;
        $hashedLinks = $db->hashedLinks;
        
        $URLData = $hashedLinks->findOne(array('hash' => $hash));

	if($URLData != null) {
            return true;
        }
        else {
            return false;
        }
    }

    public function hash($toHash) {
        return substr(md5($toHash), 0, $this->hashLength);
    }
}
