function data_show() {


	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'stats_f=1',
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );
			$('.counter1:eq(0)').text(obj.sum_prihod);
			$('.counter1:eq(1)').text(obj.sum_nach);
			$('.counter1:eq(2)').text(obj.sum_withdrawal);
			$('.counter1:eq(3)').text(obj.sum_balance);
			$('.counter1:eq(4)').text(obj.sum_reg);
			$('.counter1:eq(5)').text(obj.sum_act);
			$('.counter1:eq(6)').text(obj.sum_ofis);
			$('.counter1:eq(7)').text(obj.sum_dostavka);
			$('.counter1:eq(8)').text(obj.count_product);
			$('.counter2:eq(0)').text(obj.count_users1);
			$('.counter2:eq(1)').text(obj.count_users2);
			$('.counter2:eq(2)').text(obj.count_users3);
			$('.counter2:eq(3)').text(obj.count_users);
			$('.counter3:eq(0)').text(obj.count_status1);
			$('.counter3:eq(1)').text(obj.count_status2);
			$('.counter3:eq(2)').text(obj.count_status3);
			$('.counter3:eq(3)').text(obj.count_status4);
			$('.counter3:eq(4)').text(obj.count_status5);
			$('.counter3:eq(5)').text(obj.count_status6);
			$('.counter3:eq(6)').text(obj.count_status7);
			$('.counter3:eq(7)').text(obj.count_status8);
			$('.counter3:eq(8)').text(obj.count_status9);



		}





	}

	);

}


function spisat_modal(name) {

	$('#Sname').val(name);

}

function stats_spisat() {
	data_show();

	if ($('#Sname').val() == 'ComBalance') {
		var value2 = '&value2=' + $('.counter1:eq(0)').text();
	}
	else if ($('#Sname').val() == 'ProdReg') {
		var value2 = '&value2=' + $('.counter1:eq(4)').text();
	}
	else if ($('#Sname').val() == 'ProdAct') {
		var value2 = '&value2=' + $('.counter1:eq(5)').text();
	}
	else if ($('#Sname').val() == 'ComOffice') {
		var value2 = '&value2=' + $('.counter1:eq(6)').text();
	}
	else if ($('#Sname').val() == 'ComDelivery') {
		var value2 = '&value2=' + $('.counter1:eq(7)').text();
	}
	

	var name = '&name=' + $('#Sname').val();
	var value = '&value=' + $('#Svalue').val();
	

	

	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'stats_spisat_f=1' + name + value + value2,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if (obj.message) {
				$('#message').html('<label style="color:red;">' + obj.message + '</label>');
			}
			else if (obj.s_message) {
				data_show();
				$('#message').html('<label style="color:green;">' + obj.s_message + '</label>');
			}

		}





	}

	);

}

function stats_date(val) {

	if (val == 1) {
		var date1 = '&date1=' + $('#stats_date1').val();
		var date2 = '&date2=' + $('#stats_date2').val();
	}
	var val1 = '&val=' + val;
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'stats_date_f=1' + date1 + date2 + val1,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );
			$('.counter4:eq(0)').text(obj.sum_nach);
			$('.counter4:eq(1)').text(obj.sum_withdrawal);
			$('.counter4:eq(2)').text(obj.start_count);
			$('.counter4:eq(3)').text(obj.business_count);
			$('.counter4:eq(4)').text(obj.premium_count);
			$('.counter4:eq(5)').text(obj.sum_prihod);



		}





	}

	);

}

function show_partners(val) {
	var val1 = '&val=' + val;
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'show_partners_f=1' + val1,
		cache: false,
		success: function( result ) {

			$('#partners' + val).text(result);
			



		}





	}

	);

}




function go( url ) {
	window.location.href='/' + url;
}


$(document).ready(function() {
	stats_date(0);
	data_show();
	
});