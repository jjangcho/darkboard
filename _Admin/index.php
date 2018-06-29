<?
	//include(dirname(__FILE__).'/_Darkboard/config/db_info.php');
	//$conn = new PDO("mysql:host=$_db_host;dbname=$_db_name", $_db_user, $_db_pass);
	//$conn->query("SET NAMES '".$_db_charset."'");
	//exit;
	$_home_type = 'Admin';
	$_darkboard_path = '../_Darkboard';	// 다크보드 경로
	include_once($_darkboard_path.'/config/darkboard_setting.php'); // 기본값 세팅

	include_once($_darkboard_root.'/admin/lib/dark_admin_common_LIB.php');
	$_ADMIN_COMMON_CLS->admin_page_load();
	
	//print_r($_COMMON_LIB->get_allHomepageInfo('hugmom'));
?>