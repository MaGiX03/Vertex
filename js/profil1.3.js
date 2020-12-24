function data_show() {
	$.ajax(
	{
		url : '/function',
		type: 'POST',
		data: 'data_show_f=1',
		cache: false,
		success: function( result ) {            
			obj = jQuery.parseJSON( result );
			if (obj.go) go(obj.go);
			$('#login').val(obj.login);
			$('#password').val(obj.password);
			$('#email').val(obj.email);
			$('#number').val(obj.number);
			$('#city').val(obj.city);
			$('#ref').val(obj.ref);
			$('#fio').val(obj.fio);
			$('#birthday').val(obj.birthday);
			$('#country option[value='+ obj.country +']').attr('selected', 'selected');
			show_regions(obj.region, obj.city);
			$('#s_status').val(obj.s_status);
			$('#a_status').val(obj.a_status);
			$('#adr_del').val(obj.del);
			if (obj.a_status == 'Start') {
				$('#a_status_upgrade').html('<option value="2">Business - 70$</option><option value="3">Premium - 245$</option>');
			}
			else if (obj.a_status == 'Business') {
				$('#a_status_upgrade').html('<option value="3">Premium - 175$</option>');
			}
			else if (obj.a_status == 'Premium') {
				$('.upgrade_premium').remove();
			}
			window.User = obj;
			check_change();

		}
	}
	);

}

function check_change() {

	if ( User.password != $('#password').val() || User.email != $('#email').val() || User.number != $('#number').val() || User.country != $('#country').val() || User.city != $('#city').val() || User.fio != $('#fio').val() || User.birthday != $('#birthday').val()) {
		$('#change_butt').removeAttr('disabled');
	}
	else {
		$('#change_butt').attr('disabled', 'disabled');
	}
}

function change_data(data) {

	$('.titleHelp').html('<label>Загрузка..</label>')
	var str = '';

	$.each( data.split('.'), function(k, v) {
		str += '&' + v + '=' + $('#' + v).val();
	} );

	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'change_data_f=1' + str,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if (obj.go) go(obj.go);
			
			else if(obj.message) {
				$('.titleHelp').html('<label style="color:red;">'+ obj.message +'</label>')
			}
			else if (obj.s_message) {
				$('.titleHelp').html('<label style="color:green;">'+ obj.s_message +'</label>')
				data_show();
			}

		}

	}

	);

}

function upgrade_paket(a_status) {    
	$('.titleHelp2').html('<label>Загрузка..</label>')
	val = '&val=' + $('#a_status_upgrade').val();
	const paymentMethodVal = $('#a_payment_method').val();
	const paymentPackageVal = $('#a_status_upgrade').val();    
	const currentPackageVal = $('#a_status').val();
	const loginVal = $('#login').val();
	
	if(paymentMethodVal === '2') {        

		$("#vertex-pay-upgrade").attr("disabled", true);
		const widget = new tp.TarlanPayments();

		if (a_status == 1 && paymentPackageVal == 2) {
			var amountToPost = 28000;
		}
		else if (a_status == 2 && paymentPackageVal == 3) {
			var amountToPost = 70000;
		}
		else if (a_status == 1 && paymentPackageVal == 3) {
			var amountToPost = 98000;
		}
		const getSelectedPackageText = () => {
			switch(paymentPackageVal) {                
				case '2': return 'Business';   
				case '3': return 'Premium';
				default: return 'Пакет неизвестен'
			}
		}
		
		const getCurrentPackageAmount = () => {
			switch(currentPackageVal) {
				case 'Start': return 14000;
				case 'Business': return 42000;
				default: return 'Сумма неизвестна'
			}
		}

		// const currentPackageAmount = getCurrentPackageAmount();         

		const bcrypt = dcodeIO.bcrypt;  
		const salt = bcrypt.genSaltSync(10);
		const refIdToPost = `${Date.now()}`;
		const hash = bcrypt.hashSync(`${refIdToPost}bzHZwWDJwfFzdsfsJcNQ`, salt);  

		const amountWithCommission = amountToPost * 1.03;

		p_id = '&product_id=3.' + paymentPackageVal;
		ref_id = '&reference_id=' + refIdToPost;
		amount = '&amount=' + amountWithCommission;


		$.ajax(

		{
			url : 'https://vertexmax.com/event/order_input.php',
			type: 'POST',
			data: 'user_id=' + $('#Uid').val() + ref_id + p_id + amount,
			cache: false,
			success: function( result ) {
				if (result == 1) {                    

					widget.checkout({
						reference_id: refIdToPost,
						amount: amountWithCommission,                     
						secret_key: hash,            
						back_url: 'https://vertexmax.com/event/order_check.php',
						request_url: 'https://vertexmax.com/',
						description: `${loginVal}, Текущий пакет - ${currentPackageVal}, Апгрейд до - ${getSelectedPackageText()}`,                
						merchant_id: 7                    
					}, 
					function onSuccess(data) {      
						$("#vertex-pay-upgrade").attr("disabled", false);              
						window.location.href = data.data.redirect_url;
						$('.titleHelp2').empty();                
					},
					function onFailure(err) {
						$("#vertex-pay-upgrade").attr("disabled", false);
						console.log(err);            	
						$('.titleHelp2').html('<label style="color:red;">Произошла ошибка, попробуйте ещё раз</label>')
					})


				}
				else {
					$('.titleHelp').html('<label style="color:red;">Произошла ошибка, попробуйте ещё раз</label>');  
				}
			}
		}
		);
		
		return;
	} 

	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'upgrade_paket_f=1' + val,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if (obj.go) go(obj.go);
			
			else if(obj.message) {
				$('.titleHelp2').html('<label style="color:red;">'+ obj.message +'</label>')
			}
			else if (obj.s_message) {
				$('.titleHelp2').html('<label style="color:green;">'+ obj.s_message +'</label>')
				data_show();
			}

		}

	}

	);

}

