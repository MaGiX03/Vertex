function reviews_check (val) {
	val2 = '&val=' + val;
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'reviews_check_f=1' + val2,
		cache: false,
		success: function( data ) {

			data = JSON.parse(data);
			var out = '';
			if (data.no_result != 1) {

				for (var id in data) {
					out+=`<div class="col-md-6 col-xl-4 wow fadeInRight" id="r${data[id].id}"><article class="quote-modern quote-modern-custom"><div class="unit unit-spacing-md align-items-center"><div class="unit-body">`;
					out+=`<h4 class="quote-modern-cite"><a href="#">${data[id].name}</a></h4><p class="quote-modern-status">${data[id].input_date}</p></div></div>`;
					out+=`<div class="quote-modern-text"><textarea class="form-control" id="text${data[id].id}">${data[id].text}</textarea></div><button class="button button-primary" onclick="review_checked(${data[id].id},0,${val})">Подтвердить</button><button class="button button-primary" onclick="review_checked(${data[id].id},1,${val})">Удалить</button></article></div>`;
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

function review_checked(id,val, val2) {
	val1 = '&val=' + val;
	id2 = '&id=' + id;
	text = '&text=' + $('#text' + id).val();

	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'review_checked_f=1' + val1 + id2 + text,
		cache: false,
		success: function( data ) {
			if (data == 1 && val2 == 0) {
				$('#r'+id).remove();
			}
			else if (val2 == 1 && val == 1) {
				$('#r'+id).remove();
			}
			else if (val2 == 1 && val == 0) {
				alert('Успешно изменено');
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
	reviews_check(0);
});