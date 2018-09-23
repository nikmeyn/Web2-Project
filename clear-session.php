<?php
    /* Resets and forces the expiry of the user's session cookie */
    unset($_COOKIE['user']);
    setCookie('user', '', -3600);
    header('Location: login.php');
?>