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

namespace anavarocom\eventmedals\ucp;

if (!defined('IN_PHPBB'))
{
    exit;
}



class ucp_medals_info
{
    function module()
    {
        return array(
            'filename' => '\anavarocom\eventmedals\ucp\ucp_medals_module',
            'title' => 'MEDALS_TITLE',
            'version' => '1.0.0',
            'modes' => array(
                'control' => array(
					'title' => 'UCP_EVENT_CONTROL', 
					'auth' => 'ext_anavarocom/eventmedals', 
					'cat' => array('UCP_PROFILE')
				),
            ),
        );
    }
} 

?>