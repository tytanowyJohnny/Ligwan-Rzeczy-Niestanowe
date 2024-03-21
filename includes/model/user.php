<?php

// include_once ("...")
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/serverUtils.php';

abstract class UserType {

    // Value matches id from DB

    const WPROWADZANIE = 1;
    const ZATWIERDZANIE = 2;
    const ZAMAWIANIE = 3;
    const PRZEKAZYWANIE = 4;

}

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

    public function getAssignedDepartmentDisplayValue()
    {
        return $this->_user['assigned_department_display'];
        ;
    }

    public function getAssignedDepartmentValue()
    {
        return $this->_user['assigned_department'];

    }

    protected function authorize()
    {

        $this->_db_handler->dbConnect();

        //$result = $this->_db_handler->selectWhereMultiple('users', 'kod', '=', $this->_username, 'char', 'haslo', '=', $this->_password, 'char');
        $authQuery = "SELECT * FROM `users` WHERE `kod`='" . $this->_username . "' AND `haslo`='" . $this->_password . "'";

        $result = $this->_db_handler->performQuery($authQuery);

        $this->_db_handler->dbDisconnect();

        if (!$result)
            return false;

        while ($row = $result->fetch_assoc()) {

            if ($row) {
                return $row;
            }
        }

        return false;
    }

    protected function getUserAssignedDepartment()
    {

        $this->_db_handler->dbConnect();

        $query = "SELECT `department` FROM `m2m_users_departments` WHERE `user` = '" . $this->_username . "'";

        $result = $this->_db_handler->performQuery($query);

        $this->_db_handler->dbDisconnect();


        if (!$result)
            return false;

        if ($row = $result->fetch_assoc()) {

            if ($row) {
                return $row['department']; // ID
            }
        }

        return false;

    }

    protected function loadUserAccessTypes()
    {

        $this->_user['access_types'] = array();

        $this->_db_handler->dbConnect();

        $query = "SELECT `type_id` FROM `m2m_users_types` WHERE `user` = '" . $this->_username . "'";

        $result = $this->_db_handler->performQuery($query);

        while ($row = $result->fetch_assoc()) {

            if ($row) {

                $innerQuery = "SELECT * FROM `user_types` WHERE `id` = " . $row['type_id'];

                $innerResult = $this->_db_handler->performQuery($innerQuery);

                if ($innerRow = $innerResult->fetch_assoc()) {

                    if ($innerRow) {

                        $tempArr = array(
                            'id' => $innerRow['id'],
                            'display_value' => $innerRow['type_label']
                        );

                        array_push($this->_user['access_types'], $tempArr);

                    }
                }

            }

        }

        $this->_db_handler->dbDisconnect();

        if(count($this->_user['access_types']) > 0)
            return true;

        return false;
    }

    public function getUserAccessDisplayList() {

        function getDisplayValues($obj) {
            return $obj['display_value'];
        }

        $displayArr = array_map('getDisplayValues', $this->_user['access_types']);

        return implode(', ', $displayArr);

    }

    public function getUserAccessList() {

        function getValues($obj) {
            return $obj['id'];
        }

        $valuesArr = array_map('getValues', $this->_user['access_types']);

        return $valuesArr;
    }

    public function login()
    {

        $user = $this->authorize();

        if ($user) {

            $this->_user = $user; // store it so it can be accessed later
            $this->loadUserAccessTypes();

            // $this->_user['type_display'] = getUserTypeDisplayValue($user['typ']);
            $this->_user['assigned_department'] = $this->getUserAssignedDepartment();
            $this->_user['assigned_department_display'] = getAssignedDepartmentAbbr($this->_user['assigned_department']);

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
