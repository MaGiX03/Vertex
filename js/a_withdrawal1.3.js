function withdrawal_check (val3) {
	if (val3 != 4 && val3 != 5) {
		if (val3 == 0 || val3 == 2) {
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
		withdrawal_count();
	}	
	page = $('#withdrawal_count').val()*27-27;
	start = '&start=' + page;
	text = '&text=' + $('#w_search').val();
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'withdrawal_check_f=1' + val + date + start + text,
		cache: false,
		success: function( data ) {

			data = JSON.parse(data);
			window.User = data;
			window.Wval = val3;
			var out = '';
			if (data.no_result != 1) {
				if ($('#withdrawal_val').val() == 0 || $('#withdrawal_val').val() == 2) {
					for (var id in data) {
						out+=`<div class="col-md-6 col-xl-4 wow fadeInRight" id="w${data[id].id}"><article class="quote-modern quote-modern-custom"><div class="unit unit-spacing-md align-items-center"><div class="unit-body">`;
						out+=`<h4 class="quote-modern-cite"><a href="#">${data[id].title}</a></h4><p class="quote-modern-status">${data[id].input_date}</p></div></div>`;
						out+=`<div class="quote-modern-text"><p class="q">${data[id].text}</p></div><button class="button button-primary" onclick="withdrawal_checked(${data[id].id}, 1)">Подтвердить</button><button class="button button-primary" onclick="withdrawal_checked(${data[id].id}, 2)">Отменить</button></article></div>`;
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
			
			
			$('#withdrawal_out').html(out);


		}

	}

	);
	
}

function withdrawal_count() {
	val = '&val=' + $('#withdrawal_val').val();
	date = '&date=' + $('#withdrawal_date').val();
	text = '&text=' + $('#w_search').val();
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'withdrawal_count_f=1' + val + date + text,
		cache: false,
		success: function( data ) {
			if (data != 0) {
				var page_count = Math.ceil(data / 27);
				var i = 1;
				var out = '<label for="a_status">Страница</label><select id="withdrawal_count" class="form-control" onchange="withdrawal_check(5)" style="padding: 8px 30px;">';
				for (i = 1; i <= page_count; i++) {
					out+='<option>'+ i +'</option>';
				}
				out+= '</select>';
				$('#withdrawal_select').html(out);
			}
			else {
				$('#withdrawal_out').html('<h3>База пуста</h3>');
			}
		}

	}

	);
}

function withdrawal_checked (id, val) {
	id2 = '&id=' + id;
	val = '&val=' + val;
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'withdrawal_checked_f=1' + id2 + val,
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

function go( url ) {
	window.location.href='/' + url;
}

$(document).ready(function() {
	withdrawal_check(0);
});