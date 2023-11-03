<?php


class Dbconfig
{
    protected $serverName;
    protected $userName;
    protected $passCode;
    protected $dbName;

    public function __construct()
    {
        $this->serverName = 'localhost';
        $this->userName = 'ligwan-rzn-connector';
        $this->passCode = 'PrrQHAbd1JzhDasH';
        $this->dbName = 'ligwan-rzn';
    }

    /**
     * Get the value of serverName
     */ 
    public function getServerName()
    {
        return $this->serverName;
    }

    /**
     * Get the value of userName
     */ 
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Get the value of passCode
     */ 
    public function getPassCode()
    {
        return $this->passCode;
    }

    /**
     * Get the value of dbName
     */ 
    public function getDbName()
    {
        return $this->dbName;
    }

}

?>