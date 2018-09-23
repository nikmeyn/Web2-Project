<?php

#taken from the labs

define('HOST', 'localhost');
define('DB','travel');
define('USER','aente721');
define('PASS','');
define('CONN','mysql:host='.HOST.';dbname='.DB);


try{
    $pdo = new PDO (CONN,USER,PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $error){
    echo "Connection failed: ". $error->getMessage();
}


// auto load all classes so we don't have to explicitly include them
spl_autoload_register(function ($class) {
    $file = 'lib/' . $class . '.class.php';
    if (file_exists($file)) {
        include $file;
    }
});


// connect to the database
$connection = DatabaseHelper::createConnectionInfo(array(CONN, USER, PASS));

?>
