function DarkConfirmSave(checkbox, msg) {
	var isRemember;

	if(checkbox.checked) {
		isRemember = confirm(msg);
		if(!isRemember) checkbox.checked = false;
	}
}

/*
function DarkSetsave(name, value, expiredays) {
	var today = new Date();
	today.setDate( today.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + today.toGMTString() + ";"
}
*/

function DarkAutoLogin(form) {
	// 쿠키 값을 30일간 저장
	if(form.save_id != null && form.save_id.checked) {
		if(form.auto_login != null && form.auto_login.checked) {
			DarkSetCookie("userid", form.user_id.value, 30);
			DarkSetCookie("userpw", form.user_pass.value, 30);
		}
		else {
			alert(form.user_id.value);
			DarkSetCookie("userid", form.user_id.value, 30);
			DarkSetCookie("userpw", "", -1);
		}
	}
	else {
		if(form.auto_login != null && form.auto_login.checked) {
			DarkSetCookie("userid", form.user_id.value, 30);
			DarkSetCookie("userpw", form.user_pass, 30);
		}
		else {
			DarkSetCookie("userid", "", -1);
			DarkSetCookie("userpw", "", -1);
		}
	}
}


function DarkGetLogin(form_id) {
	var f = document.getElementById(form_id);
  // userid 쿠키에서 id,pw 값을 가져온다.
	var cook = document.cookie + ";";
	var idx = cook.indexOf("userid", 0);
	var idx2 = cook.indexOf("userpw", 0);
	var begin = "";
	var begin2 = "";
	var end = "";
	var end2 = "";
	var val = "";
	var val2 = "";

	if(idx != -1) {
		cook1 = cook.substring(idx, cook.length);
		begin = cook1.indexOf("=", 0) + 1;
		end = cook1.indexOf(";", begin);
		val = unescape( cook1.substring(begin, end) );
	}
	if(idx2 != -1) {
		cook2 = cook.substring(idx2, cook.length);
		begin2 = cook2.indexOf("=", 0) + 1;
		end2 = cook2.indexOf(";", begin2);
		val2 = unescape(cook2.substring(begin2, end2) );
	}

	// 가져온 쿠키값이 있으면
	if(val!= "" && val2!= "") {
		f.user_id.value = val;
		if(f.save_id != null) {
			f.save_id.checked = true;
		}
		if(f.auto_login != null) {
			f.user_pass.value = val2;
			f.auto_login.checked = true;
			var auto_check = confirm("자동로그인을 하시겠습니까?");
			if(auto_check) {
				f.submit();
			}
			else {
				f.auto_login.checked = false;
				f.user_pass.value = "";
				f.user_pass.focus();
			}
		}
		else {
			f.user_pass.focus();
		}
	}
	else if(val!= "") {
		f.user_id.value = val;
		if(f.save_id != null) {
			f.save_id.checked = true;
		}
		f.user_pass.focus();
	}
	else {
		if(f.save_id != null) {
			f.save_id.checked = false;
		}
		f.user_id.focus();
	}
}

function DarkLoginCheck(form) {
	DarkAutoLogin(form);
}