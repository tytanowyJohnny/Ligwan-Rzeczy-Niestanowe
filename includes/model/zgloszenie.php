<?php

abstract class STATUS {

    const STATUS_ACCEPTED_VALUE = 3;
    const STATUS_ACCEPTED_DISPLAY_VALUE = "Zaakceptowany";

    const STATUS_ORDERED_VALUE = 5;
    const STATUS_ORDERED_DISPLAY_VALUE = "Zamówiony";

    const STATUS_REJECTED_VALUE = 2;
    const STATUS_REJECTED_DISPLAY_VALUE = "Odrzucony";

    const STATUS_DENIED_VALUE = 7;
    const STATUS_DENIED_DISPLAY_VALUE = "Odmowa";

    const STATUS_CLOSED_VALUE = 6;
    const STATUS_CLOSED_DISPLAY_VALUE = "Zamknięty";

}

abstract class HistoryEntryType {

    const STATE_CHANGE = "Zmiana statusu";
    const ARRIVAL_DATE_CHANGE = "Zmiana daty dostawy";

    const ADD_INFO_STATUS = "Nowy status";
    const ADD_INFO_REJECT = "Powód";
    const ADD_INFO_ARRIVAL_DATE = "Przybliżony czas dostawy";
    const ADD_INFO_NEW_CASE = "ID nowego zgłoszenia";
    const ADD_INFO_ORDER_NUMBER = "Numer zamówienia";

    public static function composeHistoryEntry($type, $userDisplayName, $additionalInfo) {

        $tmp = new stdClass();

        $tmp->type = $type;
        $tmp->timestamp = date('d/m/Y H:i:s', time());
        $tmp->userDisplayName = $userDisplayName;
        $tmp->additionalInfo = $additionalInfo;

        return $tmp;

    }

}

class Zgloszenie {


    protected $_id;
    protected $_created_by;
    protected $_czas_wprowadzenie;
    protected $_order;
    protected $_link;
    protected $_syntetyka;
    protected $_mpk;
    protected $_podmiot;
    protected $_cost;
    protected $_project;
    protected $_amount;
    protected $_comment;
    protected $_status;

    // protected $_zatwierdzajacy;
    // protected $_czas_zatwierdzenia;
    // protected $_zamawiajacy;
    // protected $_czas_zamowienia;
    protected $_data_dostawy;
    protected $_attachment_uri;
    protected $_assigned_department;
    protected $_history;

    protected $_amount_value;
    protected $_sygnatura;

    protected $_cel_kosztu;

    public function __construct(
        $_id, $_sygnatura, $_created_by, $_czas_wprowadzenie, $_order, $_link, $_syntetyka, $_mpk, 
        $_podmiot, $_cost, $_project, $_amount, $_amount_value, $_comment, $_status, 
        $_data_dostawy, $_attachment_uri, $_assigned_department, $_history, $_cel_kosztu) {


        $this->_id = $_id;
        $this->_sygnatura = $_sygnatura;
        $this->_created_by = $_created_by;
        $this->_czas_wprowadzenie = $_czas_wprowadzenie;
        $this->_order = $_order;
        $this->_link = $_link;
        $this->_syntetyka = $_syntetyka;
        $this->_mpk = $_mpk;
        $this->_podmiot = $_podmiot;
        $this->_cost = $_cost;
        $this->_project = $_project;
        $this->_amount = $_amount;
        $this->_amount_value = $_amount_value;
        $this->_comment = $_comment;
        $this->_status = $_status;
        $this->_data_dostawy = $_data_dostawy;
        $this->_attachment_uri = $_attachment_uri;
        $this->_assigned_department = $_assigned_department;
        $this->_history = $_history;
        $this->_cel_kosztu = $_cel_kosztu;

    }

    public function composeHistory() {

        $historyJson = json_decode($this->_history);

        $historyString = "Historia zgłoszenia:\n";

        foreach ($historyJson as $key => $value) {

            $historyString .= $key .": ". $value;
        }

        return $historyString;
    }

    public function getPodmiotDisplayValue() {

        $createdByQuery = "SELECT * FROM `podmioty` WHERE `ident`='".$this->_podmiot."'";

        $db = new Mysql;

        $db->dbConnect();

        $result = $db->performQuery($createdByQuery);

        if ($row = $result->fetch_assoc()) {

            $db->dbDisconnect();
            return $row['name'];
        }

        $db->dbDisconnect();

        return false;

    }

