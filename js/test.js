function post_query( url, name, data ) {

	title = $('.titleHelp');
	if (name == 'test3') {
		title = $('.titleHelp2');
	}
	title.html('<label>Загрузка..</label>');

	var str = '';

	$.each( data.split('.'), function(k, v) {
		str += '&' + v + '=' + $('#' + v).val();
	} );
	

	$.ajax(

	{
		url : '/' + url,
		type: 'POST',
		data: name + '_f=1' + str,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if (obj.go) go(obj.go);

			else if ( obj.message ) {
				title.html('<label style="color:red;">' + obj.message + '</label>');
			}
			else if ( obj.s_message ) {
				title.html('<label style="color:green;">' + obj.s_message + '</label>');
			}

			else if ( obj.error_message ) {
				title.html('<label style="color:red;">Произошла ошибка, попробуйте ещё раз</label>');
			}

		}





	}

	);

}


function test() {

	const bcrypt = dcodeIO.bcrypt;  
	const salt = bcrypt.genSaltSync(10);
	const refIdToPost = `${Date.now()}`;
	const hash = bcrypt.hashSync(`${refIdToPost}bzHZwWDJwfFzdsfsJcNQ`, salt);  

	const str = '&str=' + hash;
	const str2 = '&salt=' + salt;
	const str3 = '&id=' + refIdToPost;


	$.ajax(

	{
		url : '/a_function',
		type: 'POST',
		data: 'test_f=1' + str + str2 + str3,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if (obj.go) go(obj.go);

			else if ( obj.message ) {
				title.html('<label style="color:red;">' + obj.message + '</label>');
			}
			else if ( obj.s_message ) {
				title.html('<label style="color:green;">' + obj.s_message + '</label>');
			}

			else if ( obj.error_message ) {
				title.html('<label style="color:red;">Произошла ошибка, попробуйте ещё раз</label>');
			}

		}





	}

	);

}