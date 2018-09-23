<?php
    /* Creates a user session. Checks to see if UserName and Password match, then creates a user session cookie and favorites list cookie */
    include "includes/db_config.inc.php";
    $db = new UsersLoginGateway($connection);
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = $db->findViaJoin('u');
        foreach($user as $u) {
            if($_POST['user'] == $u['UserName']) {
                $userMatch = true;
                break;
            } else {
                $userMatch = false;
            }                
        }
        if($userMatch == true) {
            $hashP = md5($_POST['pword'] . $u['Salt']);
            foreach($user as $u) {
                if($u['Password'] == $hashP) {
                    $pMatch = true;
                    break;
                } else {
                    $pMatch = false;
                }
            }
            if($pMatch == false) {
                setCookie('error', 'password', time()+2);
                header('Location: login.php');
            } else if ($pMatch == true) {
                $fav = [];
                setCookie('user', $_POST['user'], 0);
                setCookie('fav', serialize($fav), 0);
                header('Location: userProfile.php');
            }
        } else if ($userMatch == false) {
            setCookie('error', 'user', time()+2);
            header('Location: login.php');
            
        } 
    }
?>