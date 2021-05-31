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
        alert('he;;');
    })

});