function users_check (val) {
	$('#users_out').text('Загрузка');
	page = $('#users_count').val()*20-20;
	start = '&start=' + page; 
	text = '&text=' + $('#search').val();
	if (val == 1) {
		users_count();
	}
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'users_check_f=1'  + start + text,
		cache: false,
		success: function( data ) {
			if (data != 0) {
				data = JSON.parse(data);
				var out = '';
				for (var id in data) {
					out+=`<li class="list-group-item"><a href="#" onclick="show_user_data(${data[id].id})"><h5>${data[id].id} | ${data[id].login}</h5></a></li>`;
				}
				$('#users_out').html(out);
			}
			


		}

	}

	);

}

function users_count() {
	text = '&text=' + $('#search').val();
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'users_count_f=1' + text,
		cache: false,
		success: function( data ) {
			if (data != 0) {
				var page_count = Math.ceil(data / 20);
				var i = 1;
				var out = '<label for="a_status">Страница</label><select id="users_count" class="form-control" onchange="users_check(0)" style="padding: 8px 30px;">';
				for (i = 1; i <= page_count; i++) {
					out+='<option>'+ i +'</option>';
				}
				out+= '</select>';
				$('#users_select').html(out);
			}
			else {
				$('#users_out').html('<h4>По вашему запросу ничего не найдено</h4>');
			}
		}

	}

	);
}

function show_user_data(id) {
	var id = '&id=' + id;
	var top = $('#user_data').offset().top;
	 $('body,html').animate({scrollTop: top}, 1000);
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'SelectUser_f=1' + id,
		cache: false,
		success: function( data ) {
			data= JSON.parse(data);
			$('#Uid').val(data.id);
			 $('#Uname').val(data.login);
			 $('#Unumber').val(data.number);
			 $('#Umail').val(data.email);
			 $('#Ufio').val(data.fio);
			 $('#Ubirthday').val(data.birthday);
			 $('#Ucountry option[value='+ data.country +']').attr('selected', 'selected');
			show_regions(data.region);
			show_cities(data.city);
			 $('#Uref').val(data.ref);
			 $('#Upassword').val(data.password);
			 $('#Ubalance').val(data.balance);
			 $('#Upaket').val(data.a_status);
			 if (data.a_status == 'Start') {
			 	$('#upgrade1').removeAttr('disabled');
			 	$('#upgrade2').removeAttr('disabled');
			 	$('#upgrade3').removeAttr('disabled');
			 }
			 else if (data.a_status == 'Business') {
			 	$('#upgrade1').attr('disabled', 'disabled');
			 	$('#upgrade2').removeAttr('disabled');
			 	$('#upgrade3').removeAttr('disabled');
			 }
			 else if (data.a_status == 'Premium') {
			 	$('#upgrade1').attr('disabled', 'disabled');
			 	$('#upgrade2').attr('disabled', 'disabled');
			 	$('#upgrade3').removeAttr('disabled');
			 }
			 else {
			 	$('#upgrade1').attr('disabled', 'disabled');
			 	$('#upgrade2').attr('disabled', 'disabled');
			 }
			 $('#Ustatus').val(data.s_status);
			 $('#Uregtime').val(data.reg_time);
		}

	}

	);
}

function change_user_data(data) {
	$('.titleHelp').html('<label>Загрузка..</label>');
	var str = '';

	$.each( data.split('.'), function(k, v) {
		str += '&' + v + '=' + $('#' + v).val();
	} );

	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'change_user_data_f=1' + str,
		cache: false,
		success: function( data ) {
			data= JSON.parse(data);

			if ( data.message ) {
				$('.titleHelp').html('<label style="color:red;">' + data.message + '</label>');
			}
			else if ( data.s_message ) {
				$('.titleHelp').html('<label style="color:green;">' + data.s_message + '</label>');
			}
		}

	}

	);

}


function upgrade_user(status) {
	var status = '&status=' + status;

	var id = '&id=' + $('#Uid').val();
	
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'upgrade_user_f=1' + status + id,
		cache: false,
		success: function( data ) {
			data= JSON.parse(data);

			if ( data.message ) {
				$('.titleHelp1').html('<label style="color:red;">' + data.message + '</label>');
			}
			else if ( data.s_message ) {
				$('.titleHelp1').html('<label style="color:green;">' + data.s_message + '</label>');
			}
		}

	}

	);

}


function show_regions(check) {
	if ($('#Ucountry').val() == 0) return 0;
	var val = '&val=' + $('#Ucountry').val();
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
				$('#Uregion').html(out);
				if (check != 0) $('#Uregion option[value='+ check +']').attr('selected', 'selected');
				show_cities();
				

		}
	}

	);
}

function show_cities(check) {
	if ($('#Uregion').val() == 0) return 0;
	var val = '&val=' + $('#Uregion').val();
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
				$('#Ucity').html(out);
				if (check != 0) $('#Ucity option[value='+ check +']').attr('selected', 'selected');
	
				
		}
	}

	);
}


function go( url ) {
	window.location.href='/' + url;
}

$(document).ready(function() {
	users_check(0);
	users_count();
	
});