    public function getCreateByDisplayName() {

        $createdByQuery = "SELECT * FROM `users` WHERE `kod`='".$this->_created_by."'";

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

    
    public function getMPKDisplayValue() {

        $query = "SELECT `label` FROM `mpk` WHERE `value`='".$this->_mpk."'";

        $db = new Mysql;

        $db->dbConnect();

        $result = $db->performQuery($query);

        if ($row = $result->fetch_assoc()) {

            $db->dbDisconnect();
            return $row['label'];
        }

        $db->dbDisconnect();

        return false;

    }

    
    public function getSyntetykaDisplayValue() {

        $query = "SELECT `label` FROM `syntetyki` WHERE `value`='".$this->_syntetyka."'";

        $db = new Mysql;

        $db->dbConnect();

        $result = $db->performQuery($query);

        if ($row = $result->fetch_assoc()) {

            $db->dbDisconnect();
            return $row['label'];
        }

        $db->dbDisconnect();

        return false;

    }

    public function getCostDisplayValue() {

        $query = "SELECT `label` FROM `cost` WHERE `value`='".$this->_cost."'";

        $db = new Mysql;

        $db->dbConnect();

        $result = $db->performQuery($query);

        if ($row = $result->fetch_assoc()) {

            $db->dbDisconnect();
            return $row['label'];
        }

        $db->dbDisconnect();

        return false;

    }

    
    public function getProjectDisplayValue() {

        $query = "SELECT `label` FROM `projects` WHERE `value`='".$this->_project."'";

        $db = new Mysql;

        $db->dbConnect();

        $result = $db->performQuery($query);

        if ($row = $result->fetch_assoc()) {

            $db->dbDisconnect();
            return $row['label'];
        }

        $db->dbDisconnect();

        return false;

    }

    public function getStatusAndDeliveryDate() {

        $statusDisplayValue = $this->getStatusDisplayValue();

        $deliveryDate = $this->get_data_dostawy();
        $statusValue = $this->get_status();

        if($deliveryDate != null && $statusValue == 5) // show only for ordered status
            return $statusDisplayValue . "<br />(" . $deliveryDate . ")";

        return $statusDisplayValue;

    }

    public function getStatusDisplayValue() {

        $query = "SELECT `label` FROM `statusy` WHERE `value`='".$this->_status."'";

        $db = new Mysql;

        $db->dbConnect();

        $result = $db->performQuery($query);

        if ($row = $result->fetch_assoc()) {

            $db->dbDisconnect();
            return $row['label'];
        }

        $db->dbDisconnect();

        return false;

    }

    /**
     * Get the value of _sygnatura
     */ 
    public function get_sygnatura()
    {
        return $this->_sygnatura;
    }

    /**
     * Set the value of _history
     *
     * @return  self
     */ 
    public function set_sygnatura($_sygnatura)
    {
        $this->_sygnatura = $_sygnatura;

        return $this;
    }


    /**
     * Get the value of _history
     */ 
    public function get_history()
    {
        return $this->_history;
    }

    /**
     * Set the value of _history
     *
     * @return  self
     */ 
    public function set_history($_history)
    {
        $this->_history = $_history;

        return $this;
    }

    /**
     * Get the value of _assigned_department
     */ 
    public function get_assigned_department()
    {
        return $this->_assigned_department;
    }

    /**
     * Set the value of _assigned_department
     *
     * @return  self
     */ 
    public function set_assigned_department($_assigned_department)
    {
        $this->_assigned_department = $_assigned_department;

        return $this;
    }

    /**
     * Get the value of _czas_wprowadzenie
     */ 
    public function get_czas_wprowadzenie()
    {
        return $this->_czas_wprowadzenie;
    }

    /**
     * Set the value of _czas_wprowadzenie
     *
     * @return  self
     */ 
    public function set_czas_wprowadzenie($_czas_wprowadzenie)
    {
        $this->_czas_wprowadzenie = $_czas_wprowadzenie;

        return $this;
    }

    /**
     * Get the value of _order
     */ 
    public function get_order()
    {
        return $this->_order;
    }

    /**
     * Set the value of _order
     *
     * @return  self
     */ 
    public function set_order($_order)
    {
        $this->_order = $_order;

        return $this;
    }

    /**
     * Get the value of _link
     */ 
    public function get_link()
    {
        // Remove https:// if included

        $format = preg_replace(['/https:\/\//', '/http:\/\//'], '', $this->_link);

        return $format;
    }

    /**
     * Set the value of _link
     *
     * @return  self
     */ 
    public function set_link($_link)
    {
        $this->_link = $_link;

        return $this;
    }

    /**
     * Get the value of _syntetyka
     */ 
    public function get_syntetyka()
    {
        return $this->_syntetyka;
    }

    /**
     * Set the value of _syntetyka
     *
     * @return  self
     */ 
    public function set_syntetyka($_syntetyka)
    {
        $this->_syntetyka = $_syntetyka;

        return $this;
    }

    /**
     * Get the value of _mpk
     */ 
    public function get_mpk()
    {
        return $this->_mpk;
    }

    /**
     * Set the value of _mpk
     *
     * @return  self
     */ 
    public function set_mpk($_mpk)
    {
        $this->_mpk = $_mpk;

        return $this;
    }

    /**
     * Get the value of _podmiot
     */ 
    public function get_podmiot()
    {
        return $this->_podmiot;
    }

    /**
     * Set the value of _podmiot
     *
     * @return  self
     */ 
    public function set_podmiot($_podmiot)
    {
        $this->_podmiot = $_podmiot;

        return $this;
    }

    /**
     * Get the value of _cost
     */ 
    public function get_cost()
    {
        return $this->_cost;
    }

    /**
     * Set the value of _cost
     *
     * @return  self
     */ 
    public function set_cost($_cost)
    {
        $this->_cost = $_cost;

        return $this;
    }

    /**
     * Get the value of _project
     */ 
    public function get_project()
    {
        return $this->_project;
    }

    /**
     * Set the value of _project
     *
     * @return  self
     */ 
    public function set_project($_project)
    {
        $this->_project = $_project;

        return $this;
    }

    /**
     * Get the value of _amount
     */ 
    public function get_amount_value()
    {
        return $this->_amount_value;
    }

    /**
     * Set the value of _amount
     *
     * @return  self
     */ 
    public function set_amount_value($_amount_value)
    {
        $this->_amount_value = $_amount_value;

        return $this;
    }

    /**
     * Get the value of _amount
     */ 
    public function get_amount()
    {
        return $this->_amount;
    }

    /**
     * Set the value of _amount
     *
     * @return  self
     */ 
    public function set_amount($_amount)
    {
        $this->_amount = $_amount;

        return $this;
    }

    /**
     * Get the value of _comment
     */ 
    public function get_comment()
    {
        return $this->_comment;
    }

    /**
     * Set the value of _comment
     *
     * @return  self
     */ 
    public function set_comment($_comment)
    {
        $this->_comment = $_comment;

        return $this;
    }

    /**
     * Get the value of _id
     */ 
    public function get_id()
    {
        return $this->_id;
    }

    /**
     * Set the value of _id
     *
     * @return  self
     */ 
    public function set_id($_id)
    {
        $this->_id = $_id;

        return $this;
    }

    /**
     * Get the value of _status
     */ 
    public function get_status()
    {
        return $this->_status;
    }

    /**
     * Set the value of _status
     *
     * @return  self
     */ 
    public function set_status($_status)
    {
        $this->_status = $_status;

        return $this;
    }

    /**
     * Get the value of _data_dostawy
     */ 
    public function get_data_dostawy()
    {
        return $this->_data_dostawy;
    }

    /**
     * Set the value of _data_dostawy
     *
     * @return  self
     */ 
    public function set_data_dostawy($_data_dostawy)
    {
        $this->_data_dostawy = $_data_dostawy;

        return $this;
    }

    /**
     * Get the value of _attachment_uri
     */ 
    public function get_attachment_uri()
    {
        return $this->_attachment_uri;
    }

    /**
     * Set the value of _attachment_uri
     *
     * @return  self
     */ 
    public function set_attachment_uri($_attachment_uri)
    {
        $this->_attachment_uri = $_attachment_uri;

        return $this;
    }

    /**
     * Get the value of _cel_kosztu
     */ 
    public function get_cel_kosztu()
    {

        if(!$this->_cel_kosztu)
            return '';

        return $this->_cel_kosztu;
    }

    /**
     * Set the value of _attachment_uri
     *
     * @return  self
     */ 
    public function set_cel_kosztu($_cel_kosztu)
    {
        $this->_cel_kosztu = $_cel_kosztu;

        return $this;
    }

    
}