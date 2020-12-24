function linear_check () {
	id = '&id=' + $('#uid').val();
	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'linear_check_f=1' + id,
		cache: false,
		success: function( data ) {

			data = JSON.parse(data);

			if (data.go) go(data.go);

			var out = '';
			for (var id in data) {
					out+=`<li class="list-group-item"><a href="#" onclick="show_ref_data(${data[id].id})"><h5>${data[id].login} ▼</h5></a><ul id="u${data[id].id}" class="list-group" style="display:none;"><li class="list-group-item">ФИО: ${data[id].fio}</li><li class="list-group-item">Телефон: ${data[id].number}</li><li class="list-group-item">Общий личный объем: ${data[id].total_buy}</li><li class="list-group-item">Месячный личный объем:${data[id].week_buy}</li><li class="list-group-item">Общий объем:${data[id].total_amount}</li><li class="list-group-item">Месячный объем:${data[id].current_amount}</li><li class="list-group-item">Пакет: ${data[id].a_status}</li><li class="list-group-item">Статус: ${data[id].s_status}</li><li class="list-group-item"><a href="linear${data[id].id}">Смотреть личников</a></li></ul></li></ul>`;
				}
				$('#refs_out').html(out);


		}

	}

	);

}

function s_user_search () {
	$('#users_out').html('<li class="list-group-item"><h5>Загрузка</h5></li>');
	val = '&aim=' + $('#search').val();
	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 's_user_search_f=1' + val,
		cache: false,
		success: function( data ) {
			if (data != 0) {
				data = JSON.parse(data);
				var out = '';
				for (var id in data) {
					out+=`<li class="list-group-item"><a href="linear${data[id].id}"><h5>${data[id].login}</h5></a></li>`;
				}
				$('#users_out').html(out);
			}
			else {
				$('#users_out').html('<li class="list-group-item"><h5>Пользователь не найден</h5></li>');
			}
			


		}
	}
	);
	}

function show_ref_data(id) {
	$('#u' + id).slideToggle();
}
function go( url ) {
	window.location.href='/' + url;
}

$(document).ready(function() {
	linear_check();
	
});

