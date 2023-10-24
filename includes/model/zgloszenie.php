<?php


abstract class Wykonawca {

    const CONSERVATOR = 'conservator';
    const EXTERNAL = 'external_company';

}

function getContractorDisplayValue($contractorType) {

    if($contractorType == Wykonawca::CONSERVATOR)
        return 'Konserwator';
    else if($contractorType == Wykonawca::EXTERNAL)
        return 'Firma zewnętrzna';

    return 'Nie przypisany';

}


class Zgloszenie {


    protected $_id;
    protected $_created_by;
    protected $_czas_wprowadzenie;
    protected $_dzial;
    protected $_poziom;
    protected $_pomieszczenie;
    protected $_status;
    protected $_usterka;
    protected $_usterka_manual;
    protected $_usterka_filepath;
    protected $_device;
    protected $_dzial_zglaszajacy;
    protected $_rejected_reason;


    public function __construct($_id, $_created_by, $_czas_wprowadzenie, $_dzial, $_poziom, $_pomieszczenie, $_status, $_usterka, $_usterka_manual, $_usterka_filepath, $_device, $_dzial_zglaszajacy, $_rejected_reason) {


        $this->_id = $_id;
        $this->_created_by = $_created_by;
        $this->_czas_wprowadzenie = $_czas_wprowadzenie;
        $this->_dzial = $_dzial;
        $this->_poziom = $_poziom;
        $this->_pomieszczenie = $_pomieszczenie;
        $this->_status = $_status;
        $this->_usterka = $_usterka;
        $this->_usterka_manual = $_usterka_manual;
        $this->_usterka_filepath = $_usterka_filepath;
        $this->_device = $_device;
        $this->_dzial_zglaszajacy = $_dzial_zglaszajacy;
        $this->_rejected_reason = $_rejected_reason;

    }

    public function getUsterkaDisplayName() {

        if($this->_usterka == '0')
            return $this->_usterka_manual;
        
        $usterkaQuery = "SELECT * FROM `usterki` WHERE `id`='".$this->_usterka."'";

        $db = new Mysql;

        $db->dbConnect();

        $result = $db->performQuery($usterkaQuery);

        if ($row = $result->fetch_assoc()) {

            $db->dbDisconnect();
            return $row['name'];
        }

        $db->dbDisconnect();

        return false;


    }    

    public function getStatusDisplayName() {
        
        $statusQuery = "SELECT * FROM `statusy` WHERE `value`='".$this->_status."'";

        $db = new Mysql;

        $db->dbConnect();

        $result = $db->performQuery($statusQuery);

        if ($row = $result->fetch_assoc()) {

            $db->dbDisconnect();
            return $row['label'];
        }

        $db->dbDisconnect();

        return false;


    }    

    public function getCreateByDisplayName() {

        $createdByQuery = "SELECT * FROM `users` WHERE `username`='".$this->_created_by."'";

        $db = new Mysql;

        $db->dbConnect();

        $result = $db->performQuery($createdByQuery);

        if ($row = $result->fetch_assoc()) {

            $db->dbDisconnect();
            return $row['imie'].' '.$row['nazwisko'];
        }

        $db->dbDisconnect();

        return false;

    }


    /**
     * Get the value of _id
     */ 
    public function get_id()
    {
        return $this->_id;
    }

    /**
     * Get the value of _created_by
     */ 
    public function get_created_by()
    {
        return $this->_created_by;
    }

    /**
     * Get the value of _czas_wprowadzenie
     */ 
    public function get_czas_wprowadzenie()
    {
        return $this->_czas_wprowadzenie;
    }

    /**
     * Get the value of _dzial
     */ 
    public function get_dzial()
    {
        return $this->_dzial;
    }

    /**
     * Get the value of _poziom
     */ 
    public function get_poziom()
    {
        return $this->_poziom;
    }

    /**
     * Get the value of _pomieszczenie
     */ 
    public function get_pomieszczenie()
    {
        return $this->_pomieszczenie;
    }

    /**
     * Get the value of _status
     */ 
    public function get_status()
    {
        return $this->_status;
    }

        /**
         * Get the value of _usterka
         */ 
        public function get_usterka()
        {
                return $this->_usterka;
        }

    /**
     * Get the value of _usterka_filepath
     */ 
    public function get_usterka_filepath()
    {
        return $this->_usterka_filepath;
    }

    /**
     * Get the value of _device
     */ 
    public function get_device()
    {
        return $this->_device;
    }

    /**
     * Get the value of _dzial_zglaszajacy
     */ 
    public function get_dzial_zglaszajacy()
    {
        return $this->_dzial_zglaszajacy;
    }
}


?>