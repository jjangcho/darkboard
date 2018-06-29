<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>

	<title><?=$_homepageInfo['home_name']?> 관리자</title>
	<?=(!empty($_homepageInfo['favicon']) ? '<link rel="shortcut icon" href="'.$_darkboard_home.$_homepageInfo['favicon'].'">' : '')?> <!-- 파비콘이 등록된 경우 파비콘 태그 출력 -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="Content-Type" content="text/javascript"/>
	<meta http-equiv="Content-Tpye" content="text/css"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>

	<!-- script -->
	<script src="<?=$_darkboard_home?>/js/jquery-1.11.3.min.js" type="text/javascript"></script>
	<script src="<?=$_darkboard_home?>/js/jquery-ui-1.9.2.custom.min.js" type="text/javascript" charset="utf-8"></script>
	<? include($_darkboard_root.'/js/Dark.jsLoad.php'); ?>

	<!-- css -->
	<link href="<?=$_darkboard_home?>/css/jquery-ui-1.7.2.custom.css" type="text/css" rel="stylesheet" media="screen" charset="utf-8"/>
	<link href="<?=$_darkboard_home?>/admin/css/admin.css" type="text/css" rel="stylesheet">

</head>

<body>
