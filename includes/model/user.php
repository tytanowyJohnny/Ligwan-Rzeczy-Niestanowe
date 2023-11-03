<?php

// include_once('../../db/db.php');

class UserService
{

    protected $_username;
    protected $_password;
    protected $_db_handler;
    protected $_user;

    // function UserService($username, $password)
    // {

    //     $this->_username = $username;
    //     $this->_password = md5($password);
    //     $this->_db_handler = new Mysql();
    // }

    public function __construct($username, $password)
    {

        $this->_username = $username;
        $this->_password = md5($password);
        $this->_db_handler = new Mysql();
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function getUserDisplayName()
    {
        return $this->_user['imie'] . ' ' . $this->_user['nazwisko'];
    }

    public function getUserTypeDisplayName()
    {
        return $this->_user['type_display'];
    }

    public function getUserAccessType()
    {
        return $this->_user['typ'];
    }

    public function getUserDepartment() 
    {
        return $this->_user['dzial'];
;    }

    protected function authorize()
    {

        $this->_db_handler->dbConnect();

        //$result = $this->_db_handler->selectWhereMultiple('users', 'kod', '=', $this->_username, 'char', 'haslo', '=', $this->_password, 'char');
        $authQuery = "SELECT * FROM `users` WHERE `kod`='" . $this->_username . "' AND `haslo`='" . $this->_password . "'";

        $result = $this->_db_handler->performQuery($authQuery);

        if (!$result)
            return false;

        while ($row = $result->fetch_assoc()) {

            if ($row) {
                return $row;
            }
        }

        $this->_db_handler->dbDisconnect();
    }

    public function login()
    {

        $user = $this->authorize();
        if ($user) {
            $this->_user = $user; // store it so it can be accessed later

            // Fetch type display value
            $this->_db_handler->dbConnect();

            $typeQuery = "SELECT `type_label` FROM `user_types` WHERE `type_name`='" . $this->_user['typ'] . "'";

            $typeResult = $this->_db_handler->performQuery($typeQuery);

            if (!$typeResult)
                return false;

            while ($row = $typeResult->fetch_assoc()) {

                if ($row) {
                    $this->_user['type_display'] = $row['type_label'];
                }
            }

            $this->_db_handler->dbDisconnect();

            return true;
        }
        return false;
    }

    public function logout()
    {

        $this->_user = null;
        session_destroy();
    }

    public function getUser()
    {
        return $this->_user;
    }
}
