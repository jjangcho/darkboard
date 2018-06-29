<?
	include_once(dirname(__FILE__).'/dark_common_DB.php');

	class dark_board_LIB extends dark_common_DB {
		function get_homepageInfo($h_idx) {
			echo $_SERVER['HTTP_HOST'];
			$_http_host = explode(':', $_SERVER['HTTP_HOST']);
			if(empty($h_idx)) {
			}
			else {
			}
			//$this->_DBopen();
			//$sql = "SELECT * FROM darkboard_homepage WHERE h_idx='".$h_idx."'";
			$sql = "SELECT * FROM darkboard_homepage WHERE h_idx=:h_idx";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':h_idx', $h_idx, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetchAll();
			//$this->_DBclose();
			return $result;
			//echo $this->$dbh->query("SELECT * FROM darkboard_homepage WHERE h_idx='1'");
		}
	}
?>