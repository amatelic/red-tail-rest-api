<?php

/**
 * http://help.redtailtechnology.com/entries/21598557-A-101-Look-Into-Our-Rest-Based-API
 * https://api2.redtailtechnology.com/crm/v1/rest/help
 * 
 * 
 * PHP Web Service Client to integrate with redtail rest api
 * 
 * @author Hardik Shah<hardiks059@gmail.com>
 * @since June 2014
 */
class apiNew {

    /**
     * API KEY
     * @var String $apiKey
     */
    public $apiKey = "6C135EDF-C37C-4039-AEF3-5DFC079F9E6A";

    /**
     * Username to be used in api
     * @var String $userName 
     */
    public $userName = 'Statementone';

    /**
     * Password for authentication
     * @var String $password 
     */
    public $password = "sonedemo";

    /**
     * Authstring to be prpepared in construct
     * @var String Authstring apikey:username:password
     */
    public $authString = "";

    /**
     * Base URL
     * @var String $baseURL
     */
    public $baseURL = "https://api2.redtailtechnology.com/crm/v1/rest/";

    /**
     *
     * Client ID received from REST API Authentication
     * @var String  $CID
     */
    public $CID = "0";

    /**
     * DatabaseID Received from REST API Authentication
     * @var String DatabaseID 
     */
    public $DatabaseID = "0";

    /**
     * Constructor
     * Prepars the authentication string and does an authentication
     */
    public function __construct() {
        $this->authString = base64_encode("{$this->apiKey}:{$this->userName}:{$this->password}");
        $this->doAuthenticate();
    }

    /**
     * Generic function for pinging to API
     * @param type $url
     * @param type $jsonData
     * @return String
     */
    public function doPing($url, $jsonData = '') {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        //curl_setopt($ch, CURLOPT_HEADER, 1); # for debugging
        curl_setopt($ch, CURLOPT_USERPWD, $this->authString);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


        if ($jsonData) {
            $fh = tmpfile();
            fwrite($fh, $jsonData);
            fseek($fh, 0);
            curl_setopt($ch, CURLOPT_PUT, 1);
            curl_setopt($ch, CURLOPT_INFILE, $fh);
            curl_setopt($ch, CURLOPT_INFILESIZE, strlen($jsonData));
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);
        return $return;
    }

    /**
     * API MEthod toe get contacts
     * @return JSON
     */
    
    public function getContacts() {
        $url = $this->prepareURL('contacts');
        $response = $this->doPing($url);
        return $response;
    }

    /**
     * API MEthod to create contact
     * @param type $data
     * @return type
     */
    public function createContact($data) {
        $url = $this->prepareURL('contacts/0');

        $data['DatabaseID'] = $this->DatabaseID;
        $data['CID'] = $this->CID;

        $jsonString = json_encode($data);
        $response = $this->doPing($url, $jsonString);
        return $response;
    }

    /**
     * Generic Method to prepare the URL
     * 
     */
    public function prepareURL($url) {
        return $this->baseURL . $url;
    }

    /**
     * API Method to authenticate
     * 
     */
    public function doAuthenticate() {
        $url = $this->prepareURL("authentication");
        $payload = $this->doPing($url);

        $response = json_decode($payload, true);
        $this->CID = $response['CID'];
        $this->DatabaseID = $response['DatabaseID'];

        if ($this->CID == 0) {
            print "<span style='color:red;font-family:verdana;font-weight:bold'>Authentication Failed. {$response['Message']}</span>";
        }
    }

}

?>