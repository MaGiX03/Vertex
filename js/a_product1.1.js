function add_tovar(val) {
	var formData = new FormData();
	if (val == 1) {
		var data = CKEDITOR.instances.add_text.getData();
		formData.append("p_img", $("#add_img")[0].files[0]);
		formData.append('p_add_f',1);
		formData.append('p_name',$("#add_name").val());
		formData.append('p_text',data);
		formData.append('val',val);
	}
	else {
		var data = CKEDITOR.instances.change_text.getData();
		formData.append("p_img", $("#change_img")[0].files[0]);
		formData.append('p_change_f',1);
		formData.append('p_id',$("#change_id").val());
		formData.append('p_name',$("#change_name").val());
		formData.append('p_text',data);
		formData.append('val',val);
	}
	$('.titleHelp').html('Загрузка');

	$.ajax(

	{
		url : '/a_function',
		contentType: false,
		processData: false,
		type: 'POST',
		data: formData,
		xhr: function(){
			var xhr = $.ajaxSettings.xhr();
			xhr.upload.onprogress = function(evt){ $('.titleHelp').html('Загружено ' + evt.loaded/1000000 + 'мб из ' + evt.total/1000000 + 'мб'); } ;
			return xhr ;
		},
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if ( obj.message ) {
				$('.titleHelp').html('<label style="color:red;">' + obj.message + '</label>');
			}
			else if ( obj.s_message ) {
				$('.titleHelp').html('<label style="color:green;">' + obj.s_message + '</label>');
				if (val == 1) {
					$('#change_id').append('<option value="'+obj.p_id+'" id ="co'+obj.p_id+'">'+ $("#add_name").val() +'</option>');
					$('#delete_id').append('<option value="'+obj.p_id+'" id ="do'+obj.p_id+'">'+ $("#add_name").val() +'</option>');
				}
				else {
					$('#co' + $("#change_id").val()).text($("#change_name").val());
					$('#do' + $("#change_id").val()).text($("#change_name").val());
				}

			}

			else if ( obj.error_message ) {
				$('.titleHelp').html('<label style="color:red;">Произошла ошибка, попробуйте ещё раз</label>');
			}
		},
	}
	);

}

function show_tovar() {
	id = '&id=' + $('#change_id').val();
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'show_tovar_f=1' + id,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			$('#change_name').val(obj.p_name);
			$('#change_text_place').html('<label for="change_text">Описание</label><textarea class="form-control" id="change_text" rows="3">' + obj.p_text + '</textarea><script>CKEDITOR.replace("change_text");</script>');


		}





	}

	);

}

function delete_tovar() {
	id2 = '&p_id=' + $('#delete_id').val();
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'p_delete_f=1' + id2,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if ( obj.message ) {
				$('.titleHelp').html('<label style="color:red;">' + obj.message + '</label>');
			}
			else if ( obj.s_message ) {
				$('.titleHelp').html('<label style="color:green;">' + obj.s_message + '</label>');
				$('#co' + $('#delete_id').val()).remove();
				$('#do' + $('#delete_id').val()).remove();
				
			}

			else if ( obj.error_message ) {
				$('.titleHelp').html('<label style="color:red;">Произошла ошибка, попробуйте ещё раз</label>');
			}

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
		$('#delete_tovar').slideToggle();
		$('#delete_tovar').text('Удалить');
		$('#add_tovar').text('Добавить ▼');
		$('#add_form').slideDown();
		$('#change_form').slideUp();
		$('#delete_form').slideUp();
	}
	if (val == 2) {
		$('#add_tovar').slideToggle();
		$('#add_tovar').text('Добавить');
		$('#delete_tovar').slideToggle();
		$('#delete_tovar').text('Удалить');
		$('#change_tovar').text('Изменить ▼');
		$('#change_form').slideDown();
		$('#add_form').slideUp();
		$('#delete_form').slideUp();
	}
	if (val == 3) {
		$('#add_tovar').slideToggle();
		$('#add_tovar').text('Добавить');
		$('#change_tovar').slideToggle();
		$('#change_tovar').text('Изменить');
		$('#delete_tovar').text('Удалить ▼');
		$('#delete_form').slideDown();
		$('#add_form').slideUp();
		$('#change_form').slideUp();
	}
	clear_titleHelp()

}


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

function users_count() {
	text = '&text=' + $('#search').val();
	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'users_sp_count_f=1' + text,
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


function show_user_sp(id) {
	var id2 = '&id=' + id;
	$.ajax(

	{
		url : '/a_function',
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
		url : '/a_function',
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

$(document).ready(function() {
	show_tovar();
	users_check(0);
	users_count();
});

