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
namespace anavaro\eventmedals\acp;

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
		//$this->var_display($action);

		//$this->var_display($tid);
		//Lets get some groups!
		switch ($mode) {
			case 'add':
				$user->add_lang_ext('anavaro/eventmedals', 'event_medals');
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
									WHERE username_clean = \''.$db->sql_escape(utf8_clean_string($VAR)).'\'';
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
								$sql_rq = 'SELECT  oid, link, COUNT(*) FROM  phpbb_event_medals WHERE oid = '.$db->sql_escape($ID).' AND link = '.$db->sql_escape($link);
								$result = $db->sql_fetchrow($db->sql_query($sql_rq));
								//$this->var_display($result['COUNT(*)']);
								if ($result['COUNT(*)'] < 1) {
									$sql = 'INSERT INTO phpbb_event_medals SET oid = '.$db->sql_escape($ID).', type = '.$db->sql_escape($VAR['select']).', date = '.$db->sql_escape($timestamp);
									if ($link) { $sql .= ', link = '.$db->sql_escape($link); }
									if ($image) { $sql .= ', image = \''.$db->sql_escape($image).'\''; }
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
			case 'edit':
				$user->add_lang_ext('anavaro/eventmedals', 'event_medals');
				$this->tpl_name		= 'acp_event_medals_edit';
				$this->page_title	= 'ACP_EVENT_MEDALS_EDIT';
				
				$stage = $request->variable('stage', 'first');
				
				switch ($stage) {
					case 'first':
						$sql_array = array(
							'SELECT'	=>	'DISTINCT(e.link) as id, t.topic_title as title',
							'FROM'	=> array(
								'phpbb_event_medals'	=> 'e',
								TOPICS_TABLE	=> 't'
							),
							'WHERE'	=>	'e.link = t.topic_id',
							'ORDER_BY'	=>	'id DESC'
							
						);
						$sql = $db->sql_build_query('SELECT', $sql_array);
						$result = $db->sql_query($sql);
						while ($row = $db->sql_fetchrow($result))
						{
							$template->assign_block_vars('event', array(
								'ID'	=>	$row['id'],
								'EVENT'	=>	$row['title'],
							));
							//$this->var_display($row);
							
						}
						
						$post_url = append_sid("index.php?i=".$id."&mode=".$mode."&stage=second");
						$template->assign_vars(array(
							'S_STAGE' => 'first',
							'U_ACTION'	=>	$post_url,
						));
					break;
					case 'second':
						$edit_type = $request->variable('event_edit_type', 'event');
						if ($edit_type == 'event')
						{
							$event_id = $request->variable('topic', '');
							$sql_array = array(
								'SELECT'	=>	'e.oid, e.type, u.username, e.image',
								'FROM'	=>	array(
									'phpbb_event_medals'	=> 'e',
									USERS_TABLE	=> 'u',
								),
								'WHERE' => 'e.oid = u.user_id AND e.link = ' . $db->sql_escape($event_id)
							);
							$sql = $db->sql_build_query('SELECT', $sql_array);
							$result = $db->sql_query($sql);
							
							while ($row = $db->sql_fetchrow($result)) 
							{
								$template->assign_block_vars('event_edit', array(
									'USERNAME'	=>	$row['username'],
									'USER_ID'	=>	$row['oid'],
									'TYPE'	=>	$row['type'],
									'IMAGE'	=>	$row['image']
								));
							}
							$post_url = append_sid("index.php?i=".$id."&mode=".$mode."&stage=third_event");
							$template->assign_vars(array(
								'S_STAGE' => 'second',
								'U_ACTION'	=>	$post_url,
								'S_EVENT_ID'	=>	$event_id,
							));
						}
						else
						{
							$username_request = utf8_normalize_nfc($request->variable('username', ''));
							$sql = 'SELECT user_id, username 
									FROM ' . USERS_TABLE . '
									WHERE username_clean = \''.$db->sql_escape(utf8_clean_string($username_request)).'\'';
							$result = $db->sql_query($sql);
							$username;
							$user_id;
							while ($row = $db->sql_fetchrow($result))
							{
								$username = $row['username'];
								$user_id = $row['user_id'];
							}
							$sql_array = array(
								'SELECT'	=>	'e.type as type, e.link as link, e.image as image, t.topic_title as title',
								'FROM'	=>	array(
									'phpbb_event_medals'	=>	'e',
									TOPICS_TABLE	=> 't',
								),
								'WHERE'	=> 'e.link = t.topic_id AND oid = '. $user_id
							);
							$sql = $db->sql_build_query('SELECT', $sql_array);
							$result = $db->sql_query($sql);
							while ($row = $db->sql_fetchrow($result))
							{
								$events[$row['link']] = array(
									'type'	=>	$row['type'],
									'title'	=>	$row['title'],
									'image'	=>	$row['image']
								);
							}
							$post_url = append_sid("index.php?i=".$id."&mode=".$mode."&stage=third_user");
							$template->assign_vars(array(
								'S_STAGE' => 'second_user',
								'U_ACTION'	=>	$post_url,
								'S_USERNAME'	=>	$username,
								'S_USER_ID'	=>	$user_id,
							));
							foreach ($events as $ID => $VAR)
							{
								$template->assign_block_vars('user_edit', array(
									'EVENT_ID'	=>	$ID,
									'TYPE'	=>	$VAR['type'],
									'TITLE'	=>	$VAR['title'],
									'IMAGE'	=>	$VAR['image']
								));
							}
							
							//$this->var_display($events);
						}
					break;
					case 'third_event':
						$event_id = $request->variable('target_event', '');
						$delete = $request->variable('delete', array(''=>''));
						//first we delete, then we update
						foreach ($delete as $VAR)
						{
							$sql = 'DELETE FROM phpbb_event_medals WHERE oid = '.$db->sql_escape($VAR).' AND `link` = '.$db->sql_escape($event_id).' LIMIT 1';
							$db->sql_query($sql);
						}
						$users = $request->variable ('usesr', array('' => array(''=>'',''=>'',''=>'')));

						foreach ($users as $ID=>$VAR)
						{
							$users_new[$ID] = $VAR['select'];
							$users_image_new[$ID] = $VAR['image'];
						}
						$sql = 'SELECT oid, type, image FROM phpbb_event_medals WHERE link = '.$db->sql_escape($event_id);
						$result = $db->sql_query($sql);
						
						while ($row = $db->sql_fetchrow($result))
						{
							$users_old[$row['oid']] = $row['type'];
							$users_image_old[$row['oid']] = $row['image'];
						}
						$users_diff = array_diff_assoc($users_new, $users_old);
						$users_image_diff = array_diff_assoc($users_image_new, $users_image_old);
						
						foreach ($delete as $VAR)
						{
							unset($users_diff[$VAR]);
							unset($users_image_diff[$VAR]);
						}
						if ($users_diff) 
						{
							foreach ($users_diff as $ID => $VAR)
							{
								$sql = 'UPDATE phpbb_event_medals SET type = '.$db->sql_escape($VAR).' WHERE oid = '.$db->sql_escape($ID).' AND link = '.$db->sql_escape($event_id).' LIMIT 1';
								$db->sql_query($sql);
							}
						}
						if ($users_image_diff)
						{
							foreach ($users_image_diff as $ID => $VAR)
							{
								$sql = 'UPDATE phpbb_event_medals SET image = \''.$db->sql_escape($VAR).'\' WHERE oid = '.$db->sql_escape($ID).' AND link = '.$db->sql_escape($event_id).' LIMIT 1';
								$db->sql_query($sql);
							}
						}
						
						$post_url = append_sid("index.php?i=".$id."&mode=".$mode);
						$template->assign_vars(array(
							'S_STAGE' => 'third',
							'U_ACTION'	=>	$post_url,
						));
					break;
					case 'third_user':
						$user_id = $request->variable('target_user', '');
						$delete = $request->variable('delete', array(''=>''));
						foreach ($delete as $VAR)
						{
							$sql = 'DELETE FROM phpbb_event_medals WHERE oid = '.$db->sql_escape($user_id).' AND link = '.$db->sql_escape($VAR).' LIMIT 1';
							$db->sql_query($sql);
						}
						$eventsrq = $request->variable ('events', array('' => array(''=>'',''=>'',''=>'')));
						foreach ($eventsrq as $ID => $VAR)
						{
							$events_new[$ID] = $VAR['select'];
							$events_image_new[$ID] = $VAR['image'];
						}
						
						$sql = 'SELECT link, type, image FROM phpbb_event_medals WHERE oid = '.$db->sql_escape($user_id);
						$result = $db->sql_query($sql);
						while ($row = $db->sql_fetchrow($result))
						{
							$events_old[$row['link']] = $row['type'];
							$events_image_old[$row['link']] = $row['image'];
						}
						$events_diff = array_diff_assoc($events_new, $events_old);
						$events_image_diff = array_diff_assoc($events_image_new, $events_image_old);
						foreach ($delete as $VAR)
						{
							unset($events_diff[$VAR]);
							unset($events_image_diff[$VAR]);
						}
						if ($events_diff)
						{
							foreach ($events_diff as $ID => $VAR)
							{
								$sql = 'UPDATE phpbb_event_medals SET type = '.$db->sql_escape($VAR).' WHERE oid = '.$db->sql_escape($user_id).' AND link = '.$db->sql_escape($ID).' LIMIT 1';
								$db->sql_query($sql);
							}
						}
						if ($events_image_diff)
						{
							foreach ($events_image_diff as $ID => $VAR)
							{
								$sql = 'UPDATE phpbb_event_medals SET image = \''.$db->sql_escape($VAR).'\' WHERE oid = '.$db->sql_escape($user_id).' AND link = '.$db->sql_escape($ID).' LIMIT 1';
								$db->sql_query($sql);
							}
						}
						$post_url = append_sid("index.php?i=".$id."&mode=".$mode);
						$template->assign_vars(array(
							'S_STAGE' => 'third',
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
