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
        return $this -> connectionString;
    }

    function dbDisconnect() {
        $this -> connectionString = NULL;
        $this -> sqlQuery = NULL;
        $this -> dataSet = NULL;
        $this -> databaseName = NULL;
        $this -> hostName = NULL;
        $this -> userName = NULL;
        $this -> passCode = NULL;
    }

    function performQuery($queryString) {

        // echo $queryString;
        return mysqli_query($this -> connectionString, $queryString);

    }


}
