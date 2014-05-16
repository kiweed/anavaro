<?php
/**
*
* @package migration
* @copyright (c) 2012 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License v2
*
*/

namespace anavarocom\eventmedals\migrations;

class release_1_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
        {
                return isset($this->config['event_medals_version']);
        }
	static public function depends_on()
        {
                return array('\phpbb\db\migration\data\v310\alpha2');
        }
		
	public function update_data()
	{
		return array(
			array('config.add', array('event_medals_version', '1.0.0')),
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_DEMO_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_DEMO_TITLE',
				array(
					'module_basename'	=> '\anavarocom\eventmedals\acp\main_module',
					'modes'		=> array('add'),
				),
			)),
		);
	}
}