function address_deliv() {

	$('.titleHelp3').html('<label>Загрузка..</label>')
	var str = '';

	str= '&text=' + $('#adr_del').val();

	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'adress_deliv_f=1' + str,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if (obj.go) go(obj.go);
			
			else if(obj.message) {
				$('.titleHelp3').html('<label style="color:red;">'+ obj.message +'</label>');
			}
			else if (obj.s_message) {
				$('.titleHelp3').html('<label style="color:green;">'+ obj.s_message +'</label>');
			}

		}

	}

	);

}

function deliv_check() {

	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'deliv_check_f=1',
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if (obj.no_result != 1) {
				$('#track_code').val(obj.tr_code);
				$("#track_link").attr("href", obj.track);
				$("#track_btn").attr("onclick", "deliv_сomplete(" + obj.id + ")");
				$("#track_form").show();
			}


		}

	}

	);

}

function deliv_сomplete(id) {

	id= '&id=' + id;

	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'deliv_complete_f=1' + id,
		cache: false,
		success: function( result ) {
				if (result == 1) {
					$('#track_form').remove();
				}

		}

	}

	);

}

function show_regions(check, city) {
	if ($('#country').val() == 0) return 0;
	var val = '&val=' + $('#country').val();
	$.ajax(

	{
		url : '/gform',
		type: 'POST',
		data: 'show_regions_f=1' + val,
		cache: false,
		success: function( result ) {

			data = JSON.parse(result);
			var out = '';
				for (var id in data) {
					out+=`<option value="${data[id].region_id}">${data[id].name}</option>`;
				}
				$('#region').html(out);
				if (check != 0) $('#region option[value='+ check +']').attr('selected', 'selected');
				show_cities(city);
				

		}
	}

	);
}

function show_cities(check) {
	if ($('#region').val() == 0) return 0;
	var val = '&val=' + $('#region').val();
	$.ajax(

	{
		url : '/gform',
		type: 'POST',
		data: 'show_cities_f=1' + val,
		cache: false,
		success: function( result ) {

			data = JSON.parse(result);
			var out = '';
				for (var id in data) {
					out+=`<option value="${data[id].city_id}">${data[id].name}</option>`;
				}
				$('#city').html(out);
				if (check != 0) $('#city option[value='+ check +']').attr('selected', 'selected');
				check_change();
				
		}
	}

	);
}


function go( url ) {
	window.location.href='/' + url;
}

$(document).ready(function() {
	data_show();
	deliv_check();
	
});

/*document.addEventListener('DOMContentLoaded', () => {
    const amounts = [
        {                
            kz: 29400, other: 70
        },
        { kz: 73500, other: 175 },    
    ]   
    const activationOptions = document.getElementById('a_status_upgrade');       

    const setOptionByCountry = async() => {
        try {
            const res = await fetch('https://finddifferences.club/api/country');
            const { country } = await res.json();                         
            
            amounts.forEach(({ kz, other }, index) => {
                const optionText = activationOptions.options[index].innerHTML

                if(country === 'KZ') {
                    activationOptions.options[index].innerHTML = `${optionText} - ${kz} тенге`;
                    return; 
                }         
                activationOptions.options[index].innerHTML = `${optionText} - ${other}$`;
            })            
        }       
        catch(err) {
            // console.log(err);

            amounts.forEach(({ kz }, index) => {
                const optionText = activationOptions.options[index].innerHTML
                activationOptions.options[index].innerHTML = `${optionText} - ${kz} тенге`;
               
            })        
        }
    }

    setOptionByCountry()
})*/