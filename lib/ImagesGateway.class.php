<?php

class ImagesGateway extends Adapter {
    public function __construct($connect) {
    parent::__construct($connect);
    }
     
    protected function getSelectStatement(){
        return "SELECT ImageID, UserID, Title, Description, Latitude, Longitude, CityCode, CountryCodeISO, ContinentCode, Path FROM ImageDetails ";
    }
     
    protected function getOrderFields() {
        return 'Title';
    }
    
    protected function getPrimaryKeyName() {
        return "ImageID";
    }
    protected function getViaJoinSingleImages(){
        return $sql = "SELECT i.ImageID, i.Latitude, i.Longitude, i.UserID, i.Title, i.Description, i.Path, u.FirstName, u.LastName, i.CountryCodeISO, c.CountryName, c.ISO, ct.AsciiName, ct.CityCode FROM ImageDetails AS i JOIN Users AS u ON i.UserID=u.UserID JOIN Countries AS c ON i.CountryCodeISO=c.ISO JOIN Cities AS ct ON ct.CityCode=i.CityCode ";
    }
    protected function getViaJoinPostImages(){
        return $sql = "SELECT pi.PostID, i.Title, i.ImageID, i.Path FROM PostImages AS pi JOIN ImageDetails AS i ON pi.ImageID = i.ImageID JOIN Posts AS p ON p.PostID = pi.PostID WHERE pi.ImageID != p.MainPostImage AND pi.PostID ";

    }    
}

?>