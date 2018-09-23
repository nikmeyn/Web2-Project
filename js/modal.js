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
            $('#img-' +i+ ' .total').text(imgTotal);
        }
        $('#subtotal').text(subtotal);
        finaltotal += subtotal;
        
        var shipping = $('#shipping-choice input:checked' ).val();
        $.each(data.shipping, function(index, sh) {
            if(shipping == sh.id) {
                finaltotal += sh.rules.none;
                $('#shipping-cost').text(sh.rules.none);
            }
        });
        $('#total-cost').text(finaltotal);
        
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
                
                $('#img-' +i+ ' .total').text(imgTotal);
                
                for(let j=0; j<$('#order .row').length-3; j++) {
                    subtotal += parseFloat($('#img-' +j+ ' .total').text());
                    $('#subtotal').text(subtotal);
                }
                countFrames();
                getTotal();
                
            }); 
            
            
        }
        $('#shipping-choice input').on("click" ,function(e) {
            var shippingSelected = $('#shipping-choice input:checked' ).val();
            countFrames();
        });
        
        function updateShipping(fc){
            console.log(fc);
            var shippingSelected = $('#shipping-choice input:checked' ).val();
            $.each(data.shipping, function(index, sh){
                if (shippingSelected == sh.id ){
                    if (fc == 0 ){
                        $('#shipping-cost').text(sh.rules.none);
                    }else if (fc > 0 && fc < 10){
                        $('#shipping-cost').text(sh.rules.under10);
                    }else if (fc >= 10){
                        $('#shipping-cost').text(sh.rules.over10);
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
            $.each(data.freeThresholds, function(index, thresh) {
                var shippingSel = $('#shipping-choice input:checked' ).labels();
                console.log(shippingSel);
                // if ( sdasdsa== data.shipping.name){
                    
                // }
                // if (shippingSel == 1){
                    
                // }
            })
        }
    });
