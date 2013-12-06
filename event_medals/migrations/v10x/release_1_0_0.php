<?php
/**
*
* @package migration
* @copyright (c) 2012 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License v2
*
*/

namespace anavarocom\event_medals\migrations\v10x;

class release_1_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
        {
                return isset($this->config['event_medals_version']) && version_compare($this->config['event_medals_version'], '1.0.0', '>=');
        }
	static public function depends_on()
        {
                return array('\phpbb\db\migration\data\v310\dev');
        }
		
	public function update_data()
	{
		return array(
		
			array('module.add', array(
				'acp',
				'',
				'ACP_EVENT_MEDALS'
			)),
			array('module.add', array(
				'acp',
				'ACP_EVENT_MEDALS',
				'ACP_EVENT_MEDALS_GRP'
			)),
			array('module.add', array(
				'acp',
				'ACP_EVENT_MEDALS_GRP',
				array(
					'module_basename'	=> '\anavarocom\event_medals\acp\main_module'	,
					'mode'		=> array('add'),
				)
			)),
			
			array('config.add', array('event_medals_version', '1.0.0')),
		);
	}
	public function revert_data()
	{
		return array(
			array('module.remove', array(
				'acp',
				'ACP_EVENT_MEDALS_GRP',
				array(
					'module_basename'	=> '\anavarocom\event_medals\acp\main_module'	,
					'mode'		=> array('add'),
				)
			)),
			array('module.remove', array(
				'acp',
				'ACP_EVENT_MEDALS',
				'ACP_EVENT_MEDALS_GRP'
			)),
			array('module.add', array(
				'acp',
				'',
				'ACP_EVENT_MEDALS'
			)),
			array('config.remove', array('event_medals_version')),
		);
	}
	//lets create the needed table	
	public function update_schema()
	{
		return array(
			'add_columns'        => array(
				$this->table_prefix . 'users_custom'        => array(
					'profile_event_show'    => array('UINT', 1),
				)
			),
			'add_tables'    => array(
				$this->table_prefix . 'event_medals'		=> array(
					'COLUMNS'		=> array(
						'id'		=> array('UINT:11', NULL, 'auto_increment'),
						'oid'		=> array('VCHAR:32', ''),
						'type'		=> array('UINT:2', 1),
						'link'		=> array('UINT:8'),
						'date'		=> array('VCHAR:16', NULL),
						'image'		=> array('VCHAR:128', '', 'none')
					),
					'PRIMARY_KEY'    => 'id',
				)
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'		=> array(
				$this->table_prefix . 'users_custom'        => array(
					'profile_event_show',
				)
			),
			'drop_tables'		=> array(
				$this->table_prefix . 'event_medals'
			),
		);
	}
}