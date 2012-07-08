function deleteCookie(sCookie) {
	
	setCookie(sCookie, "", 0);
	
}

function getCookie(sName) {
	
	var i, sCName, y, arrCookies = document.cookie.split(";");
	
	for (i = 0; i < arrCookies.length; i++) {
		
		sCName = arrCookies[i].substr(0, arrCookies[i].indexOf("=") );
		sValue = arrCookies[i].substr( arrCookies[i].indexOf("=") + 1 );
		
		sCName = sCName.replace(/^\s+|\s+$/g, "");
		
		if (sCName == sName)
			return unescape(sValue);
			
	}
	
}

function setCookie(sName, value, intDays) {
	
	var objDate = new Date();
	
	objDate.setDate( objDate.getDate() + intDays );
	
	var sValue = escape(value) + ( (intDays == null) ? "" : "; expires=" + objDate.toUTCString() );
	
	document.cookie = sName + "=" + sValue;
	
}