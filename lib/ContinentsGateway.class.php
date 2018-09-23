<?php

class ContinentsGateway extends Adapter {
    public function __construct($connect) {
    parent::__construct($connect);
    }
     
    protected function getSelectStatement(){
        return "SELECT ContinentCode, ContinentName, GeoNameID FROM Continents ";
    }
     
    protected function getOrderFields() {
        return 'ContinentName';
    }
    
    protected function getPrimaryKeyName() {
        return "ContinentCode";
    }
}

?>