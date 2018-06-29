
	<script src="<?=$_darkboard_home?>/js/spin.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		String.prototype.trim = function() {
			return this.replace(/(^\s*)|(\s*$)/g, "");
		}

		String.prototype.replaceAll = function (str1, str2){
			var strTemp = this;
			strTemp = strTemp.split(str1).join(str2);
			return strTemp;
		}

		var _homepage_home = "<?=$_homepage_home?>"; // 홈페이지 루트 전역변수
		var _darkboard_home = "<?=$_darkboard_home?>"; // 홈페이지 루트 전역변수
		var _index_page = "<?=$_index_page?>";	// 인덱스 파일 네임.
		var _admin_index = "<?=$_admin_index?>";	// 관리자 인덱스 파일 경로.
		var _default_h_idx = "<?=$_homepageInfo['h_idx']?>";
		var _default_home_id = "<?=$_homepageInfo['home_id']?>";
		var _default_b_idx = "<?=$_REQUEST['b_idx']?>";
		//var _default_f_ca1 = "<?=$_REQUEST['f_ca1']?>";
		var _this_page_url = "<?=$_this_page_url?>";

		jQuery(document).ready(function(){
			var commonDiv = document.createElement("div");
			var commonTxt = "<iframe id=\"php_run\" name=\"php_run\" style=\"display:none;\"></iframe> <!--모듈 실행용-->\n";
			//commonTxt += "<div id=\"DarkPopupLoad\" name=\"DarkPopupLoad\" style=\"display:noned;\"></div> <!--모듈 실행용-->\n";
			//commonTxt += "<div id=\"DarkboardWait\" style=\"display:none; text-align:center;\"></div> <!--실행중 창 띄우기-->\n";
			commonTxt += "<div id=\"DarkboardWaitSpin\" style=\"width:50px; height:50px; display:none; text-align:center;\"></div> <!--실행중 창 띄우기-->\n";

			commonTxt += "<form id=\"DelCont\" name=\"DelCont\" method=\"post\" action=\"\" target=\"<?=$_target?>\">\n";
			commonTxt += "	<input type=\"hidden\" name=\"mod\" value=\"\" />\n";
			commonTxt += "	<input type=\"hidden\" name=\"b_idx\" value=\"<?=$_REQUEST['b_idx']?>\" />\n";
			commonTxt += "	<input type=\"hidden\" name=\"h_idx\" value=\"<?=$_REQUEST['h_idx']?>\" />\n";
			commonTxt += "	<input type=\"hidden\" name=\"no\" value=\"\" />\n";
			commonTxt += "	<input type=\"hidden\" name=\"no2\" value=\"\" />\n";
			commonTxt += "	<input type=\"hidden\" name=\"go_url\" value=\"\" />\n";
			commonTxt += "</form>\n";

			commonDiv.innerHTML = commonTxt;
			document.getElementsByTagName("body")[0].appendChild(commonDiv);
			//alert(document.getElementById("DelCont").b_idx.value);
			//alert(homepage_home+"/"+index_page+"/"+admin_index);

			var target = document.getElementById("DarkboardWaitSpin");
			var opts = {
				lines: 9 // The number of lines to draw
				, length: 10 // The length of each line
				, width: 5 // The line thickness
				, radius: 10 // The radius of the inner circle
				, scale: 1 // Scales overall size of the spinner
				, corners: 1 // Corner roundness (0..1)
				, color: 'blue' // #rgb or #rrggbb or array of colors
				, opacity: 0.25 // Opacity of the lines
				, rotate: 0 // The rotation offset
				, direction: 1 // 1: clockwise, -1: counterclockwise
				, speed: 1 // Rounds per second
				, trail: 60 // Afterglow percentage
				, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
				, zIndex: 10000 // The z-index (defaults to 2000000000)
				, className: 'spinner' // The CSS class to assign to the spinner
				, top: '50%' // Top position relative to parent
				, left: '50%' // Left position relative to parent
				, shadow: false // Whether to render a shadow
				, hwaccel: false // Whether to use hardware acceleration
				//, position: 'absolute' // Element positioning
			}
			new Spinner(opts).spin(target);
		});
		
	</script>
	
	<script src="<?=$_darkboard_home?>/js/Dark.ValiCheck.js" type="text/javascript"></script>
	<!--
	<script src="<?=$_darkboard_home?>/js/DarkCommonFunction.js" type="text/javascript"></script>
	<script src="<?=$_darkboard_home?>/js/DarkBoardFunction.js" type="text/javascript"></script>
	<script src="<?=$_darkboard_home?>/js/DarkPopupLoad.js" type="text/javascript"></script>
	-->
	<script src="<?=$_darkboard_home?>/js/Dark.Cookie.js" type="text/javascript"></script>

	<? echo $_COMMON_CLS->popup_load(); ?>