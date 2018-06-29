<?
	include(dirname(__FILE__).'/db_info.php');

	try {
		$hostname = "...."; // 서버 주소
		$port = 1433; // 포트번호
		$dbname = "..."; // 대상 DB명
		$username = "..."; // DB 계정
		$pw = "..."; // 패스워드
		$dbh = new PDO ("dblib:host=$hostname:$port;dbname=$dbname","$username","$pw");
		$dbh->query("SET NAMES 'utf8'");
	} catch (PDOException $e) {
		 echo "Failed to get DB handle: " . $e->getMessage() . "\n";
		 exit;
	}

?>