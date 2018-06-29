<?
	include_once(dirname(__FILE__).'/dark_db_LIB.php');

	class dark_init_LIB extends dark_db_LIB {
		// 초기 변수 및 환경 설정.
		function __construct() {
			foreach ($_GET as $k => $v) {
				$_GET[$k] = $this->protectInjectionXss($v);
			}
			foreach ($_POST as $k => $v) {
				$_POST[$k] = $this->protectInjectionXss($v);
			}
			foreach ($_REQUEST as $k => $v) {
				$_REQUEST[$k] = $this->protectInjectionXss($v);
			}
			foreach ($_COOKIE as $k => $v) {
				$_COOKIE[$k] = $this->protectInjectionXss($v);
			}
			$this->get_homepageInfo($_REQUEST['h_idx']);
			$this->get_memberInfo();
		}

		// 홈페이지 정보 로드 및 변수 세팅
		protected function get_homepageInfo($h_idx) {
			$this->_DBopen();
			if(empty($h_idx)) {
				$sql = "
					SELECT
						t1.*
						,SUM(t3.num) AS logTotal
						,SUM(t4.num) AS logTodayTotal
					FROM darkboard_homepage AS t1
					LEFT JOIN darkboard_domain AS t2 ON t2.h_idx=t1.h_idx
					LEFT JOIN darklog_total AS t3 ON t3.h_idx=t1.h_idx
					LEFT JOIN darklog_total AS t4 ON t4.h_idx=t1.h_idx AND t4.wdate=:toDay
					WHERE t2.dm_name=:DomainName
					GROUP BY NULL
					LIMIT 1
				";
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':DomainName', $_SERVER['HTTP_HOST'], PDO::PARAM_STR);
				$stmt->bindParam(':toDay', $toDay = date("Y-m-d", time()), PDO::PARAM_STR);
			}
			else {
				$sql = "
					SELECT
						t1.*
						,SUM(t2.num) AS logTotal
						,SUM(t3.num) AS logTodayTotal
					FROM darkboard_homepage AS t1
					LEFT JOIN darklog_total AS t2 ON t2.h_idx=t1.h_idx
					LEFT JOIN darklog_total AS t3 ON t3.h_idx=t1.h_idx AND t3.wdate=:toDay
					WHERE t1.h_idx=:hIdx
					GROUP BY NULL
					LIMIT 1
				";
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':hIdx', $h_idx, PDO::PARAM_STR);
				$stmt->bindParam(':toDay', $toDay = date("Y-m-d", time()), PDO::PARAM_STR);
			}
			$stmt->execute();
			//$result = $stmt->fetchAll(PDO::FETCH_ASSOC);	// 여러개 (형식 배열)
			//$result = $stmt->fetchObject();	// 한개 (형식 구조체)
			$result = $stmt->fetch(PDO::FETCH_ASSOC);	// while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {} 형식으로 사용가능.

			if(empty($result)) {
				$stmt = null;
				$sql = "
					SELECT
						t1.*
						,SUM(t2.num) AS logTotal
						,SUM(t3.num) AS logTodayTotal
					FROM darkboard_homepage AS t1
					LEFT JOIN darklog_total AS t2 ON t2.h_idx=t1.h_idx
					LEFT JOIN darklog_total AS t3 ON t3.h_idx=t1.h_idx AND t3.wdate=:toDay
					WHERE t1.h_idx=:hIdx
					GROUP BY NULL
					LIMIT 1
				";
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':hIdx', $h_idx = '1', PDO::PARAM_STR);
				$stmt->bindParam(':toDay', $toDay = date("Y-m-d", time()), PDO::PARAM_STR);
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC);	// 한개
			}

			$this->_DBclose();
			//print_r($result);
			//exit;
			//return;

			foreach($result as $key => $value) {
				//echo $value;
				$value = stripslashes($value);
				$result[$key] = $value;
			}

			//global $_h_idx;
			global $_darkboard_home;
			global $_darkboard_root;
			global $_homepage_home;
			global $_homepage_root;
			global $_index_page;
			global $_homepageInfo;
			global $_home_type;

			$_darkboard_home = $result['darkboard_path'];
			$_darkboard_root = $_SERVER['DOCUMENT_ROOT'].$_darkboard_home;

			if($_home_type == 'Mobile' && !empty($result['mobile_index'])) {
				$_homepage_home = $result['mobile_path'];	// 홈페이지 루트
				$_index_page = $result['mobile_index'];	// 인덱스 페이지 명.
				$_loginPage_url = $_index_page.'?'.$result['mobile_login_path'];	// 로그인 페이지
			}
			else if($_home_type == 'Admin') {
				$_homepage_home = $result['darkboard_path'].'/admin';	// 홈페이지 루트
				$_index_page = $result['admin_index'].'?h_idx='.(empty($h_idx) ? '1' : $h_idx);
			}
			else {
				$_homepage_home = $result['home_path'];	// 홈페이지 루트
				$_index_page = $result['home_index'];	// 인덱스 페이지 명.
				$_loginPage_url = $_index_page.'?'.$result['home_login_path'];	// 로그인 페이지
			}
			$_homepage_root = $_SERVER['DOCUMENT_ROOT'].$_homepage_home;

			//$result->domain_name =

			//print_r($result);

			//$result->unserial_home_type = unserialize($result->home_type);

			$_homepageInfo = $result;
			//$this->_DBclose();
		}

		// 회원정보 로드
		protected function get_memberInfo() {
			global $_memberInfo;
			global $_homepageInfo;

			//$this->conn->null;
			$this->_DBopen();

			$whereis = "WHERE t1.m_idx='".$_SESSION['login_idx']."'";
			if($_SESSION['login_type'] != 'A') {
				$whereis .= " AND (t1.h_idx='".$_homepageInfo['h_idx']."'";
				$sql = "SELECT h_idx FROM darkboard_homepage WHERE member_type='TOTAL'";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$whereis .= " OR t1.h_idx='".$row['h_idx']."'";
				}
				$whereis .= ")";
			}
			//print_r($whereis);

			$sql = "
				SELECT
					t1.*
				FROM darkboard_member AS t1
				".$whereis."
			";
			try {
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e) {
				echo "login info error / ".$e;
			}

			//if($_SESSION['login_type'] != 'A' || $_SESSION['login_level'] != '1') {
			//	$row['user_pass'] = '****';
			//}

			$_memberInfo = $row;

			$this->_DBclose();
		}

		// 인젝션 공격을 막기위한 통신상의 변수 변조.
		function protectInjectionXss($string) {
			$string = trim($string);
			$string = str_replace("'","",$string);
			//$string = str_replace("\\","",$string);
			$string = str_replace("\"","",$string);
			$string = str_replace("<","",$string);
			$string = str_replace(">","",$string);
			$string = str_replace("(","",$string);
			$string = str_replace(")","",$string);
			return $string;
		}
	}
?>
