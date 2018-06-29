<?
	include_once(dirname(__FILE__).'/session_config.php');
	include_once(dirname(__FILE__).'/../lib/dark_init_LIB.php');
	include_once(dirname(__FILE__).'/../lib/dark_common_LIB.php');

	//$_SESSION['test'] = 'asfs';

	//$_h_idx = null;
	$_darkboard_home = null;
	$_darkboard_root = null;
	$_homepage_home = null;
	$_homepage_root = null;
	$_index_page = null;
	$_homepageInfo = null;
	$_memberInfo = null;

	$_INIT_CLS = new dark_init_LIB();
	$_COMMON_CLS = new dark_common_LIB();
	//$_INIT_LIB->get_homepageInfo('2');	// 홈페이지 정보
	//print_r($_COMMON_CLS->get_allHomepageInfo());
	

	//$_REQUEST['h_idx'] = empty($_REQUEST['h_idx']) ? $_homepageInfo['h_idx'] : $_REQUEST['h_idx'];	// 홈페이지 번호 세팅
	//$_COMMON_LIB->_DBopen();
?>