function buy_tovar() {
	id2 = '&id=' + $('#Pid').val();
    val = '&val=' + $('#pay_type').val();    
    const optionVal = $('#pay_type').val();    

    if(optionVal === '3') {        
        
        $('#message').html('<label>Загрузка..</label>');
        $("#vertex-product-pay").attr("disabled", true);    
        const widget = new tp.TarlanPayments();

        $.ajax(
        {
            url : '/function',
            type: 'POST',
            data: 'data_show_f=1',
            cache: false,
            success: function( result ) {            
                obj = jQuery.parseJSON( result );
                const login = obj.login;
                const productName = $('#Pname').text();

                const bcrypt = dcodeIO.bcrypt;  
                const salt = bcrypt.genSaltSync(10);
                const refIdToPost = `${Date.now()}`;
                const hash = bcrypt.hashSync(`${refIdToPost}bzHZwWDJwfFzdsfsJcNQ`, salt);   

                const amountWithCommission = 14000 * 1.03;

                p_id = '&product_id=1.' + $('#Pid').val();
                ref_id = '&reference_id=' + refIdToPost;
                amount = '&amount=' + amountWithCommission;

                $.ajax(

                {
                    url : 'https://vertexmax.com/event/order_input.php',
                    type: 'POST',
                    data: 'user_id=' + obj.id + ref_id + p_id + amount,
                    cache: false,
                    success: function( result ) {

                        if (result == 1) {                        

                        widget.checkout({
                            reference_id: refIdToPost,
                            amount: amountWithCommission,                        
                            secret_key: hash,            
                            back_url: 'https://vertexmax.com/event/order_check.php',
                            request_url: 'https://vertexmax.com/',
                            description: `${login} - ${productName}`,                
                            merchant_id: 7                        
                        }, 
                        function onSuccess(data) {        
                            $("#vertex-product-pay").attr("disabled", false);                                            
                            window.location.href = data.data.redirect_url;
                            $('#message').empty();              
                        },
                        function onFailure(err) {
                            $("#vertex-product-pay").attr("disabled", false);                
                            console.log(err);
                            $('#message').html('<label style="color:red;">Произошла ошибка, попробуйте ещё раз</label>');   
                        })

                       }
                       else {
                        $('#message').html('<label style="color:red;">Произошла ошибка, попробуйте ещё раз</label>');  
                       }



                   }

               }

               );


            }
        }
        );

        return;
    }

    $.ajax(

    {
      url : '/function',
      type: 'POST',
      data: 'buy_tovar_f=1' + id2 + val,
      cache: false,
      success: function( result ) {

         obj = jQuery.parseJSON( result );

         if (obj.go) go(obj.go);

         else if (obj.message) {
            $('#message').html('<label style="color:red;"> ' + obj.message + '</label>');	
        }
        else if (obj.s_message) {
            $('#message').html('<label style="color:green;"> ' + obj.s_message + '</label>');
            choose_tovar($('#Pid').val());	
        }


    }

}

);

}

function choose_tovar(id) {
	$('#Pid').val(id);
	$('#Pname').text('Продукт: ' + $('#t' + id).text());
	point_check();
}

function point_check() {

	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'point_check_f=1',
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if (obj.go) go(obj.go);

			$('#pay_type1').text('Бонусные баллы - ' + obj.point);
			$('#pay_type2').text('C баланса - ' + obj.balance);
			if (obj.sp > 1) {
				$('#pay_type4').show();
				$('#pay_type4').text('sp - ' + obj.sp);
			}


		}

	}

	);

}

function go( url ) {
	window.location.href='/' + url;
}

$(document).ready(function() {
	point_check();
	
});


