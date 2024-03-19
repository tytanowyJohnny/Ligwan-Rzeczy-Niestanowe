<?php

include_once('../../db/db.php');
include_once('user.php');

require_once __DIR__ . '/../commonUtils.php';

abstract class FLOW_STAGE {

    const AWAITING_ACCEPTANCE = 0;
    const REJECTED = 1;
    const ACCEPTED = 2;
    const APPROVED = 3;
    const FINALIZED = 4;

}

class FlowProcessor {

    protected $_db;
    protected $_dependencies_map = array();

    protected $_actions_list = array();
    protected $_user;

    public function __construct() {

        
        $this->_db = new Mysql();
        $this->_db->dbConnect();

        // LOAD ACTIONS FROM SERVER
        $query = "SELECT * FROM `actions`";
        
        $result = $this->_db->performQuery($query);

        while($row = $result->fetch_assoc()) {

            $tempObj = array(

                "id" => $row["id"],
                "label" => $row["action_label"]
            );

            array_push($this->_actions_list, $tempObj);

        }

        // LOAD DEPENDENCIES FROM SERVER
        $query = "SELECT * FROM `flow_rules` WHERE `active` = TRUE";

        $result = $this->_db->performQuery($query);

        $this->_db->dbDisconnect();

        while ($row = $result->fetch_assoc()) {

            $tempObj = array(

                "id" => $row["id"],
                "action" => $row["action_id"],
                "source" => $row["source_status"],
                "target" => $row["target_status"],
                "allowed_user_type" => $row["allowed_user_type"]
            );

            array_push($this->_dependencies_map, $tempObj);
            
        }

    }


    public function getValidTransitions($source, $userTypes) {

        $validArr = [];

        foreach ($this->_dependencies_map as $dependency) {
            
            if($dependency['source'] == $source && in_array($dependency['allowed_user_type'], $userTypes)) {

                // Find Action
                $searchResult = searchIn2DimArray($this->_actions_list, "id", $dependency['action']);

                $temp = array(
                    "action_name" => $this->_actions_list[$searchResult]["label"],
                    "target_status" => $dependency['target']
                );

                array_push($validArr, $temp);

            }
        
        }

        return $validArr;

    }


}


?>