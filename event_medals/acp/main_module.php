<?php

/**
*
* @package Anavaro.com Event Medals
* @copyright (c) 2013 Lucifer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* @ignore
*/
namespace anavarocom\event_medals\acp;

if (!defined('IN_PHPBB'))
{
    exit;
}

class main_module
{
	var $u_action;
	function var_display($i) {
		echo "<pre>";
		print_r($i);
		echo "</pre>";
	}
	function main($id, $mode)
	{	
		
		
		global $db, $user, $auth, $template, $cache, $request;
        global $config, $SID, $phpbb_root_path, $phpbb_admin_path, $phpEx, $k_config, $table_prefix;
		$action = $request->variable('act', 'add');
		//$this->var_display($action);

		//$this->var_display($tid);
		//Lets get some groups!
		switch ($action) {
			case 'add':
				$user->add_lang_ext('anavarocom/event_medals', 'event_medals');
				$this->tpl_name		= 'acp_event_medals_add';
				$this->page_title	= 'ACP_EVENT_MEDALS_ADD';
				
				$stage = $request->variable('stage', 'first');
				//$this->var_display($stage);
				switch ($stage) {
					case 'first':
						$post_url = append_sid("index.php?i=".$id."&mode=".$mode."&stage=second");
						$template->assign_vars(array(
							'S_STAGE' => 'first',
							'U_ACTION'	=>	$post_url,
						));
					break;
					case 'second':
						$post_url = append_sid("index.php?i=".$id."&mode=".$mode."&stage=third");
						$template->assign_vars(array(
							'S_STAGE' => 'second',
							'U_ACTION'	=>	$post_url,
						));
						//we get nicks
						$usersSTR = utf8_normalize_nfc($request->variable('usernames', '', true));
						//build nick array
						$users_arry = explode(PHP_EOL, $usersSTR);
						
						//let's check users in DB
						
						$nick_errs = array();
						
						
						foreach ($users_arry as $VAR) {
							$sql = 'SELECT user_id, username 
									FROM ' . USERS_TABLE . '
									WHERE `username_clean` = \''.utf8_clean_string($VAR).'\'
									';
							$result = $db->sql_query($sql);
							$row = $db->sql_fetchrow($result);
							//$this->var_display($row);
							if (!$row) { 
								$nick_errs[] = $VAR; 
							}
							else {
								$users[$row['user_id']] = $row['username'];
							}
						}
						if ($users) {
							foreach ($users AS $ID => $VAR) {
								$template->assign_block_vars('usrs', array(
									'USERNAME' => $VAR,
									'ID'	=>	$ID,
								));
							}
						}
						$template->assign_vars(array(
							'S_ERROR' => implode($nick_errs, " "),
						));
						
						//$this->var_display($users_arry);
					break;
					case 'third':
						$post_url = append_sid("index.php?i=".$id."&mode=".$mode."&stage=fourth");
						$template->assign_vars(array(
							'S_STAGE' => 'third',
							'U_ACTION'	=>	$post_url,
						));
						$medals_array = $request->variable('usesr', array(array('' => '', '' => '')));
						//$this->var_display($_POST);
						//$this->var_display($medals_array);
						foreach ($medals_array AS $ID => $VAR) {
							//$this->var_display($VAR);
							$template->assign_block_vars('usrs1', array(
								'SELECTION' => $VAR['select'],
								'USERNAME'	=>	$VAR['username'],
								'USERID'	=>	$ID,
							));
						}
						
					break;
					case 'fourth':
						$medals_array = $request->variable('usesr', array(array('' => '', '' => '', '' => '')));
						$day = $request->variable('day', '');
						$month = $request->variable('month', '');
						$year = $request->variable('year', '');
						$link = $request->variable('link', '');
						$image = utf8_normalize_nfc($request->variable('image', 'none'));
						
						$error_array = array();
						
						if (!is_numeric($day)) { $error_array[] = '{L_ERR_DAY_NOT_NUM}'; }
						if ($day < 1 OR $day > 31) { $error_array[] = '{L_ERR_DAY_NOT_IN_RANGE}'; }
						
						if (!is_numeric($year)) { $error_array[] = '{L_ERR_YEAR_NOT_NUM}'; }
						
						$months_long = array("1", "3", "5", "7", "8", "10", "12");
						if ((in_array($month, $months_long) AND $day <= "31") OR (!in_array($month, $months_long) AND $month != "2" AND $day <= "30") OR ($month == "2" AND $year % 4 == "0" AND $day <= "29") OR ($month == "2" AND $year % 4 != "0" AND $day <= "28")) {
							
						}
						else { $error_array[] = '{L_ERR_DATE_ERR}'; }
						if ($link AND !is_numeric($link)) { $error_array[] = '{L_ERR_TOPIC_ERR}'; }
						$error_array_sub = 0;
						if (!$error_array) {
							$timestamp = mktime("0", "0", "0", $month, $day, $year);
							
							foreach ($medals_array AS $ID => $VAR) {
								
								//$this->var_display($VAR);
								$sql_rq = "SELECT  `oid`, `link`, COUNT(*) FROM  `phpbb_event_medals` WHERE `oid` = '".$ID."' AND `link` = '".$link."'";
								$result = $db->sql_fetchrow($db->sql_query($sql_rq));
								//$this->var_display($result['COUNT(*)']);
								if ($result['COUNT(*)'] < 1) {
									$sql = "INSERT INTO `phpbb_event_medals` SET `oid` = '".$ID."', `type` = '".$VAR['select']."', `date` = '".$timestamp."'";
									if ($link) { $sql .= ", `link` = '".$link."'"; }
									if ($image) { $sql .= ", `image` = '".$image."'"; }
									//$this->var_display($sql);
									$db->sql_query($sql);
								}
								else {	$error_array_sub ++; }
							}
							$post_url = append_sid("index.php?i=".$id."&mode=".$mode);
						}
						else {
							//$this->var_display($error_array);
							$template->assign_vars(array(
								'S_ERROR'	=>	'1',
							));
							
							foreach ($error_array AS $VAR) { 
								$template->assign_block_vars('errs', array( 
									'MSG'	=>	$VAR,
								));
							}
						}
						
						$template->assign_vars(array(
							'S_STAGE' => 'fourth',
							'U_ACTION'	=>	$post_url,
						));
					break;
				}
			break;
		}
	}
	function edit($id, $mode) {
		$this->var_display($_POST);
	}
}
?>
