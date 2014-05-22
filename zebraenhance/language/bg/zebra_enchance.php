<?php

/**
*
* newspage [Bulgarian]
*
* @package language
* @version $Id$
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined('IN_PHPBB'))
{
        exit;
}
if (empty($lang) || !is_array($lang))
{
        $lang = array();
}

$lang = array_merge($lang, array(
	'UCP_ZEBRA_PENDING_IN'	=>	'Очакващи потвърждение',
	'UCP_ZEBRA_PENDING_IN_EXP'	=>	'Списък на очакващите потвърждение заявки за приятелство.',
	
	'UCP_ZEBRA_PENDING_OUT'	=>	'Изчакващи потвърждение',
	'UCP_ZEBRA_PENDING_OUT_EXP'	=>	'Списък на изчкаващите вашето потвърждение заявки за приятелство.',
	
	'UCP_ZEBRA_PENDING_NONE'	=>	'Нямате изчакващи заявки',
	
	
	'UCP_ZEBRA_ENCHANCE_CONFIRM_CANCEL_ASK'	=>	'Сигурни ли сте, че искате да отхвърлите предложението за приятелство?',
	'UCP_ZEBRA_ENCHANCE_CONFIRM_CANCEL'	=> 'Предложението за приятелство е отхвърлено!',
	
	'NOTIFICATION_TYPE_ZEBRA_ADD'	=>	'Сигнал за получаване на заявка за приятелство',
	'NOTIFICATION_ZEBRA_ADD'	=>	'%1$s Ви изпрати покана за приятелство!',
	
	'NOTIFICATION_TYPE_ZEBRA_CONFIRM'	=>	'Сигнал за потвърждаване на приятелство',
	'NOTIFICATION_ZEBRA_CONFIRM'	=>	'%1$s потвърди приятелството!',
	
));