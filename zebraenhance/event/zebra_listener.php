<?php

/**
*
* @package Anavaro.com Zebra Enchance
* @copyright (c) 2013 Lucifer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
//TODO 1: Dynamicly locate ZEBRA module
//TODO 2: Make use of ajax requests for canceling requests
//TODO 3: check if Zebra table is cleaned from deletion of user (make it clean if it is not.

namespace anavarocom\zebraenhance\event;

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* Event listener
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class zebra_listener implements EventSubscriberInterface
{	
	static public function getSubscribedEvents()
    {
		return array(
			//'core.memberlist_prepare_profile_data'	       => 'prepare_medals',
			//'core.user_setup'		=> 'load_language_on_setup',
			//'core.memberlist_view_profile'	      => 'fuunct_one',
			//'core.viewtopic_modify_post_row'	=>	'modify_post_row',
			
			'core.user_setup'		=> 'load_language_on_setup',
			'core.ucp_add_zebra'	=>	'zebra_confirm_add',
			'core.ucp_remove_zebra'	=>	'zebra_confirm_remove',
			'core.ucp_display_module_before'	=>	'module_display',
			'core.delete_user_before'	=> 'delete_users',
		);
    }
	
	
	/**
	* Constructor
	* NOTE: The parameters of this method must match in order and type with
	* the dependencies defined in the services.yml file for this service.
	*
	* @param \phpbb\auth		$auth		Auth object
	* @param \phpbb\cache\service	$cache		Cache object
	* @param \phpbb\config	$config		Config object
	* @param \phpbb\db\driver	$db		Database object
	* @param \phpbb\request	$request	Request object
	* @param \phpbb\template	$template	Template object
	* @param \phpbb\user		$user		User object
	* @param \phpbb\content_visibility		$content_visibility	Content visibility object
	* @param \phpbb\controller\helper		$helper				Controller helper object
	* @param string			$root_path	phpBB root path
	* @param string			$php_ext	phpEx
	*/
	public function __construct(\phpbb\auth\auth $auth, \phpbb\cache\service $cache, \phpbb\config\config $config, \phpbb\db\driver\driver $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\controller\helper $helper, $root_path, $php_ext)
	{
		$this->auth = $auth;
		$this->cache = $cache;
		$this->config = $config;
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->helper = $helper;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}
	public function load_language_on_setup($event){
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
            'ext_name' => 'anavarocom/zebraenhance',
            'lang_set' => 'zebra_enchance',
        );
        $event['lang_set_ext'] = $lang_set_ext;
	}


	protected $image_dir = 'ext/anavarocom/zebraenhance/images';
	
	public function zebra_confirm_add($event)
	{
		if ($event['mode'] == 'friends')
		{
			foreach($event['sql_ary'] as $VAR) 
			{
				//let's test if we have sent request
				$sql = "SELECT * FROM `phpbb_zebra_confirm` WHERE `user_id` = '".$VAR['user_id']."' AND `zebra_id` = '".$VAR['zebra_id']."'";
				$result = $this->db->sql_fetchrow($this->db->sql_query($sql));
				if (!$result)
				{
					//Let's test if request is pending from the other user
					$sql = "SELECT * FROM `phpbb_zebra_confirm` WHERE `user_id` = '".$VAR['zebra_id']."' AND `zebra_id` = '".$VAR['user_id']."'";
					$result = $this->db->sql_fetchrow($this->db->sql_query($sql));
					//$this->var_display($result);
					if ($result) 
					{
						//so we have incoming request -> we add friends!
						$sql = "INSERT INTO ". ZEBRA_TABLE ." SET `user_id` = '".$VAR['user_id']."', `zebra_id` = '".$VAR['zebra_id']."', `friend` = '1', `foe` = '0'";
						$this->db->sql_query($sql);
						$sql = "INSERT INTO ". ZEBRA_TABLE ." SET `user_id` = '".$VAR['zebra_id']."', `zebra_id` = '".$VAR['user_id']."', `friend` = '1', `foe` = '0'";
						$this->db->sql_query($sql);
						
						//let's clean the request table 
						$sql = "DELETE FROM `phpbb_zebra_confirm` WHERE `user_id` = '".$VAR['zebra_id']."' AND `zebra_id` = '".$VAR['user_id']."'";
						$this->db->sql_query($sql);
						$sql = "DELETE FROM `phpbb_zebra_confirm` WHERE `user_id` = '".$VAR['user_id']."' AND `zebra_id` = '".$VAR['zebra_id']."'";
						$this->db->sql_query($sql);
					}
					else 
					{
						//lets see if user is hostile towerds us (if yes - silently drop request)
						$sql = "SELECT * FROM ". ZEBRA_TABLE ." WHERE `user_id` = '".$VAR['zebra_id']."' AND `zebra_id` = '".$VAR['user_id']."' AND `foe` = '1'";
						$result = $this->db->sql_fetchrow($this->db->sql_query($sql));
						if (!$result) {
							$sql = "INSERT INTO `phpbb_zebra_confirm` SET `user_id` = '".$VAR['user_id']."', `zebra_id` = '".$VAR['zebra_id']."', `friend` = '1', `foe` = '0'";
							$this->db->sql_query($sql);
						}
					}
				}
			}
			$event['sql_ary'] = array();
		}
		if ($event['mode'] == 'foes')
		{
			foreach($event['sql_ary'] as $VAR) 
			{
				//if we add user as foe we have to remove pending requests.
				$sql = "DELETE FROM `phpbb_zebra_confirm` WHERE `user_id` = '".$VAR['zebra_id']."' AND `zebra_id` = '".$VAR['user_id']."'";
				$this->db->sql_query($sql);
				$sql = "DELETE FROM `phpbb_zebra_confirm` WHERE `user_id` = '".$VAR['user_id']."' AND `zebra_id` = '".$VAR['zebra_id']."'";
				$this->db->sql_query($sql);
			}
		}
	}
	
	public function zebra_confirm_remove($event)
	{
		if($event['mode'] == 'friends')
		{
			//let's go for syncronieus remove
			foreach($event['user_ids'] AS $VAR)
			{
				$sql = 'DELETE FROM ' . ZEBRA_TABLE . '
				WHERE user_id = \'' . $this->user->data['user_id'] . '\'
				AND `zebra_id` = \''. $VAR .'\'';
				$this->db->sql_query($sql);
				
				$sql = 'DELETE FROM ' . ZEBRA_TABLE . '
				WHERE user_id = \'' . $VAR . '\'
				AND `zebra_id` = \''. $this->user->data['user_id'] .'\'';
				$this->db->sql_query($sql);
			}
			$event['user_ids'] = array('0');
		}
	}
	
	
	public function module_display($event)
	{
		$ispending = $iswaiting = '';
		//TODO 1
		if ($event['id'] == 'ucp_zebra' OR $event['id'] == '168')
		{
			//let's get incoming pendings
			$sql = "SELECT `zc`.*, `u`.`username`, `u`.`user_colour`
					FROM `phpbb_zebra_confirm` AS `zc`
					JOIN ". USERS_TABLE ." AS `u` ON (`zc`.`user_id` = `u`.`user_id`)
					WHERE `zc`.`zebra_id` = '".$this->user->data['user_id']."'";
			$result = $this->db->sql_query($sql);
			
			while($row = $this->db->sql_fetchrow($result))
			{
				$ispending = 1;
				$this->template->assign_block_vars('pending_requests', array(
					'USERNAME'	=> '<a class="username-coloured" style="color: '.$row['user_colour'].'" href="'.append_sid('memberlist.php?mode=viewprofile&u='.$row['user_id']).'">'.$row['username'].'</a>',
					'CONFIRM' => '<a href="./ucp.php?i=zebra&add='.$row['username'].'"><img src="' . $this->image_dir . '/confirm_16.png"/></a>',
					//TODO 2
					//'CANCEL'	=> '<a href="'.$this->root_path.'app.php/zebraenhance/cancel_fr/'.$row['user_id'].'" data-ajax="true" data-refresh="true"><img src="' . $this->image_dir . '/cancel.gif"/></a>',
					'CANCEL'	=> '<a href="'.$this->root_path.'app.php/zebraenhance/cancel_fr/'.$row['user_id'].'"><img src="' . $this->image_dir . '/cancel.gif"/></a>',
				));
			}
			if($ispending)
			{
				$this->template->assign_var('HAS_PENDING', 'yes');
				
			}
			//now, let's get our own requests that are waiting.
			$sql = "SELECT `zc`.*, `u`.`username`, `u`.`user_colour`
					FROM `phpbb_zebra_confirm` AS `zc`
					JOIN ". USERS_TABLE ." AS `u` ON (`zc`.`zebra_id` = `u`.`user_id`)
					WHERE `zc`.`user_id` = '".$this->user->data['user_id']."'";
			$result = $this->db->sql_query($sql);

			while($row = $this->db->sql_fetchrow($result))
			{
				$iswaiting = 1;
				$this->template->assign_block_vars('pending_awaits', array(
					'USERNAME'	=> '<a class="username-coloured" style="color: '.$row['user_colour'].'" href="'.append_sid('memberlist.php?mode=viewprofile&u='.$row['zebra_id']).'">'.$row['username'].'</a>',
					//TODO 2
					//'CANCEL'	=> '<a href="'.$this->root_path.'app.php/zebraenhance/cancel_fr/'.$row['zebra_id'].'" data-ajax="true"><img src="' . $this->image_dir . '/cancel.gif"/></a>',
					'CANCEL'	=> '<a href="'.$this->root_path.'app.php/zebraenhance/cancel_fr/'.$row['zebra_id'].'"><img src="' . $this->image_dir . '/cancel.gif"/></a>',
				));
			}
			if($iswaiting)
			{
				$this->template->assign_var('HAS_WAITING', 'yes');
			}
			
			
			//let's populate the prity zebra list (bff and all)
			$sql = "SELECT `zc`.*, `u`.`username`, `u`.`user_colour`
					FROM ". ZEBRA_TABLE ." AS `zc`
					JOIN ". USERS_TABLE ." AS `u` ON (`zc`.`zebra_id` = `u`.`user_id`)
					WHERE `zc`.`user_id` = '".$this->user->data['user_id']."'";
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$this->template->assign_block_vars('prity_zebra', array(
					'USERNAME'	=>	'<a class="username-coloured" style="color: '.$row['user_colour'].'" href="'.append_sid('memberlist.php?mode=viewprofile&u='.$row['zebra_id']).'">'.$row['username'].'</a>',
					'CANCEL' => '<a href="./ucp.php?i=zebra&remove=1&usernames[]='.$row['zebra_id'].'"><img src="' . $this->image_dir . '/cancel.gif"/></a>',
					'BFF' =>	$row['bff'] ? '<a href="./app.php/zebraenhance/togle_bff/'.$row['zebra_id'].'" data-ajax="togle_bff"><img id="usr_'.$row['zebra_id'].'" src="'. $this->image_dir . '/favorite_remove.png" width="16px" height="16px"/></a>' : '<a href="./app.php/zebraenhance/togle_bff/'.$row['zebra_id'].'" data-ajax="togle_bff"><img id="usr_'.$row['zebra_id'].'" src="'. $this->image_dir . '/favorite_add.png" width="16px" height="16px"/></a>'
				));
			}
			$this->template->assign_var('IMGDIR', $this->image_dir);
		}
	}
	
	
	public function delete_users($event)
	{
		foreach ($event[user_ids] AS $VAR)
		{
			//TODO 3
			$sql = "DELETE FROM `phpbb_zebra_confirm` WHERE `user_id` = '".$VAR."' OR `zebra_id` = '".$VAR."'";
			$this->db->sql_query($sql);
		}
	}
	protected function var_display($i) 
	{
		echo '<pre>';
		print_r($i);
		echo '</pre>';
		return true;
	}
	
}
