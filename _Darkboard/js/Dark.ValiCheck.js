var DarkValiCheck = function(frm) {
	if(frm.submitOK != null && frm.submitOK.value.trim() == 'Y') {
		return false;
	}
	else {
		if(frm.submitOK == null) {
			var AddEl = document.createElement("input");
			AddEl.name = "submitOK";
			AddEl.value = "N";
			AddEl.style.display = "none";
			frm.appendChild(AddEl);
			//alert(frm.submitOK);
		}

		//return;

		if(frm.submitOK.value.trim() == "N") {
			//alert();
			var inputEl = frm.getElementsByTagName("*");
			for(var i = 0 ; i < inputEl.length ; i++) {
				if(inputEl[i].getAttribute("check") != null && inputEl[i].getAttribute("check") == "Y") {
					if(inputEl[i].getAttribute("type") == "checkbox" || inputEl[i].getAttribute("type") == "radio") {
						//var totalInput = document.getElementsByName(inputEl[i].getAttribute("name"));
						var totalInput = frm.querySelectorAll("input[name='" + inputEl[i].getAttribute("name") + "']");
						var k = 0
						for(var j = 0 ; j < totalInput.length ; j++) {
							if(totalInput[j].checked == true) {
								k++;
							}
						}
						if(k <= 0) {
							if(inputEl[i].getAttribute("type") == "checkbox") {
								alert(inputEl[i].getAttribute("outText") + "에 체크해주세요.");
							}
							else {
								alert(inputEl[i].getAttribute("outText") + "을(를) 선택해주세요.");
							}
							inputEl[i].focus();
							return false;
						}
					}
					/*
					if(inputEl[i].getAttribute("type") == "checkbox") {
						var checkInput = document.getElementsByName(inputEl[i].getAttribute("name"));
						var k = 0
						for(var j = 0 ; j < checkInput.length ; j++) {
							if(checkInput[j].checked == true) {
								k++;
							}
						}
						if(k <= 0) {
							alert(inputEl[i].getAttribute("outText") + "을(를) 체크해주세요.");
							inputEl[i].focus();
							return false;
						}
					}
					else if(inputEl[i].getAttribute("type") == "radio") {
						var radioInput = document.getElementsByName(inputEl[i].getAttribute("name"));
						//alert(radioInput.length);
						var k = 0
						for(var j = 0 ; j < radioInput.length ; j++) {
							if(radioInput[j].checked == true) {
								k++;
							}
						}
						if(k <= 0) {
							alert(inputEl[i].getAttribute("outText") + "을(를) 선택해주세요.");
							inputEl[i].focus();
							return false;
						}
					}
					*/
					else if(inputEl[i].value.trim() == "") {
						if(inputEl[i].tagName == "SELECT") {
							alert(inputEl[i].getAttribute("outText") + "을(를) 선택해주세요.");
						}
						if(inputEl[i].getAttribute("type") == "file") {
							alert(inputEl[i].getAttribute("outText") + "의 파일을 선택해주세요.");
						}
						else {
							alert(inputEl[i].getAttribute("outText") + "을(를) 입력해주세요.");
						}
						inputEl[i].focus();
						return false;
					}
				}

				if(inputEl[i].getAttribute("type") == "file" && inputEl[i].value.trim() != "") {
					var allowType = ['jpg', 'JPG', 'jpeg', 'JPEG', 'gif', 'GIF', 'png', 'PNG', 'zip', 'ZIP', 'doc', 'DOC', 'hwp', 'HWP', 'xml', 'XML', 'xlsx', 'XLSX', 'ppt', 'PPT', 'pptx', 'PPTX', 'pdf', 'PDF', 'ico', 'ICO'];
					var filename = inputEl[i].value.trim();
					var type = filename.split(".")[filename.split(".").length-1];

					if(allowType.indexOf(type) === -1) {
						alert(inputEl[i].getAttribute("outText") + "의 확장자형식( ." + type + " )은 업로드 할 수 없습니다.");
						return false;
					}
				}
			}
			return true;
		}
		else {
			return false;
		}
	}
}