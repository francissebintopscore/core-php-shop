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
                }
        });
    });

});