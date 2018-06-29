<?php
	abstract class dark_db_LIB {
		protected $conn = null;

		protected function _DBopen() {
			include(dirname(__FILE__).'/../config/db_info.php');

			$_db_charset = empty($_db_charset) ? 'utf8' : $_db_charset;
			$_db_host = ($_db_host == 'localhost') ? $_db_host : (empty($_db_port) ? '' : ':'.$_db_port);

			try {
				$this->conn = new PDO("mysql:host=$_db_host;dbname=$_db_name", $_db_user, $_db_pass);
				$this->conn->query("SET NAMES '".$_db_charset."'");
			}
			catch (PDOException $e) {
				echo "Failed to get DB handle: " . $e->getMessage() . "\n";
				exit;
			}
		}

		protected function _DBclose() {
			if($this->conn != null) {
				$this->conn = null;
			}
		}
	}
?>