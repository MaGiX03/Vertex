function withdraw () {
	str = '&w_sum=' + $('#w_sum').val() + '&w_aim=' + $('#w_aim').val();
	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'withdraw_f=1' + str,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if (obj.go) go(obj.go);
			
			else if (obj.message) {
				$('.titleHelp').html('<label style="color:red;">' + obj.message + '</label>');
			}
			else if (obj.s_message) {
				$('.titleHelp').html('<label style="color:green;">' + obj.s_message + '</label>');
				$('#balance').text(obj.balance);
			}


		}

	}

	);
	
}

function transfer () {
	str = '&t_sum=' + $('#t_sum').val() + '&t_aim=' + $('#t_aim').val();
	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'transfer_f=1' + str,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if (obj.go) go(obj.go);
			
			else if (obj.message) {
				$('.titleHelp2').html('<label style="color:red;">' + obj.message + '</label>');
			}
			else if (obj.s_message) {
				$('.titleHelp2').html('<label style="color:green;">' + obj.s_message + '</label>');
				$('#balance').text(obj.balance);
			}


		}

	}

	);
	
}

function popolnit(login) {          

	$('.titleHelp3').html('<label>Загрузка..</label>');
	$("#butt1").attr("disabled", true);     

	const widget = new tp.TarlanPayments();    

	const bcrypt = dcodeIO.bcrypt;  
	const salt = bcrypt.genSaltSync(10);
	const refIdToPost = `${Date.now()}`;
	const hash = bcrypt.hashSync(`${refIdToPost}bzHZwWDJwfFzdsfsJcNQ`, salt);   

	const amount = parseFloat($('#p_sum').val())*400;
	if (amount < 4000 || !amount) {
		$('.titleHelp3').html('<label style="color:red">Минимальная сумма пополнения 10$</label>');
		$("#butt1").attr("disabled", false);
		return 0;   
	}
	p_id = '&product_id=4';
	ref_id = '&reference_id=' + refIdToPost;
	amountToInput = '&amount=' + amount;

	$.ajax(

	{
		url : 'https://vertexmax.com/event/order_input.php',
		type: 'POST',
		data: 'user_id=' + $('#Uid').val() + ref_id + p_id + amountToInput,
		cache: false,
		success: function( result ) {
			if (result == 1) {                    
				amountWithCommision = amount*1.03;
				widget.checkout({
					reference_id: refIdToPost,
					amount: amountWithCommision,            
					secret_key: hash,            
					back_url: 'https://vertexmax.com/event/order_check.php',
					request_url: 'https://vertexmax.com/',
					description: `${login}, Пополнение - ${amount}`,                
					merchant_id: 7            
				}, 
				function onSuccess(data) {       
					$("#butt1").attr("disabled", false);             
					window.location.href = data.data.redirect_url;
					$('.titleHelp3').html('');
				},
				function onFailure(err) {
					$("#butt1").attr("disabled", false);             
					console.log(err);
					$('.titleHelp3').html('<label style="color:red;">Произошла ошибка, попробуйте ещё раз</label>');        
				})


			}
			else {
				$('.titleHelp3').html('<label style="color:red;">Произошла ошибка, попробуйте ещё раз</label>');  
			}
		}
	}
	);


	
}

function check_login() {
	str = '&login=' + $('#t_aim').val();
	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'check_login_f=1' + str,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if (obj.go) go(obj.go);
			
			else if (obj.result == 1) {
				$('#transfer_fio').html(obj.fio);
				$('#transfer_btn').attr('disabled',false);
			}
			else {
				$('#transfer_fio').html('');
				$('#transfer_btn').attr('disabled',true);
			}


		}

	}

	);
	
}


function go( url ) {
	window.location.href='/' + url;
}

