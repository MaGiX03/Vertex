function users_check () {
	$('#users_out').text('Загрузка');
	text = '&text=' + $('#search').val();
	$.ajax(

	{
		url : '/log_function',
		type: 'POST',
		data: 'users_check_f=1' + text,
		cache: false,
		success: function( data ) {
			if (data != 0) {
				data = JSON.parse(data);
				var out = '';
				for (var id in data) {
					out+=`<li class="list-group-item"><h5>${data[id].id} | ${data[id].login}</h5>
					<div class="row row-30 justify-content-center">
					<div class="col-sm-12 col-md-10 col-lg-6">
					<h5>Логин: ${data[id].fio} </h5>
					<h5>Телефон: ${data[id].number} </h5>
					<h5>Адрес: ${data[id].deliv} </h5>
					<div class="form-group">
					         <label>Трек код/Номер отслеживания</label>
							<input type="text" class="form-control" id="text${data[id].id}">
						</div>
						<div class="form-group" style="margin-top: 20px;">
								<label>Веб-сервис</label>
								<select class="form-control" id="service${data[id].id}" style="padding: 8px 30px;">
									<option value="1">Kazpost</option>
									<option value="2">EMS</option>
									<option value="3">AVIS</option>
								</select>
							</div>
							</div>

							</div>
							<b id="message${data[id].id}"></b><br/>
					<button class="button button-primary" href="#" onclick="insert_logist(${data[id].id})">Добавить</button></li></ul>`;
				}
				$('#users_out').html(out);
			}
			else {
				$('#users_out').text('');
			}
			


		}

	}

	);

}





function insert_logist(id) {
	var text = '&text=' + $('#text' + id).val();
	var service = '&service=' + $('#service' + id).val();
	var id2 = '&id=' + id;

	
	$.ajax(

	{
		url : '/log_function',
		type: 'POST',
		data: 'insert_logist_f=1' + text + service + id2,
		cache: false,
		success: function( data ) {
			data= JSON.parse(data);

			if ( data.message ) {
				$('#message' + id).html('<label style="color:red;">' + data.message + '</label>');
			}
			else if ( data.s_message ) {
				$('#message' + id).html('<label style="color:green;">' + data.s_message + '</label>');
			}
		}

	}

	);

}

function product_count() {
	val = '&val=' + $('#withdrawal_val').val();
	date = '&date=' + $('#withdrawal_date').val();
	text = '&text=' + $('#w_search').val();
	$.ajax(

	{
		url : '/log_function',
		type: 'POST',
		data: 'product_count_f=1' + val + date + text,
		cache: false,
		success: function( data ) {
			if (data != 0) {
				var page_count = Math.ceil(data / 27);
				var i = 1;
				var out = '<label for="a_status">Страница</label><select id="product_count" class="form-control" onchange="product_check(5)" style="padding: 8px 30px;">';
				for (i = 1; i <= page_count; i++) {
					out+='<option>'+ i +'</option>';
				}
				out+= '</select>';
				$('#product_select').html(out);
			}
			else {
				$('#product_out').html('<h3>База пуста</h3>');
			}
		}

	}

	);
}

