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
	'ACP_EVENT_MEDALS'	=>	'Event medals',
	'ACP_EVENT_MEDALS_ADD'	=>	'Add event medals',
	'ACP_EVENT_MEDALS_EDIT'	=>	'Edit event medals',
	'ACP_EVENT_MEDALS_GRP'	=>	'Event medals',
	
	'MEDALS_TITLE'	=> 'Event medals',
	'MEDALS_ADD_SCRIPT'	=>	'Event medals addition script',
	'MEDALS_ADD_STEP_ONE'	=> 'STEP 1: User list',
	'MEDALS_USERS_LIST'	=>	'User list',
	'MEDALS_USERS_LIST_HINT'	=> 'Add every username on new line.',
	'MEDALS_ADD_STEP_TWO'	=>	'STEP 2: Event medals type.',
	'WARNING'	=>	'Warning!',
	'INFO'	=>	'Information',
	'SUCCESS_INFO'	=>	'Event medals are added successfully',
	'BACK'	=> '« Back to previous page',
	'USER'	=>	'User',
	'NOT_EXISTENTS'	=>	'does not exist',
	'CORRECT_WARNING_ONE'	=>	'USE BACK button to go back and change username or add user manualy.',
	'CORRECT_WARNING_THREE'	=>	'USE BACK button to go back and correct.',
	'MEDAL_TYPE'	=>	'Event medal type:',
	'MEDAL_TYPE_ONE'	=> 'Organizer',
	'MEDAL_TYPE_TWO'	=> 'Participant',
	'MEDAL_TYPE_THREE'	=> 'Ran away',
	'MEDAL_TYPE_FOUR'	=> 'NOT WELCOMED!',
	'MEDALS_ADD_STEP_THREE'	=> 'STEP 3: Dates and custom images.',
	
	'DATE'	=> 'Date:',
	'M_JAN'	=>	'January',
	'M_FEB'	=>	'February',
	'M_MAR'	=>	'March',
	'M_APR'	=>	'April',
	'M_MAY'	=>	'May',
	'M_JUN'	=>	'June',
	'M_JUL'	=>	'July',
	'M_AUG'	=>	'August',
	'M_SEP'	=>	'September',
	'M_OCT'	=>	'October',
	'M_NOV'	=>	'November',
	'M_DEC'	=>	'December',
	'TOPIC_NUMBER'	=>	'Topic ID:',
	'IMAGE_PATH'	=> 'Custom images path:',
	
	'ERR_DAY_NOT_NUM'	=>	'You know that the day should be a number, right?',
	'ERR_DAY_NOT_IN_RANGE'	=>	'There is no such day in the month!',
	'ERR_YEAR_NOT_NUM'	=> 'Not numeral Year?',
	'ERR_DATE_ERR'	=> 'The date is wrong ...',
	'ERR_TOPIC_ERR'	=> 'Nope! There is no Topic ID like the one you\'ve provided',
	
));