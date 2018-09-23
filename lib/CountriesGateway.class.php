<?php

class CountriesGateway extends Adapter {
    public function __construct($connect) {
    parent::__construct($connect);
    }
     
    protected function getSelectStatement(){
        return "SELECT ISO, ISONumeric, CountryName, Capital, Area, Population, Continent, TopLevelDomain, CurrencyCode, CurrencyName, PhoneCountryCode, Languages, Neighbours, CountryDescription FROM Countries ";
    }
     
    protected function getOrderFields() {
        return 'CountryName';
    }
    
    protected function getPrimaryKeyName() {
        return "ISO";
    }
    protected function getViaJoinCountriesImages(){
        return "SELECT c.CountryName, i.ImageID, i.Path, i.CountryCodeISO, c.ISO FROM Countries c INNER JOIN ImageDetails i ON c.ISO=i.CountryCodeISO GROUP BY c.ISO ORDER BY c.CountryName ";
    }
}

?>