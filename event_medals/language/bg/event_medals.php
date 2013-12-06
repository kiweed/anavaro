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
	'ACP_EVENT_MEDALS'	=>	'Медали',
	'ACP_EVENT_MEDALS_ADD'	=>	'Добави медали',
	'ACP_EVENT_MEDALS_EDIT'	=>	'Промени медали',
	
	'MEDALS_TITLE'	=> 'Медали',
	'MEDALS_ADD_SCRIPT'	=>	'Скрип за добавяне на медали',
	'MEDALS_ADD_STEP_ONE'	=> 'СТЪПКА 1: Добавете списък с потребители',
	'MEDALS_USERS_LIST'	=>	'Списък на потребителите',
	'MEDALS_USERS_LIST_HINT'	=> 'Въведете всяко потребителско име на нов ред.',
	'MEDALS_ADD_STEP_TWO'	=>	'СТЪПКА 2: Тип на медалите.',
	'WARNING'	=>	'ВНИМАНИЕ!',
	'INFO'	=>	'Информация',
	'SUCCESS_INFO'	=>	'Медалите са добавени успешно',
	'BACK'	=> '« Обратно към предишната страница',
	'USER'	=>	'Потребител',
	'NOT_EXISTENTS'	=>	'не съществува',
	'CORRECT_WARNING_ONE'	=>	'ИЗПОЛЗВАЙТЕ BACK бутона за да се върнете и коригирате или добавете медалите на тези потребители по-късно.',
	'CORRECT_WARNING_THREE'	=>	'ИЗПОЛЗВАЙТЕ BACK бутона за да се върнете и коригирате!',
	'MEDAL_TYPE'	=>	'Тип медал:',
	'MEDAL_TYPE_ONE'	=> 'Организатор',
	'MEDAL_TYPE_TWO'	=> 'Участник',
	'MEDAL_TYPE_THREE'	=> 'Избягал',
	'MEDAL_TYPE_FOUR'	=> 'НЕ ЖЕЛАН!',
	'MEDALS_ADD_STEP_THREE'	=> 'СТЪПКА 3: Дати и картинки.',
	
	'DATE'	=> 'Дата:',
	'M_JAN'	=>	'Януари',
	'M_FEB'	=>	'Февруари',
	'M_MAR'	=>	'Март',
	'M_APR'	=>	'Април',
	'M_MAY'	=>	'Май',
	'M_JUN'	=>	'Юни',
	'M_JUL'	=>	'Юли',
	'M_AUG'	=>	'Август',
	'M_SEP'	=>	'Септември',
	'M_OCT'	=>	'Октомври',
	'M_NOV'	=>	'Ноември',
	'M_DEC'	=>	'Декември',
	'TOPIC_NUMBER'	=>	'Номер на тема:',
	'IMAGE_PATH'	=> 'Път към картинка:',
	
	'ERR_DAY_NOT_NUM'	=>	'Деня трябва да е число, нали знаеш?',
	'ERR_DAY_NOT_IN_RANGE'	=>	'Е не може да си написал такова число!',
	'ERR_YEAR_NOT_NUM'	=> 'Е не може годината да не е число!',
	'ERR_DATE_ERR'	=> 'Нещо си объркал в датата ...',
	'ERR_TOPIC_ERR'	=> 'А не ... намери си темата в която е срещата!',
	
	
	
));