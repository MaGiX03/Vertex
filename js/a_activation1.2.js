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
		data: 'act_users_check_f=1'  + start + text,
		cache: false,
		success: function( data ) {
			if (data != 0) {
				data = JSON.parse(data);

				if (data.go) go(data.go);
				var out = '';
				for (var id in data) {
					out+=`<li id="l${data[id].id}" class="list-group-item"><h5>${data[id].id} | ${data[id].login} <select class="form-control" id = "s${data[id].id}" style="padding: 8px 30px;"><option value='1'>Старт</option><option value='2'>Бизнес</option><option value='3'>Премиум</option></select><br> <button class="btn btn-primary" onclick="user_activate(${data[id].id})"> Активировать</button><br> <button class="btn btn-primary" style="margin-top:20px;" onclick="user_delete(${data[id].id})"> Удалить</button></h5></li></ul>`;
				}
				$('#users_out').html(out);
			}
			


		}

	}

	);

}

function users_count() {
	test_admin();
	text = '&text=' + $('#search').val();
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'act_users_count_f=1' + text,
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

function user_activate(id) {
	test_admin();
	var id2 = '&id=' + id;
	var paket = '&paket=' + $('#s' + id).val();
	if ($('#s' + id).val() == 1) {
		text = 'Старт';
	}
	else if ($('#s' + id).val() == 2) {
		text = 'Бизнес';
	}
	else if ($('#s' + id).val() == 3) {
		text = 'Премиум';
	}
	var isActivate = confirm("Активировать пользователя на пакет " + text + "?");
	if (isActivate) {
		$.ajax(

		{
			url : '/a_function',
			type: 'POST',
			data: 'user_activate_f=1' + id2 + paket,
			cache: false,
			success: function( data ) {

				if (data == 1) {
					$('#l' + id).remove();
				}
				else if (data == 2) {
					alert('Спонсор не активирован');
				}
				else if (data == 3) {
					alert('Этот пользователь уже активен');
				}
				else {
					alert('Произошла ошибка');
				}

			}

		}

		);
	}
}

function user_delete(id) {
	test_admin();
	var id2 = '&id=' + id;

	var isDelete = confirm("Удалить пользователя?");

	if (isDelete) {

		$.ajax(

		{
			url : '/a_function',
			type: 'POST',
			data: 'user_delete_f=1' + id2,
			cache: false,
			success: function( data ) {

				if (data == 1) {
					$('#l' + id).remove();
				}
				else {
					alert('Произошла ошибка');
				}

			}

		}

		);

	}
	
}

function test_admin() {
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'test_admin_f=1',
		cache: false,
		success: function( data ) {
			data = JSON.parse(data);

			if (data.go) go(data.go);

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