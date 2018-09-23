<?php
    class UsersLoginGateway extends Adapter {
        public function _construct($connect) {
            parent::_construct($connect);
        }
        protected function getSelectStatement() {
            return "SELECT UserID, UserName, Password, Salt FROM UsersLogin";
        }
        
        protected function getOrderFields() {
            return 'UserID';
        }
        
        protected function getPrimaryKeyName() {
            return 'UserID';
        }
        
        protected function getViaJoinUsers() {
            return "SELECT UsersLogin.UserID, Users.UserID, UserName, Password, Salt FROM UsersLogin, Users";
        }
    }
?>