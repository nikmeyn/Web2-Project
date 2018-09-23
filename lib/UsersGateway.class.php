<?php

class UsersGateway extends Adapter {
    public function __construct($connect) {
    parent::__construct($connect);
    }
     
    protected function getSelectStatement(){
        return "SELECT UserID, FirstName, LastName, Address, City, Region, Country, Postal, Phone, Email, Privacy FROM Users ";
    }
     
    protected function getOrderFields() {
        return 'LastName' ;
    }
    
    protected function getPrimaryKeyName() {
        return "UserID";
    }
    
    protected function getViaJoinUsers() {
        return "SELECT Users.UserID, UsersLogin.UserID, UsersLogin.UserName, FirstName, LastName, Address, City, Region, Country, Postal, Phone, Email, Privacy FROM Users, UsersLogin WHERE UsersLogin.UserID = Users.UserID";
    }
}

?>