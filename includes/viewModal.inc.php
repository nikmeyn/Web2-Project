<!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        
        <div class="modal-dialog modal-lg" role="document">
          
          <!-- Content in Modal -->
            <div class="modal-content">
          
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Print Favorites</h4>
                </div>
          
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-2">Size</div>
                        <div class="col-md-2">Paper</div>
                        <div class="col-md-2">Frame</div>
                        <div class="col-md-2">Quantity</div>
                        <div class="col-md-2">Total</div>
                    </div>
                    <script>
                        $.get('print-services.php')
                            .done(function(data) {
                                
                                /* Modify to account for multiple images */
                                var subtotal = 0;
                                var finaltotal = 0;
                                $.each(data.shipping, function(index, ship) { 
                                    if(ship.id == 0){
                                        $('#shipping-choice').append( $('<input type="radio" value="' + ship.id + '" name="shipping"><label for="'+ ship.id + '">'+ship.name+'</label>').attr("checked", "checked")); 
                                    } else if (ship.id == 1) {
                                        $('#shipping-choice').append( $('<input type="radio" value="' + ship.id + '" name="shipping"><label for="'+ ship.id + '">'+ship.name+'</label>')); 
                                    }
                                });
                                
                                for(let i=0;i<$('#order .row').length-3;i++) {
                                    $.each(data.sizes, function(index, size) { $('#img-' +i+ ' .size').append( $('<option value="' + size.id + '">' + size.name + '</option>')); });
                                    $.each(data.stock, function(index, stock) { $('#img-' +i+ ' .paper').append( $('<option value="' + stock.id + '">' + stock.name + '</option>')); });
                                    $.each(data.frame, function(index, frame) { $('#img-' +i+ ' .frame').append( $('<option value="' + frame.id + '">' + frame.name + '</option>')); });
                                    
                                    var imgTotal = 0;
                                
                                    
                                    var size = $('#img-' +i+ ' .size option:selected').val();
                                    var paper = $('#img-' +i+ ' .paper option:selected').val();
                                    var frame = $('#img-' +i+ ' .frame option:selected').val();
                                    var quantity = $('#img-' +i+ ' .quantity').val();
                                    
                                    $.each(data.sizes, function(index, s) {
                                        if(size == s.id) {
                                            var price = s.cost;
                                            imgTotal += price;
                                        }
                                    });
                                    $.each(data.stock, function(index, p) {
                                        if(paper == p.id) {
                                            var price = p.small_cost;
                                            imgTotal += price;
                                        }
                                    });
                                    
                                    $.each(data.frame, function(index, f) {
                                        if(frame == f.id) {
                                            var price = f.costs[size];
                                            imgTotal += price;
                                        }
                                    });
                                    
                                    imgTotal = imgTotal * quantity;
                                    subtotal += imgTotal;
                                    $('#img-' +i+ ' .total').text(imgTotal.toFixed(2));
                                }
                                $('#subtotal').text(subtotal.toFixed(2));
                                finaltotal += subtotal;
                                
                                var shipping = $('#shipping-choice input:checked' ).val();
                                $.each(data.shipping, function(index, sh) {
                                    if(shipping == sh.id) {
                                        finaltotal += sh.rules.none;
                                        $('#shipping-cost').text(sh.rules.none.toFixed(2));
                                    }
                                });
                                $('#total-cost').text(finaltotal.toFixed(2));
                                
                            })
                            .fail(function() {
                                alert("error, could not detect file input");
                            })
                            .always(function(data) {
                                for(let i=0; i<$('#order .row').length-3; i++) {
                                    $('#img-'+i).change(function(e){
                                       
                                        var sizeSelected = $('#img-' + i +' .size option:selected').val();    
                                        var paperSelected = $('#img-' + i +' .paper option:selected').val();
                                        var frameSelected = $('#img-' + i +' .frame option:selected').val();
                                        var quantitySelected = $('#img-' + i +' .quantity').val();
                                        var shippingSelected = $('#shipping-choice input:checked' ).val();
                                    
                                        //varaibles for total
                                        var imgTotal = 0;
                                        var subtotal = 0;
                                        
                                        $.each(data.sizes, function(index, s) {
                                        
                                            //accesses the size array
                                            if (sizeSelected == s.id){
                                                imgTotal += s.cost;
                                            }
                                        });
                                        
                                        $.each(data.stock, function(index, p) {
                                            //accesses the stock array
                                            if (paperSelected == p.id){
                                                if(sizeSelected == 0 || sizeSelected == 1) {
                                                    imgTotal += p.small_cost;
                                                } else if (sizeSelected == 2 || sizeSelected == 3) {
                                                    imgTotal += p.large_cost;
                                                }
                                                
                                            }
                                            
                                        });
                                        
                                        $.each(data.frame, function(index, f) {
                                            //accesses the frame array
                                            if (frameSelected == f.id){
                                                imgTotal += f.costs[sizeSelected];
                                            }
                                        });
                                        
                                        imgTotal = imgTotal * quantitySelected;
                                        
                                        $('#img-' +i+ ' .total').text(imgTotal.toFixed(2));
                                        
                                        for(let j=0; j<$('#order .row').length-3; j++) {
                                            subtotal += parseFloat($('#img-' +j+ ' .total').text());
                                            $('#subtotal').text(subtotal.toFixed(2));
                                        }
                                        countFrames();
                                        getTotal();
                                        
                                    }); 
                                    
                                    
                                }
                                $('#shipping-choice input').on("click" ,function(e) {
                                    var shippingSelected = $('#shipping-choice input:checked' ).val();
                                    countFrames();
                                    getTotal();
                                });
                                
                                function updateShipping(fc){
                                    var shippingSelected = $('#shipping-choice input:checked' ).val();
                                    $.each(data.shipping, function(index, sh){
                                        if (shippingSelected == sh.id ){
                                            if (fc == 0 ){
                                                $('#shipping-cost').text(sh.rules.none.toFixed(2));
                                            }else if (fc > 0 && fc < 10){
                                                $('#shipping-cost').text(sh.rules.under10.toFixed(2));
                                            }else if (fc >= 10){
                                                $('#shipping-cost').text(sh.rules.over10.toFixed(2));
                                            }
                                            
                                        }
                                    });
                                }
                                
                                function countFrames(){
                                    var frameTotal = 0;
                                    for(let m=0; m<$('#order .row').length-3; m++) {
                                        var frameSelected = $('#img-' + m +' .frame option:selected').val();
                                        var quantitySelected = $('#img-' + m +' .quantity').val();
                                        //accesses the frame array
                                        if(frameSelected > 0) {
                                            frameCurrent = 1 * quantitySelected; 
                                        } else if(frameSelected == 0) {
                                            frameCurrent = 0;
                                        }
                                        frameTotal += frameCurrent;
                                    }
                                    updateShipping(frameTotal);
                                }
                                function getTotal(){
                                    var limit = 0;
                                    $.each(data.freeThresholds, function(index, thresh) {
                                        //var shippingSel = $('#shipping-choice input:checked' ).val();
                                        var shippingName = $('#shipping-choice label[for="' + $('#shipping-choice input:checked' ).val() + '"]').text();
                                        
                                        if (thresh.name == shippingName){
                                            limit = thresh.amount;
                                        }
                                    })
                                    if (parseFloat($('#subtotal').text()) >= limit){
                                        $('#shipping-cost').text("0.00");
                                    }
                                    var finalsubtotal = parseFloat($('#subtotal').text());
                                    var finalshippingtotal = parseFloat($('#shipping-cost').text());
                                    var finaltotal = finalsubtotal + finalshippingtotal;
                                    $('#total-cost').text(finaltotal.toFixed(2));
                                }
                            });
                        
                        
                            
                            
                            
                    </script>
                    <?php 
                        $fav = unserialize($_COOKIE['fav']);
                        $size = sizeof($fav);
                        
                        /* Gets the favorite list and displays the correct images that are saved */
                        $resultImg = $db2->findAll();
                        echo '<form action="order.php" method="post" id="order">';
                        foreach($resultImg as $img) {
                            for($i=0;$i<$size;$i++) {
                                if($fav[$i][0] == 'img') {
                                    if($fav[$i][3] == $img['ImageID']) {
                                        echo '<div class="row" id="img-'.$i.'">';
                                        echo '<div class="col-md-2">';
                                        echo '<img class="img-responsive" src="images/square-small/' . $fav[$i][1] . '"/></div>';
                                        echo '<div class="col-md-2"><select class="size" name="size' .$i. '"></select></div>';
                                        echo '<div class="col-md-2"><select class="paper" name="paper' .$i. '"></select></div>';
                                        echo '<div class="col-md-2"><select class="frame" name="frame' .$i. '"></select></div>';
                                        echo '<div class="col-md-2"><input class="quantity" size="2" type="text" name="quantity' .$i. '" value="1"></div>';
                                        echo '<div class="col-md-2 total" readonly></div>';
                                        echo '</div>';
                                    }
                                }
                            }
                        }
                    
                    ?>
                    <hr>
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-2">Subtotal</div>
                        <div class="col-md-2" id="subtotal"></div>
                    </div>
                    <div class="row shipping">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">Shipping Type:</div>
                        <div class="col-md-3" id="shipping-choice"></div>
                        <div class="col-md-2">Shipping</div>
                        <div class="col-md-2" id="shipping-cost"></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-2">Total</div>
                        <div class="col-md-2" id="total-cost"></div>
                    </div>
                    
                </div>
          
                <div class="modal-footer">
                    <?php 
                        echo '<div class="col-md-12"><h5>';
                        echo '<button class ="btn btn-danger" type="submit">Order</button></a>'; 
                        echo '</h5></div>';
                    
                    ?>
                </form>
            
                    <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                    
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->

                </div>
        
            </div>
        
        </div>
      
    </div> <!-- End of Modal -->    
    