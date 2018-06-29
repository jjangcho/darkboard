<?
	include_once(dirname(__FILE__).'/../../lib/dark_db_LIB.php');

	class dark_admin_common_LIB extends dark_db_LIB {

		function admin_page_load() {
			global $_darkboard_home;
			global $_darkboard_root;
			global $_homepage_home;
			global $_homepage_root;
			global $_index_page;
			global $_homepageInfo;
			global $_memberInfo;
			global $_home_type;

			global $_INIT_CLS;
			global $_COMMON_CLS;

			include ($_darkboard_root.'/admin/include/header.php');	// html의 <head> 부분

			if($_memberInfo['type'] == 'A') {
				include ($_darkboard_root.'/admin/include/body_top.php');	// <body>의 상단부분.

				if(darkboardAdminCheck(true)) {	// 페이지별 관리자 권한 체크
					if(!empty($_boardInfo['board_id']) && !empty($_REQUEST['b_type'])) {
						include_once($_darkboard_root.'/lib/darkboard.BoardFunction.php');	// 게시판 관련 함수
						echo darkboardBoardLoad($_REQUEST['b_idx'], $_REQUEST['b_type'], 'main');
					}
					else if(!empty($_REQUEST['b_idx']) && !empty($_REQUEST['b_type']) && is_file($_darkboard_root.'/admin/subpage/'.$_REQUEST['b_idx'].'_'.$_REQUEST['b_type'].'.php')) {
						include($_darkboard_root.'/admin/subpage/'.$_REQUEST['b_idx'].'_'.$_REQUEST['b_type'].'.php');
					}
					else if(empty($_REQUEST['b_idx']) && !empty($_REQUEST['b_type']) && is_file($_darkboard_root.'/admin/subpage/'.$_REQUEST['b_type'].'.php')) {
						include($_darkboard_root.'/admin/subpage/'.$_REQUEST['b_type'].'.php');
					}
					else if($_memberInfo['level'] == '10' && file_exists($_darkboard_root.'/admin/subpage/eap_contents_list.php')) {
						include($_darkboard_root.'/admin/subpage/eap_contents_list.php');
					}
					else if(file_exists($_darkboard_root.'/admin/subpage/main.php')) {
						include($_darkboard_root.'/admin/subpage/main.php');
					}
					else {
						echo "<div style=\"width:100%; height:150px; text-align:center; vertical-align:middle; font-size:20px; padding-top:100px; font-weight:bold;\">존재하지 않는 페이지입니다.</div>";
					}
				}
				else {
					echo "<div style=\"width:100%; height:150px; text-align:center; vertical-align:middle; font-size:20px; padding-top:100px; font-weight:bold;\">접근 권한이 없습니다.</div>";
				}

				include ($_darkboard_root.'/admin/include/body_bottom.php');	// <body>의 하단부분
			}
			else {
				//echo $_memberInfo['type'].'sfaf';
				include ($_darkboard_root.'/admin/subpage/login.php');	// 로그인 페이지
			}

			include ($_darkboard_root.'/admin/include/footer.php');	// html의 <head> 부분
		}
	}

	$_ADMIN_COMMON_CLS = new dark_admin_common_LIB();
?>