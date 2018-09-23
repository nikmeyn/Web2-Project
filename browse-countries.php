<!DOCTYPE html>
<html>
<head>
    <title>Assign 1 (Winter 2018)</title>
    <?php //taken from labs 
        include "includes/css.inc.php"; 
        include "includes/db_config.inc.php"; ?>
</head>
<body>
    
    <?php //taken from labs 
        include "includes/header.inc.php";
        $countriesDB = new CountriesGateway($connection);
    ?>
    <div class="container">
        <div class='panel panel-info'>
            <div class="panel panel-heading">Countries with Images</div>
                <div class='panel-body'>
                    <div class='row'>
                    <?php
                        
                        $result = $countriesDB->findViaJoin("country");
                        
                        foreach($result as $country){
                            echo "<div class='col-md-3'><a href='single-country.php?id=".$country["CountryCodeISO"]."'>".$country["CountryName"]."</a></div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php //taken from labs 
        include "includes/footer.inc.php"; ?>
</body>

</html>