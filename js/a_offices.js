function office_data (val) {

	val2 = '&val=' + val;
	id = '&id=' + $('#change_id').val();
	if (val == 1) {
		var city = '&city=' + $('#add_city').val();
		var address = '&address=' + $('#add_address').val();
		var number = '&number=' + $('#add_number').val();
	}
	else {
		var city = '&city=' + $('#ch_city').val();
		var address = '&address=' + $('#ch_address').val();
		var number = '&number=' + $('#ch_number').val();
	}
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'office_data_f=1' + val2 + city + address + number + id,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if ( obj.message ) {
				$('.titleHelp').html('<label style="color:red;">' + obj.message + '</label>');
			}
			else if ( obj.s_message ) {
				$('.titleHelp').html('<label style="color:green;">' + obj.s_message + '</label>');
				
			}

			else if ( obj.error_message ) {
				$('.titleHelp').html('<label style="color:red;">Произошла ошибка, попробуйте ещё раз</label>');
			}

		}

	}

	);

}

function show_office() {
	id = '&id=' + $('#change_id').val();
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'show_office_f=1' + id,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			$('#ch_city').val(obj.city);
			$('#ch_address').val(obj.address);
			$('#ch_number').val(obj.number);


		}





	}

	);

}



function clear_titleHelp() {
	$('.titleHelp').empty();

}

function show_variants(val) {
	if (val == 1) {
		$('#change_tovar').slideToggle();
		$('#change_tovar').text('Изменить');
		$('#add_tovar').text('Добавить ▼');
		$('#add_form').slideDown();
		$('#change_form').slideUp();
	}
	if (val == 2) {
		$('#add_tovar').slideToggle();
		$('#add_tovar').text('Добавить');
		$('#change_tovar').text('Изменить ▼');
		$('#change_form').slideDown();
		$('#add_form').slideUp();
	}

	clear_titleHelp()

}



function go( url ) {
	window.location.href='/' + url;
}

$(document).ready(function() {
	show_office();
});

