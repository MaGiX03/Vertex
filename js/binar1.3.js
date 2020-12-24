function binar_check () {
	id = '&id=' + $('#uid').val();
	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'binar_check_f=1' + id,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if (obj.go) go(obj.go);

			if(obj.fol1 != 0) {
				$('.first-level-binar:eq(0) a').attr('href' ,'binar'+obj.fol1);
				$('.first-level-binar:eq(0) h5').html( obj.fol_1_login );
				$('.first-level-binar:eq(0)').addClass('left-active');
			}
			if(obj.fol2 != 0) {
				$('.first-level-binar:eq(1) a').attr('href' ,'binar'+obj.fol2);
				$('.first-level-binar:eq(1) h5').html(obj.fol_2_login);
				$('.first-level-binar:eq(1)').addClass('right-active');
			}
			if(obj.fol_1_1 != 0) {
				$('.second-level-binar:eq(0) a').attr('href' ,'binar'+obj.fol_1_1);
				$('.second-level-binar:eq(0) h5').html(obj.fol_1_1_login);
				$('.second-level-binar:eq(0)').addClass('left-active');
			}
			if(obj.fol_1_2 != 0) {
				$('.second-level-binar:eq(1) a').attr('href' ,'binar'+obj.fol_1_2);
				$('.second-level-binar:eq(1) h5').html(obj.fol_1_2_login);
				$('.second-level-binar:eq(1)').addClass('left-active');
			}
			if(obj.fol_2_1 != 0) {
				$('.second-level-binar:eq(2) a').attr('href' ,'binar'+obj.fol_2_1);
				$('.second-level-binar:eq(2) h5').html(obj.fol_2_1_login);
				$('.second-level-binar:eq(2)').addClass('right-active');
			}
			if(obj.fol_2_2 != 0) {
				$('.second-level-binar:eq(3) a').attr('href' ,'binar'+obj.fol_2_2);
				$('.second-level-binar:eq(3) h5').html(obj.fol_2_2_login);
				$('.second-level-binar:eq(3)').addClass('right-active');
			}
			if(obj.no_main != 0) {
				$('#main_name').text(obj.main_login);
				$('.back_butt').show();
			}

			$('#left_week_vp').text('Недельный объем: ' + obj.l_vp + ' sp');
			$('#left_total_vp').text('Общий объем: ' + obj.left_vp + ' sp');
			$('#l_fol_total').text('Кол-во партнёров: ' + obj.l_count);
			$('#l_fol_1').text('Start: ' + obj.l_start);
			$('#l_fol_2').text('Business: ' + obj.l_business);
			$('#l_fol_3').text('Premium: ' + obj.l_premium);

			$('#right_week_vp').text('Недельный объем: ' + obj.r_vp + ' sp');
			$('#right_total_vp').text('Общий объем: ' + obj.right_vp + ' sp');
			$('#r_fol_total').text('Кол-во партнёров: ' + obj.r_count);
			$('#r_fol_1').text('Start: ' + obj.r_start);
			$('#r_fol_2').text('Business: ' + obj.r_business);
			$('#r_fol_3').text('Premium: ' + obj.r_premium);



		}

	}

	);

}

function position_change () {
	$('.titleHelpP').html('<label>Загрузка..</label>');
	val = '&val=' + $('#pos_val').val();
	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'position_change_f=1' + val,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if (obj.go) go(obj.go);

			else if ( obj.message ) {
				$('.titleHelpP').html('<label style="color:red;">' + obj.message + '</label>');
			}
			else if ( obj.s_message ) {
				$('.titleHelpP').html('<label style="color:green;">' + obj.s_message + '</label>');
			}



		}
	}
	);
}

function b_user_search () {
	$('#users_out').html('<li class="list-group-item"><h5>Загрузка</h5></li>');
	val = '&aim=' + $('#search').val();
	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'b_user_search_f=1' + val,
		cache: false,
		success: function( data ) {
			if (data != 0) {
				data = JSON.parse(data);
				var out = '';
				for (var id in data) {
					out+=`<li class="list-group-item"><a href="binar${data[id].id}"><h5>${data[id].login}</h5></a></li>`;
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


function go( url ) {
	window.location.href='/' + url;
}

$(document).ready(function() {
	binar_check();
	
});