
var ipAPI="http://ip-api.com/json/?callback=?";

function getCookie(name) {
	var regex = new RegExp("/^(?:.*;)?[ ]{0,1}"+name+"\s*=\s*([^;]+)(?:.*)?$/");
	var result = (document.cookie.match(regex)||[,null])[1];
	alert(result);
}

$(document).ready(function() {
	var ipTracker = Cookies.get('cubo-iptracker');
	if(!ipTracker) {
		$.getJSON(ipAPI,function(json) {
			Cookies.set('cubo-iptracker',json,{ expires: 7, path: '/' });
			alert('Called API!!!');
		});
	}
});