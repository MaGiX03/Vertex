function post_query( url, name, data ) {


	$('.titleHelp').html('<label>Загрузка..</label>');
	var str = '';

	$.each( data.split('.'), function(k, v) {
		str += '&' + v + '=' + $('#' + v).val();
	} );
	

	$.ajax(
	{
		url : '/' + url,
		type: 'POST',
		data: name + '_f=1' + str,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if (obj.go) go(obj.go);

			else if ( obj.message ) {
				$('.titleHelp').html('<label style="color:red;">' + obj.message + '</label>');
			}
			else if ( obj.s_message ) {
				$('.titleHelp').html('<label style="color:green;">' + obj.s_message + '</label>');
			}

			else if ( obj.error_message ) {
				$('.titleHelp').html('<label style="color:red;">Произошла ошибка, попробуйте ещё раз</label>');
			}

			else if (obj.m_shop) {
				$('#m_shop').val(obj.m_shop);
				$('#m_orderid').val(obj.m_orderid);
				$('#pr_orderid').val(obj.m_orderid);
				$('#m_amount').val(obj.m_amount);
				$('#pr_amount').val(obj.m_amount);
				$('#m_curr').val(obj.m_curr);
				$('#m_desc').val(obj.m_desc);
				$('#m_sign').val(obj.sign);
				pay_form_show();
			}
		}
	}
	);
}


function clear_titleHelp() {
	$('.titleHelp').empty();

}

function show_reg() {
	$('#auth_but').removeClass("active");
	$('#auth').slideUp();
	$('#rec').slideUp();
	$('#reg_but').addClass("active");
	$('#reg').slideDown();
}
function show_auth() {
	$('#reg_but').removeClass("active");
	$('#reg').slideUp();
	$('#rec').slideUp();
	$('#auth_but').addClass("active");
	$('#auth').slideDown();
}
function show_rec() {
	$('#reg_but').removeClass("active");
	$('#auth_but').removeClass("active");
	$('#reg').slideUp();
	$('#auth').slideUp();
	$('#rec').slideDown();
}

function pay_type() {
	var val = $('#pay_type').val();

	if (val == 1) {
		$('#butt1').show();
		$('#butt2').hide();
	}
	else if (val == 2) {
		$('#butt1').hide();
		$('#butt2').show();
	}
}

function agreement_check() {
	var chbox;
	var reg_butt;
	chbox=document.getElementById('Check1');
	reg_butt=document.getElementById('reg_button');
	if (chbox.checked) {
		reg_butt.removeAttribute('disabled');
	}
	else {
		reg_butt.setAttribute('disabled','disabled');
	}
}

function go( url ) {
	window.location.href='/' + url;
}

function activationPayWithCard(login) {          

	$('.titleHelp').html('<label>Загрузка..</label>');
	$("#butt1").attr("disabled", true);

	const paketVal = $('#paket').val();
	const payTypeVal = $('#pay_type').val();       

	if(payTypeVal === '1') {
		const getAmountByVal = () => {
			switch(paketVal) {
				case '1': return 14000;
				case '2': return 42000;   
				case '3': return 112000;
				default: return 'Сумма неизвестна'
			}
		}

		const getTextByVal = () => {
			switch(paketVal) {
				case '1': return 'Старт';
				case '2': return 'Бизнес';
				case '3': return 'Премиум';
				default: return 'Неизвестный пакет'
			}
		}

		const widget = new tp.TarlanPayments();    

		const bcrypt = dcodeIO.bcrypt;  
		const salt = bcrypt.genSaltSync(10);
		const refIdToPost = `${Date.now()}`;
		const hash = bcrypt.hashSync(`${refIdToPost}secret_key`, salt);   

		const amountWithCommission = getAmountByVal() * 1.03;

		p_id = '&product_id=2.' + paketVal;
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
						description: `${login}, Пакет - ${getTextByVal()}`,                
						merchant_id: 7            
					}, 
					function onSuccess(data) {       
						$("#butt1").attr("disabled", false);             
						window.location.href = data.data.redirect_url;
						clear_titleHelp();   
					},
					function onFailure(err) {
						$("#butt1").attr("disabled", false);             
						console.log(err);
						$('.titleHelp').html('<label style="color:red;">Произошла ошибка, попробуйте ещё раз</label>');        
					})


				}
				else {
					$('.titleHelp').html('<label style="color:red;">Произошла ошибка, попробуйте ещё раз</label>');  
				}
			}
		}
		);


	}
}

function show_regions() {
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
				show_cities();
		}
	}

	);
}

function show_cities() {
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
		}
	}

	);
}

document.addEventListener('DOMContentLoaded', () => {
    const amounts = [
        {                
            kz: 14000, other: 35
        },
        { kz: 42000, other: 105 },
        { kz: 112000, other: 280 }
    ]   
    const activationOptions = document.getElementById('paket');       

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
            console.log(err);

            amounts.forEach(({ kz }, index) => {
                const optionText = activationOptions.options[index].innerHTML
                activationOptions.options[index].innerHTML = `${optionText} - ${kz} тенге`;
               
            })        
        }
    }

    setOptionByCountry()
})