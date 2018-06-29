	<?
		/*
		class test extends dark_db_LIB {
			function test111() {
				$this->_DBopen();
		
				$sql = "
					SELECT
						t1.*
						,SUM(t2.num) AS logTotal
						,SUM(t3.num) AS logTodayTotal
					FROM darkboard_homepage AS t1
					LEFT JOIN darklog_total AS t2 ON t2.h_idx=t1.h_idx
					LEFT JOIN darklog_total AS t3 ON t3.h_idx=t1.h_idx AND t3.wdate='".date("Y-m-d", time())."'
					WHERE t1.h_idx <> '1'
					GROUP BY t1.h_idx
				";

				$res = $this->conn->query($sql);
				$db_result = $this->conn->errorInfo();
				if($db_result[0] == '00000') {
					while($row = $res->fetch(PDO::FETCH_ASSOC)) {
						//print_r($row);
					}
				}
				else {
					$result = $this->conn->errorInfo();
				}
			}
		}

		$ttt = new test();
		$ttt->test111();
		*/
		/*
		$temp = new dark_db_LIB();
		$temp->_DBopen();
		
				$sql = "
					SELECT
						t1.*
						,SUM(t2.num) AS logTotal
						,SUM(t3.num) AS logTodayTotal
					FROM darkboard_homepage AS t1
					LEFT JOIN darklog_total AS t2 ON t2.h_idx=t1.h_idx
					LEFT JOIN darklog_total AS t3 ON t3.h_idx=t1.h_idx AND t3.wdate='".date("Y-m-d", time())."'
					WHERE t1.h_idx <> '1'
					GROUP BY t1.h_idx
				";

			$res = $temp->conn->query($sql);
			$db_result = $temp->conn->errorInfo();
			if($db_result[0] == '00000') {
				while($row = $res->fetch(PDO::FETCH_ASSOC)) {
					print_r($row);
				}
			}
			else {
				$result = $temp->conn->errorInfo();
			}
		*/
	?>


	<div id="LoginBox">
		<h1 id="admin_logo"><?=$_homepageInfo['home_name']?> 관리자<!--img src="<?=$_homepage_home?>/darkboard/admin/images/header_logo.gif" /--></h1>

		<div id="admin_login_box">
			<strong>Login</strong>
			<span>Login</span>
			<form action="<?=$_darkboard_home?>/admin/php/admin_login_proc.php" method="post" id="login_form" name="login_form" target="<?=$_target?>" enctype="multipart/form-data" onsubmit="return false;">
			<input type="hidden" name="h_idx" value="<?=$_REQUEST['h_idx']?>" />
			<input type="hidden" id="go_url" name="go_url" value="<?=$_this_page_url?>">
			<table>
				<tr>
					<th>아이디 : </th>
					<td><input type="text" name="user_id" check="Y" outText="아이디" alt="아이디" tabindex="1"></td>
					<td class="buttonTD" rowspan="2"><input type="submit" value="로그인" alt="아이디" tabindex="4" onclick="javascript:LoginFormCheck(this.form);"></td>
				</tr>
				<tr>
					<th>비밀번호 : </th>
					<td><input type="password" name="user_pass" check="Y" outText="비밀번호" alt="비밀번호" tabindex="2"></td>
				</tr>
				<tr>
					<td colspan="3"><input type="checkbox" name="save_id" alt="아이디저장" tabindex="3"> 아이디 저장</td>
				</tr>
				<tr>
					<td colspan="3"><input type="checkbox" name="auto_login" onchange="DarkConfirmSave(this,'이 기기에 아이디/패스워드 정보를 저장하시겠습니까? 타인의 기기에서는 개인정보가 유출될 수 있으니 주의해주십시오.');" alt="자동로그인" tabindex="3"> 자동 로그인</td>
				</tr>
			</table>
			<input type="radio" name="upfile" check="Y" outText="업로드파일" />
			<input type="radio" name="upfile" />
			<input type="radio" name="upfile" />
			</form>
		</div>
	</div>
	<script src="<?=$_darkboard_home?>/js/Dark.AutoLogin.js" type="text/javascript" ></script>
	<script type="text/javascript">
		//### 밸리데이션 체크
		function LoginFormCheck(a) {
			var formCheck = new DarkValiCheck(a);
			if(!formCheck) {
				return false;
			}
			else {
				DarkLoginCheck(a);
				//darkboardFormSubmit(a);
				return false;
			}
		}
		// 밸리데이션 체크

		function loginBoxInit(onfocus) {
			var LayerOb = document.getElementById("LoginBox");
			var LayerW = parseInt(jQuery(LayerOb).css("width").replace("px",""));
			var LayerH = parseInt(jQuery(LayerOb).css("height").replace("px",""));
			var LayerT = 0;
			var LayerL = 0;
			if(onfocus == null || onfocus == "") {
				onfocus = 'Y';
			}

			if(LayerH < (jQuery(window).innerHeight() || window.innerHeight || document.body.clientHeight)){
				LayerT = (((jQuery(window).innerHeight() || window.innerHeight || document.body.clientHeight) - LayerH) / 2) + (jQuery(window).scrollTop() || document.body.scrollTop);
			}
			else {
				LayerT = (jQuery(window).scrollTop() || document.body.scrollTop);
			}

			if(LayerW < (jQuery(window).innerWidth() || window.innerWidth || document.body.clientWidth)){
				LayerL = (((jQuery(window).innerWidth() ||window.innerWidth || document.body.clientWidth) - LayerW) / 2) + (jQuery(window).scrollLeft() || document.body.scrollLeft);
			}
			else {
				LayerL = (jQuery(window).scrollLeft() || document.body.scrollLeft);
			}

			jQuery(LayerOb).css({"position":"absolute","top":LayerT+"px","left":LayerL+"px","margin":"0"});

			if(onfocus == 'Y') {
				if(jQuery(LayerOb).find("input[type!='hidden']").eq(0) != null) {
					jQuery(LayerOb).find("input[type!='hidden']").eq(0).focus();
				}
			}
		}


		jQuery(document).ready(function(){
			DarkGetLogin('login_form');
			loginBoxInit();
		});

		jQuery(window).resize(function(){
			loginBoxInit("N");
		});
		//console.log(document.cookie);
	</script>

</html>