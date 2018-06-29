<?
	include_once(dirname(__FILE__).'/dark_db_LIB.php');

	class dark_common_LIB extends dark_db_LIB {
		function get_allHomepageInfo($home_id = '') {
			$this->_DBopen();

			if(!empty($home_id)) {
				$sql = "
					SELECT
						t1.*
						,SUM(t2.num) AS logTotal
						,SUM(t3.num) AS logTodayTotal
					FROM darkboard_homepage AS t1
					LEFT JOIN darklog_total AS t2 ON t2.h_idx=t1.h_idx
					LEFT JOIN darklog_total AS t3 ON t3.h_idx=t1.h_idx AND t3.wdate='".date("Y-m-d", time())."'
					WHERE t1.h_idx <> '1' AND t1.home_id='".$home_id."'
					GROUP BY t1.h_idx
					LIMIT 1
				";
				//$stmt = $this->conn->prepare($sql);
				//$stmt->bindParam(':hId', $home_id, PDO::PARAM_STR);
				//$stmt->bindParam(':toDay', $toDay = date("Y-m-d", time()), PDO::PARAM_STR);
			}
			else {
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
				//$stmt = $this->conn->prepare($sql);
				//$stmt->bindParam(':toDay', $toDay = date("Y-m-d", time()), PDO::PARAM_STR);
			}
			$res = $this->conn->query($sql);
			$db_result = $this->conn->errorInfo();
			if($db_result[0] == '00000') {
				while($row = $res->fetch(PDO::FETCH_ASSOC)) {
					//print_r($row);
					$result[$row['home_id']] = $row;
				}
			}
			else {
				$result = $this->conn->errorInfo();
			}

			//print_r($result);

			$this->_DBclose();
			return $result;
		}

		function popup_load() {
			global $_home_type;
			global $_darkboard_home;
			global $_darkboard_root;
			global $_homepageInfo;

			if(1 != 1 || !empty($_REQUEST['p_idx']) || $_REQUEST['preview_popup'] == 'Y' || (empty($_REQUEST['b_idx']) && empty($_REQUEST['b_type'])) || (empty($_REQUEST['b_idx']) && $_REQUEST['b_type'] == 'main')) {

				$this->_DBopen();
				$today = date('Y-m-d H:i:s');
				$whereis = " WHERE h_idx='".$_homepageInfo['h_idx']."'";
				if(!empty($_REQUEST['p_idx'])) {
					$whereis .= " AND p_idx='".$_REQUEST['p_idx']."'";
				}
				else {
					$whereis .= " AND home_type='".$_home_type."'";
					//if($_REQUEST['preview'] != 'Y') {
						$whereis .= " AND view_config='Y' AND ((from_date=to_date) OR (from_date<='".$today."' AND to_date>='".$today."')) ";
					//}
				}

				$sql = "
					SELECT
						*
					FROM darkboard_popup
					".$whereis."
				";

				//echo $sql;

				$res = $this->conn->query($sql);
				$db_result = $this->conn->errorInfo();
				if($db_result[0] == '00000') {

					$result = "<script type=\"text/javascript\">\n";

					$result .= "	var DarkPopUpDiv = null;\n";
					$result .= "	var DarkPopUpZindex = null;\n";
					$result .= "	var DarkPopUpHtml = \"\";\n";
					$result .= "	var DarkPopUp = new Array();\n";

					$counter = 0;

					while($popup_row = $res->fetch(PDO::FETCH_ASSOC)) {
						if(!empty($popup_row['contents'])) {
							$contents = $popup_row['contents'].trim();
							$contents = preg_replace('/\r\n|\r|\n/', '', $contents);
						}
						if(!empty($popup_row['up_img']) && file_exists($_darkboard_root.$popup_row['up_img'])) {
							$img_size = GetImageSize($_darkboard_root.$popup_row['up_img']);
							$filetype = substr($popup_row['up_img'],-4);
							if($filetype != '.swf' && $filetype != '.SWF') {
								if(!empty($popup_row['link_url'])) {
									$view_img = "<a href='".$popup_row['link_url']."' target='".$popup_row['to_target']."' onfocus='this.blur();' style='padding:0; border:0; margin:0;'><img src='".$_darkboard_home.$popup_row['up_img']."' width='".$img_size[0]."px' height='".$img_size[1]."px' style='padding:0; border:0; margin:0;' /></a>";
								}
								else {
									$view_img = "<img src='".$_darkboard_home.$popup_row['up_img']."' width='".$img_size[0]."px' height='".$img_size[1]."px' style='padding:0; border:0; margin:0;' />";
								}
							}
							else {
								$view_img = "<embed src='".$_darkboard_home.$popup_row['up_img']."' type='application/x-shockwave-flash' border='0px' width='".$img_size[0]."px' height='".$img_size[1]."px' wmode='transparent'/>";

							}
							switch($popup_row['close_type']) {
								case '1' : $LimitDay = '하루동안 안열기'; break;
								case '2' : $LimitDay = '이틀동안 안열기'; break;
								case '3' : $LimitDay = '삼일동안 안열기'; break;
								case '4' : $LimitDay = '사일동안 안열기'; break;
								case '5' : $LimitDay = '오일동안 안열기'; break;
								case '7' : $LimitDay = '일주일간 안열기'; break;
								default : $popup_row['close_type'] = '7'; $LimitDay = '일주일간 안열기'; break;
							}
							$CookieId = 'DarkMainPopUp_'.strtotime($popup_row['regdate']);

							$result .= "	if(document.cookie.indexOf(\"".$CookieId."=1\") == -1) {\n";
							$result .= "		DarkPopUpDiv = document.createElement(\"div\");\n";
							$result .= "		jQuery(DarkPopUpDiv).css({\"position\":\"absolute\", \"top\":\"".$popup_row['top_view']."px\", \"left\":\"".$popup_row['left_view']."px\", \"z-index\":\"".$popup_row['zindex']."\"});\n";
							$result .= "		jQuery(DarkPopUpDiv).attr(\"id\", \"DarkMainPopUp_".$popup_row['p_idx']."\");\n";
							if($popup_row['type'] == '2') {
								$result .= "		jQuery(DarkPopUpDiv).addClass(\"DarkMainPopUpMove\");\n";
							}
							if(empty($contents)) {
								$result .= "		DarkPopUpHtml = \"<div class='pop_img' style='padding:0; border:0; margin:0;'>".$view_img."</div>\";\n";
							}
							else {
								$contents = stripslashes($contents);
								$contents = str_replace('"', '\"', $contents);
								$contents = str_replace('<?=$_hompage_home?>', $_hompage_home, $contents);
								$result .= "		DarkPopUpHtml = \"<div class='pop_img' style='padding:0; border:0; margin:0;'>".$contents."</div>\";\n";
							}
							$result .= "		DarkPopUpHtml = \"<div style='padding:0; border:0; margin:0;'>".$view_img."</div>\";\n";
							$result .= "		DarkPopUpHtml += \"<div style='width:100%; height:20px; background-color:#eeeeee; padding:0; border:0; margin:0;'>\";\n";
							$result .= "		DarkPopUpHtml += \"	<p style='float:left; font-size:12px; cursor:pointer; margin:5px 0 0 5px; padding:0; border:0; line-height:10px;' onclick=\\\"javascript:DarkSetCookie('".$CookieId."', '1', ".$popup_row['close_type']."); jQuery('#DarkMainPopUp_".$popup_row['p_idx']."').remove();\\\">".$LimitDay."</p>\";\n";
							$result .= "		DarkPopUpHtml += \"	<p style='float:right; font-size:12px; cursor:pointer; margin:5px 5px 0 0; padding:0; border:0; line-height:10px;' onclick=\\\"javascript: jQuery('#DarkMainPopUp_".$popup_row['p_idx']."').remove();\\\">[닫기]</p>\";\n";
							$result .= "		DarkPopUpHtml += \"</div>\";\n";
							$result .= "		jQuery(DarkPopUpDiv).html(DarkPopUpHtml);\n";
							$result .= "		DarkPopUp[DarkPopUp.length] = DarkPopUpDiv;\n";
							$result .= "	}\n";

							$counter++;
						}
						
					}

					if($counter > 0) {
						$result .= "	jQuery(document).ready(function(){\n";
						$result .= "		for(var i = 0 ; i < DarkPopUp.length ; i++) {\n";
						$result .= "			document.getElementsByTagName(\"body\")[0].appendChild(DarkPopUp[i]);\n";
						$result .= "			jQuery(DarkPopUp[i]).css('width', jQuery(DarkPopUp[i]).width() + 'px');\n";
						$result .= "		}\n";
						$result .= "		jQuery(\".DarkMainPopUpMove\").draggable({\n";
						$result .= "			cursor: 'move'\n";
						$result .= "			,opacity: 0.9\n";
						$result .= "			,helper: 'original'\n";
						$result .= "			,scroll : false\n";
						$result .= "			,start : function(event, ui){\n";
						$result .= "				DarkPopUpZindex = jQuery(this).css('z-index');\n";
						$result .= "				jQuery(this).css({'z-index' : '10000000'});\n";
						$result .= "			}\n";
						$result .= "			,stop : function(event, ui){\n";
						$result .= "				jQuery(this).css({'z-index' : DarkPopUpZindex});\n";
						$result .= "			}\n";
						$result .= "		});\n";
						$result .= "	});\n";
					}

					$result .= "</script>";
				}
				else {
					$result = $this->conn->errorInfo();
				}

				//print_r($result);

				$this->_DBclose();
				return $result;
			}
		}
	}
?>