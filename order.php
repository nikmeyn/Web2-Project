
<!DOCTYPE html>
<html>
<head>
    <title>Assign 1 (Winter 2018)</title>
    <?php //taken from labs 
      include "includes/css.inc.php"; 
      include "includes/db_config.inc.php"; 
      $db = new ImagesGateway($connection);
    ?>
        
<!-- This script will automatically refresh the search query when an option in the dropdown filter is selected-->


</head>
<body>
    
  <?php //taken from labs 
      include "includes/header.inc.php";
  ?>
  <main class="container">
    <div class="panel panel-default">
      <div class="panel-heading">Order Summary</div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-2"><h4>Size</h4></div>
          <div class="col-md-2"><h4>Paper</h4></div>
          <div class="col-md-3"><h4>Frame</h4></div>
          <div class="col-md-2"><h4>Quantity</h4></div>
        </div>
        <script>
          $.get('print-services.php')
            .done(function(data) {
              for(let i=0; i<$('#image .row').length;i++) {
                
                var size = $('#size' + i).text();
                var paper = $('#paper' + i).text();
                var frame = $('#frame' + i).text();
                
                $.each(data.sizes, function(index, s) {
                  if(size == s.id) {
                    var name = s.name;
                    $('#size' + i).text(name);
                  }
                });
                
                $.each(data.stock, function(index, p) {
                  if(paper == p.id) {
                    var name = p.name;
                    $('#paper' + i).text(name);
                  }
                });
                
                $.each(data.frame, function(index, f) {
                  if(frame == f.id) {
                    var name = f.name;
                    $('#frame' + i).text(name);
                  }
                });
              }
              
              var shipping = $('#shipping').text();
              $.each(data.shipping, function(index, sh) {
                if(shipping == sh.id) {
                  var name = sh.name;
                  $('#shipping').html("<h5>" + name + " Shipping</h5>");
                }
              });
              
            }) 
            .fail(function() {
              alert("error, could not detect file input");
            })
            .always(function(data) {
            });
        </script>
        
        
        <?php 
          $fav = unserialize($_COOKIE['fav']);
          $size = sizeof($fav);
          echo '<div id="image">';
          $resultImg = $db->findAll();
          foreach($resultImg as $img) {
            for($i=0;$i<$size;$i++) {
              if($fav[$i][0] == 'img') {
                if($fav[$i][3] == $img['ImageID']) {
                  echo '<div class="row" id="img-'.$i.'">';
                  echo '<div class="col-md-2">';
                  echo '<img class="img-responsive" src="images/square-small/' . $fav[$i][1] . '"/></div>';
                  $s = "size" . $i;
                  $p = "paper" . $i;
                  $f = "frame" . $i;
                  $q = "quantity" . $i;
                  echo '<div class="col-md-2" id="size' .$i. '">' .$_POST[$s]. '</div>';
                  echo '<div class="col-md-2" id="paper' .$i. '">' .$_POST[$p]. '</div>';
                  echo '<div class="col-md-3" id="frame' .$i. '">' .$_POST[$f]. '</div>';
                  echo '<div class="col-md-3" id="quantity">' .$_POST[$q]. '</div>';
                  
                  echo '</div>';
                }
              }
            }
          }
         echo '</div>';
         echo '<div class="row">';
         echo '<div class="col-md-8"></div>';
         echo '<div class="col-md-4" id="shipping">' .$_POST['shipping']. '</div>';
         echo '</div>';
          
        ?>
      </div>
    </div>
  </main>
  <?php //taken from labs 
    include "includes/footer.inc.php"; ?>
</body>

</html>      