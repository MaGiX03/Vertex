function send_review(data) {

	$('.titleHelp').html('<label>Загрузка..</label>')
	var str = '';

	$.each( data.split('.'), function(k, v) {
		str += '&' + v + '=' + $('#' + v).val();
	} );

	$.ajax(

	{
		url : '/function',
		type: 'POST',
		data: 'send_review_f=1' + str,
		cache: false,
		success: function( result ) {

			obj = jQuery.parseJSON( result );

			if (obj.go) go(obj.go);
			
			else if(obj.message) {
				$('.titleHelp').html('<label style="color:red;">'+ obj.message +'</label>')
			}
			else if (obj.s_message) {
				$('.titleHelp').html('<label style="color:green;">'+ obj.s_message +'</label>')
			}

		}

	}

	);

}




function go( url ) {
	window.location.href='/' + url;
}