function product_check (val3) {
	if (val3 != 4 && val3 != 5) {
		if (val3 == 0) {
			$('#withdrawal_date').hide();
		}
		else {
			$('#withdrawal_date').show();
		}
		val = '&val=' + val3;
		$('#withdrawal_val').val(val3);
	}
	else {
		val = '&val=' + $('#withdrawal_val').val();
	}
	date = '&date=' + $('#withdrawal_date').val();

	if (val3 != 5) {
		product_count();
	}	
	page = $('#product_count').val()*27-27;
	start = '&start=' + page; 
	text = '&text=' + $('#w_search').val();
	$.ajax(

	{
		url : '/log_function',
		type: 'POST',
		data: 'product_check_f=1' + val + date + start + text,
		cache: false,
		success: function( data ) {

			data = JSON.parse(data);
			window.User = data;
			window.Wval = val3;
			var out = '';
			if (data.no_result != 1) {
				if ($('#withdrawal_val').val() == 0) {
					for (var id in data) {
						out+=`<div class="col-md-6 col-xl-4 wow fadeInRight" id="w${data[id].id}"><article class="quote-modern quote-modern-custom"><div class="unit unit-spacing-md align-items-center"><div class="unit-body">`;
						out+=`<h4 class="quote-modern-cite"><a href="#">${data[id].title}</a></h4><p class="quote-modern-status">${data[id].input_date}</p></div></div>`;
						out+=`<div class="quote-modern-text"><p class="q">${data[id].text}</p></div><button class="button button-primary" onclick="product_checked(${data[id].id}, 1)">Подтвердить</button><button class="button button-primary" onclick="product_checked(${data[id].id}, 2)">Отменить</button></article></div>`;
					}
				}
				else {
					for (var id in data) {
						out+=`<div class="col-md-6 col-xl-4 wow fadeInRight" id="w${data[id].id}"><article class="quote-modern quote-modern-custom"><div class="unit unit-spacing-md align-items-center"><div class="unit-body">`;
						out+=`<h4 class="quote-modern-cite"><a href="#">${data[id].title}</a></h4><p class="quote-modern-status">${data[id].input_date}</p></div></div>`;
						out+=`<div class="quote-modern-text"><p class="q">${data[id].text}</p></div></article></div>`;
					}
				}
			}
			else {
				out+='<h3>База пуста</h3>';
			}
			
			
			$('#product_out').html(out);


		}

	}

	);
	
}

function product_checked (id, val) {
	id2 = '&id=' + id;
	val = '&val=' + val;
	$.ajax(

	{
		url : '/log_function',
		type: 'POST',
		data: 'product_checked_f=1' + id2 + val,
		cache: false,
		success: function( data ) {

			if (data == 1) {
				$('#w'+id).remove();
			}
			else {
				alert('Ошибка');
			}
			


		}

	}

	);
	
}


function users_sp_check (val) {
	$('#users_out').text('Загрузка');
	page = $('#users_count').val()*20-20;
	start = '&start=' + page; 
	text = '&text=' + $('#search').val();
	if (val == 1) {
		users_sp_count();
	}
	$.ajax(

	{
		url : '/log_function',
		type: 'POST',
		data: 'users_sp_check_f=1'  + start + text,
		cache: false,
		success: function( data ) {
			if (data != 0) {
				data = JSON.parse(data);
				var out = '';
				for (var id in data) {
					out+=`<li class="list-group-item"><a onclick="show_user_sp(${data[id].id})" href="#modalCta" data-toggle="modal" data-caption-animate="fadeInUp" data-caption-delay="200"><h5>${data[id].login}</h5></a></li></ul>`;
				}
				$('#users_out').html(out);
			}
			


		}

	}

	);

}

function users_sp_count() {
	text = '&text=' + $('#search').val();
	$.ajax(

	{
		url : '/log_function',
		type: 'POST',
		data: 'users_sp_count_f=1' + text,
		cache: false,
		success: function( data ) {
			if (data != 0) {
				var page_count = Math.ceil(data / 20);
				var i = 1;
				var out = '<label for="a_status">Страница</label><select id="users_count" class="form-control" onchange="users_sp_check(0)" style="padding: 8px 30px;">';
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


function show_user_sp(id) {
	var id2 = '&id=' + id;
	$.ajax(

	{
		url : '/log_function',
		type: 'POST',
		data: 'show_user_sp_f=1' + id2,
		cache: false,
		success: function( data ) {
			$('#Uid').val(id);
			$('#Pname').text('sp: '+data);


		}

	}

	);

}

function give_tovar() {
	var id2 = '&id=' + $('#Uid').val();
	var Pid = '&pid=' + $('#s_product').val();
	var count = '&count=' + $('#p_kolvo').val();
	$.ajax(

	{
		url : '/log_function',
		type: 'POST',
		data: 'give_tovar_f=1' + id2 + Pid + count,
		cache: false,
		success: function( result ) {
			
			obj = jQuery.parseJSON( result );

			if ( obj.message ) {
				$('#message').html('<label style="color:red;">' + obj.message + '</label>');
			}
			else if ( obj.s_message ) {
				$('#message').html('<label style="color:green;">' + obj.s_message + '</label>');
				show_user_sp($('#Uid').val());
				
			}

			else if ( obj.error_message ) {
				$('#message').html('<label style="color:red;">Произошла ошибка, попробуйте ещё раз</label>');
			}

		}

	}

	);
}

function go( url ) {
	window.location.href='/' + url;
}
