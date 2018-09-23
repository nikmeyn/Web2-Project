<!-- taken from labs -->
<?php
    include "includes/db_config.inc.php";
    
?>
            <aside class="col-md-2">
                <div class="panel panel-info">
                    <div class="panel-heading">Continents</div>
                    <ul class="list-group">
                        <?php
                        /* display list of continents from continents table  */
                            
                            $sql ="SELECT ContinentName, ContinentCode FROM Continents";
                            $result = $pdo-> query($sql);

                            while ($record = $result -> fetch()){
                                echo '<li class="list-group-item"><a href="browse-images.php?continent='.$record["ContinentCode"].'">'.$record["ContinentName"].'</a></li>';
                            }   
                        ?>
                    </ul>
                </div>
                <!-- end continents panel -->

                <div class="panel panel-info">
                    <div class="panel-heading">Popular</div>
                    <ul class="list-group">
                       <?php                         
                           
                            $sql ="SELECT c.CountryName, c.ISO FROM Countries c INNER JOIN ImageDetails i ON c.ISO=i.CountryCodeISO GROUP BY c.ISO ORDER BY c.CountryName";
                            $result = $pdo-> query($sql);
                            
                            while ($record = $result -> fetch()){
                                echo '<li class="list-group-item"><a href="browse-images.php?country='.$record["ISO"].'">'.$record["CountryName"].'</a></li>';
                            }   
                        ?>
                    </ul>
                </div>
                <!-- end continents panel -->
            </aside>