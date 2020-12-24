function logs_check () {
	val = '&val=' + $('#logs_val').val();
	val2 = '&val2=' + $('#date_order').val();
	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'logs_check_f=1' + val + val2,
		cache: false,
		success: function( data ) {

			data = JSON.parse(data);

			if (data.go) go(data.go);
			var out='<table class="table"><thead><tr><th scope="col">Тип</th><th scope="col">Описание</th><th scope="col">Дата</th></tr></thead><tbody>';
			if (data.no_result != 1) {
				for (var id in data) {
					/*out+=`<div class="col-md-12 col-xl-12 wow fadeInRight"><article class="quote-modern quote-modern-custom"><div class="unit unit-spacing-md align-items-center"><div class="unit-body">`;
					out+=`<h4 class="quote-modern-cite"><a href="#">${data[id].title}</a></h4><p class="quote-modern-status">${data[id].input_date}</p></div></div>`;
					out+=`<div class="quote-modern-text"><p class="q">${data[id].text}</p></div></article></div>`;*/
					out+=`<tr>
					<th scope="row">${data[id].title}</th>
					<td>${data[id].text}</td>
					<td>${data[id].input_date}</td>
					</tr>`;
				}
				out+='</tbody></table>'
			}
			else {
				out+='<h3>История пуста</h3>';
			}
			
			
			$('#logs_out').html(out);


		}

	}

	);
	
}

$(document).ready(function() {
	logs_check();
});

function go( url ) {
	window.location.href='/' + url;
}