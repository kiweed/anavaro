<?php
/**
*
* @package migration
* @copyright (c) 2012 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License v2
*
*/

namespace anavaro\postlove\migrations;

class release_1_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
        {
                return isset($this->config['postlove_version']) && version_compare($this->config['postlove_version'], '1.0.0', '>=');
        }
	static public function depends_on()
        {
                return array('\phpbb\db\migration\data\v310\dev');
        }
		
	public function update_data()
	{
		return array(
			array('config.add', array('postlove_version', '1.0.0')),
		);
	}

	//lets create the needed table	
	public function update_schema()
	{
		return array(
			'add_tables'    => array(
				$this->table_prefix . 'posts_likes'		=> array(
					'COLUMNS'		=> array(
						'post_id'		=> array('UINT:8'),
						'user_id'		=> array('UINT:8'),
						'type'		=> array('VCHAR:16', 'post'),
						'timestamp'		=> array('VCHAR:32', NULL)
					),
					'PRIMARY_KEY'    => 'post_id, user_id',
				)
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables'		=> array(
				$this->table_prefix . 'posts_likes'
			),
		);
	}
}