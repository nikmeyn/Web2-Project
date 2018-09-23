<?php

class CitiesGateway extends Adapter {
    public function __construct($connect) {
    parent::__construct($connect);
    }
     
    protected function getSelectStatement(){
        return "SELECT CityCode, Asciiname, CountryCodeISO, Latitude, Longitude, Population, Elevation, Timezone FROM Cities ";
    }
     
    protected function getOrderFields() {
        return 'AsciiName';
    }
    
    protected function getPrimaryKeyName() {
        return "CityCode";
    }
     protected function getViaJoinCitiesImages(){
        return "SELECT c.AsciiName, c.CityCode FROM Cities c INNER JOIN ImageDetails i ON c.CityCode=i.CityCode GROUP BY c.CityCode ORDER BY c.AsciiName";
    }
}

?>