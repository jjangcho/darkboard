function DarkGetCookie(Name) {
	var search = Name + '=';
	if (document.cookie.length > 0){	// if there are any cookies
		offset = document.cookie.indexOf(Name);
		if (offset != -1){	// if cookie exists
			offset += search.length;	// set index of beginning of value
			end = document.cookie.indexOf(';', offset);	// set index of end of cookie value
			if (end == -1) end = document.cookie.length;
			return unescape(document.cookie.substring(offset, end));
		}
		else{
			return false;
		}
	}
	else{
		return false;
	}
}

function DarkSetCookie(Name, value, expire) {	// expire 값을 설정 안하거나 0값이면 브라우져 종료시 삭제됨
	var today = new Date();
	today.setTime( today.getTime() + (1000 * 60 * 60 * 24 * parseInt(expire)) );
	//alert(((expire == null || parseInt(expire) == 0) ? '' : (' expires=' + today.toGMTString() + ';')));
	document.cookie = Name + '=' + escape(value) + '; path=/;' + ((expire == null || parseInt(expire) == 0) ? '' : (' expires=' + today.toGMTString() + ';'));
}

function DarkDeleteCookie(Name) {
	var expireDate = new Date();
	//어제 날짜를 쿠키 소멸 날짜로 설정한다.
	expireDate.setDate( expireDate.getDate()-1 );
	document.cookie = Name + "=" + "; path=/; expires=" + expireDate.toGMTString() + ";";
}

function DarkSetTopScroll() {
	DarkSetCookie("prev2ScrollTop", DarkGetCookie("prevScrollTop"));
	DarkSetCookie("prevScrollTop", DarkGetCookie("RecentScrollTop"));
	jQuery(window).scroll(function() {
		DarkSetCookie("RecentScrollTop", jQuery(document).scrollTop());
	});
}
