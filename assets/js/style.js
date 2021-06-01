$(document).ready(function(){

    // $('#cart-table .product-qty').on('change',function(){
    //     let price = parseInt( $(this).parent().parent().find('.price').text() );
    //     console.log( price );
    // });
    $('#cart-table .product-qty').on('change',function(){
        $('#cart-update-btn').removeClass('disabled');
    });

    $('#cart-update-btn').on('click',function(){

        if( $(this).hasClass('disabled') )
        {
            return;
        }
        // alert('he;;');
    });

    $('#cart-table .cart-remove').on('click',function(){
        // var productId = $(this).parent().parent().data('product-id');
        var element = $(this).parent().parent();
        var productId = element.data('product-id');

        $.ajax({
                url : 'actions/do_ajax.php',
                method:'GET',
                data: { productId : productId, action : 'removeCartItem'},
                success: function(response){
                    console.log(response);
                    element.remove();
                    window.location.reload();
                }
        });
    });

    $('.ajax-addToCart').on('click',function(e){
        e.preventDefault();
        var productId = parseInt( $(this).data('product-id') );
        // console.log(typeof productId);
        $.ajax({
            url : 'actions/do_ajax.php',
            method:'POST',
            data: { productId : productId, action : 'addCartItem'},
            success: function(response){
                console.log(response);
                // window.location.reload();
            }
    });
    })

});