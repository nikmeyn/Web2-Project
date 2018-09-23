<?php

    $data = file_get_contents('printRules.json', true);
    
    header('Content-Type: application/json');  
     
    echo($data);

?>