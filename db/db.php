<?php


include 'db_config.php';

class Mysql extends Dbconfig {

    public $connectionString;
    public $dataSet;
    private $sqlQuery;
    
    protected $databaseName;
    protected $hostName;
    protected $userName;
    protected $passCode;

    public function __construct() {
        // $this -> connectionString = NULL;
        // $this -> sqlQuery = NULL;
        // $this -> dataSet = NULL;

        $dbPara = new Dbconfig();
        $this -> databaseName = $dbPara->getDbName();
        $this -> hostName = $dbPara->getServerName();
        $this -> userName = $dbPara->getUserName();
        $this -> passCode = $dbPara->getPassCode();
        $dbPara = NULL;
    }
  
    function dbConnect()    {
        $this -> connectionString = mysqli_connect($this -> hostName,$this -> userName,$this -> passCode);
        mysqli_select_db($this -> connectionString, $this -> databaseName);
        // mysqli_query($this -> connectionString, "SET NAMES 'utf8'"); // IMPORTANT
        return $this -> connectionString;
    }

    function dbDisconnect() {
        mysqli_close($this -> connectionString);
        $this -> connectionString = NULL;
        $this -> sqlQuery = NULL;
        $this -> dataSet = NULL;
        // $this -> databaseName = NULL;
        // $this -> hostName = NULL;
        // $this -> userName = NULL;
        // $this -> passCode = NULL;
    }

    function getLatestID() {

        return mysqli_insert_id($this->connectionString);
    }

    function performQuery($queryString) {

        // echo $queryString; // BREAKS DATA TABLES

        // echo $queryString;
        return mysqli_query($this -> connectionString, $queryString);

    }


}
