function guests_check () {
	val = '&val=' + $('#guest_type').val();
	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'guests_check_f=1' + val,
		cache: false,
		success: function( data ) {

			data = JSON.parse(data);
			if (data.go) go(data.go);
			var out = '';
			for (var id in data) {
				if (data[id].involvement == 1) data[id].involvement = '★ ✩ ✩ ✩';
				else if (data[id].involvement == 2) data[id].involvement = '★ ★ ✩ ✩';
				else if (data[id].involvement == 3) data[id].involvement = '★ ★ ★ ✩';
				else if (data[id].involvement == 4) data[id].involvement = '★ ★ ★ ★';
				out+=`<li class="list-group-item"><h5>${data[id].name} | ${data[id].number} | ${data[id].involvement} | ${data[id].reg_time}</h5></li></ul>`;
			}
			$('#refs_out').html(out);


		}

	}

	);

}

function auto_active_check () {

	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'auto_active_check_f=1' ,
		cache: false,
		success: function( data ) {

			if (data == 1) {
				guests_check();
			}
			else {
				$('#active_check').html('<h4>Вам не доступна автоворонка, так как вы не активированы</h4>')
			}
		}

	}

	);

}

function auth_check () {
	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'auth_check_f=1',
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
	auth_check ();
	auto_active_check ();
	
});