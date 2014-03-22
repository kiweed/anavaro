<?php

/**
*
* @package Anavaro.com Event medals
* @copyright (c) 2013 Lucifer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* @ignore
*/

namespace anavarocom\eventmedals\acp;

if (!defined('IN_PHPBB'))
{
    exit;
}



class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\anavarocom\eventmedals\acp\main_module',
			'title'		=> 'Медали от събития',
			'version'	=> '0.0.9',
			'modes'		=> array(
				'add'		=> array(
									'title' => 'ACP_EVENT_MEDALS_ADD',
									'auth' 		=> 'acl_a_user', 
									'cat'		=> array('ACP_EVENT_MEDALS')
									),
				'edit'		=> array(
									'title' => 'ACP_EVENT_MEDALS_EDIT', 
									'auth' 		=> 'acl_a_user', 
									'cat'		=> array('ACP_EVENT_MEDALS')
									),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}

?>