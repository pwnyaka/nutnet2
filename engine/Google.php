<?php


namespace app\engine;


class Google
{
    protected $client;
    public function __construct()
    {
        $this->client = $this->getClient();
    }

    public function getClient() {
        $client = new \Google_Client();
        $client->setApplicationName('Google Sheets API PHP Quickstart');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAuthConfig(realpath("../config/credentials.json"));
        $client->setAccessType('offline');

        return $client;
    }
}